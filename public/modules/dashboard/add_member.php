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

require_once '../../database/config.php';

$fullName    = trim($_POST['fullName']    ?? '');
$username    = trim($_POST['username']    ?? '');
$institution = trim($_POST['institution'] ?? '');
$password    = trim($_POST['password']    ?? '');
$phone       = trim($_POST['phone']       ?? '');
$photoBase64 = $_POST['photoBase64']      ?? null;

if (!$fullName || !$username || !$institution || !$password) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi.']);
    exit;
}

$conn = getConnection();

// Cek username duplikat
$chk = $conn->prepare("SELECT id FROM members WHERE username = ?");
$chk->bind_param('s', $username);
$chk->execute();
$chk->store_result();
if ($chk->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username sudah terdaftar.']);
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
    $uploadDir = '../../uploads/photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $imgData  = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $photoBase64));
    $fileName = $memberId . '_' . time() . '.jpg';
    if (file_put_contents($uploadDir . $fileName, $imgData)) {
        $photoPath = 'uploads/photos/' . $fileName;
    }
}

// Simpan
$stmt = $conn->prepare(
    "INSERT INTO members (member_id, full_name, username, email, institution, password, phone, photo_path, joined_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())"
);
$stmt->bind_param('ssssssss', $memberId, $fullName, $username, $username, $institution, $password, $phone, $photoPath);

if ($stmt->execute()) {
    $photoReturn = null;
    if ($photoPath && file_exists('../../' . $photoPath)) {
        $photoReturn = 'data:image/jpeg;base64,' . base64_encode(file_get_contents('../../' . $photoPath));
    }
    echo json_encode([
        'success'     => true,
        'message'     => 'Anggota berhasil ditambahkan.',
        'memberId'    => $memberId,
        'fullName'    => $fullName,
        'username'    => $username,
        'institution' => $institution,
        'password'    => $password,
        'phone'       => $phone,
        'photo'       => $photoReturn,
        'joinedAt'    => date('Y-m-d H:i:s'),
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan: ' . $stmt->error]);
}

$stmt->close();
$conn->close();