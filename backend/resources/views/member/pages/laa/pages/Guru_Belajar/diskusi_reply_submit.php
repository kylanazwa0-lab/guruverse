<?php
session_start();
require_once '../../../../database/config.php';

if (!isset($_SESSION['member_int_id']) && !isset($_SESSION['member_id'])) {
    jsonResponse(false, 'Harap login terlebih dahulu');
}

$conn = getConnection();
$user_id = $_SESSION['member_int_id'] ?? null; // ID integer anggota

// Jika session int_id belum di-set, coba query berdasarkan member_id string
if (!$user_id && isset($_SESSION['member_id'])) {
    $stmt = $conn->prepare("SELECT id FROM members WHERE member_id = ?");
    $stmt->bind_param("s", $_SESSION['member_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $user_id = $row['id'];
        $_SESSION['member_int_id'] = $user_id; // Set untuk digunakan berikutnya
    }
    $stmt->close();
}

if (!$user_id) {
    jsonResponse(false, 'ID Pengguna tidak valid');
}

$discussion_id = isset($_POST['discussion_id']) ? intval($_POST['discussion_id']) : 0;
$body = isset($_POST['body']) ? trim($_POST['body']) : '';

if ($discussion_id <= 0 || empty($body)) {
    jsonResponse(false, 'Topik diskusi atau isi balasan tidak boleh kosong');
}

// 1. Simpan balasan ke gb_discussion_replies
$stmt = $conn->prepare("INSERT INTO gb_discussion_replies (discussion_id, user_id, body, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $discussion_id, $user_id, $body);

if ($stmt->execute()) {
    // 2. Update replies_count di gb_discussions
    $stmt_update = $conn->prepare("UPDATE gb_discussions SET replies_count = replies_count + 1 WHERE id = ?");
    $stmt_update->bind_param("i", $discussion_id);
    $stmt_update->execute();
    $stmt_update->close();
    
    jsonResponse(true, 'Komentar berhasil ditambahkan');
} else {
    jsonResponse(false, 'Gagal mengirim komentar: ' . $stmt->error);
}

$stmt->close();
$conn->close();
