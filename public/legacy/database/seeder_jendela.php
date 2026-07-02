<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

try {
    $db->begin_transaction();
    
    // Create table if not exists
    $db->query("CREATE TABLE IF NOT EXISTS gb_inspira_jendela (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(255) NOT NULL,
        kategori VARCHAR(50) NOT NULL,
        gambar VARCHAR(255)
    )");
    
    // Truncate
    $db->query("TRUNCATE TABLE gb_inspira_jendela");
    
    // Seed gb_inspira_jendela
    $jendela = [
        ['Inovasi Pendidikan di Finlandia', 'Global', 'jendela1.jpg'],
        ['Tren EdTech 2026', 'Teknologi', 'jendela2.jpg'],
        ['Metode Montessori Modern', 'Pedagogi', 'jendela3.jpg']
    ];
    $stmt_j = $db->prepare("INSERT INTO gb_inspira_jendela (judul, kategori, gambar) VALUES (?, ?, ?)");
    foreach ($jendela as $j) {
        $stmt_j->bind_param("sss", $j[0], $j[1], $j[2]);
        $stmt_j->execute();
    }
    
    $db->commit();
    echo "Seeding jendela berhasil!";
} catch (Exception $e) {
    $db->rollback();
    echo "Error: " . $e->getMessage();
}
$db->close();
