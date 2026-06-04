<?php
session_start();
require_once __DIR__ . '/../../../database/config.php';

if (empty($_SESSION['member_int_id'])) {
    jsonResponse(false, 'Sesi berakhir, silakan login kembali.');
}

$user_id  = (int)$_SESSION['member_int_id'];
$title    = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$content  = trim($_POST['content'] ?? '');

if (!$title || !$content) {
    jsonResponse(false, 'Judul dan isi topik wajib diisi.');
}

$conn = getConnection();
$stmt = $conn->prepare("INSERT INTO gb_discussions (user_id, title, category, body, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("isss", $user_id, $title, $category, $content);

if ($stmt->execute()) {
    jsonResponse(true, 'Topik berhasil diposting!');
} else {
    jsonResponse(false, 'Gagal menyimpan topik: ' . $conn->error);
}
$stmt->close();
$conn->close();
