<?php
/**
 * modules/dashboard/send_password_invite.php
 * ─────────────────────────────────────────────────────
 * Endpoint: Kirim undangan email atur password ke member.
 * Dipanggil dari: admin/views/member.php → sendInvite()
 * Method: POST
 * Body  : member_id (string)
 * ─────────────────────────────────────────────────────
 */

// ── Output Buffering — WAJIB ADA di baris pertama ────────────────────────────
ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

// ── Session ───────────────────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// ── Helper: kirim JSON bersih ─────────────────────────────────────────────────
function sendJsonResponse(bool $success, string $message = '', array $extra = [], int $httpCode = 200): void
{
    if (ob_get_length()) ob_clean();
    http_response_code($httpCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

// ── Hanya terima POST ─────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Method tidak diizinkan.', [], 405);
}

// ── Verifikasi sesi admin ─────────────────────────────────────────────────────
$is_admin = (
    (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) ||
    (isset($_SESSION['admin_id'])        && !empty($_SESSION['admin_id']))          ||
    (isset($_SESSION['role'])            && $_SESSION['role'] === 'admin')
);

if (!$is_admin) {
    sendJsonResponse(false, 'Akses ditolak. Silakan login sebagai admin.', [], 401);
}

// ── Load dependencies ─────────────────────────────────────────────────────────
$configPath     = __DIR__ . '/../../database/config.php';
$mailHelperPath = __DIR__ . '/../../backend/MailHelper.php';

if (!file_exists($configPath)) {
    sendJsonResponse(false, 'File konfigurasi database tidak ditemukan.');
}
if (!file_exists($mailHelperPath)) {
    sendJsonResponse(false, 'File MailHelper tidak ditemukan.');
}

require_once $configPath;
require_once $mailHelperPath;

// ── Validasi input ────────────────────────────────────────────────────────────
$member_id = trim($_POST['member_id'] ?? '');

if (empty($member_id)) {
    sendJsonResponse(false, 'Member ID tidak boleh kosong.');
}

// ── Ambil data member dari database ──────────────────────────────────────────
try {
    $conn = getConnection();
} catch (Exception $e) {
    sendJsonResponse(false, 'Koneksi database gagal: ' . $e->getMessage());
}

$stmt = $conn->prepare(
    "SELECT full_name, email, username FROM members WHERE member_id = ? LIMIT 1"
);

if (!$stmt) {
    $conn->close();
    sendJsonResponse(false, 'Query error: ' . $conn->error);
}

$stmt->bind_param('s', $member_id);
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

// ── Validasi data member ──────────────────────────────────────────────────────
if (!$member) {
    sendJsonResponse(false, "Member dengan ID '{$member_id}' tidak ditemukan.");
}

$toName  = $member['full_name'] ?? 'Pengguna';
$toEmail = trim($member['email'] ?? '');

if (empty($toEmail)) {
    sendJsonResponse(false,
        "Member '{$toName}' tidak memiliki alamat email. Pastikan data email sudah diisi sebelum mengirim undangan."
    );
}

if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
    sendJsonResponse(false,
        "Format email member tidak valid: '{$toEmail}'. Perbarui data member terlebih dahulu."
    );
}

// ── Kirim email undangan ──────────────────────────────────────────────────────
$result = MailHelper::sendInvitation($toEmail, $toName, $member_id);

if ($result['success']) {
    sendJsonResponse(true,
        "✅ Undangan berhasil dikirim ke {$toEmail}. Minta member untuk memeriksa inbox (dan folder Spam)."
    );
} else {
    // Sertakan debug log agar admin bisa mendiagnosis masalah
    $debugInfo = !empty($result['debug']) ? $result['debug'] : null;
    sendJsonResponse(false,
        'Gagal mengirim email: ' . ($result['message'] ?? 'Unknown error'),
        $debugInfo ? ['debug' => $debugInfo] : [],
        500
    );
}
