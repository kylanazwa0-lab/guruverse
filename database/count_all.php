<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

$tables = ['gb_courses','gb_enrollments','gb_modules','gb_certificates',
           'gb_discussions','gb_discussion_replies','gb_notifications',
           'gb_inspira_cerita','gb_inspira_proyek','gb_inspira_forum','gb_inspira_event','gb_inspira_jendela',
           'gb_mengajar_tantangan','gb_mengajar_jadwal','gb_mengajar_pelatihan',
           'gb_mengajar_stats','gb_mengajar_impact_stats',
           'products','gb_perpustakaan','members'];

foreach ($tables as $t) {
    $r = $db->query("SELECT COUNT(*) as cnt FROM `$t`");
    $cnt = $r ? $r->fetch_assoc()['cnt'] : 'ERROR';
    printf("%-40s : %s baris\n", $t, $cnt);
}
$db->close();
