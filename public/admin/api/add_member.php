<?php
/**
 * admin/api/add_member.php
 * Adds a new member. Requires admin session.
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

$fullName    = trim($_POST['fullName'] ?? '');
$username    = trim($_POST['username'] ?? '');
$institution = trim($_POST['institution'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$password    = trim($_POST['password'] ?? '');

if (!$fullName || !$username || !$password) {
    echo json_encode(['success' => false, 'message' => 'Nama, username, dan password wajib diisi.']);
    exit;
}

// Check if username already exists
$check = $conn->prepare("SELECT id FROM members WHERE username=?");
$check->bind_param('s', $username);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username sudah digunakan.']);
    exit;
}
$check->close();

$hashed = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare(
    "INSERT INTO members (full_name, username, institution, phone, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())"
);
$stmt->bind_param('sssss', $fullName, $username, $institution, $phone, $hashed);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Anggota berhasil ditambahkan.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan: ' . $conn->error]);
}
$stmt->close();
