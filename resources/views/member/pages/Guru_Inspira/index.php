<?php
/**
 * Guru Inspira - Member Dashboard
 * Memanggil kerangka global dari Guru Belajar
 */

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar_inspira.php';

echo '<main class="main-layout">';

// Semua page di-include (JS menangani show/hide via class active)
require_once __DIR__ . '/dashboard.php';
require_once __DIR__ . '/forum.php';
require_once __DIR__ . '/forum_thread.php';
require_once __DIR__ . '/proyek.php';
require_once __DIR__ . '/proyek_detail.php';
require_once __DIR__ . '/cerita.php';
require_once __DIR__ . '/cerita_detail.php';
require_once __DIR__ . '/agenda.php';
require_once __DIR__ . '/jendela.php';
require_once __DIR__ . '/jendela_detail.php';
require_once __DIR__ . '/diskusi.php';

// Include pengaturan global dari Guru Belajar
require_once __DIR__ . '/../Guru_Belajar/pengaturan.php';

echo '</main>';

require_once __DIR__ . '/../../includes/footer.php';
?>
