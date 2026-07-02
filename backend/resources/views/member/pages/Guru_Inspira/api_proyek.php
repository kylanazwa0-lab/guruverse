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

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array('y' => 'tahun','m' => 'bulan','w' => 'minggu','d' => 'hari','h' => 'jam','i' => 'menit','s' => 'detik');
    foreach ($string as $k => &$v) {
        if ($diff->$k) $v = $diff->$k . ' ' . $v;
        else unset($string[$k]);
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}

function getInitials($name) {
    $parts = explode(' ', $name);
    $in = strtoupper(substr($parts[0], 0, 1));
    if(count($parts) > 1) $in .= strtoupper(substr($parts[1], 0, 1));
    return $in;
}

if ($action === 'get_all') {
    $proyek = [];
    $res = $conn->query("
        SELECT p.*, m.full_name as author_name,
        (SELECT COUNT(*) FROM gb_inspira_proyek_members WHERE proyek_id = p.id AND status = 'accepted') as member_count
        FROM gb_inspira_proyek p
        JOIN members m ON p.author_id = m.id
        ORDER BY p.created_at DESC
    ");
    
    if($res) {
        while($r = $res->fetch_assoc()) {
            $r['time_ago'] = time_elapsed_string($r['created_at']);
            $r['author_initials'] = getInitials($r['author_name']);
            $proyek[] = $r;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $proyek]);
    exit;
}

if ($action === 'create') {
    $judul = trim($_POST['judul'] ?? '');
    $label = trim($_POST['label'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $kebutuhan = (int)$_POST['kebutuhan_anggota'];
    
    if(!$judul || !$deskripsi) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
        exit;
    }
    
    $warna = ['#4f46e5', '#059669', '#d97706', '#be123c', '#0284c7'];
    $bg = $warna[array_rand($warna)];
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_proyek (author_id, judul, deskripsi, label, kebutuhan_anggota, warna_bg) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $uid, $judul, $deskripsi, $label, $kebutuhan, $bg);
    
    if($stmt->execute()) {
        // Pembuat otomatis menjadi anggota pertama
        $pid = $conn->insert_id;
        $conn->query("INSERT INTO gb_inspira_proyek_members (proyek_id, user_id, status) VALUES ($pid, $uid, 'accepted')");
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan']);
    }
    exit;
}

if ($action === 'get_detail') {
    $id = (int)$_GET['id'];
    
    $resP = $conn->query("
        SELECT p.*, m.full_name as author_name
        FROM gb_inspira_proyek p
        JOIN members m ON p.author_id = m.id
        WHERE p.id = $id
    ");
    $proyek = $resP->fetch_assoc();
    if(!$proyek) {
        echo json_encode(['status' => 'error', 'message' => 'Proyek tidak ditemukan']);
        exit;
    }
    $proyek['time_ago'] = time_elapsed_string($proyek['created_at']);
    $proyek['author_initials'] = getInitials($proyek['author_name']);
    $proyek['deskripsi'] = nl2br(htmlspecialchars($proyek['deskripsi']));
    
    // Anggota dan Pendaftar
    $members = [];
    $applicants = [];
    $is_member = false;
    $has_requested = false;
    $is_author = ($proyek['author_id'] == $uid);
    
    $resM = $conn->query("
        SELECT pm.*, m.full_name as user_name 
        FROM gb_inspira_proyek_members pm
        JOIN members m ON pm.user_id = m.id
        WHERE pm.proyek_id = $id
    ");
    if($resM) {
        while($r = $resM->fetch_assoc()) {
            $r['user_initials'] = getInitials($r['user_name']);
            $r['pesan'] = nl2br(htmlspecialchars($r['pesan']));
            
            if($r['status'] === 'accepted') {
                $members[] = $r;
            } elseif ($r['status'] === 'pending' && $is_author) {
                $applicants[] = $r;
            }
            
            if($r['user_id'] == $uid) {
                if($r['status'] === 'accepted') $is_member = true;
                if($r['status'] === 'pending') $has_requested = true;
            }
        }
    }
    
    echo json_encode([
        'status' => 'success', 
        'data' => [
            'proyek' => $proyek,
            'members' => $members,
            'applicants' => $applicants,
            'is_author' => $is_author,
            'is_member' => $is_member,
            'has_requested' => $has_requested
        ]
    ]);
    exit;
}

if ($action === 'join_request') {
    $id = (int)$_POST['id'];
    $pesan = trim($_POST['pesan'] ?? '');
    
    // Cek apakah sudah pernah request
    $cek = $conn->query("SELECT id FROM gb_inspira_proyek_members WHERE proyek_id = $id AND user_id = $uid");
    if($cek->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Anda sudah mengajukan permintaan atau sudah bergabung']);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_proyek_members (proyek_id, user_id, pesan, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iis", $id, $uid, $pesan);
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim permintaan']);
    }
    exit;
}

if ($action === 'manage_applicant') {
    $proyek_id = (int)$_POST['proyek_id'];
    $applicant_id = (int)$_POST['applicant_id'];
    $status_update = $_POST['status_update']; // 'accepted' or 'rejected'
    
    if(!in_array($status_update, ['accepted', 'rejected'])) {
        echo json_encode(['status' => 'error', 'message' => 'Status tidak valid']);
        exit;
    }
    
    // Cek apakah user ini adalah pembuat proyek
    $cek = $conn->query("SELECT id, kebutuhan_anggota FROM gb_inspira_proyek WHERE id = $proyek_id AND author_id = $uid");
    if($cek->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak berhak mengelola proyek ini']);
        exit;
    }
    
    $proyekData = $cek->fetch_assoc();
    
    if($status_update === 'accepted') {
        // Cek kuota dulu
        $resCount = $conn->query("SELECT COUNT(*) as c FROM gb_inspira_proyek_members WHERE proyek_id = $proyek_id AND status = 'accepted'");
        $currentCount = $resCount->fetch_assoc()['c'];
        if($currentCount >= $proyekData['kebutuhan_anggota']) {
            echo json_encode(['status' => 'error', 'message' => 'Kuota proyek sudah penuh']);
            exit;
        }
    }
    
    if($status_update === 'rejected') {
        // Hapus data jika direject agar user bisa mencoba lagi nanti jika perlu, atau set status='rejected'
        // Untuk skenario ini, kita update saja statusnya ke 'rejected'
        $stmt = $conn->prepare("UPDATE gb_inspira_proyek_members SET status = 'rejected' WHERE proyek_id = ? AND user_id = ?");
    } else {
        $stmt = $conn->prepare("UPDATE gb_inspira_proyek_members SET status = 'accepted' WHERE proyek_id = ? AND user_id = ?");
    }
    
    $stmt->bind_param("ii", $proyek_id, $applicant_id);
    if($stmt->execute()) {
        // Jika diterima dan kuota sudah penuh, opsional ubah status proyek menjadi 'Berjalan'
        if($status_update === 'accepted') {
            $resCount = $conn->query("SELECT COUNT(*) as c FROM gb_inspira_proyek_members WHERE proyek_id = $proyek_id AND status = 'accepted'");
            $currentCount = $resCount->fetch_assoc()['c'];
            if($currentCount >= $proyekData['kebutuhan_anggota']) {
                $conn->query("UPDATE gb_inspira_proyek SET status = 'Berjalan' WHERE id = $proyek_id");
            }
        }
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah status']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
