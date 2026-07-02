<?php
/**
 * API: Send a notification for the logged-in member
 * POST body: { "title": "...", "body": "...", "icon": "book|check|bell|award|message", "link": "page_name" }
 * 
 * SECURITY: user_id SELALU diambil dari session
 */
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    session_start();
}

// Wajib login
if (empty($_SESSION['member_int_id']) || empty($_SESSION['member_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Tidak terautentikasi.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'POST only']);
    exit;
}

require_once __DIR__ . '/../../../database/config.php';
$conn = getConnection();

// user_id dari session — tidak bisa dimanipulasi
$user_id = (int)$_SESSION['member_int_id'];

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    echo json_encode(['success' => false, 'error' => 'Body tidak valid.']);
    exit;
}

$title = trim($input['title'] ?? '');
$body  = trim($input['body'] ?? '');
// Whitelist icon yang diizinkan
$allowed_icons = ['book', 'check', 'bell', 'award', 'message', 'info'];
$icon = in_array($input['icon'] ?? '', $allowed_icons) ? $input['icon'] : 'info';
$link = trim($input['link'] ?? '');

if (empty($title) || empty($body)) {
    echo json_encode(['success' => false, 'error' => 'title & body wajib diisi.']);
    exit;
}

// Batasi panjang input
$title = mb_substr($title, 0, 150);
$body  = mb_substr($body, 0, 500);
$link  = mb_substr($link, 0, 100);

$stmt = $conn->prepare("INSERT INTO gb_notifications (user_id, title, body, icon, link, is_read, is_pushed, created_at) VALUES (?, ?, ?, ?, ?, 0, 0, NOW())");
$stmt->bind_param("issss", $user_id, $title, $body, $icon, $link);
$stmt->execute();
$newId = $stmt->insert_id;
$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Notification sent!']);
