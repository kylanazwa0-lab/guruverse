<?php
/**
 * Admin Panel - Main Entry Point
 */
// Session config harus konsisten dengan admin_login.php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../admin.php');
    exit;
}

// Determine active module
$module = $_GET['mod'] ?? 'dashboard';
$allowed = ['dashboard', 'kelas', 'modul', 'member', 'sertifikat', 'diskusi', 'notifikasi', 'bot_settings', 'produk', 'inspira_cerita', 'inspira_agenda', 'mengajar_jadwal', 'mengajar_gamifikasi', 'live_chat'];
if (!in_array($module, $allowed)) $module = 'dashboard';

// Include shared layout
require_once __DIR__ . '/includes/layout_header.php';

// Include the appropriate page view
$view_file = __DIR__ . '/views/' . $module . '.php';
if (file_exists($view_file)) {
    require_once $view_file;
} else {
    echo '<div style="padding:40px;text-align:center;color:#fff">Halaman tidak ditemukan.</div>';
}

require_once __DIR__ . '/includes/layout_footer.php';
