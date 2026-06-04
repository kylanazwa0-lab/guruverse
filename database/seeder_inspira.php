<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

try {
    $db->begin_transaction();
    
    // Clear the tables
    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    $db->query("TRUNCATE TABLE gb_modules");
    $db->query("TRUNCATE TABLE gb_inspira_cerita");
    $db->query("TRUNCATE TABLE gb_inspira_proyek");
    $db->query("TRUNCATE TABLE gb_inspira_forum");
    $db->query("TRUNCATE TABLE gb_inspira_event");
    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    
    // Seed gb_modules
    $res = $db->query("SELECT id FROM gb_courses");
    $stmt_m = $db->prepare("INSERT INTO gb_modules (course_id, module_number, title, duration_minutes, video_url, content) VALUES (?, ?, ?, ?, 'https://youtube.com', 'Konten modul yang edukatif.')");
    
    while($r = $res->fetch_assoc()) {
        $c_id = $r['id'];
        for ($i=1; $i<=5; $i++) {
            $title = "Modul $i: Pengenalan " . ['Dasar','Lanjutan','Praktik','Evaluasi','Kesimpulan'][$i-1];
            $dur = rand(10, 45);
            $stmt_m->bind_param("iisi", $c_id, $i, $title, $dur);
            $stmt_m->execute();
        }
    }
    
    // Seed gb_inspira_cerita
    $cerita = [
        ['Membangun Literasi Digital di Desa', 'cerita1.jpg'],
        ['Kisah Sukses Pak Budi Mengajar Coding', 'cerita2.jpg'],
        ['Pentingnya Soft Skills di Era AI', 'cerita3.jpg']
    ];
    $stmt_c = $db->prepare("INSERT INTO gb_inspira_cerita (judul, gambar) VALUES (?, ?)");
    foreach ($cerita as $c) {
        $stmt_c->bind_param("ss", $c[0], $c[1]);
        $stmt_c->execute();
    }
    
    // Seed gb_inspira_proyek
    $proyek = [
        ['Pembuatan Alat Peraga Fisika Sederhana', 'proyek1.jpg', 'Sains', 'Selesai', 'rgba(108,92,231,0.15)'],
        ['Penggalangan Buku untuk Pelosok', 'proyek2.jpg', 'Sosial', 'Berjalan', 'rgba(0,184,148,0.15)']
    ];
    $stmt_p = $db->prepare("INSERT INTO gb_inspira_proyek (judul, gambar, label, status, warna_bg) VALUES (?, ?, ?, ?, ?)");
    foreach ($proyek as $p) {
        $stmt_p->bind_param("sssss", $p[0], $p[1], $p[2], $p[3], $p[4]);
        $stmt_p->execute();
    }
    
    // Seed gb_inspira_forum
    $forum = [
        ['Strategi Kurikulum Merdeka', 124, 'ti ti-messages', 'rgba(108,92,231,0.1)'],
        ['Diskusi Teknologi Pendidikan', 89, 'ti ti-device-laptop', 'rgba(9,132,227,0.1)'],
        ['Berbagi Modul Ajar', 45, 'ti ti-file-text', 'rgba(0,184,148,0.1)']
    ];
    $stmt_f = $db->prepare("INSERT INTO gb_inspira_forum (judul, total_postingan, icon, warna_bg) VALUES (?, ?, ?, ?)");
    foreach ($forum as $f) {
        $stmt_f->bind_param("siss", $f[0], $f[1], $f[2], $f[3]);
        $stmt_f->execute();
    }
    
    // Seed gb_inspira_event
    $event = [
        ['Webinar: AI untuk Guru', 'Online', '24 Mei 2026', 'ti ti-calendar', '#6c5ce7', 'rgba(108,92,231,0.1)'],
        ['Workshop Literasi', 'Offline', '01 Jun 2026', 'ti ti-map-pin', '#00b894', 'rgba(0,184,148,0.1)']
    ];
    $stmt_e = $db->prepare("INSERT INTO gb_inspira_event (judul, tipe, tanggal_text, icon, warna_text, warna_bg) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($event as $e) {
        $stmt_e->bind_param("ssssss", $e[0], $e[1], $e[2], $e[3], $e[4], $e[5]);
        $stmt_e->execute();
    }
    
    $db->commit();
    echo "Seeding semua tabel Inspira dan Modules berhasil!";
} catch (Exception $e) {
    $db->rollback();
    echo "Error: " . $e->getMessage();
}
$db->close();
