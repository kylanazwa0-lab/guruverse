<?php
require_once __DIR__ . '/config.php';
$db = getConnection();
echo "=== ALL TABLES in guruverse ===\n";
$r = $db->query("SHOW TABLES"); while($c=$r->fetch_array()) echo $c[0]."\n";

echo "\n=== gb_discussions COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_discussions"); while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";

echo "\n=== Sample certificates for user 8 ===\n";
$r = $db->query("SELECT * FROM gb_certificates WHERE user_id=8 LIMIT 2"); while($c=$r->fetch_assoc()) print_r($c);

echo "\n=== Sample enrollments for user 8 ===\n";
$r = $db->query("SELECT id, course_id, status, progress_percent, completed_modules, current_module FROM gb_enrollments WHERE user_id=8 LIMIT 3"); while($c=$r->fetch_assoc()) print_r($c);

echo "\n=== Count enrollments for user 8 ===\n";
$r = $db->query("SELECT COUNT(*) as cnt FROM gb_enrollments WHERE user_id=8");
print_r($r->fetch_assoc());
