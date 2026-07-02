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

    // Set charset ke utf8mb4 (disarankan)
    $conn->set_charset("utf8mb4");

    // Hindari error pada collation yang tidak dikenal (mis. utf8mb4_unicode_ci
    // yang hanya ada di MySQL 8 tertentu). Kita set ke collation generik.
    $conn->query("SET NAMES utf8mb4");

    return $conn;
}

