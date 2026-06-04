<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

// 1. Seed gb_discussion_replies
$db->query("TRUNCATE TABLE gb_discussion_replies");
$replies = [
    [1, 5, 'Terima kasih atas diskusinya! Saya juga mengalami kendala yang sama pada modul 2.'],
    [1, 6, 'Menurut saya, pendekatannya bisa dengan membagi kelompok kecil, Pak Budi.'],
    [2, 7, 'Untuk sertifikat, coba cek di tab Sertifikat, saya kemarin langsung muncul.'],
];
$stmt = $db->prepare("INSERT INTO gb_discussion_replies (discussion_id, user_id, body) VALUES (?, ?, ?)");
foreach ($replies as $r) {
    $stmt->bind_param("iis", $r[0], $r[1], $r[2]);
    $stmt->execute();
}
$stmt->close();
// Update replies_count in gb_discussions
$db->query("UPDATE gb_discussions d SET replies_count = (SELECT COUNT(*) FROM gb_discussion_replies r WHERE r.discussion_id = d.id)");

// 2. Seed gb_mengajar_tantangan
$db->query("TRUNCATE TABLE gb_mengajar_tantangan");
$tantangan = [
    [8, '2026-05-26', '🎯', 'Selesaikan 3 modul hari ini', 150, 1, 3, 0],
    [8, '2026-05-26', '📝', 'Buat RPP Inovatif', 300, 0, 1, 0],
    [8, '2026-05-26', '💬', 'Balas 5 diskusi forum', 100, 5, 5, 1],
    [5, '2026-05-26', '🎯', 'Selesaikan 2 modul', 100, 2, 2, 1],
    [5, '2026-05-26', '🗣️', 'Tanya di forum 1x', 50, 0, 1, 0],
];
$stmt = $db->prepare("INSERT INTO gb_mengajar_tantangan (member_id, tanggal, ikon, nama_tantangan, xp_reward, progress, target, is_done) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($tantangan as $t) {
    $stmt->bind_param("isssiiii", $t[0], $t[1], $t[2], $t[3], $t[4], $t[5], $t[6], $t[7]);
    $stmt->execute();
}
$stmt->close();

// 3. Seed gb_mengajar_pelatihan
$db->query("TRUNCATE TABLE gb_mengajar_pelatihan");
$pelatihan = [
    ['🎓', 'Bootcamp Kurikulum Merdeka Terapan', 'Sabtu, 30 Mei', '09:00 - 15:00', 'Zoom Meeting / Online', 'Nadiem Makarim', 'Praktisi Pendidikan', '15', 'Buka', 'Kumer,Praktik', 1, '#6c5ce7'],
    ['💡', 'Workshop AI untuk Asesmen Otomatis', 'Minggu, 31 Mei', '10:00 - 12:00', 'Google Meet / Online', 'Prof. Budi', 'Tech Educator', '5', 'Buka', 'AI,Asesmen', 1, '#0984e3'],
    ['🗣️', 'Public Speaking untuk Guru Modern', 'Sabtu, 6 Juni', '13:00 - 16:00', 'Aula PGRI / Offline', 'Merry Riana', 'Motivator', 'Habis', 'Terdaftar', 'Softskill', 1, '#00b894'],
];
$stmt = $db->prepare("INSERT INTO gb_mengajar_pelatihan (emoji, title, tanggal, waktu, lokasi, mentor, mentor_role, sisa_kursi, status_daftar, tags, ada_sertifikat, warna) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($pelatihan as $p) {
    $stmt->bind_param("ssssssssssis", $p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8], $p[9], $p[10], $p[11]);
    $stmt->execute();
}
$stmt->close();

echo "Seeding completed successfully.";
$db->close();
