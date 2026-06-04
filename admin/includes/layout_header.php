<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once __DIR__ . '/../../database/config.php';
$conn = getConnection();
$current_mod = $_GET['mod'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="icon" type="image/png" href="../asset/img/logo guruverse FA.ai.png">
<title>Admin Panel — Guruverse.id</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../asset/css/admin.css?v=1.1.0">
<!-- FlyonUI & Tailwind -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flyonui@1.0.0/dist/flyonui.css">
<script src="https://cdn.tailwindcss.com"></script>
<style>
/* Fix FlyonUI Action Dropdowns in tables causing overflow */
td .dropdown .dropdown-menu,
.dropdown.absolute .dropdown-menu {
  right: 0 !important;
  left: auto !important;
  top: 100% !important;
  margin-top: 4px;
  background: #ffffff;
  border: 1px solid var(--border);
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  border-radius: 8px;
  padding: 0.25rem 0;
  z-index: 9999;
}
td .dropdown .dropdown-item,
.dropdown.absolute .dropdown-item {
  padding: 0.5rem 1rem;
  font-size: 0.82rem;
  font-weight: 500;
}
</style>
</head>
<script>
  function toggleDesktopSidebar() {
    const sb = document.getElementById('sidebar');
    const main = document.querySelector('.main');
    sb.classList.toggle('collapsed');
    main.classList.toggle('collapsed');
    localStorage.setItem('sidebar_collapsed', sb.classList.contains('collapsed') ? '1' : '0');
  }
  document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('sidebar_collapsed') === '1' && window.innerWidth > 900) {
      document.getElementById('sidebar').classList.add('collapsed');
      document.querySelector('.main').classList.add('collapsed');
    }
  });
</script>
<body>

