<?php
/* ══════════════════════════════════════════════════
     SIDEBAR GURU INSPIRA
══════════════════════════════════════════════════ */
?>
<aside class="sidebar">
  <div class="sidebar-toggle-btn" onclick="toggleSidebar()">
    <svg class="stb-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
  </div>
  <div class="sidebar-brand" style="padding:16px 20px 14px;border-bottom:1px solid rgba(255,255,255,0.07)">
    <img src="/guruverse/asset/img/FA Logo Guruverse.ID - main.png" class="brand-logo-light" alt="GuruVerse.ID" style="height:28px;width:auto;object-fit:contain;display:block">
    <img src="/guruverse/asset/img/FA Logo Guruverse.ID - nrgative.png" class="brand-logo-dark" alt="GuruVerse.ID" style="height:28px;width:auto;object-fit:contain;display:none">
  </div>

  <a href="/guruverse/guru-belajar/member/home_member.php" style="display:flex; align-items:center; gap:8px; padding:12px 20px; font-size:12px; font-weight:700; color:rgba(255,255,255,0.6); text-decoration:none; border-bottom:1px solid rgba(255,255,255,0.07); transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Portal
  </a>

  <nav class="sidebar-nav">
    <span class="nav-label">Menu Utama</span>
    <a class="nav-item active" onclick="showPage('dashboard')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span> 
      <span class="nav-text">Dashboard</span>
    </a>
    <a class="nav-item" onclick="showPage('forum')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span> 
      <span class="nav-text">Forum Diskusi</span>
    </a>
    <a class="nav-item" onclick="showPage('proyek')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></span> 
      <span class="nav-text">Kolaborasi Proyek</span>
    </a>
    <a class="nav-item" onclick="showPage('cerita')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></span> 
      <span class="nav-text">Cerita Inspiratif</span>
    </a>
    <a class="nav-item" onclick="showPage('agenda')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span> 
      <span class="nav-text">Agenda & Event</span>
    </a>
    <a class="nav-item" onclick="showPage('jendela')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span> 
      <span class="nav-text">Jendela Dunia</span>
    </a>
    <span class="nav-label" style="margin-top:8px">Komunitas</span>
    <a class="nav-item" onclick="showPage('diskusi')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span> 
      <span class="nav-text">Rekan Kolaborasi</span>
    </a>

    <span class="nav-label" style="margin-top:8px">Akun</span>
    <a class="nav-item" onclick="showPage('pengaturan')">
      <span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span> 
      <span class="nav-text">Pengaturan</span>
    </a>
  </nav>

  <div class="sidebar-promo">
    <span class="promo-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg></span>
    <h4>Ajak rekan guru</h4>
    <p>Dapatkan benefit menarik!</p>
    <button class="btn-promo">Ajak Sekarang</button>
  </div>
</aside>

<!-- ══════════════════════════════════════════════════
     TOPBAR
══════════════════════════════════════════════════ -->
<header class="topbar">
  <span class="topbar-hamburger" onclick="toggleSidebar()" title="Toggle Sidebar" style="cursor:pointer; margin-right: 16px; display: none;">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
  </span>

  <div class="topbar-logo">
    <img src="/guruverse/asset/img/FA Logo Guruverse.ID - main.png" class="brand-logo-light" alt="GuruVerse.ID" style="height:26px;width:auto;object-fit:contain;display:block">
    <img src="/guruverse/asset/img/FA Logo Guruverse.ID - nrgative.png" class="brand-logo-dark" alt="GuruVerse.ID" style="height:26px;width:auto;object-fit:contain;display:none">
  </div>

  <div class="search-wrap">
    <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
    <input class="search-input" type="text" placeholder="Cari kelas, materi, topik...">
  </div>

  <div class="topbar-right">
    <!-- Dark / Light Mode Toggle -->
    <button class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleDarkMode()" title="Ganti Mode Tampilan">
      <!-- Moon (tampil di mode terang) -->
      <span class="icon-moon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </span>
      <!-- Sun (tampil di mode gelap) -->
      <span class="icon-sun">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
      </span>
    </button>
    <button class="notif-btn" onclick="toggleNotif()">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <?php if ($unread_notif_count > 0): ?>
        <span class="notif-count"><?= $unread_notif_count ?></span>
      <?php endif; ?>
    </button>
    <div class="topbar-divider"></div>
    <div class="user-pill" id="userPill" onclick="toggleUserMenu()" style="cursor:pointer;position:relative">
      <div class="user-avatar" style="font-size:14px;font-weight:800;color:#fff"><?= htmlspecialchars($user_initials) ?></div>
      <div>
        <div class="user-name"><?= htmlspecialchars($user_name) ?></div>
        <div class="user-role"><?= htmlspecialchars($user['institution'] ?? 'Member') ?></div>
      </div>
      <span class="user-chevron">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      </span>
    </div>
  </div>
</header>

<!-- User Dropdown Menu -->
<div id="userDropdown" style="
  display:none;position:fixed;top:68px;right:16px;z-index:9999;
  background:#ffffff;border:1px solid #e2e8f0;
  border-radius:14px;padding:6px;min-width:200px;
  box-shadow:0 10px 40px rgba(0,0,0,0.18), 0 2px 8px rgba(0,0,0,0.08);
