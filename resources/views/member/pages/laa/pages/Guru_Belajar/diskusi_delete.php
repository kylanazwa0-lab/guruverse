<?php
session_start();
require_once __DIR__ . '/../../../database/config.php';

function jsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if (empty($_SESSION['member_int_id'])) {
    jsonResponse(false, 'Sesi berakhir, silakan login kembali.');
}

$user_id = (int)$_SESSION['member_int_id'];
$id      = (int)($_POST['id'] ?? 0);

if (!$id) {
    jsonResponse(false, 'ID topik tidak valid.');
}

$conn = getConnection();

// Pastikan yang menghapus adalah pemiliknya
$stmt = $conn->prepare("DELETE FROM gb_discussions WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        jsonResponse(true, 'Topik berhasil dihapus.');
    } else {
        jsonResponse(false, 'Topik tidak ditemukan atau Anda tidak memiliki izin.');
    }
} else {
    jsonResponse(false, 'Gagal menghapus topik: ' . $conn->error);
}

$stmt->close();
$conn->close();
