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

function getInitials($name) {
    $parts = explode(' ', $name);
    $in = strtoupper(substr($parts[0], 0, 1));
    if(count($parts) > 1) $in .= strtoupper(substr($parts[1], 0, 1));
    return $in;
}

if ($action === 'get_all') {
    $rekan = [];
    $res = $conn->query("
        SELECT r.*, m.full_name as user_name, m.institution
        FROM gb_inspira_rekan r
        JOIN members m ON r.user_id = m.id
        WHERE r.status_open = 1
        ORDER BY r.created_at DESC
    ");
    
    if($res) {
        while($r = $res->fetch_assoc()) {
            $r['user_initials'] = getInitials($r['user_name']);
            $r['is_me'] = ($r['user_id'] == $uid);
            $rekan[] = $r;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $rekan]);
    exit;
}

if ($action === 'get_my_profile') {
    $res = $conn->query("SELECT * FROM gb_inspira_rekan WHERE user_id = $uid LIMIT 1");
    if ($res && $res->num_rows > 0) {
        echo json_encode(['status' => 'success', 'data' => $res->fetch_assoc()]);
    } else {
        echo json_encode(['status' => 'not_found']);
    }
    exit;
}

if ($action === 'update_profile') {
    $bidang_minat = trim($_POST['bidang_minat'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $status_open = isset($_POST['status_open']) ? (int)$_POST['status_open'] : 1;
    
    if(!$bidang_minat) {
        echo json_encode(['status' => 'error', 'message' => 'Bidang minat tidak boleh kosong']);
        exit;
    }
    
    // Cek apakah profil sudah ada
    $cek = $conn->query("SELECT id FROM gb_inspira_rekan WHERE user_id = $uid");
    if ($cek && $cek->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE gb_inspira_rekan SET bidang_minat=?, deskripsi=?, status_open=? WHERE user_id=?");
        $stmt->bind_param("ssii", $bidang_minat, $deskripsi, $status_open, $uid);
    } else {
        $stmt = $conn->prepare("INSERT INTO gb_inspira_rekan (user_id, bidang_minat, deskripsi, status_open) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $uid, $bidang_minat, $deskripsi, $status_open);
    }
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan profil']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
