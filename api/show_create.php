<?php
require_once __DIR__ . '/../database/config.php';
$c = getConnection();
$res = $c->query("SHOW CREATE TABLE gb_discussion_replies");
$row = $res->fetch_assoc();
echo $row['Create Table'];
echo "\n\n";
$res2 = $c->query("SHOW CREATE TABLE gb_discussions");
$row2 = $res2->fetch_assoc();
echo $row2['Create Table'];
