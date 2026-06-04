<?php
// ============================================
// database/config.php
// ============================================

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'guruverse');
define('APP_URL', rtrim($_ENV['APP_URL'] ?? 'http://localhost/guruverse', '/'));

function getConnection(): mysqli {
    try {
        // Matikan reporting exception jika ingin menangani manual, atau biarkan dan gunakan try-catch
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $conn->set_charset('utf8mb4');
        return $conn;
    } catch (mysqli_sql_exception $e) {
        // Jangan gunakan die() dengan HTML jika ini adalah request API
        if (ob_get_length()) ob_clean();
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false, 
            'message' => 'Koneksi database gagal: ' . $e->getMessage()
        ]);
        exit;
    }
}

// Helper: kirim JSON response
if (!function_exists('jsonResponse')) {
    function jsonResponse(bool $success, string $message = '', array $extra = []): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
        exit;
    }
}