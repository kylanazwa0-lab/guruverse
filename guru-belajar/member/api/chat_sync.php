<?php
session_start();
require_once __DIR__ . '/../../../database/config.php';

if (!isset($_SESSION['member_id']) && !isset($_SESSION['member_int_id'])) exit;

$conn = getConnection();
// Resolve user ID
$user_id = $_SESSION['member_int_id'] ?? null;
if (!$user_id && isset($_SESSION['member_id'])) {
    $stmt = $conn->prepare("SELECT id FROM members WHERE member_id = ?");
    $stmt->bind_param("s", $_SESSION['member_id']);
    $stmt->execute();
    if ($res = $stmt->get_result()) {
        if ($row = $res->fetch_assoc()) {
            $user_id = $row['id'];
        }
    }
}

if (!$user_id) exit;

$session_id = intval($_GET['session_id'] ?? 0);
$last_id = intval($_GET['last_id'] ?? 0);

if (!$session_id) exit;

$stmt = $conn->prepare("SELECT id, sender_type, message, created_at FROM gb_chat_messages WHERE session_id = ? AND id > ? ORDER BY id ASC");
$stmt->bind_param("ii", $session_id, $last_id);
$stmt->execute();
$res = $stmt->get_result();
$messages = [];
while ($row = $res->fetch_assoc()) {
    $messages[] = $row;
}
$stmt->close();

$stmt = $conn->prepare("SELECT status FROM gb_chat_sessions WHERE id = ?");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$session = $stmt->get_result()->fetch_assoc();
$stmt->close();

echo json_encode(['success' => true, 'messages' => $messages, 'status' => $session['status'] ?? 'closed']);
