<div class="page" id="page-modul">
  <div class="hero-section mb-16" style="padding:14px 24px;min-height:auto">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:20%;left:15%;--d:3s;--delay:0s"></span>
      <span style="top:50%;left:65%;--d:3.5s;--delay:1s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge">
        <span class="hero-badge-dot" style="background:var(--c-primary-light)"></span> Kurikulum Guru
      </div>
      <h1 style="font-size:20px;margin-bottom:4px">Modul Belajar</h1>
      <p style="font-size:13px">Akses materi pembelajaran, video tutorial, dan referensi pedagogik pilihan.</p>
    </div>
  </div>

  <div class="empty-state-card">
    <div class="empty-state-icon-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
      </svg>
    </div>
    <h2 class="t-h2" style="margin-bottom:12px">Belum ada modul aktif</h2>
    <p class="t-body t-muted" style="max-width:480px;margin:0 auto 32px">
      Modul belajar akan muncul di sini secara otomatis setelah Anda terdaftar di salah satu kelas aktif.
    </p>
    <div style="display:flex;gap:12px;justify-content:center">
      <button class="btn btn-primary" onclick="showPage('dashboard')">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             style="margin-right:8px">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        Jelajahi Kelas
      </button>
      <button class="btn btn-outline" onclick="window.open('https://wa.me/6281234567890', '_blank')">
        <i class="ti ti-headset" style="margin-right:8px"></i> Hubungi Mentor
      </button>
    </div>
  </div>

</div><!-- /page-modul -->
