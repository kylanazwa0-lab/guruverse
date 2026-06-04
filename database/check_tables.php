<?php
require 'config.php';
$c = getConnection();
$r = $c->query('SHOW TABLES');
while($row=$r->fetch_array()){ echo $row[0]."\n"; }
?>
