<?php
// ── Konfigurasi sesi yang aman (harus sebelum session_start) ─────────────────
ini_set('session.cookie_httponly', 1);    // Cookie tidak bisa diakses JS
ini_set('session.use_strict_mode', 1);    // Tolak session ID yang tidak diinisialisasi server
ini_set('session.cookie_samesite', 'Lax'); // Cegah CSRF via cookie

session_start();

// Koneksi database
require_once __DIR__ . '/../../../database/config.php';
$conn = getConnection();

// ── Validasi sesi ─────────────────────────────────────────────────────────────
// 1. Cek apakah sesi login ada
if (empty($_SESSION['member_int_id']) || empty($_SESSION['member_logged_in'])) {
    session_destroy();
    header('Location: /guruverse/register/register.php');
    exit;
}

// 2. Deteksi Session Hijacking: cek apakah User-Agent berubah sejak login
$current_ua = md5($_SERVER['HTTP_USER_AGENT'] ?? '');
if (!empty($_SESSION['member_user_agent']) && $_SESSION['member_user_agent'] !== $current_ua) {
    // User-Agent berubah — kemungkinan session hijacking
    session_destroy();
    header('Location: /guruverse/register/register.php?reason=security');
    exit;
}

// 3. Session timeout — sesi lebih dari 8 jam dianggap kadaluarsa
if (!empty($_SESSION['member_login_at']) && (time() - $_SESSION['member_login_at']) > 8 * 3600) {
    session_destroy();
    header('Location: /guruverse/register/register.php?reason=timeout');
    exit;
}

$user_id = (int)$_SESSION['member_int_id'];
$user = null;
$stmt = $conn->prepare("SELECT * FROM members WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Akun tidak ditemukan di DB (mungkin dihapus) — paksa logout
    session_destroy();
    header('Location: /guruverse/register/register.php');
    exit;
}
$stmt->close();

// ── Hitung statistik: 4 COUNT digabung menjadi 1 query ──────────────────
$total_kelas = 0;
$kelas_selesai = 0;
$total_sertifikat = 0;
$total_jam = 0;
$unread_notif_count = 0;

// ── Statistik dengan prepared statement (aman dari SQL injection) ────────────
$stmt_stats = $conn->prepare("
    SELECT
        (SELECT COUNT(*) FROM gb_enrollments WHERE user_id = ?) AS total_kelas,
        (SELECT COUNT(*) FROM gb_enrollments WHERE user_id = ? AND status = 'completed') AS kelas_selesai,
        (SELECT COUNT(*) FROM gb_certificates WHERE user_id = ?) AS total_sertifikat,
        (SELECT COALESCE(SUM(c.duration_hours),0) FROM gb_enrollments e JOIN gb_courses c ON e.course_id = c.id WHERE e.user_id = ?) AS total_jam,
        (SELECT COUNT(*) FROM gb_notifications WHERE user_id = ? AND is_read = 0) AS unread_notif
");
$stmt_stats->bind_param("iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);
$stmt_stats->execute();
$res = $stmt_stats->get_result();
$stmt_stats->close();
if ($row = $res->fetch_assoc()) {
    $total_kelas        = (int)$row['total_kelas'];
    $kelas_selesai      = (int)$row['kelas_selesai'];
    $total_sertifikat   = (int)$row['total_sertifikat'];
    $total_jam          = (float)$row['total_jam'];
    $unread_notif_count = (int)$row['unread_notif'];
}

// ── Ambil notifikasi dengan prepared statement ───────────────────────────────
$notifications = [];
$stmt_notif = $conn->prepare("SELECT id, title, body, icon, link, is_read, created_at FROM gb_notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt_notif->bind_param("i", $user_id);
$stmt_notif->execute();
$res_notif = $stmt_notif->get_result();
if ($res_notif) {
    while ($row = $res_notif->fetch_assoc()) {
        $notifications[] = $row;
    }
}
$stmt_notif->close();

// ── Data halaman khusus — hanya load jika dibutuhkan ─────────────────────
// $enrollments, $available_courses, $certificates, $discussions, $ebooks
// dimuat masing-masing di dalam page file supaya tidak memperlambat
// request saat user mengunjungi halaman lain.

$user_name = $user ? $user['full_name'] : 'Member';
$user_initials = '';
if ($user) {
    $parts = explode(' ', $user['full_name']);
    $user_initials = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) $user_initials .= strtoupper(substr($parts[1], 0, 1));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="/guruverse/asset/img/logo guruverse FA.ai.png">
<title>Guruverse.ID &mdash; Guru Belajar</title>
<!-- ⚡ CRITICAL: Set theme before CSS loads to prevent flash & choppy transition -->
<script>
(function(){
  var t = localStorage.getItem('guruverse_theme');
  if (!t) t = window.matchMedia('(prefers-color-scheme:dark)').matches ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', t);
  /* Disable ALL transitions during initial load so theme doesn't animate from wrong state */
  var s = document.createElement('style');
  s.id = '__no-transition';
  s.textContent = '*,*::before,*::after{transition:none!important}';
  document.head.appendChild(s);
  /* Re-enable after 2 animation frames (ensures layout is painted first) */
  requestAnimationFrame(function(){
    requestAnimationFrame(function(){
      var el = document.getElementById('__no-transition');
      if (el) el.remove();
    });
  });
})();
</script>
<!-- Preconnect: percepat DNS lookup untuk resource eksternal -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<!-- Google Fonts: hanya 3 weight yang benar-benar dipakai (hemat 4 HTTP req) -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flyonui/dist/full.min.css">
<link rel="stylesheet" href="/guruverse/guru-belajar/member/css/style.css">
<link rel="stylesheet" href="/guruverse/guru-belajar/member/css/lms-player.css">
</head>
<body>
