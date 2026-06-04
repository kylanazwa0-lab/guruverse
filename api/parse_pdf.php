<?php
// api/parse_pdf.php
// Endpoint untuk membaca metadata PDF dan mengembalikannya ke frontend

ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();
header('Content-Type: application/json; charset=utf-8');

// Pastikan user adalah admin
$is_admin = (
    (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) ||
    (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) ||
    (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
);

if (!$is_admin) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Gagal mengupload file atau file tidak ada.']);
    exit;
}

$file = $_FILES['pdf_file'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($ext !== 'pdf') {
    echo json_encode(['success' => false, 'message' => 'File harus berupa PDF.']);
    exit;
}

try {
    $parser = new \Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($file['tmp_name']);
    $details = $pdf->getDetails();
    
    // Ambil metadata judul dari PDF jika ada, jika tidak pakai nama file
    $title = '';
    if (isset($details['Title']) && trim($details['Title']) !== '') {
        $title = trim($details['Title']);
    } else {
        $title = pathinfo($file['name'], PATHINFO_FILENAME);
        // Bersihkan nama file (misal: "Bicara itu ada seninya" atau "Guru-MoveOn-LENGKAP")
        $title = str_replace(['-', '_'], ' ', $title);
        $title = ucwords(strtolower($title));
    }
    
    // Ambil jumlah halaman
    $pages = count($pdf->getPages());
    
    // Coba ekstrak sedikit teks untuk deskripsi (maks 200 karakter)
    $text = $pdf->getText();
    $text = preg_replace('/\s+/', ' ', trim($text)); // Bersihkan whitespace
    $description = mb_substr($text, 0, 200) . (mb_strlen($text) > 200 ? '...' : '');
    
    if (empty($description)) {
        $description = "E-book: $title ($pages Halaman).";
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'title' => $title,
            'pages' => $pages,
            'description' => $description,
            'type' => 'pdf'
        ]
    ]);

} catch (Exception $e) {
    // Jika parser gagal, kita fallback ke nama file
    $title = pathinfo($file['name'], PATHINFO_FILENAME);
    $title = str_replace(['-', '_'], ' ', $title);
    $title = ucwords(strtolower($title));
    
    echo json_encode([
        'success' => true,
        'data' => [
            'title' => $title,
            'pages' => null,
            'description' => "E-book: $title.",
            'type' => 'pdf'
        ],
        'notice' => 'Metadata gagal dibaca: ' . $e->getMessage()
    ]);
}
