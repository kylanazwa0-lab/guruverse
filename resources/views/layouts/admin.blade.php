<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="/asset/img/logo guruverse FA.ai.png">
<title>@yield('title', 'Admin Panel') — Guruverse.id</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/asset/css/admin.css?v=1.1.0">
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
/* Strong highlight (sorotan) for active sidebar link */
.sidebar .sb-link.active {
  background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%) !important;
  color: #ffffff !important;
  font-weight: 800 !important;
  box-shadow: 0 4px 15px rgba(124, 58, 237, 0.45) !important;
  border: 1px solid rgba(255, 255, 255, 0.18) !important;
  transform: translateX(4px) !important;
}
.sidebar .sb-link.active svg {
  color: #ffffff !important;
  opacity: 1 !important;
  filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.8)) !important;
}
</style>
@yield('styles')
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
    // Scroll active link into view with a slight delay to ensure layout is complete
    setTimeout(() => {
      const activeLink = document.querySelector('.sidebar .active');
      if (activeLink) {
        activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }, 150);

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
      <img
        src="/asset/img/FA Logo Guruverse.ID - negative.png"
        alt="Guruverse.ID"
        class="logo-expanded"
        style="height:28px;object-fit:contain;width:auto;"
        onerror="this.style.display='none';document.getElementById('sb-logo-fallback').style.display='flex';"
      >
      <img
        src="/asset/img/logo guruverse FA.ai.png"
        alt="GV"
        class="logo-collapsed"
        style="height:32px;object-fit:contain;width:auto;display:none;"
      >
      <span id="sb-logo-fallback" class="logo-expanded" style="display:none;font-weight:900;font-size:1rem;color:#fff;letter-spacing:-0.02em;">Guruverse</span>
    </div>

    <!-- Profile Card -->
    <div class="sb-profile">
      <div class="sb-profile-avatar">{{ strtoupper(substr($admin->full_name ?? 'AD', 0, 2)) }}</div>
      <div class="sb-profile-info">
        <div class="sb-profile-name">{{ $admin->full_name ?? 'Administrator' }}</div>
        <div class="sb-profile-role">{{ ucwords(str_replace('_', ' ', $admin->role ?? 'super_admin')) }}</div>
      </div>
      <div class="sb-profile-dot"></div>
    </div>

    <div class="sb-section">
      <div class="sb-section-label">Menu Utama</div>
      <a class="sb-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>
      @if(in_array($admin->role ?? 'super_admin', ['super_admin', 'admin_member']))
      <a class="sb-link {{ Route::is('admin.members') ? 'active' : '' }}" href="{{ route('admin.members') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Data Member
      </a>
      @endif
    </div>

    <div class="sb-divider"></div>

    @if(in_array($admin->role ?? 'super_admin', ['super_admin', 'admin_kelas', 'admin_konten']))
    <div class="sb-section">
      <div class="sb-section-label" style="color: #93b5ff; opacity: 0.8;">Pilar: Guru Belajar</div>
      <a class="sb-link {{ Route::is('admin.kelas') ? 'active' : '' }}" href="{{ route('admin.kelas') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        Manajemen Kelas
      </a>
      <a class="sb-link {{ Route::is('admin.modul') ? 'active' : '' }}" href="{{ route('admin.modul') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        Modul Pembelajaran
      </a>
      <a class="sb-link {{ request()->route('module') === 'produk' ? 'active' : '' }}" href="{{ route('admin.module', 'produk') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        Perpustakaan & E-Book
      </a>
      <a class="sb-link {{ request()->route('module') === 'sertifikat' ? 'active' : '' }}" href="{{ route('admin.module', 'sertifikat') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        Sertifikat Member
      </a>
    </div>
    @endif

    <div class="sb-divider"></div>

    @if(in_array($admin->role ?? 'super_admin', ['super_admin', 'admin_konten']))
    <div class="sb-section">
      <div class="sb-section-label" style="color: #fbbd88; opacity: 0.8;">Pilar: Guru Inspira</div>
      <a class="sb-link {{ Route::is('admin.inspira_cerita') ? 'active' : '' }}" href="{{ route('admin.inspira_cerita') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Cerita & Artikel
      </a>
      <a class="sb-link {{ Route::is('admin.inspira_agenda') ? 'active' : '' }}" href="{{ route('admin.inspira_agenda') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Agenda & Event
      </a>
    </div>
    @endif

    <div class="sb-divider"></div>

    @if(in_array($admin->role ?? 'super_admin', ['super_admin', 'admin_kelas']))
    <div class="sb-section">
      <div class="sb-section-label" style="color: #6ee7b7; opacity: 0.8;">Pilar: Guru Mengajar</div>
      <a class="sb-link {{ Route::is('admin.mengajar_jadwal') ? 'active' : '' }}" href="{{ route('admin.mengajar_jadwal') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Monitoring Jadwal
      </a>
      <a class="sb-link {{ Route::is('admin.mengajar_gamifikasi') ? 'active' : '' }}" href="{{ route('admin.mengajar_gamifikasi') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        Statistik Gamifikasi
      </a>
    </div>
    @endif

    <div class="sb-divider"></div>

    @if(in_array($admin->role ?? 'super_admin', ['super_admin', 'admin_konten']))
    <div class="sb-section">
      <div class="sb-section-label">Komunitas & Pengaturan</div>
      <a class="sb-link {{ Route::is('admin.diskusi') ? 'active' : '' }}" href="{{ route('admin.diskusi') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Forum Diskusi
      </a>
      <a class="sb-link {{ request()->route('module') === 'live_chat' ? 'active' : '' }}" href="{{ route('admin.module', 'live_chat') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        Live Chat Admin
      </a>
      @if(($admin->role ?? '') === 'super_admin')
      <a class="sb-link {{ request()->route('module') === 'bot_settings' ? 'active' : '' }}" href="{{ route('admin.module', 'bot_settings') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
        Manajemen Bot
      </a>
      @endif
      <a class="sb-link {{ Route::is('admin.notifikasi') ? 'active' : '' }}" href="{{ route('admin.notifikasi') }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        Notifikasi
      </a>
    </div>
    @endif

    <div class="sb-divider"></div>

    <div class="sb-section">
      <div class="sb-section-label">Lainnya</div>
      <a class="sb-link" href="#" onclick="alert('Export functionality will be migrated soon!')">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export Excel
      </a>
    </div>

    <div class="sb-bottom">
      <form action="{{ route('admin.logout') }}" method="POST" id="logout-form" class="hidden">
        @csrf
      </form>
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sb-link" style="color:rgba(252,165,165,0.7); margin-top:2px;">
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
            @yield('page_title', 'Dashboard')
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
               <div style="padding:20px;text-align:center;color:var(--muted);font-size:0.8rem">Belum ada notifikasi</div>
            </div>
            <li style="padding:10px;text-align:center;border-top:1px solid var(--border);background:#fff"><a href="{{ route('admin.dashboard') }}" style="font-size:0.75rem;color:var(--v1);font-weight:700">Lihat Dashboard</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page content injected here -->
    <div class="content">
      @yield('content')
    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /layout -->

<!-- TOAST -->
<div class="toast" id="toast" style="display:none;"></div>

<!-- GLOBAL DELETE CONFIRM MODAL -->
<div class="overlay" id="global-delete-modal" style="display:none;z-index:9999" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md" style="max-width:380px;text-align:center;padding:2.5rem 1.5rem">
    <div style="width:64px;height:64px;border-radius:50%;background:rgba(239,68,68,0.1);color:#ef4444;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
    </div>
    <h3 style="font-size:1.15rem;font-weight:900;color:var(--t);margin-bottom:8px" id="delete-modal-title">Konfirmasi Hapus</h3>
    <p style="font-size:0.85rem;color:var(--muted);margin-bottom:2rem;line-height:1.5" id="delete-modal-text">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
    <div style="display:flex;gap:12px;justify-content:center">
      <button type="button" class="btn-sm" onclick="document.getElementById('global-delete-modal').style.display='none'" style="background:#f1f5f9;color:#475569;border:none;padding:0.6rem 1.5rem;flex:1;font-weight:600">Batal</button>
      <button type="button" class="btn-sm" id="delete-modal-confirm" style="background:#ef4444;color:#fff;border:none;padding:0.6rem 1.5rem;flex:1;font-weight:600;box-shadow:0 4px 12px rgba(239,68,68,0.3)">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
// ── Clock ────────────────────────────────────────────────────────
(function(){
  const el = document.getElementById('clock');
  if (!el) return;
  const tick = () => { el.textContent = new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'}); };
  tick(); setInterval(tick, 1000);
})();

// ── Sidebar mobile ───────────────────────────────────────────────
function openSidebar()  { document.getElementById('sidebar').classList.add('open');    document.getElementById('mob-overlay').classList.add('on'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('mob-overlay').classList.remove('on'); }

// ── Toast ────────────────────────────────────────────────────────
function showToast(msg, type='success') {
  const el = document.getElementById('toast');
  el.className = 'toast toast-' + type;
  el.textContent = msg;
  el.style.display = 'flex';
  clearTimeout(el._tid);
  el._tid = setTimeout(() => { el.style.display = 'none'; }, 3500);
}

// ── Global Delete Confirm ────────────────────────────────────────
let currentDeleteForm = null;
document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', (e) => {
    const submitBtn = e.target.closest('form.form-delete button[type="submit"]');
    if (submitBtn) {
      e.preventDefault();
      e.stopPropagation();
      currentDeleteForm = submitBtn.closest('form');
      const msg = currentDeleteForm.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus data ini?';
      const textEl = document.getElementById('delete-modal-text');
      if (textEl) textEl.innerText = msg;
      document.getElementById('global-delete-modal').style.display = 'flex';
    }
  });

  const confirmBtn = document.getElementById('delete-modal-confirm');
  if (confirmBtn) {
    confirmBtn.addEventListener('click', () => {
      if (currentDeleteForm) currentDeleteForm.submit();
    });
  }
});

