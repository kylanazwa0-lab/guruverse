<?php
// ============================================
// api/export_pdf.php  (Admin only)
// ============================================
session_start();

if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    die('Unauthorized.');
}

require_once '../../database/config.php';

$conn   = getConnection();
$result = $conn->query(
    "SELECT member_id, full_name, username, institution, password, phone, joined_at
     FROM members ORDER BY joined_at DESC"
);
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export PDF - Anggota Guruverse</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Cetak / Simpan PDF</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    <h2>DATA ANGGOTA GURUVERSE.ID</h2>
    <p>Diekspor pada: <?= date('d/m/Y H:i:s') ?></p>
    <table>
        <thead>
            <tr>
                <th>ID Anggota</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Instansi / Sekolah</th>
                <th>Password</th>
                <th>No. WhatsApp</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['member_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['full_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['username'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['institution'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['password'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['joined_at'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>