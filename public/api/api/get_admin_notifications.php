<?php
require_once __DIR__ . '/../database/config.php';
$conn = getConnection();
header('Content-Type: application/json');

$notifs = [];

// New members
$res = $conn->query("SELECT id, full_name as title, 'Member baru mendaftar' as message, joined_at as created_at, 'user' as type FROM members ORDER BY joined_at DESC LIMIT 3");
if($res) while($r = $res->fetch_assoc()) $notifs[] = $r;

// New discussions
$res = $conn->query("SELECT id, title, 'Topik diskusi baru' as message, created_at, 'message-square' as type FROM gb_discussions ORDER BY created_at DESC LIMIT 3");
if($res) while($r = $res->fetch_assoc()) $notifs[] = $r;

// Sort by created_at DESC
usort($notifs, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Take top 5
$notifs = array_slice($notifs, 0, 5);

echo json_encode(['success' => true, 'data' => $notifs]);
