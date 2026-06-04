<?php
require 'config.php';
$db = getConnection();
$tables = ['gb_modules', 'gb_inspira_cerita', 'gb_inspira_proyek', 'gb_inspira_forum', 'gb_inspira_event'];

foreach($tables as $table) {
    echo "--- $table ---\n";
    $res = $db->query("DESCRIBE $table");
    if($res) {
        while($r = $res->fetch_assoc()) echo $r['Field']."\n";
    } else {
        echo "Table does not exist\n";
    }
}
