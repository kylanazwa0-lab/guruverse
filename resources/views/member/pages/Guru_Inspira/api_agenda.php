<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../../database/config.php';
$conn = getConnection();

if (!isset($_SESSION['member_int_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$uid = (int)$_SESSION['member_int_id'];
$action = $_GET['action'] ?? '';

if ($action === 'get_all') {
    $events = [];
    $res = $conn->query("
        SELECT e.*, m.full_name as author_name,
        (SELECT COUNT(*) FROM gb_inspira_event_rsvp WHERE event_id = e.id) as peserta_count
        FROM gb_inspira_event e
        JOIN members m ON e.author_id = m.id
        ORDER BY e.event_date ASC
    ");
    
    if($res) {
        while($r = $res->fetch_assoc()) {
            // Format date
            $dt = new DateTime($r['event_date']);
            $r['tanggal_formatted'] = $dt->format('d M Y, H:i');
            
            // Check if joined
            $cek = $conn->query("SELECT id FROM gb_inspira_event_rsvp WHERE event_id = {$r['id']} AND user_id = $uid");
            $r['has_joined'] = ($cek->num_rows > 0);
            
            // Sembunyikan link meeting jika belum bergabung
            if(!$r['has_joined'] && $r['author_id'] != $uid) {
                $r['link_meeting'] = ''; 
            }
            
            $events[] = $r;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $events]);
    exit;
}

if ($action === 'create') {
    $judul = trim($_POST['judul'] ?? '');
    $tipe = trim($_POST['tipe'] ?? '');
    $tgl = trim($_POST['event_date'] ?? '');
    $link = trim($_POST['link_meeting'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    
    if(!$judul || !$tgl || !$deskripsi) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
        exit;
    }
    
    // Assign Icon and Color based on type
    $icon = 'ti ti-calendar-event';
    $wbg = '#f1f5f9';
    $wtx = '#475569';
    
    if($tipe === 'Webinar') {
        $icon = 'ti ti-video';
        $wbg = '#eff6ff';
        $wtx = '#2563eb';
    } else if($tipe === 'Lokakarya') {
        $icon = 'ti ti-building-community';
        $wbg = '#f0fdf4';
        $wtx = '#16a34a';
    } else if($tipe === 'Diskusi Santai') {
        $icon = 'ti ti-coffee';
        $wbg = '#fffbeb';
        $wtx = '#d97706';
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_event (author_id, judul, deskripsi, tipe, event_date, link_meeting, icon, warna_bg, warna_text) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $uid, $judul, $deskripsi, $tipe, $tgl, $link, $icon, $wbg, $wtx);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan']);
    }
    exit;
}

if ($action === 'rsvp') {
    $event_id = (int)$_POST['id'];
    
    // Cek apakah sudah pernah RSVP
    $cek = $conn->query("SELECT id FROM gb_inspira_event_rsvp WHERE event_id = $event_id AND user_id = $uid");
    if($cek->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Anda sudah terdaftar']);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_event_rsvp (event_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $event_id, $uid);
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftar']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