<div class="mob-overlay" id="mob-overlay" onclick="closeSidebar()"></div>
<div class="layout">
  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sb-logo">
      <!-- Logo negative (putih) untuk background sidebar gelap -->
      <img
        src="/guruverse/asset/img/FA Logo Guruverse.ID - negative.png"
        alt="Guruverse.ID"
        class="logo-expanded"
        style="height:28px;object-fit:contain;width:auto;"
        onerror="this.style.display='none';document.getElementById('sb-logo-fallback').style.display='flex';"
      >
      <img
        src="/guruverse/asset/img/logo guruverse FA.ai.png"
        alt="GV"
        class="logo-collapsed"
        style="height:32px;object-fit:contain;width:auto;display:none;"
      >
      <span id="sb-logo-fallback" class="logo-expanded" style="display:none;font-weight:900;font-size:1rem;color:#fff;letter-spacing:-0.02em;">Guruverse</span>
    </div>

    <!-- Profile Card -->
    <div class="sb-profile">
      <div class="sb-profile-avatar">AD</div>
      <div class="sb-profile-info">
        <div class="sb-profile-name">Administrator</div>
        <div class="sb-profile-role">Super Admin</div>
      </div>
      <div class="sb-profile-dot"></div>
    </div>

    <div class="sb-section">
      <div class="sb-section-label">Menu Utama</div>
      <a class="sb-link <?= $current_mod==='dashboard'?'active':'' ?>" href="index.php?mod=dashboard">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>
      <a class="sb-link <?= $current_mod==='member'?'active':'' ?>" href="index.php?mod=member">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Data Member
      </a>
    </div>

    <div class="sb-divider"></div>

    <div class="sb-section">
      <div class="sb-section-label" style="color: rgba(147,181,255,0.55);">Pilar: Guru Belajar</div>
      <a class="sb-link <?= $current_mod==='kelas'?'active':'' ?>" href="index.php?mod=kelas">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        Manajemen Kelas
      </a>
      <a class="sb-link <?= $current_mod==='modul'?'active':'' ?>" href="index.php?mod=modul">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        Modul Pembelajaran
      </a>
      <a class="sb-link <?= $current_mod==='produk'?'active':'' ?>" href="index.php?mod=produk">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        Perpustakaan & E-Book
      </a>
      <a class="sb-link <?= $current_mod==='sertifikat'?'active':'' ?>" href="index.php?mod=sertifikat">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        Sertifikat Member
      </a>
    </div>

    <div class="sb-divider"></div>

    <div class="sb-section">
      <div class="sb-section-label" style="color: rgba(251,191,136,0.55);">Pilar: Guru Inspira</div>
      <a class="sb-link <?= $current_mod==='inspira_cerita'?'active':'' ?>" href="index.php?mod=inspira_cerita">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Cerita & Artikel
      </a>
      <a class="sb-link <?= $current_mod==='inspira_agenda'?'active':'' ?>" href="index.php?mod=inspira_agenda">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Agenda & Event
      </a>
    </div>

    <div class="sb-divider"></div>

    <div class="sb-section">
      <div class="sb-section-label" style="color: rgba(110,231,183,0.55);">Pilar: Guru Mengajar</div>
      <a class="sb-link <?= $current_mod==='mengajar_jadwal'?'active':'' ?>" href="index.php?mod=mengajar_jadwal">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Monitoring Jadwal
      </a>
      <a class="sb-link <?= $current_mod==='mengajar_gamifikasi'?'active':'' ?>" href="index.php?mod=mengajar_gamifikasi&v=<?= time() ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        Statistik Gamifikasi
      </a>
    </div>

    <div class="sb-divider"></div>

    <div class="sb-section">
      <div class="sb-section-label">Komunitas & Pengaturan</div>
      <a class="sb-link <?= $current_mod==='diskusi'?'active':'' ?>" href="index.php?mod=diskusi">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Forum Diskusi
      </a>
      <a class="sb-link <?= $current_mod==='live_chat'?'active':'' ?>" href="index.php?mod=live_chat">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        Live Chat Admin
      </a>
      <a class="sb-link <?= $current_mod==='bot_settings'?'active':'' ?>" href="index.php?mod=bot_settings">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
        Manajemen Bot
      </a>
      <a class="sb-link <?= $current_mod==='notifikasi'?'active':'' ?>" href="index.php?mod=notifikasi">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi
      </a>
    </div>

    <div class="sb-divider"></div>

    <div class="sb-section">
      <div class="sb-section-label">Lainnya</div>
      <a class="sb-link" href="../modules/dashboard/export_xlsx.php" target="_blank">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export Excel
      </a>
    </div>

    <div class="sb-bottom">
      <a href="../admin.php?logout=1" class="sb-link" style="color:rgba(252,165,165,0.7); margin-top:2px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar
      </a>
    </div>
  </aside>

  <!-- MAIN CONTENT AREA -->
  <div class="main">
    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="mob-ham btn-sm" onclick="openSidebar()" style="background:var(--bg);color:var(--muted);border:1px solid var(--border);">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <button class="desktop-ham btn-sm" onclick="toggleDesktopSidebar()" style="background:var(--bg);color:var(--muted);border:1px solid var(--border); margin-right: 12px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 6h16M4 12h10M4 18h16"/></svg>
        </button>
        <div>
          <div class="topbar-title" id="topbar-title">
            <?php
              $titles = [
                'dashboard'=>'Dashboard',
                'member'=>'Data Member',
                'kelas'=>'Manajemen Kelas',
                'modul'=>'Modul Pembelajaran',
                'sertifikat'=>'Sertifikat Member',
                'diskusi'=>'Forum Diskusi',
                'notifikasi'=>'Notifikasi', 
                'produk'=>'Perpustakaan & E-Book',
                'inspira_cerita'=>'Cerita & Artikel',
                'inspira_agenda'=>'Agenda & Event',
                'mengajar_jadwal'=>'Monitoring Jadwal',
                'mengajar_gamifikasi'=>'Statistik Gamifikasi',
                'live_chat'=>'Live Chat Admin',
                'bot_settings'=>'Manajemen Bot'
              ];
              echo $titles[$current_mod] ?? 'Admin Panel';
            ?>
          </div>
          <div class="topbar-sub">Guruverse.id — Admin Panel</div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="topbar-clock">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
          <span id="clock"></span>
        </div>
        <div class="dropdown relative inline-flex">
          <button type="button" class="notif-btn dropdown-toggle" id="notif-dropdown-btn" style="background:transparent;border:none;cursor:pointer;position:relative;padding:8px">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="notif-badge" id="notif-badge" style="display:none;position:absolute;top:2px;right:2px;background:#ef4444;color:#fff;font-size:10px;font-weight:bold;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff">0</span>
          </button>
          <ul class="dropdown-menu" id="notif-dropdown-menu" style="width:350px;right:0;left:auto;padding:0;overflow:hidden;max-height:none">
            <li style="padding:12px 16px;font-weight:800;border-bottom:1px solid var(--border);font-size:0.9rem">Notifikasi Aktivitas</li>
            <div id="notif-list-container" style="max-height:350px;overflow-y:auto;background:#fafbfc">
               <div style="padding:20px;text-align:center;color:var(--muted);font-size:0.8rem">Memuat...</div>
            </div>
            <li style="padding:10px;text-align:center;border-top:1px solid var(--border);background:#fff"><a href="?mod=dashboard" style="font-size:0.75rem;color:var(--v1);font-weight:700">Lihat Dashboard</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page content injected here -->
    <div class="content">
