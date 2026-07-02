<?php
// ============================================
// api/admin_login.php
// ============================================
ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();

header('Content-Type: application/json; charset=utf-8');

// ── Ganti password di sini ──
define('ADMIN_PASSWORD', 'admin123');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$pass = $_POST['pass'] ?? '';

if ($pass === ADMIN_PASSWORD) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_time']      = time();
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Password salah.']);
}