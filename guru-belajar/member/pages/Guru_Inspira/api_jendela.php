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
    $jendela = [];
    $res = $conn->query("
        SELECT j.*, m.full_name as author_name
        FROM gb_inspira_jendela j
        JOIN members m ON j.author_id = m.id
        ORDER BY j.created_at DESC
    ");
    
    if($res) {
        while($r = $res->fetch_assoc()) {
            $r['time_ago'] = time_elapsed_string($r['created_at']);
            $r['author_initials'] = getInitials($r['author_name']);
            $r['konten_raw'] = strip_tags($r['konten']);
            $jendela[] = $r;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $jendela]);
    exit;
}

if ($action === 'create') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? 'Inovasi');
    $konten = trim($_POST['konten'] ?? '');
    $sumber = trim($_POST['sumber'] ?? '');
    
    if(!$judul || !$konten) {
        echo json_encode(['status' => 'error', 'message' => 'Judul dan konten tidak boleh kosong']);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_jendela (author_id, kategori, judul, konten, sumber) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $uid, $kategori, $judul, $konten, $sumber);
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan artikel']);
    }
    exit;
}

if ($action === 'get_detail') {
    $id = (int)$_GET['id'];
    
    $res = $conn->query("
        SELECT j.*, m.full_name as author_name
        FROM gb_inspira_jendela j
        JOIN members m ON j.author_id = m.id
        WHERE j.id = $id
    ");
    
    $jendela = $res->fetch_assoc();
    if(!$jendela) {
        echo json_encode(['status' => 'error', 'message' => 'Artikel tidak ditemukan']);
        exit;
    }
    
    $jendela['time_ago'] = time_elapsed_string($jendela['created_at']);
    $jendela['author_initials'] = getInitials($jendela['author_name']);
    $jendela['konten_html'] = nl2br(htmlspecialchars($jendela['konten']));
    
    echo json_encode(['status' => 'success', 'data' => $jendela]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
