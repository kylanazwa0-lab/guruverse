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
  <?php else: 
    $total_hours = 0;
    $total_modules = 0;
    $completed_modules = 0;
    foreach ($enrollments as $en) {
      $total_hours += $en['duration_hours'];
      $total_modules += $en['total_modules'];
      $completed_modules += $en['completed_modules'];
    }
    $avg_progress = $total_modules > 0 ? round(($completed_modules / $total_modules) * 100) : 0;
  ?>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:24px;">
      <div class="card card-body" style="text-align:center;padding:32px 20px;">
        <div style="font-size:36px;font-weight:900;color:var(--c-primary);margin-bottom:8px;"><?= $avg_progress ?>%</div>
        <div style="font-size:13px;font-weight:700;color:var(--c-text-muted);">Rata-rata Progress</div>
      </div>
      <div class="card card-body" style="text-align:center;padding:32px 20px;">
        <div style="font-size:36px;font-weight:900;color:#10b981;margin-bottom:8px;"><?= $completed_modules ?>/<?= $total_modules ?></div>
        <div style="font-size:13px;font-weight:700;color:var(--c-text-muted);">Modul Diselesaikan</div>
      </div>
      <div class="card card-body" style="text-align:center;padding:32px 20px;">
        <div style="font-size:36px;font-weight:900;color:#3b82f6;margin-bottom:8px;"><?= $total_hours ?></div>
        <div style="font-size:13px;font-weight:700;color:var(--c-text-muted);">Jam Belajar</div>
      </div>
    </div>
    
    <div class="card card-body">
      <h3 style="font-size:16px;font-weight:800;margin-bottom:20px;">Riwayat Aktivitas Kelas</h3>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <?php foreach ($enrollments as $en): 
          $pct = $en['total_modules'] > 0 ? round(($en['completed_modules'] / $en['total_modules']) * 100) : 0;
        ?>
        <div style="display:flex;align-items:center;gap:16px;padding:16px;border:1px solid var(--c-border-light);border-radius:12px;">
          <div style="flex:1;">
            <div style="font-weight:700;font-size:14px;margin-bottom:8px;"><?= htmlspecialchars($en['title']) ?></div>
            <div style="height:6px;background:var(--c-border);border-radius:99px;overflow:hidden;margin-bottom:6px;">
              <div style="width:<?= $pct ?>%;height:100%;background:var(--c-primary);border-radius:99px;"></div>
            </div>
          </div>
          <div style="font-weight:800;color:var(--c-primary);font-size:15px;width:60px;text-align:right;"><?= $pct ?>%</div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

</div><!-- /page-progress -->