">
  <div style="padding:10px 12px 10px;border-bottom:1px solid #f1f5f9;margin-bottom:4px">
    <div style="font-weight:700;font-size:13px;color:#1e293b"><?= htmlspecialchars($user_name) ?></div>
    <div style="font-size:11px;color:#64748b;margin-top:2px"><?= htmlspecialchars($user['institution'] ?? 'Member') ?></div>
  </div>
  <a onclick="showPage('pengaturan');document.getElementById('userDropdown').style.display='none'"
     style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:500;color:#334155;text-decoration:none;transition:background .15s"
     onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6c5ce7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
    Profil Saya
  </a>
  <div style="height:1px;background:#f1f5f9;margin:4px 0"></div>
  <a id="logoutBtn" onclick="openLogoutModal()"
     style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;color:#ef4444;text-decoration:none;transition:background .15s"
     onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    Keluar
  </a>
</div>

<script>
function toggleUserMenu() {
  var dd = document.getElementById('userDropdown');
  dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
}

// Tutup dropdown jika klik di luar
document.addEventListener('click', function(e) {
  var pill = document.getElementById('userPill');
  var dd = document.getElementById('userDropdown');
  if (dd && !pill.contains(e.target) && !dd.contains(e.target)) {
    dd.style.display = 'none';
  }
});

function openLogoutModal() {
  document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogoutModal() {
  document.getElementById('logoutModal').style.display = 'none';
}

function memberLogout() {
  fetch('/guruverse/modules/member/login/member_logout.php', {
    method: 'POST'
  })
  .then(r => r.json())
  .then(d => {
    window.location.href = '/guruverse/';
  })
  .catch(() => {
    window.location.href = '/guruverse/';
  });
}

function toggleSidebar() {
  document.body.classList.toggle('sidebar-minimized');
}
</script>

<!-- ══════════════════════════════════════════════════
     NOTIFICATION DROPDOWN
══════════════════════════════════════════════════ -->
<div class="notif-dropdown" id="notifDropdown">
  <div class="notif-dd-header" style="padding:12px 16px; border-bottom:1px solid var(--c-border); display:flex; justify-content:space-between; align-items:center;">
    <h3 style="font-size:14px; font-weight:700;">Notifikasi</h3>
    <span class="link-action" style="font-size:11px; color:var(--c-primary); cursor:pointer;">Tandai dibaca</span>
  </div>

  <div class="notif-items-container" style="max-height: 350px; overflow-y: auto;">
    <?php if (empty($notifications)): ?>
      <div style="padding: 40px 20px; text-align: center; color: var(--c-text-subtle);">
        <div style="font-size: 24px; margin-bottom: 8px; opacity: 0.3;">
           <i class="ti ti-bell-off"></i>
        </div>
        <p style="font-size: 12px;">Belum ada notifikasi baru.</p>
      </div>
    <?php else: ?>
      <?php foreach ($notifications as $n): ?>
        <div class="notif-item" style="padding:12px 16px; border-bottom:1px solid var(--c-border-light); display:flex; gap:12px; transition:background .15s; cursor:pointer;" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background='transparent'">
          <div style="width:32px; height:32px; border-radius:8px; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="ti ti-bell" style="font-size:16px;"></i>
          </div>
          <div style="flex:1;">
            <h4 style="font-size:12px; font-weight:700; margin-bottom:2px;"><?= htmlspecialchars($n['title']) ?></h4>
            <p style="font-size:11px; color:var(--c-text-muted); line-height:1.4;"><?= htmlspecialchars($n['message']) ?></p>
            <div style="font-size:10px; color:var(--c-text-subtle); margin-top:4px;"><?= date('d M, H:i', strtotime($n['created_at'])) ?></div>
          </div>
          <?php if (!$n['is_read']): ?>
            <div style="width:8px; height:8px; border-radius:50%; background:var(--c-primary); margin-top:4px;"></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="notif-dd-footer" style="padding:10px; text-align:center; border-top:1px solid var(--c-border); font-size:12px; font-weight:600; color:var(--c-primary); cursor:pointer;">
    Lihat Semua Notifikasi
  </div>
</div>

<!-- MODAL LOGOUT -->
<div class="overlay" id="logoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:16px; padding:24px; width:100%; max-width:320px; box-shadow:0 12px 40px rgba(0,0,0,0.2); animation:slideDown 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
    <div style="width:48px; height:48px; border-radius:50%; background:rgba(239,68,68,0.1); color:#ef4444; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    </div>
    <h3 style="text-align:center; font-size:18px; font-weight:800; margin-bottom:8px; color:var(--c-text);">Keluar dari Akun?</h3>
    <p style="text-align:center; font-size:13px; color:var(--c-text-muted); margin-bottom:24px; line-height:1.5;">Anda harus login kembali untuk mengakses Member Area Guruverse.</p>
    <div style="display:flex; gap:12px;">
      <button onclick="closeLogoutModal()" style="flex:1; padding:10px; border-radius:10px; background:#f1f5f9; color:#475569; font-weight:700; font-size:13px; cursor:pointer; border:none; transition:background 0.2s;">Batal</button>
      <button onclick="memberLogout()" style="flex:1; padding:10px; border-radius:10px; background:#ef4444; color:#fff; font-weight:700; font-size:13px; cursor:pointer; border:none; transition:opacity 0.2s; box-shadow:0 4px 12px rgba(239,68,68,0.3);">Ya, Keluar</button>
    </div>
  </div>
</div>