// ── Action Dropdown (⋮ kebab) — handles FlyonUI .dropdown.relative pattern ──
(function() {
  function closeAllActionMenus(except) {
    document.querySelectorAll('.dropdown .dropdown-menu, .dropdown ul[role="menu"]').forEach(m => {
      if (m !== except) m.classList.add('hidden');
    });
    document.querySelectorAll('.action-dd-menu').forEach(m => {
      if (m !== except) m.classList.add('hidden');
    });
  }

  document.addEventListener('click', (e) => {
    const flyonToggle = e.target.closest('.dropdown .dropdown-toggle');
    if (flyonToggle) {
      e.stopPropagation();
      const parent = flyonToggle.closest('.dropdown');
      const menu = parent ? parent.querySelector('.dropdown-menu, ul[role="menu"]') : null;
      if (!menu) return;
      
      const isHidden = menu.classList.contains('hidden');
      closeAllActionMenus(menu);
      
      document.querySelectorAll('.dropdown').forEach(d => {
        if (d !== parent) d.classList.remove('open');
      });

      if (isHidden) {
        menu.classList.remove('hidden');
        parent.classList.add('open');
      } else {
        menu.classList.add('hidden');
        parent.classList.remove('open');
      }
      return;
    }

    const toggleBtn = e.target.closest('[data-action-toggle]');
    if (toggleBtn) {
      e.stopPropagation();
      const menu = toggleBtn.closest('.action-dd').querySelector('.action-dd-menu');
      if (!menu) return;
      const isHidden = menu.classList.contains('hidden');
      closeAllActionMenus(menu);
      if (isHidden) menu.classList.remove('hidden');
      else menu.classList.add('hidden');
      return;
    }

    if (!e.target.closest('.dropdown') && !e.target.closest('.action-dd')) {
      closeAllActionMenus(null);
      document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
    }
  });
})();

