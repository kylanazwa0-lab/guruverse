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
    $cerita = [];
    $res = $conn->query("
        SELECT c.*, m.full_name as author_name
        FROM gb_inspira_cerita c
        JOIN members m ON c.author_id = m.id
        WHERE c.status = 'published'
        ORDER BY c.created_at DESC
    ");
    
    if($res) {
        while($r = $res->fetch_assoc()) {
            $r['time_ago'] = time_elapsed_string($r['created_at']);
            $r['author_initials'] = getInitials($r['author_name']);
            $r['konten_raw'] = strip_tags($r['konten']);
            $cerita[] = $r;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $cerita]);
    exit;
}

if ($action === 'create') {
    $judul = trim($_POST['judul'] ?? '');
    $konten = trim($_POST['konten'] ?? '');
    
    if(!$judul || !$konten) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_cerita (author_id, judul, konten, status) VALUES (?, ?, ?, 'published')");
    $stmt->bind_param("iss", $uid, $judul, $konten);
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan']);
    }
    exit;
}

if ($action === 'get_detail') {
    $id = (int)$_GET['id'];
    
    // Add view
    $conn->query("UPDATE gb_inspira_cerita SET views = views + 1 WHERE id = $id");
    
    $res = $conn->query("
        SELECT c.*, m.full_name as author_name
        FROM gb_inspira_cerita c
        JOIN members m ON c.author_id = m.id
        WHERE c.id = $id
    ");
    
    $cerita = $res->fetch_assoc();
    if(!$cerita) {
        echo json_encode(['status' => 'error', 'message' => 'Cerita tidak ditemukan']);
        exit;
    }
    
    $cerita['time_ago'] = time_elapsed_string($cerita['created_at']);
    $cerita['author_initials'] = getInitials($cerita['author_name']);
    $cerita['konten_html'] = nl2br(htmlspecialchars($cerita['konten']));
    
    echo json_encode(['status' => 'success', 'data' => $cerita]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
