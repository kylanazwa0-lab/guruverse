<?php
/**
 * Guru Belajar - Member Dashboard
 * Router utama: include header, sidebar, page, dan footer
 */

// Load header (DB connect + user data + HTML head + <body>)
require_once __DIR__ . '/includes/header.php';

// Sidebar + Topbar + Notification dropdown
require_once __DIR__ . '/includes/sidebar.php';

// Main content area
echo '<main class="main-layout">';

// Semua page di-include (JS menangani show/hide via class active)
require_once __DIR__ . '/pages/Guru_Belajar/dashboard.php';
require_once __DIR__ . '/pages/Guru_Belajar/kelas.php';
require_once __DIR__ . '/pages/Guru_Belajar/modul.php';
require_once __DIR__ . '/pages/Guru_Belajar/progress.php';
require_once __DIR__ . '/pages/Guru_Belajar/perpustakaan.php';
require_once __DIR__ . '/pages/Guru_Belajar/cart.php';
require_once __DIR__ . '/pages/Guru_Belajar/sertifikat.php';
require_once __DIR__ . '/pages/Guru_Belajar/diskusi.php';
require_once __DIR__ . '/pages/Guru_Belajar/diskusi_detail.php';
require_once __DIR__ . '/pages/Guru_Belajar/pengaturan.php';
require_once __DIR__ . '/pages/Guru_Belajar/quiz.php';
require_once __DIR__ . '/pages/Guru_Belajar/quiz_list.php';
require_once __DIR__ . '/pages/Guru_Belajar/quiz_result.php';
require_once __DIR__ . '/pages/Guru_Belajar/quiz_take.php';

echo '</main>';

// Footer (JS scripts + closing tags)
require_once __DIR__ . '/includes/footer.php';
?>
