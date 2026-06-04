<?php
// ============================================
// api/export_xlsx.php  (Admin only)
// ============================================

session_start();

if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    die('Unauthorized.');
}

require_once '../database/config.php';

// Autoload PhpSpreadsheet (install via: composer require phpoffice/phpspreadsheet)
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

// Ambil data dari DB
$conn   = getConnection();
$result = $conn->query(
    "SELECT member_id, full_name, email, institution, phone, joined_at
     FROM members ORDER BY member_id ASC"
);
$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}
$conn->close();

// ── Buat Spreadsheet ──
$spreadsheet = new Spreadsheet();
$sheet       = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Anggota');

// ── HEADER ROW ──
$headers = [
    'A' => 'ID Anggota',
    'B' => 'Nama Lengkap',
    'C' => 'Email',
    'D' => 'Instansi / Sekolah',
    'E' => 'No. WhatsApp',
    'F' => 'Tanggal Daftar',
];

foreach ($headers as $col => $label) {
    $sheet->setCellValue($col . '1', $label);
}

// Style header — background ungu, teks putih, bold, center
$headerStyle = [
    'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF6D28D9']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF5B21B6']]],
];
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(24);

// ── DATA ROWS ──
$rowNum = 2;
foreach ($members as $m) {
    $sheet->setCellValue('A' . $rowNum, $m['member_id']);
    $sheet->setCellValue('B' . $rowNum, $m['full_name']);
    $sheet->setCellValue('C' . $rowNum, $m['email']);
    $sheet->setCellValue('D' . $rowNum, $m['institution']);
    $sheet->setCellValue('E' . $rowNum, $m['phone']);
    $sheet->setCellValue('F' . $rowNum, date('d/m/Y H:i', strtotime($m['joined_at'])));

    // Zebra stripe — baris genap sedikit berbeda warna
    $bgColor = ($rowNum % 2 === 0) ? 'FFF5F3FF' : 'FFFFFFFF';
    $sheet->getStyle("A{$rowNum}:F{$rowNum}")->applyFromArray([
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE9D5FF']]],
        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    ]);
    $sheet->getRowDimension($rowNum)->setRowHeight(20);
    $rowNum++;
}

// ── Kolom ID Anggota — center ──
$sheet->getStyle('A2:A' . ($rowNum - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// ── Lebar kolom ──
$sheet->getColumnDimension('A')->setWidth(14);
$sheet->getColumnDimension('B')->setWidth(28);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(32);
$sheet->getColumnDimension('E')->setWidth(18);
$sheet->getColumnDimension('F')->setWidth(18);

// ── Freeze header ──
$sheet->freezePane('A2');

// ── Auto filter ──
$sheet->setAutoFilter('A1:F1');

// ── Judul di atas tabel ──
$sheet->insertNewRowBefore(1, 2);
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('A1', 'DATA ANGGOTA GURUVERSE.ID');
$sheet->getStyle('A1')->applyFromArray([
    'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF6D28D9']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
]);
$sheet->getRowDimension(1)->setRowHeight(30);

$sheet->mergeCells('A2:F2');
$sheet->setCellValue('A2', 'Diekspor pada: ' . date('d/m/Y H:i:s') . '  |  Total: ' . count($members) . ' anggota');
$sheet->getStyle('A2')->applyFromArray([
    'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF888888']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);
$sheet->getRowDimension(2)->setRowHeight(16);

// ── Output ke browser ──
$filename = 'Anggota_Guruverse_' . date('Ymd_His') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;