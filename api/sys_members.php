<?php
require_once __DIR__ . '/../database/config.php';
$c = getConnection();

// Temporarily disable strict SQL mode so we can insert 0 if auto-increment prevents it
$c->query("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");

// Insert Admin (ID 0)
$res1 = $c->query("INSERT IGNORE INTO members (id, full_name, username, password) VALUES (0, 'Admin Guruverse', 'admin_sys', 'hidden')");

// Insert Bot (ID -99)
$res2 = $c->query("INSERT IGNORE INTO members (id, full_name, username, password) VALUES (-99, 'Guruverse Bot', 'bot_sys', 'hidden')");

echo "Admin insert: " . ($res1 ? 'Success' : $c->error) . "\n";
echo "Bot insert: " . ($res2 ? 'Success' : $c->error) . "\n";
