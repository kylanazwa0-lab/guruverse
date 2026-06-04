<?php
// member/pages/Guru_Gamifikasi/index.php
// Front‑end page for gamifikasi activities (E-Library Presentation Mode)
// Loads catalog from admin/api/gamification.php

session_start();
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
$is_user = isset($_SESSION['user_id']);
$is_member = isset($_SESSION['member_int_id']) || isset($_SESSION['member_logged_in']);

if (!$is_user && !$is_admin && !$is_member) {
    // Determine the correct login redirect path
    $login_path = file_exists('../../login.php') ? '../../login.php' : '/guruverse/index.php';
    header('Location: ' . $login_path);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru Gamifikasi - Bank Materi</title>
    <link rel="icon" type="image/png" href="/guruverse/asset/img/logo guruverse FA.ai.png">
    <link rel="stylesheet" href="/guruverse/assets/gamifikasi/css/gamifikasi.css?v=2.6">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .header-actions { position:absolute; top:20px; right:20px; z-index:100; }
        .theme-toggle {
            background: rgba(139,47,201,0.12);
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            padding: 7px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.82rem;
            transition: all 0.2s;
            backdrop-filter: blur(6px);
        }
        .theme-toggle:hover { background:var(--color-primary); color:#fff; }
        .theme-dark .theme-toggle {
            background: rgba(139,47,201,0.25);
            color: #c084fc;
            border-color: #c084fc;
        }
        .theme-dark .theme-toggle:hover { background: #7c3aed; color: #fff; }
    </style>
</head>
<body>
    <div class="header-actions">
        <button class="theme-toggle" id="theme-toggle-btn" onclick="toggleTheme()">☀️ Mode Terang</button>
    </div>

    <!-- Hiasan Melayang dari Gambar User -->
    <div class="floating-decorations">
        <div class="sprite sprite-astro delay-1"></div>
        <div class="sprite sprite-ufo delay-2"></div>
        <div class="sprite sprite-rocket delay-3"></div>
        <div class="sprite sprite-planet delay-4"></div>
        <div class="sprite sprite-crystal delay-5"></div>
        <div class="sprite sprite-flag delay-6"></div>
    </div>

    <div class="gamifikasi-container">
        <h1 class="page-title">Pusat Materi Gamifikasi (Guruverse)</h1>
        
        <div id="activity-list" class="activity-list">
            <!-- Loading indicator -->
            <div style="width:100%; text-align:center; padding:50px; color:var(--muted);">
                <h2>Memuat Katalog...</h2>
            </div>
        </div>

        <div id="activity-detail" class="activity-detail hidden" style="margin-top:0;">
            <div class="game-header" style="margin-bottom:20px; border-radius:8px;">
                <button id="btn-back" style="background:rgba(255,255,255,0.2); border:none; color:#fff; padding:6px 12px; border-radius:6px; cursor:pointer; font-weight:bold;">← Kembali</button>
                <div id="detail-title" style="flex:1; text-align:center; font-size:1.2rem; padding-right:85px;"></div>
            </div>
            
            <div id="viewer-container" class="viewer-container">
                <!-- Iframe / Download button injected here -->
            </div>

            <div class="xp-claim-section">
                <button id="btn-claim" class="game-start-btn" style="font-size:1rem; padding:12px 24px;">Selesaikan Sesi &amp; Klaim XP</button>
                <div id="claim-msg" style="display:none;"></div>
            </div>
        </div>
    </div>

    <script src="/guruverse/assets/gamifikasi/js/gamifikasi.js?v=3.0"></script>
    <script>
        const body = document.body;
        const toggleBtn = document.getElementById('theme-toggle-btn');

        function applyTheme(theme) {
            body.className = theme;
            if (toggleBtn) {
                toggleBtn.textContent = theme === 'theme-dark' ? '🌙 Mode Gelap' : '☀️ Mode Terang';
            }
        }

        // Restore saved theme or detect system preference
        const saved = localStorage.getItem('gv-theme');
        if (saved) {
            applyTheme(saved);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('theme-dark');
        } else {
            applyTheme('theme-light');
        }

        function toggleTheme() {
            const newTheme = body.classList.contains('theme-dark') ? 'theme-light' : 'theme-dark';
            applyTheme(newTheme);
            localStorage.setItem('gv-theme', newTheme);
        }
    </script>
</body>
</html>
