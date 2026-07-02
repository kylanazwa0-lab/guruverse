<?php
// ============================================
// modules/member/register/register.php
// API: Pendaftaran Member Baru
// ============================================

ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

// Konfigurasi sesi yang aman
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

session_start();
header('Content-Type: application/json; charset=utf-8');

function sendJson(bool $success, string $message = '', array $extra = [], int $code = 200): void {
    if (ob_get_length()) ob_clean();
    http_response_code($code);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJson(false, 'Method tidak diizinkan.', [], 405);
}

require_once '../../../database/config.php';

// ── Ambil & sanitasi input ──────────────────────────────────────────────────
$fullName    = trim($_POST['fullName']    ?? '');
$username    = trim($_POST['username']    ?? '');
$institution = trim($_POST['institution'] ?? '');
$password    = $_POST['password']         ?? ''; // JANGAN trim() password
$phone       = trim($_POST['phone']       ?? '');
$photoBase64 = $_POST['photoBase64']      ?? null;
$refCode     = trim($_POST['refCode']     ?? '');

// ── Validasi wajib ──────────────────────────────────────────────────────────
if (!$fullName || !$username || !$institution || !$password) {
    sendJson(false, 'Nama, username, instansi, dan password wajib diisi.');
}

if (strlen($password) < 6) {
    sendJson(false, 'Password minimal 6 karakter.');
}

if (!preg_match('/^[a-zA-Z0-9_.@]+$/', $username)) {
    sendJson(false, 'Username hanya boleh huruf, angka, titik, underscore, atau @.');
}

$conn = getConnection();

// ── Cek username duplikat ───────────────────────────────────────────────────
$stmt = $conn->prepare("SELECT id FROM members WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close(); $conn->close();
    sendJson(false, 'Username sudah terdaftar. Gunakan username lain.');
}
$stmt->close();

// ── Generate Member ID: 001-GV-2026 ────────────────────────────────────────
$year = date('Y');
$res  = $conn->query(
    "SELECT MAX(CAST(SUBSTRING_INDEX(member_id, '-', 1) AS UNSIGNED)) AS max_num 
     FROM members WHERE member_id LIKE '%-GV-{$year}'"
);
$row     = $res->fetch_assoc();
$nextNum = (int)($row['max_num'] ?? 0) + 1;
$memberId = str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;

// Antisipasi race condition
$chk = $conn->prepare("SELECT id FROM members WHERE member_id = ? LIMIT 1");
$chk->bind_param('s', $memberId);
$chk->execute();
$chk->store_result();
if ($chk->num_rows > 0) {
    $nextNum++;
    $memberId = str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;
}
$chk->close();

// ── Proses foto (base64 → file) ─────────────────────────────────────────────
$photoPath = null;
if ($photoBase64 && preg_match('/^data:image\/(jpeg|png|webp);base64,/i', $photoBase64, $m)) {
    $uploadDir = '../../../uploads/photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $imgData  = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $photoBase64));
    $ext      = strtolower($m[1]) === 'png' ? 'png' : 'jpg';
    $fileName = $memberId . '_' . time() . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    if ($imgData && file_put_contents($filePath, $imgData)) {
        $photoPath = 'uploads/photos/' . $fileName;
    }
}

// ── FIX #1: Hash password dengan BCRYPT sebelum disimpan ───────────────────
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// ── Simpan ke database ──────────────────────────────────────────────────────
$stmt = $conn->prepare(
    "INSERT INTO members (member_id, full_name, username, institution, password, phone, photo_path, joined_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
);
$stmt->bind_param('sssssss', $memberId, $fullName, $username, $institution, $hashedPassword, $phone, $photoPath);

if (!$stmt->execute()) {
    $errMsg = $stmt->error;
    $stmt->close(); $conn->close();
    sendJson(false, 'Gagal menyimpan data: ' . $errMsg, [], 500);
}

$newId = $conn->insert_id;
$stmt->close();

// ── Proses Referral (jika ada) ──────────────────────────────────────────────
if ($refCode !== '') {
    $q_ref = $conn->prepare("SELECT id FROM members WHERE referral_code = ? LIMIT 1");
    $q_ref->bind_param('s', $refCode);
    $q_ref->execute();
    $res_ref = $q_ref->get_result();
    if ($r_row = $res_ref->fetch_assoc()) {
        $referrer_id = $r_row['id'];
        $ins_ref = $conn->prepare("INSERT IGNORE INTO gb_referrals (referrer_id, referred_id) VALUES (?, ?)");
        $ins_ref->bind_param('ii', $referrer_id, $newId);
        $ins_ref->execute();
        $ins_ref->close();
    }
    $q_ref->close();
}

// ── Ambil data member yang baru dibuat ─────────────────────────────────────
$q2 = $conn->prepare("SELECT * FROM members WHERE id = ? LIMIT 1");
$q2->bind_param('i', $newId);
$q2->execute();
$member = $q2->get_result()->fetch_assoc();
$q2->close();
$conn->close();

// ── FIX #2: Set SESSION setelah register berhasil (auto-login) ─────────────
session_regenerate_id(true);
$_SESSION['member_id']         = $member['member_id'];
$_SESSION['member_int_id']     = (int)$member['id'];
$_SESSION['member_logged_in']  = true;
$_SESSION['member_login_at']   = time();
$_SESSION['member_user_agent'] = md5($_SERVER['HTTP_USER_AGENT'] ?? '');
$_SESSION['member_ip']         = $_SERVER['REMOTE_ADDR'];

// ── Buat photo base64 untuk response ───────────────────────────────────────
$photoBase64Return = null;
if (!empty($member['photo_path'])) {
    $absPath = '../../../' . $member['photo_path'];
    if (file_exists($absPath)) {
        $mime = mime_content_type($absPath) ?: 'image/jpeg';
        $photoBase64Return = "data:{$mime};base64," . base64_encode(file_get_contents($absPath));
    }
}

// ── JANGAN kirim password (bahkan yang sudah di-hash) ke client ────────────
sendJson(true, 'Pendaftaran berhasil! Selamat bergabung.', [
    'member_id'   => $member['member_id'],
    'full_name'   => $member['full_name'],
    'username'    => $member['username'],
    'institution' => $member['institution'],
    'phone'       => $member['phone'],
    'photo'       => $photoBase64Return,
    'joined_at'   => $member['joined_at'],
]);