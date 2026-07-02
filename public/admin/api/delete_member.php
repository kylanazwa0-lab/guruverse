<?php
/**
 * admin/api/delete_member.php
 * Deletes a member by memberId (username). Requires admin session.
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

$body = json_decode(file_get_contents('php://input'), true);
$memberId = trim($body['memberId'] ?? '');

if (!$memberId) {
    echo json_encode(['success' => false, 'message' => 'Member ID tidak valid.']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM members WHERE username=?");
$stmt->bind_param('s', $memberId);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Member tidak ditemukan atau gagal dihapus.']);
}
$stmt->close();
