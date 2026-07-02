<?php
/**
 * GURUVERSE.ID - Member Login API
 * Versi Secure dengan Session Regeneration + Brute Force Protection
 */

ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

// Konfigurasi sesi yang aman sebelum session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

session_start();
header('Content-Type: application/json; charset=utf-8');

function sendJsonResponse(bool $success, string $message = '', array $extra = [], int $httpCode = 200): void {
    if (ob_get_length()) ob_clean();
    http_response_code($httpCode);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Method tidak diizinkan.', [], 405);
}

require_once '../../../database/config.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? ''; // JANGAN trim() password!

if (!$username || !$password) {
    sendJsonResponse(false, 'Username dan password wajib diisi.');
}

// ── Brute Force Protection (simpan di session) ──────────────────────────────
$fail_key = 'login_fails_' . md5($username);
$lock_key  = 'login_lock_'  . md5($username);

// Jika akun sedang dikunci
if (!empty($_SESSION[$lock_key]) && $_SESSION[$lock_key] > time()) {
    $sisa = ceil(($_SESSION[$lock_key] - time()) / 60);
    sendJsonResponse(false, "Terlalu banyak percobaan login gagal. Coba lagi dalam {$sisa} menit.");
}

$conn = getConnection();

// Query dengan prepared statement
$stmt = $conn->prepare("SELECT * FROM members WHERE username = ? OR email = ? OR member_id = ? LIMIT 1");
if (!$stmt) {
    sendJsonResponse(false, 'Query error: ' . $conn->error);
}

$stmt->bind_param('sss', $username, $username, $username);
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$member) {
    // Incrementasi counter gagal walaupun akun tidak ditemukan (cegah user enumeration)
    $_SESSION[$fail_key] = ($_SESSION[$fail_key] ?? 0) + 1;
    if ($_SESSION[$fail_key] >= 5) {
        $_SESSION[$lock_key] = time() + (15 * 60); // Kunci 15 menit
        unset($_SESSION[$fail_key]);
    }
    sendJsonResponse(false, 'Username atau password salah.');
}

// Cek flag must_change_pass atau password kosong
if (empty($member['password']) || !empty($member['must_change_pass'])) {
    sendJsonResponse(false, 'Akun Anda belum memiliki kata sandi. Silakan atur password terlebih dahulu.', [
        'need_setup' => true,
        'member_id'  => $member['member_id'] ?? '',
        'email'      => $member['email'] ?? '',
    ]);
}

// Verifikasi password
$isMatch = password_verify($password, $member['password']);

// Fallback plain-text → auto-upgrade ke BCRYPT (hanya selama masa migrasi)
if (!$isMatch && $password === $member['password']) {
    $isMatch = true;
    $newHash = password_hash($password, PASSWORD_BCRYPT);
    $upStmt = $conn->prepare("UPDATE members SET password = ?, must_change_pass = 0 WHERE id = ?");
    $upStmt->bind_param('si', $newHash, $member['id']);
    $upStmt->execute();
    $upStmt->close();
}

if (!$isMatch) {
    // Incrementasi counter gagal
    $_SESSION[$fail_key] = ($_SESSION[$fail_key] ?? 0) + 1;
    if ($_SESSION[$fail_key] >= 5) {
        $_SESSION[$lock_key] = time() + (15 * 60); // Kunci 15 menit
        unset($_SESSION[$fail_key]);
        sendJsonResponse(false, 'Terlalu banyak percobaan gagal. Akun dikunci 15 menit.');
    }
    sendJsonResponse(false, 'Username atau password salah.');
}

// ── Login berhasil — Hapus counter brute force ──────────────────────────────
unset($_SESSION[$fail_key], $_SESSION[$lock_key]);

// ── KRITIS: Regenerate session ID untuk cegah Session Fixation Attack ───────
session_regenerate_id(true);

// Set session dengan data minimal yang dibutuhkan
$_SESSION['member_id']         = $member['member_id'];
$_SESSION['member_int_id']     = (int)$member['id'];
$_SESSION['member_logged_in']  = true;
$_SESSION['member_login_at']   = time();
$_SESSION['member_user_agent'] = md5($_SERVER['HTTP_USER_AGENT'] ?? '');
$_SESSION['member_ip']         = $_SERVER['REMOTE_ADDR'];

// JANGAN simpan password hash atau data sensitif lainnya di session!

// Photo Base64 (opsional, untuk avatar)
$photoBase64 = null;
$photoField = !empty($member['photo']) ? $member['photo'] : ($member['photo_path'] ?? null);
if ($photoField) {
    $absPath = '../../../' . $photoField;
    if (file_exists($absPath)) {
        $mime = mime_content_type($absPath) ?: 'image/jpeg';
        $photoBase64 = "data:{$mime};base64," . base64_encode(file_get_contents($absPath));
    }
}

$conn->close();

sendJsonResponse(true, 'Login berhasil.', [
    'member' => [
        'member_id'   => $member['member_id'] ?? '',
        'full_name'   => $member['full_name'] ?? '',
        'username'    => $member['username'] ?? '',
        'institution' => $member['institution'] ?? '',
        'phone'       => $member['phone'] ?? '',
        'photo'       => $photoBase64,
        'joined_at'   => $member['joined_at'] ?? '',
    ]
]);
