<?php
// ============================================
// api/export_csv.php  (Admin only)
// ============================================

session_start();

if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    die('Unauthorized.');
}

require_once '../database/config.php';

$conn   = getConnection();
$result = $conn->query(
    "SELECT member_id, full_name, email, institution, phone, joined_at
     FROM members ORDER BY joined_at DESC"
);
$conn->close();

$filename = 'Anggota_Guruverse_' . date('Ymd_His') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// BOM UTF-8 agar Excel Indonesia bisa baca karakter dengan benar
echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');
fputcsv($out, ['ID Anggota', 'Nama Lengkap', 'Email', 'Instansi / Sekolah', 'No. WhatsApp', 'Tanggal Daftar']);

while ($row = $result->fetch_assoc()) {
    fputcsv($out, [
        $row['member_id'],
        $row['full_name'],
        $row['email'],
        $row['institution'],
        $row['phone'],
        date('d/m/Y H:i', strtotime($row['joined_at'])),
    ]);
}

fclose($out);
exit;