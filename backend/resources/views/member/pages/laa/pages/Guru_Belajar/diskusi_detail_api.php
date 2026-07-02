<?php
session_start();
require_once '../../../../database/config.php';

// Validasi session
if (!isset($_SESSION['member_int_id']) && !isset($_SESSION['member_id'])) {
    jsonResponse(false, 'Unauthorized');
}

$conn = getConnection();
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id <= 0) {
    jsonResponse(false, 'ID Topik tidak valid');
}

// 1. Ambil detail topik utama
$stmt = $conn->prepare("SELECT d.*, m.full_name as author_name, m.photo_path 
                        FROM gb_discussions d 
                        LEFT JOIN members m ON d.user_id = m.id 
                        WHERE d.id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    $stmt->close();
    jsonResponse(false, 'Topik diskusi tidak ditemukan');
}

$topic = $res->fetch_assoc();
$stmt->close();

// 2. Ambil semua balasan untuk topik ini
$replies = [];
$stmt_replies = $conn->prepare("SELECT r.*, m.full_name as replier_name, m.photo_path 
                                FROM gb_discussion_replies r 
                                LEFT JOIN members m ON r.user_id = m.id 
                                WHERE r.discussion_id = ? 
                                ORDER BY r.created_at ASC");
$stmt_replies->bind_param("i", $topic_id);
$stmt_replies->execute();
$res_replies = $stmt_replies->get_result();

while ($row = $res_replies->fetch_assoc()) {
    $replies[] = $row;
}
$stmt_replies->close();
$conn->close();

jsonResponse(true, 'Data berhasil dimuat', [
    'topic' => $topic,
    'replies' => $replies
]);
