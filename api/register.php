<?php
// ============================================
// api/register.php
// ============================================

session_start();
header('Content-Type: application/json; charset=utf-8');

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

// Validasi dasar
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
$stmt = $conn->prepare("SELECT id FROM members WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar.']);
    $stmt->close(); $conn->close(); exit;
}
$stmt->close();

// ── Generate Member ID Format: 001-GV-2026 ──
$year    = date('Y');
$res     = $conn->query("SELECT COUNT(*) AS total FROM members");
$row     = $res->fetch_assoc();
$nextNum = (int)$row['total'] + 1;
$memberId = str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;

// Pastikan member_id unik (antisipasi race condition)
$checkStmt = $conn->prepare("SELECT id FROM members WHERE member_id = ?");
$checkStmt->bind_param('s', $memberId);
$checkStmt->execute();
$checkStmt->store_result();
if ($checkStmt->num_rows > 0) {
    // Fallback: ambil nomor urut tertinggi lalu +1
    $res2     = $conn->query(
        "SELECT MAX(CAST(SUBSTRING_INDEX(member_id, '-', 1) AS UNSIGNED)) AS max_num FROM members"
    );
    $row2     = $res2->fetch_assoc();
    $nextNum  = (int)($row2['max_num'] ?? 0) + 1;
    $memberId = str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;
}
$checkStmt->close();

// Proses foto (base64 → file)
$photoPath = null;
if ($photoBase64 && preg_match('/^data:image\/(jpeg|png|webp);base64,/i', $photoBase64)) {
    $uploadDir = '../uploads/photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $imgData  = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $photoBase64));
    $ext      = 'jpg';
    $fileName = $memberId . '_' . time() . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    if (file_put_contents($filePath, $imgData)) {
        $photoPath = 'uploads/photos/' . $fileName;
    }
}

// Simpan ke database
$stmt = $conn->prepare(
    "INSERT INTO members (member_id, full_name, email, institution, phone, photo, joined_at)
     VALUES (?, ?, ?, ?, ?, ?, NOW())"
);
$stmt->bind_param('ssssss', $memberId, $fullName, $email, $institution, $phone, $photoPath);

if ($stmt->execute()) {
    $newId = $conn->insert_id;
    $q2    = $conn->prepare("SELECT * FROM members WHERE id = ?");
    $q2->bind_param('i', $newId);
    $q2->execute();
    $member = $q2->get_result()->fetch_assoc();
    $q2->close();

    $photoBase64Return = null;
    if (!empty($member['photo']) && file_exists('../' . $member['photo'])) {
        $photoBase64Return = 'data:image/jpeg;base64,' . base64_encode(
            file_get_contents('../' . $member['photo'])
        );
    }

    echo json_encode([
        'success'     => true,
        'member_id'   => $member['member_id'],
        'full_name'   => $member['full_name'],
        'email'       => $member['email'],
        'institution' => $member['institution'],
        'phone'       => $member['phone'],
        'photo'       => $photoBase64Return,
        'joined_at'   => $member['joined_at'],
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data: ' . $stmt->error]);
}

$stmt->close();
$conn->close();