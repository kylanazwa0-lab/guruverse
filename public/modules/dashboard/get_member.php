<?php
// ============================================
// api/get_member.php - Get single member (public)
// ============================================
header('Content-Type: application/json; charset=utf-8');
require_once '../../database/config.php';

$id = trim($_GET['id'] ?? '');
if (empty($id)) {
    echo json_encode(['success' => false, 'message' => 'ID tidak boleh kosong.']);
    exit;
}

$conn = getConnection();
$stmt = $conn->prepare(
    "SELECT member_id, full_name, username, institution, password, phone, photo_path, joined_at
     FROM members WHERE member_id = ? LIMIT 1"
);
$stmt->bind_param("s", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if ($row) {
    $photoUrl = null;
    if (!empty($row['photo_path'])) {
        $absPath = '../../' . $row['photo_path'];
        if (file_exists($absPath)) {
            $photoUrl = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($absPath));
        }
    }
    echo json_encode([
        'success' => true,
        'member'  => [
            'memberId'    => $row['member_id'],
            'fullName'    => $row['full_name'],
            'username'    => $row['username'],
            'institution' => $row['institution'],
            'password'    => $row['password'],
            'phone'       => $row['phone'],
            'photo'       => $photoUrl,
            'joinedAt'    => $row['joined_at'],
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Anggota tidak ditemukan.']);
}