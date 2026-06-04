<?php
require_once __DIR__ . '/config.php';
$db = getConnection();
echo "=== gb_certificates COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_certificates"); while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
echo "\n=== gb_courses COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_courses"); while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
echo "\n=== gb_enrollments COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_enrollments"); while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
echo "\n=== gb_products (perpustakaan) COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_products"); while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
echo "\n=== gb_discussions COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_discussions"); while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
echo "\n=== Sample certificates ===\n";
$r = $db->query("SELECT * FROM gb_certificates LIMIT 2"); while($c=$r->fetch_assoc()) print_r($c);
echo "\n=== Sample courses ===\n";
$r = $db->query("SELECT id, title, total_modules, status FROM gb_courses LIMIT 3"); while($c=$r->fetch_assoc()) print_r($c);
echo "\n=== Sample enrollments for user 8 ===\n";
$r = $db->query("SELECT * FROM gb_enrollments WHERE user_id=8 LIMIT 3"); while($c=$r->fetch_assoc()) print_r($c);
