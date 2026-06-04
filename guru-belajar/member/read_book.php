<?php
session_start();
// Cek session login member
if (!isset($_SESSION['member_int_id']) && !isset($_SESSION['member_id'])) {
    header("Location: /guruverse/register/register.php");
    exit;
}

$url = $_GET['url'] ?? '';
$title = $_GET['title'] ?? 'Membaca E-Book';

if (empty($url)) {
    die("URL dokumen tidak valid.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title) ?> - Guruverse.id</title>
<link rel="icon" type="image/png" href="/guruverse/asset/img/logo guruverse FA.ai.png"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
  body, html { margin: 0; padding: 0; width: 100%; height: 100%; overflow: hidden; font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; color: #fff; }
  .header { display: flex; align-items: center; justify-content: space-between; padding: 12px 24px; background: #1e293b; border-bottom: 1px solid rgba(255,255,255,0.1); height: 64px; box-sizing: border-box; }
  .header-left { display: flex; align-items: center; gap: 20px; }
  
  .back-btn { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: rgba(255,255,255,0.05); border-radius: 10px; color: #94a3b8; text-decoration: none; transition: all 0.2s; border: 1px solid rgba(255,255,255,0.1); }
  .back-btn:hover { background: rgba(255,255,255,0.15); color: #fff; transform: translateX(-2px); }
  
  .book-info { display: flex; flex-direction: column; gap: 2px; }
  .book-title { font-size: 15px; font-weight: 800; color: #f8fafc; margin: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px; }
  .book-subtitle { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em; }
  
  .header-right { display: flex; align-items: center; gap: 12px; }
  .download-btn { display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(16, 185, 129, 0.15); border-radius: 10px; color: #10b981; text-decoration: none; font-size: 12px; font-weight: 800; transition: all 0.2s; border: none; cursor: pointer; }
  .download-btn:hover { background: #10b981; color: #fff; }

  .content { width: 100%; height: calc(100vh - 64px); background: #f1f5f9; position: relative; }
  iframe { width: 100%; height: 100%; border: none; }
</style>
</head>
<body>
  <div class="header">
    <div class="header-left">
      <a href="javascript:window.close();" class="back-btn" title="Kembali" onclick="if(window.history.length > 1) { window.history.back(); return false; }">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
      </a>
      <div class="book-info">
        <div class="book-subtitle">GURUVERSE.ID E-BOOK READER</div>
        <h1 class="book-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
          <?= htmlspecialchars($title) ?>
        </h1>
      </div>
    </div>
    <div class="header-right">
      <a href="<?= htmlspecialchars($url) ?>" download="<?= htmlspecialchars($title) ?>.pdf" class="download-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Unduh File PDF
      </a>
    </div>
  </div>
  <div class="content">
    <?php
    $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
    $office_exts = ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'];
    if (in_array($ext, $office_exts)) {
        $is_localhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:8080']);
        if ($is_localhost) {
            echo '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;text-align:center;padding:40px;">';
            echo '<div style="font-size:4rem;margin-bottom:15px;">' . (strpos($ext, 'ppt') !== false ? '📽️' : '📝') . '</div>';
            echo '<h2 style="color:#0f172a;margin-bottom:10px;">Mode Localhost Aktif</h2>';
            echo '<p style="color:#64748b;font-size:14px;max-width:400px;line-height:1.6;margin-bottom:20px;">Sistem mendeteksi Anda menjalankan aplikasi di <b>Localhost</b>. Fitur pratinjau langsung memerlukan koneksi internet ke URL web Anda (Live Hosting).</p>';
            echo '<a href="' . htmlspecialchars($url) . '" download class="download-btn" style="display:inline-flex;padding:12px 24px;font-size:14px;">Unduh File untuk Melihat</a>';
            echo '</div>';
        } else {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $fullUrl = $protocol . "://" . $host . $url;
            $viewerUrl = "https://view.officeapps.live.com/op/embed.aspx?src=" . urlencode($fullUrl);
            echo '<iframe src="' . htmlspecialchars($viewerUrl) . '" allowfullscreen webkitallowfullscreen></iframe>';
        }
    } else {
        echo '<iframe src="' . htmlspecialchars($url) . '" allowfullscreen webkitallowfullscreen></iframe>';
    }
    ?>
  </div>
</body>
</html>
