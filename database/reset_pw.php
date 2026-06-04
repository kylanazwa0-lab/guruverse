<?php
require_once __DIR__ . '/config.php';
$db = getConnection();
$pw = password_hash('intan123', PASSWORD_BCRYPT);
$result = $db->query("UPDATE members SET password = '$pw', must_change_pass = 0 WHERE username = 'intan'");
if ($db->affected_rows > 0) {
    echo "Password akun 'intan' berhasil dikembalikan ke 'intan123'";
} else {
    echo "Tidak ada baris yang berubah. Cek username.";
}
$db->close();
