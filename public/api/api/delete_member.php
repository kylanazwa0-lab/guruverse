<?php
// ============================================
// api/delete_member.php
// ============================================
ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan.']);
    exit;
}

require_once '../database/config.php';

$memberId = trim($_POST['memberId'] ?? '');
if (!$memberId) {
    echo json_encode(['success' => false, 'message' => 'Member ID wajib diisi.']);
    exit;
}

$conn = getConnection();

// Ambil data foto sebelum dihapus
$chk = $conn->prepare("SELECT photo FROM members WHERE member_id = ?");
$chk->bind_param('s', $memberId);
$chk->execute();
$row = $chk->get_result()->fetch_assoc();
$chk->close();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Anggota tidak ditemukan.']);
    $conn->close(); exit;
}

// Hapus dari database
$stmt = $conn->prepare("DELETE FROM members WHERE member_id = ?");
$stmt->bind_param('s', $memberId);

if ($stmt->execute()) {
    // Hapus file foto jika ada
    if (!empty($row['photo'])) {
        $photoPath = '../' . $row['photo'];
        if (file_exists($photoPath)) {
            @unlink($photoPath);
        }
    }

    echo json_encode(['success' => true, 'message' => 'Anggota berhasil dihapus.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus: ' . $stmt->error]);
}

$stmt->close();
$conn->close();