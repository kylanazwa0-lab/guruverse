<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

// Set password "password" untuk semua member (bcrypt)
$pw = password_hash('password', PASSWORD_BCRYPT);
$db->query("UPDATE members SET password = '$pw', must_change_pass = 0 WHERE role = 'member'");
echo "Semua akun member kini memiliki password: 'password'\n";

// Tampilkan daftar akun
$res = $db->query("SELECT id, username, email, full_name FROM members WHERE role = 'member' ORDER BY id");
while ($r = $res->fetch_assoc()) {
    echo "  ID={$r['id']} | username={$r['username']} | email={$r['email']} | nama={$r['full_name']}\n";
}
$db->close();
