<?php
require_once __DIR__ . '/config.php';
$db = getConnection();
$res = $db->query('DESCRIBE gb_enrollments');
while($r = $res->fetch_assoc()) {
    echo $r['Field'] . "\n";
}
