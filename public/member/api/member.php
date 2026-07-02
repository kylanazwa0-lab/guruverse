<?php
// ============================================
// member/api/member.php
// API: Ambil data member yang sedang login
// Dipanggil oleh halaman dashboard/profile member
// ============================================

ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

function apiJson(bool $success, string $message = '', array $data = [], int $code = 200): void {
    if (ob_get_length()) ob_clean();
    http_response_code($code);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

// ── Cek autentikasi ─────────────────────────────────────────────────────────
if (empty($_SESSION['member_logged_in']) || empty($_SESSION['member_int_id'])) {
    apiJson(false, 'Unauthorized. Silakan login terlebih dahulu.', [], 401);
}

// ── Validasi User Agent (cegah session hijacking) ───────────────────────────
$ua = md5($_SERVER['HTTP_USER_AGENT'] ?? '');
if (!empty($_SESSION['member_user_agent']) && $_SESSION['member_user_agent'] !== $ua) {
    session_destroy();
    apiJson(false, 'Sesi tidak valid. Silakan login ulang.', [], 401);
}

require_once '../../database/config.php';

$memberId = (int)$_SESSION['member_int_id'];
$conn = getConnection();

// ── Ambil data member ────────────────────────────────────────────────────────
$stmt = $conn->prepare(
    "SELECT id, member_id, full_name, username, institution, phone, 
            photo_path, email, referral_code, joined_at
     FROM members WHERE id = ? LIMIT 1"
);
$stmt->bind_param('i', $memberId);
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if (!$member) {
    session_destroy();
    apiJson(false, 'Data member tidak ditemukan. Silakan login ulang.', [], 404);
}

// ── Proses foto → base64 ────────────────────────────────────────────────────
$photoBase64 = null;
if (!empty($member['photo_path'])) {
    $absPath = '../../' . $member['photo_path'];
    if (file_exists($absPath)) {
        $mime = mime_content_type($absPath) ?: 'image/jpeg';
        $photoBase64 = "data:{$mime};base64," . base64_encode(file_get_contents($absPath));
    }
}

// ── Perbarui waktu aktivitas terakhir ───────────────────────────────────────
$_SESSION['member_last_active'] = time();

apiJson(true, 'OK', [
    'member' => [
        'id'           => (int)$member['id'],
        'member_id'    => $member['member_id'],
        'full_name'    => $member['full_name'],
        'username'     => $member['username'],
        'institution'  => $member['institution'],
        'phone'        => $member['phone'] ?? '',
        'email'        => $member['email'] ?? '',
        'referral_code'=> $member['referral_code'] ?? '',
        'photo'        => $photoBase64,
        'joined_at'    => $member['joined_at'],
        'is_admin'     => !empty($_SESSION['admin_logged_in']),
    ]
]);
