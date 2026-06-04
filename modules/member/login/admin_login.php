<?php
/**
 * modules/member/login/admin_login.php
 */
ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();

header('Content-Type: application/json; charset=utf-8');

function sendJsonResponse(bool $success, string $message = '', array $extra = []) {
    if (ob_get_length()) ob_clean();
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

// Password diambil dari environment variable
$adminPass = getenv('ADMIN_PASS') ?: 'admin123';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Method not allowed.');
}

$pass = $_POST['pass'] ?? '';

if ($pass === $adminPass) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_time']      = time();
    sendJsonResponse(true, 'Login admin berhasil');
} else {
    sendJsonResponse(false, 'Password salah.');
}