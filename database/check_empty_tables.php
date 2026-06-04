<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

echo "=== gb_discussion_replies ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_discussion_replies");
if($r) while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";

echo "\n=== gb_mengajar_tantangan ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_mengajar_tantangan");
if($r) while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";

echo "\n=== gb_mengajar_pelatihan ===\n";
$r = $db->query("SHOW COLUMNS FROM gb_mengajar_pelatihan");
if($r) while($c=$r->fetch_assoc()) echo $c['Field']." -> ".$c['Type']."\n";

$db->close();
