<?php
/**
 * GURUVERSE.ID - Member Logout API (Secure)
 * - Bersihkan seluruh session (bukan hanya beberapa key)
 * - Hapus cookie sesi
 * - Cegah cache halaman setelah logout
 */

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');

session_start();
header('Content-Type: application/json; charset=utf-8');

// Cegah cache browser setelah logout
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// 1. Hapus SEMUA data sesi (bukan hanya beberapa key tertentu)
$_SESSION = [];

// 2. Hapus cookie sesi dari browser
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// 3. Hancurkan sesi di server
session_destroy();

echo json_encode(['success' => true, 'message' => 'Logout berhasil.']);
