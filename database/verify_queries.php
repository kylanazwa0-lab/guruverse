<?php
require_once __DIR__ . '/config.php';
$db = getConnection();
$user_id = 8; // Intan

echo "=== Enrollments (kelas.php) ===\n";
$s = $db->prepare("SELECT e.id, e.status, e.completed_modules, c.title, c.total_modules, c.category, c.duration_hours
    FROM gb_enrollments e JOIN gb_courses c ON e.course_id = c.id
    WHERE e.user_id = ? ORDER BY e.enrolled_at DESC");
$s->bind_param("i", $user_id); $s->execute();
$r = $s->get_result(); $cnt = 0;
while($row = $r->fetch_assoc()) { echo "  ✅ {$row['title']} | status={$row['status']} | modul={$row['completed_modules']}/{$row['total_modules']}\n"; $cnt++; }
echo "  Total: $cnt kelas\n";
$s->close();

echo "\n=== Sertifikat (sertifikat.php) ===\n";
$s = $db->prepare("SELECT cert.id, cert.certificate_number, cert.issued_at, cert.pdf_path, c.title as course_title
    FROM gb_certificates cert JOIN gb_courses c ON cert.course_id = c.id WHERE cert.user_id = ?");
$s->bind_param("i", $user_id); $s->execute();
$r = $s->get_result(); $cnt = 0;
while($row = $r->fetch_assoc()) { echo "  ✅ {$row['course_title']} | num={$row['certificate_number']} | pdf={$row['pdf_path']}\n"; $cnt++; }
echo "  Total: $cnt sertifikat\n";
$s->close();

echo "\n=== Produk Perpustakaan (perpustakaan.php) ===\n";
$s = $db->prepare("SELECT id, title, price, image_url, pdf_url, category, is_free, author FROM products WHERE type = 'ebook' AND status = 'published' ORDER BY created_at DESC");
$s->execute();
$r = $s->get_result(); $cnt = 0;
while($row = $r->fetch_assoc()) { echo "  ✅ {$row['title']} | harga=" . ($row['is_free'] ? 'GRATIS' : 'Rp'.number_format($row['price'],0,',','.')) . " | image={$row['image_url']}\n"; $cnt++; }
echo "  Total: $cnt produk\n";
$s->close();

echo "\n=== Lanjutkan Belajar (dashboard.php) ===\n";
$s = $db->prepare("SELECT e.id, e.completed_modules, c.title, c.total_modules FROM gb_enrollments e JOIN gb_courses c ON e.course_id = c.id WHERE e.user_id = ? AND e.status != 'completed' ORDER BY e.enrolled_at DESC LIMIT 1");
$s->bind_param("i", $user_id); $s->execute();
$r = $s->get_result();
if($row = $r->fetch_assoc()) { echo "  ✅ {$row['title']} ({$row['completed_modules']}/{$row['total_modules']} modul)\n"; }
else { echo "  ℹ️ Tidak ada kelas aktif\n"; }
$s->close();

echo "\n=== SELESAI - Semua query valid ===\n";
