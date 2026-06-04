<?php
require_once __DIR__ . '/config.php';
$db = getConnection();
echo "=== gb_perpustakaan COLUMNS ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_perpustakaan");
while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
echo "\n=== Sample data ===\n";
$r = $db->query("SELECT * FROM gb_perpustakaan LIMIT 3");
while($c=$r->fetch_assoc()) print_r($c);
echo "\n=== products table ===\n";
$r = $db->query("SHOW COLUMNS FROM products");
while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";
$r2 = $db->query("SELECT * FROM products LIMIT 2");
while($c=$r2->fetch_assoc()) print_r($c);
