<?php
require 'config.php';
$db = getConnection();
$res = $db->query("SELECT id, username, role FROM members");
while($r = $res->fetch_assoc()) echo $r['id']." - ".$r['username']." (".$r['role'].")\n";
