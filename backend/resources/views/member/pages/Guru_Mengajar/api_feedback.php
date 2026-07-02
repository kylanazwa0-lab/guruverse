<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['member_int_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Silakan login terlebih dahulu.']);
    exit;
}

$uid = (int)$_SESSION['member_int_id'];
require_once '../../../../database/config.php';
$conn = getConnection();

$action = $_GET['action'] ?? '';

if ($action === 'submit_feedback') {
    $rating = (int)($_POST['rating'] ?? 0);
    $kategori = $conn->real_escape_string($_POST['kategori'] ?? '');
    $ulasan = $conn->real_escape_string($_POST['ulasan'] ?? '');

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['status' => 'error', 'message' => 'Rating tidak valid (1-5).']);
        exit;
    }
    if (empty($ulasan)) {
        echo json_encode(['status' => 'error', 'message' => 'Ulasan tidak boleh kosong.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO gb_mengajar_system_feedback (member_id, rating, kategori, ulasan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $uid, $rating, $kategori, $ulasan);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Terima kasih! Ulasan Anda sangat berarti bagi pengembangan GuruVerse.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
