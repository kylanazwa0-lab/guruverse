<div class="page" id="page-progress">
  <div class="hero-section mb-16" style="padding:14px 24px;min-height:auto">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:20%;left:15%;--d:3.5s;--delay:0.2s"></span>
      <span style="top:55%;left:65%;--d:4s;--delay:1s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge">
        <span class="hero-badge-dot" style="background:#4A90E2"></span> Analytics
      </div>
      <h1 style="font-size:20px;margin-bottom:4px">Progress Saya</h1>
      <p style="font-size:13px">Pantau perkembangan belajar, statistik modul, dan pencapaian kompetensi Anda.</p>
    </div>
  </div>

  <?php if (empty($enrollments)): ?>
    <div class="empty-state-card">
      <div class="empty-state-icon-wrap" style="background:rgba(74,144,226,0.1);color:#4A90E2">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
        </svg>
      </div>
      <h2 class="t-h2" style="margin-bottom:12px">Belum ada statistik belajar</h2>
      <p class="t-body t-muted" style="max-width:480px;margin:0 auto 32px">
        Grafik dan statistik perkembangan belajar Anda akan muncul di sini setelah memulai aktivitas di salah satu kelas.
      </p>
      <button class="btn btn-primary" onclick="showPage('dashboard')">
        <i class="ti ti-rocket" style="margin-right:8px"></i> Mulai Belajar
      </button>
    </div>
  <?php else: ?>
    <!-- Progress stats rendering will go here -->
  <?php endif; ?>

</div><!-- /page-progress -->
