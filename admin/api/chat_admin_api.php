<?php
session_start();
require_once '../../../database/config.php';

if (!isset($_SESSION['admin_logged_in'])) exit;

$conn = getConnection();
$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $res = $conn->query("SELECT s.id, s.status, m.full_name FROM gb_chat_sessions s JOIN members m ON s.user_id = m.id WHERE s.status IN ('waiting_admin', 'active') ORDER BY s.status DESC, s.id DESC");
    $sessions = [];
    while($r = $res->fetch_assoc()) $sessions[] = $r;
    echo json_encode(['success' => true, 'sessions' => $sessions]);
}

if ($action === 'activate') {
    $sid = intval($_GET['session_id']);
    $conn->query("UPDATE gb_chat_sessions SET status = 'active' WHERE id = $sid AND status = 'waiting_admin'");
    echo json_encode(['success' => true]);
}

if ($action === 'sync') {
    $sid = intval($_GET['session_id']);
    $lid = intval($_GET['last_id']);
    $res = $conn->query("SELECT id, sender_type, message FROM gb_chat_messages WHERE session_id = $sid AND id > $lid ORDER BY id ASC");
    $messages = [];
    while($r = $res->fetch_assoc()) $messages[] = $r;
    echo json_encode(['success' => true, 'messages' => $messages]);
}

if ($action === 'send') {
    $sid = intval($_POST['session_id']);
    $msg = trim($_POST['message']);
    if ($sid && $msg) {
        $stmt = $conn->prepare("INSERT INTO gb_chat_messages (session_id, sender_type, message) VALUES (?, 'admin', ?)");
        $stmt->bind_param("is", $sid, $msg);
        $stmt->execute();
    }
    echo json_encode(['success' => true]);
}