// ── Custom Select (replaces <select class="fi">) ─────────────────
(function() {
  function buildCustomSelect(select) {
    if (select.dataset.csWrapped) return;
    select.dataset.csWrapped = '1';

    Object.assign(select.style, {
      position: 'absolute', opacity: '0',
      pointerEvents: 'none', width: '0', height: '0'
    });

    const wrapper = document.createElement('div');
    wrapper.className = 'cs-wrap';
    Object.assign(wrapper.style, {
      position: 'relative', display: 'block', width: '100%'
    });

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'fi cs-btn';
    Object.assign(btn.style, {
      width: '100%', textAlign: 'left', display: 'flex',
      alignItems: 'center', justifyContent: 'space-between', cursor: 'pointer'
    });

    const textSpan = document.createElement('span');
    textSpan.className = 'cs-text';
    textSpan.innerText = select.options[select.selectedIndex]?.text || 'Pilih...';
    btn.appendChild(textSpan);
    btn.insertAdjacentHTML('beforeend', `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><polyline points="6 9 12 15 18 9"/></svg>`);

    const menu = document.createElement('ul');
    menu.className = 'cs-menu';
    Object.assign(menu.style, {
      display: 'none', position: 'absolute', top: '100%', left: '0', right: '0',
      zIndex: '9998', background: 'var(--card,#fff)', border: '1px solid var(--border,#e2e8f0)',
      borderRadius: '8px', boxShadow: '0 8px 24px rgba(0,0,0,0.12)',
      marginTop: '4px', maxHeight: '220px', overflowY: 'auto', padding: '4px 0'
    });

    function buildMenu() {
      menu.innerHTML = '';
      Array.from(select.options).forEach((opt, idx) => {
        const li = document.createElement('li');
        li.style.listStyle = 'none';
        const a = document.createElement('a');
        const isSelected = idx === select.selectedIndex;
        Object.assign(a.style, {
          display: 'block', padding: '8px 14px', fontSize: '.82rem',
          cursor: 'pointer', color: 'var(--t,#1e293b)',
          fontWeight: isSelected ? '700' : '400',
          background: isSelected ? 'var(--bg,#f8fafc)' : ''
        });
        a.innerText = opt.text;
        a.onmouseenter = () => a.style.background = 'var(--bg,#f8fafc)';
        a.onmouseleave = () => a.style.background = isSelected ? 'var(--bg,#f8fafc)' : '';
        a.onclick = (ev) => {
          ev.preventDefault();
          select.selectedIndex = idx;
          textSpan.innerText = opt.text;
          menu.style.display = 'none';
          select.dispatchEvent(new Event('change', { bubbles: true }));
          buildMenu();
        };
        li.appendChild(a);
        menu.appendChild(li);
      });
    }
    buildMenu();

    btn.onclick = (ev) => {
      ev.preventDefault();
      ev.stopPropagation();
      const isOpen = menu.style.display !== 'none';
      document.querySelectorAll('.cs-menu').forEach(m => { if (m !== menu) m.style.display = 'none'; });
      menu.style.display = isOpen ? 'none' : 'block';
    };

    select.addEventListener('change', () => {
      textSpan.innerText = select.options[select.selectedIndex]?.text || 'Pilih...';
      buildMenu();
    });

    const proto = Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value');
    if (proto) {
      Object.defineProperty(select, 'value', {
        get() { return proto.get.call(this); },
        set(val) {
          proto.set.call(this, val);
          textSpan.innerText = this.options[this.selectedIndex]?.text || 'Pilih...';
          buildMenu();
        }
      });
    }

    wrapper.appendChild(btn);
    wrapper.appendChild(menu);
    select.parentNode.insertBefore(wrapper, select);
  }

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.cs-wrap')) {
      document.querySelectorAll('.cs-menu').forEach(m => m.style.display = 'none');
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('select.fi').forEach(buildCustomSelect);
  });

  window.syncSelectUI = function(selectEl) {
    if (!selectEl) return;
    const wrap = selectEl.parentNode ? selectEl.parentNode.querySelector('.cs-wrap') : null;
    if (!wrap) return;
    const textSpan = wrap.querySelector('.cs-text');
    if (textSpan && selectEl.options[selectEl.selectedIndex]) {
      textSpan.innerText = selectEl.options[selectEl.selectedIndex].text;
    }
  };
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/flyonui@1.0.0/dist/flyonui.js"></script>
@yield('scripts')
</body>
</html>
