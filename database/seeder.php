<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

try {
    $db->begin_transaction();
    
    // 1. Clear existing dummy data (except admin)
    $tables_to_clear = [
        "gb_courses", "gb_modules", "gb_enrollments", "gb_certificates",
        "gb_discussions", "gb_discussion_replies", "gb_mengajar_aktivitas",
        "gb_mengajar_impact_terkini", "gb_mengajar_jadwal", "gb_mengajar_pelatihan",
        "gb_mengajar_riwayat_pelatihan", "gb_mengajar_stats", "products"
    ];
    
    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    foreach ($tables_to_clear as $table) {
        $db->query("TRUNCATE TABLE $table");
    }
    $db->query("DELETE FROM members WHERE role != 'admin'");
    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    
    // 2. Insert Members
    $members_data = [
        ['001-GV-2026', 'Budi Santoso, S.Pd', 'budi@guruverse.id', 'budi', 'SDN 1 Jakarta', 'Matematika', '$2y$10$TSEjv7njhh41e/0yfbBh8u7vi1lj6D9TapE/WcYEdri3wY7z3tGk.', 'member', '081234567890'],
        ['002-GV-2026', 'Siti Aminah, M.Pd', 'siti@guruverse.id', 'siti', 'SMPN 5 Bandung', 'IPA', '$2y$10$TSEjv7njhh41e/0yfbBh8u7vi1lj6D9TapE/WcYEdri3wY7z3tGk.', 'member', '081234567891'],
        ['003-GV-2026', 'Andi Wijaya, S.Kom', 'andi@guruverse.id', 'andi', 'SMKN 1 Surabaya', 'TIK', '$2y$10$TSEjv7njhh41e/0yfbBh8u7vi1lj6D9TapE/WcYEdri3wY7z3tGk.', 'member', '081234567892'],
        ['004-GV-2026', 'Intan Lestari, S.Pd', 'intan@guruverse.id', 'intan', 'Guru SD', 'Tematik', '$2y$10$TSEjv7njhh41e/0yfbBh8u7vi1lj6D9TapE/WcYEdri3wY7z3tGk.', 'member', '081234567893']
    ];
    
    $stmt = $db->prepare("INSERT INTO members (member_id, full_name, email, username, institution, subject, password, role, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($members_data as $m) {
        $stmt->bind_param("sssssssss", $m[0], $m[1], $m[2], $m[3], $m[4], $m[5], $m[6], $m[7], $m[8]);
        $stmt->execute();
    }
    
    // Get inserted member IDs
    $result = $db->query("SELECT id FROM members WHERE role='member'");
    $member_ids = [];
    while ($row = $result->fetch_assoc()) {
        $member_ids[] = $row['id'];
    }
    
    // 3. Insert Gamification Stats
    $stmt_stats = $db->prepare("INSERT INTO gb_mengajar_stats (member_id, jam_mengajar, siswa_terbantu, total_xp, level_saat_ini, hari_streak) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_jadwal = $db->prepare("INSERT INTO gb_mengajar_jadwal (member_id, hari, jam_mulai, jam_selesai, mata_pelajaran, kelas, ruangan, status) VALUES (?, 'Senin', '07:30:00', '09:00:00', 'Matematika', 'X-A', 'Ruang 1', 'aktif')");
    $stmt_aktivitas = $db->prepare("INSERT INTO gb_mengajar_impact_terkini (member_id, teks, waktu, warna_bg) VALUES (?, 'Menyelesaikan modul interaktif', 'Baru saja', 'rgba(0,184,148,.15)')");
    
    foreach ($member_ids as $m_id) {
        $jam = rand(10, 150);
        $siswa = rand(20, 300);
        $xp = rand(100, 5000);
        $lvl = rand(1, 10);
        $streak = rand(0, 30);
        
        $stmt_stats->bind_param("iiiiii", $m_id, $jam, $siswa, $xp, $lvl, $streak);
        $stmt_stats->execute();
        
        $stmt_jadwal->bind_param("i", $m_id);
        $stmt_jadwal->execute();
        
        $stmt_aktivitas->bind_param("i", $m_id);
        $stmt_aktivitas->execute();
    }

    // 4. Insert Courses
    $courses_data = [
        ['Strategi Penerapan Kurikulum Merdeka', 'Panduan lengkap menerapkan kurikulum merdeka di sekolah.', 'Kurikulum', 10.5, 5, 'mentor_1.jpg', 'Dr. Seto M.', 1, 4.8, 120],
        ['Pemanfaatan AI untuk Asesmen', 'Cara menggunakan Artificial Intelligence.', 'Teknologi', 5.0, 3, 'mentor_2.jpg', 'Prof. Budi', 0, 4.9, 300],
        ['Manajemen Kelas Digital', 'Mengelola kelas virtual menggunakan G-Suite.', 'Manajemen', 8.0, 4, 'mentor_3.jpg', 'Anita, M.Pd', 1, 4.5, 80]
    ];
    $stmt_c = $db->prepare("INSERT INTO gb_courses (title, description, category, duration_hours, total_modules, thumbnail, mentor_name, is_free, rating, total_reviews) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($courses_data as $c) {
        $stmt_c->bind_param("sssdisssdi", $c[0], $c[1], $c[2], $c[3], $c[4], $c[5], $c[6], $c[7], $c[8], $c[9]);
        $stmt_c->execute();
    }
    
    // 5. Insert Products
    $products_data = [
        ['E-Book Ice Breaking Guruverse', 45000.00, 'ice_breaking.jpg', 'Fun Learning', 'ebook', 'Guruverse', 0],
        ['Modul Ajar Fisika SMA Kelas X', 75000.00, 'modul_fisika.jpg', 'Modul', 'ebook', 'Siti Aminah', 0],
        ['Panduan Kurikulum Merdeka', 0.00, 'panduan_kumer.jpg', 'Kurikulum', 'ebook', 'Kemdikbud', 1]
    ];
    $stmt_p = $db->prepare("INSERT INTO products (title, price, image_url, category, type, author, is_free) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($products_data as $p) {
        $stmt_p->bind_param("sdssssi", $p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6]);
        $stmt_p->execute();
    }

    // 6. Insert Discussions
    if (count($member_ids) >= 2) {
        $m1 = $member_ids[0];
        $m2 = $member_ids[1];
        
        $discussions_data = [
            [$m1, 'Mengatasi siswa yang pasif saat daring?', 'Saya sudah mencoba berbagai metode, tapi banyak yang diam.', 'Strategi Mengajar', 1, 15],
            [$m2, 'Bagi template RPP Kumer dong!', 'Apakah ada yang punya template RPP terbaru?', 'Administrasi', 0, 42]
        ];
        $stmt_d = $db->prepare("INSERT INTO gb_discussions (user_id, title, body, category, replies_count, views_count) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($discussions_data as $d) {
            $stmt_d->bind_param("isssii", $d[0], $d[1], $d[2], $d[3], $d[4], $d[5]);
            $stmt_d->execute();
        }
    }

    $db->commit();
    echo "Data dummy realistis berhasil dimasukkan!\n";

} catch (Exception $e) {
    $db->rollback();
    echo "Error: " . $e->getMessage() . "\n";
}

$db->close();
