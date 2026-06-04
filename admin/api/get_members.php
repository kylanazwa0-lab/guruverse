<?php
/**
 * admin/api/get_members.php
 * Returns all members as JSON. Requires admin session.
 */
ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../../database/config.php';
$conn = getConnection();

$res = $conn->query("
    SELECT id, full_name as fullName, username as memberId, institution,
           phone, photo, created_at as joinedAt
    FROM members
    ORDER BY created_at DESC
");

$members = [];
while ($row = $res->fetch_assoc()) {
    $members[] = $row;
}

echo json_encode(['success' => true, 'members' => $members]);
