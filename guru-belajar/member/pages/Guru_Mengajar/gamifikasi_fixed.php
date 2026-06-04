<?php /* Gamifikasi — Guru Mengajar */ 
$has_gamifikasi_db = false;
$check_db = $conn->query("SHOW TABLES LIKE 'gb_mengajar_gamifikasi'");
if ($check_db && $check_db->num_rows > 0) $has_gamifikasi_db = true;

if (!$has_gamifikasi_db): 
?>
<div class="page" id="page-gamifikasi">
  <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:60vh;text-align:center;">
    <div style="font-size:64px;margin-bottom:16px;">🎮</div>
    <h2 style="font-size:24px;font-weight:800;color:#1e1b4b;margin-bottom:8px;">Akan Segera Hadir</h2>
    <p style="color:#64748b;max-width:400px;line-height:1.6;">Fitur Gamifikasi sedang dipersiapkan dan akan segera terhubung dengan database.</p>
  </div>
</div>
<?php else:
$katalog_path = $_SERVER['DOCUMENT_ROOT'] . '/guruverse/asset/docs/gamifikasi/gamifikasi_katalog.json';
$katalog = [];
if (file_exists($katalog_path)) {
    $katalog = json_decode(file_get_contents($katalog_path), true) ?: [];
}
$is_premium = $stats['is_premium_gamifikasi'] ?? 0;
$free_left = $stats['free_gamification_left'] ?? 0;
?>
<div class="page" id="page-gamifikasi">

  <!-- STATUS PREMIUM / FREE BANNER -->
  <?php if($is_premium): ?>
  <div style="background:linear-gradient(90deg, #d97706, #f59e0b); border-radius:16px; padding:16px 24px; display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; box-shadow:0 8px 24px rgba(245,158,11,.2);">
    <div style="display:flex; align-items:center; gap:16px;">
      <div style="font-size:32px;">👑</div>
      <div>
        <div style="font-size:16px; font-weight:800; color:#fff;">Member Premium Gamifikasi</div>
        <div style="font-size:12px; color:rgba(255,255,255,.8); margin-top:2px;">Anda memiliki akses tak terbatas ke seluruh koleksi materi gamifikasi.</div>
      </div>
    </div>
  </div>
  <?php else: ?>
  <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px 24px; display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; box-shadow:0 4px 12px rgba(0,0,0,.03);">
    <div style="display:flex; align-items:center; gap:16px;">
      <div style="font-size:32px;">🎁</div>
      <div>
        <div style="font-size:14px; font-weight:800; color:#0f172a;">Akses Gratis Tersedia</div>
        <div style="font-size:12px; color:#64748b; margin-top:2px;">Anda dapat mencoba mengunduh/menggunakan materi gamifikasi secara gratis.</div>
      </div>
    </div>
    <div style="text-align:right;">
      <div style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:4px; text-transform:uppercase;">Sisa Akses</div>
      <div style="display:flex; align-items:center; gap:8px;">
        <div style="font-size:24px; font-weight:900; color:<?= $free_left > 0 ? '#10b981' : '#ef4444' ?>;" id="free-left-display"><?= $free_left ?></div>
        <div style="font-size:16px; font-weight:700; color:#94a3b8;">/ 3</div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- LEVEL CARD HERO -->
  <div style="background:linear-gradient(135deg,#1e1b4b 0%,#312e81 50%,#6d28d9 100%);border-radius:20px;padding:32px;margin-bottom:24px;display:flex;align-items:center;gap:28px;position:relative;overflow:hidden">
    <div style="position:absolute;top:-60px;right:60px;width:280px;height:280px;background:radial-gradient(circle,rgba(167,139,250,.2) 0%,transparent 70%);pointer-events:none"></div>
    <!-- Trophy -->
    <div style="width:80px;height:80px;border-radius:20px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;font-size:36px;box-shadow:0 8px 24px rgba(245,158,11,.4);flex-shrink:0;position:relative;z-index:1">🏆</div>
    <div style="position:relative;z-index:1;flex:1">
      <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Level Saat Ini</div>
      <div style="font-size:1.5rem;font-weight:900;color:#fff;margin-bottom:4px">Level 4 — Mentor Inspiratif</div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
        <span style="font-size:13px;color:#fbbf24;font-weight:700">850 XP</span>
        <span style="font-size:11px;color:rgba(255,255,255,.4)">/ 1000 XP untuk Level 5</span>
      </div>
      <div style="height:10px;background:rgba(255,255,255,.12);border-radius:999px;overflow:hidden">
        <div style="width:85%;height:100%;background:linear-gradient(90deg,#f59e0b,#fbbf24);border-radius:999px"></div>
      </div>
      <div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:6px">150 XP lagi untuk naik ke Level 5 — Guru Emas</div>
    </div>
    <div style="text-align:center;position:relative;z-index:1;flex-shrink:0">
      <div style="font-size:11px;color:rgba(255,255,255,.5);margin-bottom:4px">Peringkat</div>
      <div style="font-size:2rem;font-weight:900;color:#fbbf24">#12</div>
      <div style="font-size:10px;color:rgba(255,255,255,.4)">dari 284 guru</div>
    </div>
  </div>

  <!-- STATS ROW -->
  <div class="stats-grid mb-24" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div>
        <div class="stat-value t-primary">850</div>
        <div class="stat-label">Total XP</div>
        <div class="stat-sub">Akumulasi poin Anda</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
      </div>
      <div>
        <div class="stat-value" style="color:var(--c-warning)">4</div>
        <div class="stat-label">Level Saat Ini</div>
        <div class="stat-sub">Mentor Inspiratif</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
      </div>
      <div>
        <div class="stat-value t-success">8</div>
        <div class="stat-label">Badge Diraih</div>
        <div class="stat-sub">Pencapaian aktif</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md" style="background:var(--c-danger-pale); color:var(--c-danger);">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
      </div>
      <div>
        <div class="stat-value t-danger">7</div>
        <div class="stat-label">Hari Streak</div>
        <div class="stat-sub">Konsistensi mengajar</div>
      </div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px">

    <!-- TANTANGAN HARIAN -->
    <div class="card">
      <div class="section-head">
        <h2><span class="section-dot"></span> Tantangan Hari Ini</h2>
        <span class="badge badge-purple">Reset: 6 jam lagi</span>
      </div>
      <div style="display:flex;flex-direction:column;gap:10px">
        <?php
        $challenges = [
          ['icon'=>'🎯','name'=>'Bimbing 5 Siswa','desc'=>'Berikan bimbingan langsung kepada 5 murid','xp'=>'+50 XP','done'=>true,'progress'=>5,'total'=>5],
          ['icon'=>'📝','name'=>'Isi Jurnal Mengajar','desc'=>'Tulis refleksi singkat pengalaman mengajar hari ini','xp'=>'+30 XP','done'=>false,'progress'=>0,'total'=>1],
          ['icon'=>'💬','name'=>'Balas Diskusi','desc'=>'Balas 3 pertanyaan dari rekan guru di forum','xp'=>'+25 XP','done'=>false,'progress'=>1,'total'=>3],
          ['icon'=>'📊','name'=>'Update Progress Kelas','desc'=>'Perbarui data capaian kompetensi siswa','xp'=>'+40 XP','done'=>false,'progress'=>0,'total'=>1],
        ];
        foreach($challenges as $ch): ?>
        <div style="display:flex;align-items:center;gap:12px;padding:12px;border-radius:12px;background:<?= $ch['done'] ? 'rgba(16,185,129,.06)' : 'rgba(109,40,217,.03)' ?>;border:1px solid <?= $ch['done'] ? 'rgba(16,185,129,.15)' : 'rgba(109,40,217,.08)' ?>">
          <span style="font-size:20px;flex-shrink:0"><?= $ch['icon'] ?></span>
          <div style="flex:1">
            <div style="font-size:12px;font-weight:700;color:#1e1b4b;margin-bottom:2px"><?= $ch['name'] ?></div>
            <div style="font-size:10px;color:#94a3b8"><?= $ch['desc'] ?></div>
            <?php if(!$ch['done']): ?>
            <div style="margin-top:6px;height:4px;background:#f1f5f9;border-radius:999px;overflow:hidden">
              <div style="height:100%;width:<?= $ch['total']>0 ? round($ch['progress']/$ch['total']*100) : 0 ?>%;background:linear-gradient(90deg,#6d28d9,#a78bfa);border-radius:999px"></div>
            </div>
            <div style="font-size:9px;color:#94a3b8;margin-top:3px"><?= $ch['progress'] ?>/<?= $ch['total'] ?></div>
            <?php endif; ?>
          </div>
          <span style="font-size:10px;font-weight:800;padding:4px 10px;border-radius:999px;white-space:nowrap;<?= $ch['done'] ? 'background:rgba(16,185,129,.12);color:#059669' : 'background:rgba(109,40,217,.1);color:#6d28d9' ?>"><?= $ch['done'] ? '✓ Selesai' : $ch['xp'] ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- BADGE & ACHIEVEMENT -->
    <div class="card">
      <div class="section-head">
        <h2><span class="section-dot"></span> Badge & Achievement</h2>
        <span class="link-action">Lihat Semua →</span>
      </div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px">
        <?php
        $badges = [
          ['emoji'=>'🏆','name'=>'Mentor Inspiratif','desc'=>'Level 4','locked'=>false],
          ['emoji'=>'🔥','name'=>'7 Hari Streak','desc'=>'Konsisten','locked'=>false],
          ['emoji'=>'⭐','name'=>'Guru Berbagi','desc'=>'10 kontribusi','locked'=>false],
          ['emoji'=>'📚','name'=>'Maha Guru','desc'=>'100 jam mengajar','locked'=>false],
          ['emoji'=>'💡','name'=>'Inovator','desc'=>'5 proyek kreatif','locked'=>false],
          ['emoji'=>'🎯','name'=>'Tepat Sasaran','desc'=>'Tantangan harian 30x','locked'=>false],
          ['emoji'=>'🌟','name'=>'Bintang Kelas','desc'=>'Nilai murid +50%','locked'=>false],
          ['emoji'=>'🤝','name'=>'Kolaborator','desc'=>'10 kolaborasi guru','locked'=>false],
          ['emoji'=>'🥇','name'=>'Juara Leaderboard','desc'=>'Peringkat #1','locked'=>true],
          ['emoji'=>'🎓','name'=>'Guru Emas','desc'=>'Level 5','locked'=>true],
          ['emoji'=>'💎','name'=>'Berlian','desc'=>'1000 XP dalam sehari','locked'=>true],
          ['emoji'=>'🚀','name'=>'Peluncur','desc'=>'50 proyek komunitas','locked'=>true],
        ];
        foreach($badges as $b): ?>
        <div style="text-align:center;padding:10px;border-radius:12px;background:<?= $b['locked'] ? 'rgba(0,0,0,.03)' : 'rgba(109,40,217,.05)' ?>;border:1px solid <?= $b['locked'] ? '#f1f5f9' : 'rgba(109,40,217,.12)' ?>;opacity:<?= $b['locked'] ? '.45' : '1' ?>">
          <div style="font-size:22px;margin-bottom:4px;filter:<?= $b['locked'] ? 'grayscale(1)' : 'none' ?>"><?= $b['emoji'] ?></div>
          <div style="font-size:9px;font-weight:700;color:#374151;line-height:1.2"><?= $b['name'] ?></div>
          <div style="font-size:8px;color:#94a3b8;margin-top:2px"><?= $b['desc'] ?></div>
          <?php if($b['locked']): ?><div style="font-size:8px;color:#cbd5e1;margin-top:4px">🔒 Terkunci</div><?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- LEADERBOARD -->
  <div class="card" style="margin-bottom:24px">
    <div class="section-head">
      <h2><span class="section-dot"></span> Leaderboard Guru Inspiratif</h2>
      <span class="badge badge-amber">Bulan Mei 2026</span>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Peringkat</th>
          <th>Guru</th>
          <th>Level</th>
          <th>Total XP</th>
          <th>Streak</th>
          <th>Badge</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $leaders = [
          ['rank'=>1,'name'=>'Sari Dewi, S.Pd','inst'=>'SMAN 1 Jakarta','level'=>'Level 7 — Guru Legenda','xp'=>2340,'streak'=>28,'badges'=>15,'you'=>false],
          ['rank'=>2,'name'=>'Ahmad Ridwan, M.Pd','inst'=>'SMPN 3 Bandung','level'=>'Level 6 — Guru Platinum','xp'=>1980,'streak'=>21,'badges'=>12,'you'=>false],
          ['rank'=>3,'name'=>'Rina Lestari, S.Pd','inst'=>'SDN 5 Surabaya','level'=>'Level 6 — Guru Platinum','xp'=>1750,'streak'=>15,'badges'=>11,'you'=>false],
          ['rank'=>4,'name'=>'Budi Santoso, S.Pd','inst'=>'SMAN 2 Yogyakarta','level'=>'Level 5 — Guru Emas','xp'=>1520,'streak'=>12,'badges'=>9,'you'=>false],
          ['rank'=>5,'name'=>'Dewi Kurnia, M.Pd','inst'=>'SMA Islam Al-Azhar','level'=>'Level 5 — Guru Emas','xp'=>1380,'streak'=>10,'badges'=>9,'you'=>false],
          ['rank'=>12,'name'=>'<?= htmlspecialchars($member["full_name"] ?? "Anda") ?>','inst'=>'<?= htmlspecialchars($member["institution"] ?? "") ?>','level'=>'Level 4 — Mentor Inspiratif','xp'=>850,'streak'=>7,'badges'=>8,'you'=>true],
        ];
        foreach($leaders as $l): ?>
        <tr style="<?= $l['you'] ? 'background:rgba(109,40,217,.06)' : '' ?>">
          <td>
            <?php if($l['rank'] <= 3): ?>
              <span style="font-size:18px"><?= ['🥇','🥈','🥉'][$l['rank']-1] ?></span>
            <?php else: ?>
              <span style="font-weight:800;color:<?= $l['you'] ? '#6d28d9' : '#94a3b8' ?>">#<?= $l['rank'] ?></span>
            <?php endif; ?>
            <?php if($l['you']): ?><span class="badge badge-purple" style="margin-left:4px">Anda</span><?php endif; ?>
          </td>
          <td>
