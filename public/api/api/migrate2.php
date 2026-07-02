<?php
require_once __DIR__ . '/../database/config.php';
$c = getConnection();

// Drop foreign keys so we can use system IDs (0 for Admin, -99 for Bot)
$res1 = $c->query("ALTER TABLE gb_discussion_replies DROP FOREIGN KEY gb_discussion_replies_ibfk_2");
$res2 = $c->query("ALTER TABLE gb_discussions DROP FOREIGN KEY gb_discussions_ibfk_1");

echo "Replies FK drop: " . ($res1 ? 'Success' : $c->error) . "\n";
echo "Topics FK drop: " . ($res2 ? 'Success' : $c->error) . "\n";
