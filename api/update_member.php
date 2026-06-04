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

require_once '../database/config.php';

$memberId    = trim($_POST['memberId']    ?? '');
$fullName    = trim($_POST['fullName']    ?? '');
$email       = trim($_POST['email']       ?? '');
$institution = trim($_POST['institution'] ?? '');
$phone       = trim($_POST['phone']       ?? '');
$photoBase64 = $_POST['photoBase64']      ?? null;

// Validasi
if (!$memberId || !$fullName || !$email || !$institution || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid.']);
    exit;
}

$conn = getConnection();

// Cek member ada
$chk = $conn->prepare("SELECT id, photo FROM members WHERE member_id = ?");
$chk->bind_param('s', $memberId);
$chk->execute();
$res = $chk->get_result()->fetch_assoc();
$chk->close();

if (!$res) {
    echo json_encode(['success' => false, 'message' => 'Anggota tidak ditemukan.']);
    $conn->close(); exit;
}

// Cek email duplikat (exclude diri sendiri)
$chkEmail = $conn->prepare("SELECT id FROM members WHERE email = ? AND member_id != ?");
$chkEmail->bind_param('ss', $email, $memberId);
$chkEmail->execute();
$chkEmail->store_result();
if ($chkEmail->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email sudah digunakan anggota lain.']);
    $chkEmail->close(); $conn->close(); exit;
}
$chkEmail->close();

// Proses foto baru jika ada
$photoPath = $res['photo']; // Tetap pakai foto lama kalau tidak ada foto baru
if ($photoBase64 && preg_match('/^data:image\/(jpeg|png|webp);base64,/i', $photoBase64)) {
    $uploadDir = '../uploads/photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    // Hapus foto lama kalau ada
    if (!empty($res['photo']) && file_exists('../' . $res['photo'])) {
        @unlink('../' . $res['photo']);
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
    "UPDATE members SET full_name=?, email=?, institution=?, phone=?, photo=? WHERE member_id=?"
);
$stmt->bind_param('ssssss', $fullName, $email, $institution, $phone, $photoPath, $memberId);

if ($stmt->execute()) {
    // Kembalikan foto terbaru
    $photoReturn = null;
    if (!empty($photoPath) && file_exists('../' . $photoPath)) {
        $photoReturn = 'data:image/jpeg;base64,' . base64_encode(file_get_contents('../' . $photoPath));
    }

    echo json_encode([
        'success'     => true,
        'message'     => 'Data berhasil diperbarui.',
        'memberId'    => $memberId,
        'fullName'    => $fullName,
        'email'       => $email,
        'institution' => $institution,
        'phone'       => $phone,
        'photo'       => $photoReturn,
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data: ' . $stmt->error]);
}

$stmt->close();
$conn->close();