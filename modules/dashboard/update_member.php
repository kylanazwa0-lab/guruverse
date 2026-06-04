<?php
// ============================================
// api/update_member.php
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

require_once '../../database/config.php';

$memberId    = trim($_POST['memberId']    ?? '');
$fullName    = trim($_POST['fullName']    ?? '');
$username    = trim($_POST['username']    ?? '');
$institution = trim($_POST['institution'] ?? '');
$password    = trim($_POST['password']    ?? '');
$phone       = trim($_POST['phone']       ?? '');
$photoBase64 = $_POST['photoBase64']      ?? null;

// Validasi
if (!$memberId || !$fullName || !$username || !$institution || !$password) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi.']);
    exit;
}

$conn = getConnection();

// Cek member ada
$chk = $conn->prepare("SELECT id, photo_path FROM members WHERE member_id = ?");
$chk->bind_param('s', $memberId);
$chk->execute();
$res = $chk->get_result()->fetch_assoc();
$chk->close();

if (!$res) {
    echo json_encode(['success' => false, 'message' => 'Anggota tidak ditemukan.']);
    $conn->close(); exit;
}

// Cek username duplikat (exclude diri sendiri)
$chkEmail = $conn->prepare("SELECT id FROM members WHERE username = ? AND member_id != ?");
$chkEmail->bind_param('ss', $username, $memberId);
$chkEmail->execute();
$chkEmail->store_result();
if ($chkEmail->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username sudah digunakan anggota lain.']);
    $chkEmail->close(); $conn->close(); exit;
}
$chkEmail->close();

// Proses foto baru jika ada
$photoPath = $res['photo_path'] ?? null; // Tetap pakai foto lama kalau tidak ada foto baru
if ($photoBase64 && preg_match('/^data:image\/(jpeg|png|webp);base64,/i', $photoBase64)) {
    $uploadDir = '../../uploads/photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    // Hapus foto lama
    if (!empty($res['photo_path']) && file_exists('../../' . $res['photo_path'])) {
        @unlink('../../' . $res['photo_path']);
    }

    $imgData  = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $photoBase64));
    $fileName = $memberId . '_' . time() . '.jpg';
    $filePath = $uploadDir . $fileName;

    if (file_put_contents($filePath, $imgData)) {
        $photoPath = 'uploads/photos/' . $fileName;
    }
}

// Update
$stmt = $conn->prepare(
    "UPDATE members SET full_name=?, username=?, institution=?, password=?, phone=?, photo_path=? WHERE member_id=?"
);
$stmt->bind_param('sssssss', $fullName, $username, $institution, $password, $phone, $photoPath, $memberId);

if ($stmt->execute()) {
    // Kembalikan foto terbaru
    $photoReturn = null;
    if (!empty($photoPath) && file_exists('../../' . $photoPath)) {
        $photoReturn = 'data:image/jpeg;base64,' . base64_encode(file_get_contents('../../' . $photoPath));
    }

    echo json_encode([
        'success'     => true,
        'message'     => 'Data berhasil diperbarui.',
        'memberId'    => $memberId,
        'fullName'    => $fullName,
        'username'    => $username,
        'institution' => $institution,
        'password'    => $password,
        'phone'       => $phone,
        'photo'       => $photoReturn,
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data: ' . $stmt->error]);
}

$stmt->close();
$conn->close();