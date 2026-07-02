<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['member_int_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$uid = (int)$_SESSION['member_int_id'];
require_once '../../../../database/config.php';
$conn = getConnection();

$action = $_GET['action'] ?? '';

if ($action === 'submit_karya') {
    $judul = $conn->real_escape_string($_POST['judul'] ?? '');
    $jenis = $conn->real_escape_string($_POST['jenis'] ?? '');
    $deskripsi = $conn->real_escape_string($_POST['deskripsi'] ?? '');
    $link_karya = $conn->real_escape_string($_POST['link_karya'] ?? '');

    if (empty($judul) || empty($jenis) || empty($deskripsi)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua kolom yang ditandai bintang (*) wajib diisi.']);
        exit;
    }

    $file_path = null;
    if (isset($_FILES['file_karya']) && $_FILES['file_karya']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../../../uploads/karya/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = time() . '_' . basename($_FILES['file_karya']['name']);
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['file_karya']['tmp_name'], $target_file)) {
            $file_path = '/uploads/karya/' . $file_name;
        }
    }

    $stmt = $conn->prepare("INSERT INTO gb_mengajar_karya (member_id, judul, jenis, deskripsi, file_path, link_karya) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $uid, $judul, $jenis, $deskripsi, $file_path, $link_karya);
    
    if ($stmt->execute()) {
        // Berikan XP reward sebagai apresiasi submit karya (misalnya 100 XP)
        $conn->query("UPDATE gb_mengajar_stats SET total_xp = total_xp + 100 WHERE member_id = $uid");
        echo json_encode(['status' => 'success', 'message' => 'Karya berhasil dikirim! (+100 XP)']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem.']);
    }
    exit;
}

if ($action === 'vote_karya') {
    $karya_id = (int)($_POST['karya_id'] ?? 0);
    if ($karya_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID Karya tidak valid.']);
        exit;
    }

    // Check if trying to vote own work
    $res = $conn->query("SELECT member_id FROM gb_mengajar_karya WHERE id = $karya_id");
    if ($res && $row = $res->fetch_assoc()) {
        if ($row['member_id'] == $uid) {
            echo json_encode(['status' => 'error', 'message' => 'Anda tidak bisa mem-vote karya sendiri.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Karya tidak ditemukan.']);
        exit;
    }

    // Attempt to insert vote
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO gb_mengajar_karya_votes (karya_id, member_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $karya_id, $uid);
        if ($stmt->execute()) {
            $conn->query("UPDATE gb_mengajar_karya SET vote_count = vote_count + 1 WHERE id = $karya_id");
            $conn->commit();
            echo json_encode(['status' => 'success', 'message' => 'Berhasil memberikan dukungan!']);
        } else {
            throw new Exception("Sudah mem-vote.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Anda sudah memberikan vote untuk karya ini sebelumnya.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
