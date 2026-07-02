<?php
// ============================================
// database/config.php
// ============================================

function getConnection() {

    $host = '127.0.0.1'; 
    $user = 'root';     
    $pass = '';          
    $db   = 'guruverse'; 

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");

    return $conn;
}
