<?php
/**
 * modules/dashboard/import_member.php
 * ─────────────────────────────────────────────────────
 * Import data member dari file Excel (.xlsx / .xls).
 * Mendukung password plaintext sesuai permintaan USER.
 * ─────────────────────────────────────────────────────
 */

ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. Cek Auth
if (empty($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

require_once '../../database/config.php';
require_once '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function sendJsonResponse(bool $success, string $message = '', array $extra = []) {
    if (ob_get_length()) ob_clean();
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Method tidak diizinkan.');
}

if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
    sendJsonResponse(false, 'File Excel tidak ditemukan atau gagal diunggah.');
}

$fileTmp  = $_FILES['excel_file']['tmp_name'];
$fileName = $_FILES['excel_file']['name'];
$ext      = pathinfo($fileName, PATHINFO_EXTENSION);

if (!in_array(strtolower($ext), ['xlsx', 'xls'])) {
    sendJsonResponse(false, 'Format file harus .xlsx atau .xls');
}

try {
    $spreadsheet = IOFactory::load($fileTmp);
    $sheet       = $spreadsheet->getActiveSheet();
    $rows        = $sheet->toArray();
    
    // Header check (optional, but good practice)
    // Format yang diharapkan: Nama Lengkap, Username, Instansi, Password, No WhatsApp
    // Kita mulai dari baris ke-2 (index 1) asumsi baris 1 adalah header
    
    if (count($rows) < 2) {
        sendJsonResponse(false, 'File Excel kosong atau tidak memiliki data.');
    }

    $conn = getConnection();
    $conn->begin_transaction();

    $importedCount = 0;
    $skippedCount  = 0;
    $errors        = [];

    $year = date('Y');
    
    // Ambil start number untuk member_id
    $res      = $conn->query("SELECT MAX(CAST(SUBSTRING_INDEX(member_id,'-',1) AS UNSIGNED)) AS mx FROM members");
    $startNum = (int)($res->fetch_assoc()['mx'] ?? 0) + 1;

    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // Skip header

        $fullName    = trim($row[0] ?? '');
        $username    = trim($row[1] ?? '');
        $institution = trim($row[2] ?? '');
        $password    = trim($row[3] ?? '');
        $phone       = trim($row[4] ?? '');

        if (empty($fullName) || empty($username)) {
            $skippedCount++;
            continue;
        }

        // Cek duplikat username
        $chk = $conn->prepare("SELECT id FROM members WHERE username = ? OR email = ?");
        $chk->bind_param('ss', $username, $username);
        $chk->execute();
        if ($chk->get_result()->num_rows > 0) {
            $skippedCount++;
            $chk->close();
            continue;
        }
        $chk->close();

        // Generate Member ID
        $memberId = str_pad($startNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;
        $startNum++;

        // Simpan (Sesuai permintaan: password asli/plaintext)
        $stmt = $conn->prepare(
            "INSERT INTO members (member_id, full_name, username, email, institution, password, phone, joined_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param('sssssss', $memberId, $fullName, $username, $username, $institution, $password, $phone);

        if ($stmt->execute()) {
            $importedCount++;
        } else {
            $errors[] = "Baris " . ($index + 1) . ": " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->commit();
    $conn->close();

    sendJsonResponse(true, "Berhasil mengimport {$importedCount} anggota. (Skipped: {$skippedCount})", [
        'imported' => $importedCount,
        'skipped'  => $skippedCount,
        'errors'   => $errors
    ]);

} catch (Exception $e) {
    if (isset($conn)) $conn->rollback();
    sendJsonResponse(false, 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
}
