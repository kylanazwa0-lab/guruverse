<?php
/**
 * GURUVERSE.ID - API Data Member (Admin Panel)
 * Versi Production-Ready dengan proteksi output HTML
 */

// 1. Cegah display_errors & aktifkan Output Buffering
ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

// 2. Konfigurasi Session & Header
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

/**
 * Helper: Mengirim JSON Response bersih & aman
 */
function sendJsonResponse(bool $success, string $message = '', array $data = [], int $httpCode = 200) {
    // BERSIHKAN BUFFER: Hapus semua output tak sengaja (whitespace/PHP Notice) sebelum mengirim JSON
    if (ob_get_length()) ob_clean();
    
    http_response_code($httpCode);
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $data));
    exit;
}

// 3. Verifikasi Sesi Admin
$is_admin = (
    (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) ||
    (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) ||
    (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
);

if (!$is_admin) {
    sendJsonResponse(false, 'Sesi admin tidak ditemukan. Silakan login kembali.', [], 401);
}

// 4. Validasi Path Config & Koneksi DB
$configPath = __DIR__ . '/../../database/config.php';
if (!file_exists($configPath)) {
    sendJsonResponse(false, 'Kritis: File config.php tidak ditemukan di path: ' . $configPath);
}

require_once $configPath;

try {
    // Aktifkan exception mode pada mysqli untuk menangkap error query
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = getConnection();
} catch (Exception $e) {
    sendJsonResponse(false, 'Koneksi database gagal: ' . $e->getMessage());
}

// 5. Eksekusi Query & Pengolahan Data
try {
    $today = date('Y-m-d');
    $month = date('Y-m');

    // Optimasi: Gabungkan query statistik menjadi satu
    $qStats = $conn->query("
        SELECT 
            COUNT(*) AS total,
            SUM(CASE WHEN DATE(joined_at) = '$today' THEN 1 ELSE 0 END) AS today,
            SUM(CASE WHEN DATE_FORMAT(joined_at,'%Y-%m') = '$month' THEN 1 ELSE 0 END) AS month
        FROM members
    ");
    $stats = $qStats->fetch_assoc();

    // Query anggota
    $result = $conn->query("SELECT member_id, full_name, username, email, institution, phone, photo, photo_path, joined_at FROM members ORDER BY joined_at DESC, id DESC");
    $members = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Optimasi: Gunakan URL direktori alih-alih base64
            $photoPath = !empty($row['photo']) ? $row['photo'] : (!empty($row['photo_path']) ? $row['photo_path'] : null);
            $photoUrl = null;
            if ($photoPath) {
                $cleanPath = ltrim(str_replace('../', '', $photoPath), '/');
                $photoUrl = APP_URL . '/' . $cleanPath;
            }

            $members[] = [
                'memberId'    => $row['member_id'] ?? '',
                'fullName'    => $row['full_name'] ?? '',
                'username'    => $row['username'] ?? $row['email'] ?? '',
                'email'       => $row['email'] ?? '',
                'institution' => $row['institution'] ?? '',
                'phone'       => $row['phone'] ?? '',
                'photo'       => $photoUrl,
                'joinedAt'    => $row['joined_at'] ?? '',
            ];
        }
    }

    $conn->close();

    sendJsonResponse(true, 'Data berhasil dimuat', [
        'members' => $members,
        'stats'   => [
            'total' => (int)($stats['total'] ?? 0),
            'today' => (int)($stats['today'] ?? 0),
            'month' => (int)($stats['month'] ?? 0),
        ]
    ]);
} catch (Exception $e) {
    sendJsonResponse(false, 'Kesalahan Database: ' . $e->getMessage());
}