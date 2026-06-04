<?php
/**
 * api/get_member.php - Get single member (public)
 */
ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

header('Content-Type: application/json; charset=utf-8');

function sendJsonResponse(bool $success, string $message = '', array $extra = []) {
    if (ob_get_length()) ob_clean();
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

require_once '../database/config.php';

$id = trim($_GET['id'] ?? '');
if (empty($id)) {
    sendJsonResponse(false, 'ID tidak boleh kosong.');
}

$conn = getConnection();
$stmt = $conn->prepare(
    "SELECT member_id, full_name, email, institution, phone, photo, joined_at
     FROM members WHERE member_id = ? LIMIT 1"
);
$stmt->bind_param("s", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if ($row) {
    $photoUrl = null;
    if (!empty($row['photo'])) {
        $absPath = '../' . $row['photo'];
        if (file_exists($absPath)) {
            $mime = mime_content_type($absPath) ?: 'image/jpeg';
            $photoUrl = "data:{$mime};base64," . base64_encode(file_get_contents($absPath));
        }
    }
    sendJsonResponse(true, 'Data ditemukan', [
        'member'  => [
            'memberId'    => $row['member_id'],
            'fullName'    => $row['full_name'],
            'email'       => $row['email'],
            'institution' => $row['institution'],
            'phone'       => $row['phone'],
            'photo'       => $photoUrl,
            'joinedAt'    => $row['joined_at'],
        ]
    ]);
} else {
    sendJsonResponse(false, 'Anggota tidak ditemukan.');
}