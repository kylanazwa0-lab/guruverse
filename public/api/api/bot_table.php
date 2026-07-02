<?php
require_once __DIR__ . '/../database/config.php';
$c = getConnection();
$q = 'CREATE TABLE IF NOT EXISTS gb_bot_rules (id INT AUTO_INCREMENT PRIMARY KEY, keywords TEXT, answer TEXT)';
$c->query($q);

// Insert default rules if empty
$res = $c->query("SELECT COUNT(*) as c FROM gb_bot_rules");
$row = $res->fetch_assoc();
if ($row['c'] == 0) {
    $c->query("INSERT INTO gb_bot_rules (keywords, answer) VALUES ('sertifikat,piagam', 'Halo! Untuk mengunduh sertifikat, silakan buka menu Sertifikat di panel kiri, lalu klik tombol Unduh pada kelas yang telah Anda selesaikan. 🎓')");
    $c->query("INSERT INTO gb_bot_rules (keywords, answer) VALUES ('lupa password,kata sandi,reset', 'Jika Anda mengalami masalah login atau lupa password, silakan hubungi tim Support melalui email ke support@guruverse.id. Kami siap membantu! 🛠️')");
    $c->query("INSERT INTO gb_bot_rules (keywords, answer) VALUES ('kurikulum merdeka,kumer', 'Terkait Kurikulum Merdeka, Guruverse menyediakan modul pembelajaran khusus di menu Manajemen Kelas. Pastikan Anda sudah terdaftar di kelas tersebut ya! 📚')");
    $c->query("INSERT INTO gb_bot_rules (keywords, answer) VALUES ('halo,hai,ping', 'Halo! 👋 Saya adalah Guruverse Bot. Ada yang bisa saya bantu hari ini mengenai platform pembelajaran kita?')");
}
echo "Table and defaults ready.";
