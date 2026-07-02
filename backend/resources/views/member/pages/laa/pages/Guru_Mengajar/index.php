<?php
/**
 * Guru Mengajar - Member Dashboard
 * Memanggil kerangka global dari Guru Belajar
 */

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar_mengajar.php';

echo '<main class="main-layout">';

// Semua page di-include (JS menangani show/hide via class active)
require_once __DIR__ . '/dashboard.php';
require_once __DIR__ . '/gamifikasi.php';
require_once __DIR__ . '/cart_gamifikasi.php';
require_once __DIR__ . '/impact_tracker.php';
require_once __DIR__ . '/pelatihan.php';
require_once __DIR__ . '/kirim_karya.php';
require_once __DIR__ . '/referral.php';

echo '</main>';

require_once __DIR__ . '/../../includes/footer.php';
?>
