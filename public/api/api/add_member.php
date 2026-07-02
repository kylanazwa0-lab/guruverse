<?php
// ============================================
// api/add_member.php
// Tambah anggota baru dari panel admin
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

$fullName    = trim($_POST['fullName']    ?? '');
$email       = trim($_POST['email']       ?? '');
$institution = trim($_POST['institution'] ?? '');
$phone       = trim($_POST['phone']       ?? '');
$photoBase64 = $_POST['photoBase64']      ?? null;

if (!$fullName || !$email || !$institution || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid.']);
    exit;
}

$conn = getConnection();

// Cek email duplikat
$chk = $conn->prepare("SELECT id FROM members WHERE email = ?");
$chk->bind_param('s', $email);
$chk->execute();
$chk->store_result();
if ($chk->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar.']);
    $chk->close(); $conn->close(); exit;
}
$chk->close();

// Generate Member ID: 001-GV-2026
$year     = date('Y');
$res      = $conn->query("SELECT COUNT(*) AS total FROM members");
$nextNum  = (int)$res->fetch_assoc()['total'] + 1;
$memberId = str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;

// Antisipasi race condition
$chkId = $conn->prepare("SELECT id FROM members WHERE member_id = ?");
$chkId->bind_param('s', $memberId);
$chkId->execute();
$chkId->store_result();
if ($chkId->num_rows > 0) {
    $res2     = $conn->query("SELECT MAX(CAST(SUBSTRING_INDEX(member_id,'-',1) AS UNSIGNED)) AS mx FROM members");
    $nextNum  = (int)$res2->fetch_assoc()['mx'] + 1;
    $memberId = str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;
}
$chkId->close();

// Proses foto
$photoPath = null;
if ($photoBase64 && preg_match('/^data:image\/(jpeg|png|webp);base64,/i', $photoBase64)) {
    $uploadDir = '../uploads/photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $imgData  = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $photoBase64));
    $fileName = $memberId . '_' . time() . '.jpg';
    if (file_put_contents($uploadDir . $fileName, $imgData)) {
        $photoPath = 'uploads/photos/' . $fileName;
    }
}

// Simpan
$stmt = $conn->prepare(
    "INSERT INTO members (member_id, full_name, email, institution, phone, photo, joined_at) VALUES (?, ?, ?, ?, ?, ?, NOW())"
);
$stmt->bind_param('ssssss', $memberId, $fullName, $email, $institution, $phone, $photoPath);

if ($stmt->execute()) {
    $photoReturn = null;
    if ($photoPath && file_exists('../' . $photoPath)) {
        $photoReturn = 'data:image/jpeg;base64,' . base64_encode(file_get_contents('../' . $photoPath));
    }
    echo json_encode([
        'success'     => true,
        'message'     => 'Anggota berhasil ditambahkan.',
        'memberId'    => $memberId,
        'fullName'    => $fullName,
        'email'       => $email,
        'institution' => $institution,
        'phone'       => $phone,
        'photo'       => $photoReturn,
        'joinedAt'    => date('Y-m-d H:i:s'),
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan: ' . $stmt->error]);
}

$stmt->close();
$conn->close();