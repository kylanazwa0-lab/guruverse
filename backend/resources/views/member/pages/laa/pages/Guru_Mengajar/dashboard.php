<?php /* Dashboard Personal — Guru Mengajar */ 
$uid = (int)$_SESSION['member_int_id'];

$stats = ['jam_mengajar'=>0, 'siswa_terbantu'=>0, 'total_xp'=>0, 'level_saat_ini'=>1, 'hari_streak'=>0, 'badge_diraih'=>0];
$res = $conn->query("SELECT * FROM gb_mengajar_stats WHERE member_id = $uid");
if ($res && $res->num_rows > 0) $stats = $res->fetch_assoc();




$tantangan_db = [];
$res = $conn->query("SELECT * FROM gb_mengajar_tantangan WHERE member_id = $uid AND (tanggal = CURDATE() OR is_done = 0)");
if ($res) while ($row = $res->fetch_assoc()) $tantangan_db[] = $row;

$aktivitas_db = [];
$res = $conn->query("SELECT * FROM gb_mengajar_aktivitas WHERE member_id = $uid ORDER BY created_at DESC LIMIT 5");
if ($res) while ($row = $res->fetch_assoc()) $aktivitas_db[] = $row;

function timeAgo($timestamp) {
    $diff = time() - strtotime($timestamp);
    if ($diff < 60) return "Baru saja";
    if ($diff < 3600) return floor($diff/60)." mnt lalu";
    if ($diff < 86400) return floor($diff/3600)." jam lalu";
    if ($diff < 172800) return "Kemarin";
    return floor($diff/86400)." hari lalu";
}
?>
<div class="page active" id="page-dashboard">

  <!-- HERO -->
  <div class="hero-section mb-24">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:12%;left:8%;--d:2.5s;--delay:0s"></span>
      <span style="top:28%;left:18%;--d:3.2s;--delay:0.8s"></span>
      <span style="top:55%;left:12%;--d:2s;--delay:0.3s"></span>
      <span style="top:20%;left:55%;--d:4s;--delay:1.2s"></span>
      <span style="top:70%;left:45%;--d:3s;--delay:0.6s"></span>
      <span style="top:10%;left:72%;--d:2.8s;--delay:1.8s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge"><span class="hero-badge-dot"></span> Guru Mengajar — Guruverse</div>
      <h1 style="color:#fff;font-size:2rem;font-weight:800;margin-bottom:8px;">Selamat Datang, <br><?= htmlspecialchars($user_name ?? 'Guru') ?></h1>
      <p style="color:rgba(255,255,255,.78);font-size:14px;line-height:1.6;max-width:380px;">Hari ini adalah kesempatan baru untuk memberikan dampak nyata bagi murid dan komunitas. Ayo mulai!</p>
      <div style="display:flex;gap:12px;margin-top:24px;flex-wrap:wrap;">
        <button class="hero-cta" onclick="showPage('gamifikasi')" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
          Lihat Gamifikasi
        </button>
        <button class="hero-cta" onclick="showPage('impact')" style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);box-shadow:none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          Impact Tracker
        </button>
      </div>
    </div>
    <div class="hero-illustration">
      <img class="hero-main-img" src="/guruverse/asset/img/hero-teachers.png" alt="Guru Mengajar" style="width:100%; height:auto; object-fit:contain; display:block; transform: scale(1.1) translateY(-10px);" onerror="this.style.display='none'">
    </div>
  </div>

  <!-- KPI CARDS -->
  <div class="stats-grid mb-24">
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="stat-value t-primary"><?= number_format($stats['jam_mengajar']) ?></div>
        <div class="stat-label">Jam Mengajar</div>
        <div class="stat-sub">Total terdokumentasi</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div>
        <div class="stat-value t-success"><?= number_format($stats['siswa_terbantu']) ?></div>
        <div class="stat-label">Siswa Terbantu</div>
        <div class="stat-sub">Dampak langsung</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
      </div>
      <div>
        <div class="stat-value" style="color:var(--c-warning)"><?= number_format($stats['total_xp']) ?></div>
        <div class="stat-label">Total XP</div>
        <div class="stat-sub">Level 4 — Mentor</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md" style="background:var(--c-danger-pale);color:var(--c-danger);">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div>
        <div class="stat-value t-danger"><?= $stats['hari_streak'] ?></div>
        <div class="stat-label">Hari Streak</div>
        <div class="stat-sub">Konsistensi mengajar</div>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT: 2 columns -->
  <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;margin-bottom:24px;">

    <!-- LEFT: Jadwal + Quick Actions -->
    <div style="display:flex;flex-direction:column;gap:20px;">




      <!-- Tantangan Harian (mini) -->
      <div class="card card-body">
        <div class="section-head">
          <h2>Tantangan Hari Ini</h2>
          <span class="link-action" onclick="showPage('gamifikasi')">Lihat Semua &rarr;</span>
        </div>
        <?php if(empty($tantangan_db)): ?>
        <div style="padding:16px;text-align:center;color:var(--c-text-muted);font-size:12px;">Belum ada tantangan hari ini.</div>
        <?php else: ?>
        <?php foreach($tantangan_db as $c):
          $pct = $c['target']>0 ? round($c['progress']/$c['target']*100) : 0;
          $done = $c['is_done'] == 1;
        ?>
        <div style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;background:<?= $done ? 'rgba(0,184,148,.06)' : 'rgba(108,92,231,.04)' ?>;border:1px solid <?= $done ? 'rgba(0,184,148,.18)' : 'var(--c-border)' ?>;margin-bottom:8px;">
          <div style="flex:1;min-width:0;">
            <div style="font-size:11px;font-weight:700;color:var(--c-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($c['nama_tantangan']) ?></div>
            <?php if(!$done): ?>
            <div style="height:3px;background:var(--c-border);border-radius:99px;margin-top:5px;overflow:hidden;">
              <div style="width:<?= $pct ?>%;height:100%;background:var(--c-primary);border-radius:99px;"></div>
            </div>
            <div style="font-size:9px;color:var(--c-text-muted);margin-top:2px;"><?= $c['progress'] ?>/<?= $c['target'] ?></div>
            <?php endif; ?>
          </div>
          <span style="font-size:9px;font-weight:800;padding:3px 8px;border-radius:99px;white-space:nowrap;<?= $done ? 'background:rgba(0,184,148,.12);color:var(--c-success)' : 'background:var(--c-primary-pale);color:var(--c-primary)' ?>;"><?= $done ? '✓ Selesai' : '+'.$c['xp_reward'].' XP' ?></span>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Aktivitas Terbaru -->
      <div class="card card-body">
        <div class="section-head">
          <h2>Aktivitas Terbaru</h2>
        </div>
        <?php if(empty($aktivitas_db)): ?>
        <div style="padding:16px;text-align:center;color:var(--c-text-muted);font-size:12px;">Belum ada aktivitas.</div>
        <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <?php foreach($aktivitas_db as $akt): ?>
          <div style="display:flex;align-items:center;gap:14px;padding-bottom:12px;border-bottom:1px dashed var(--c-border-light);">
            <div style="width:36px;height:36px;border-radius:10px;background:<?= htmlspecialchars($akt['warna_bg'] ?: 'rgba(0,0,0,0.05)') ?>;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
              <?= htmlspecialchars($akt['ikon'] ?: '📌') ?>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="font-size:12px;font-weight:700;color:var(--c-text);line-height:1.4;"><?= htmlspecialchars($akt['teks_aktivitas']) ?></div>
              <div style="font-size:10px;color:var(--c-text-muted);margin-top:2px;display:flex;align-items:center;gap:4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?= timeAgo($akt['created_at']) ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

    </div><!-- /LEFT -->

    <!-- RIGHT: XP Progress & Menu Fitur -->
    <div style="display:flex;flex-direction:column;gap:20px;">

      <!-- XP Progress -->
      <div class="card card-body" style="background:linear-gradient(135deg,#1e1b4b,#312e81);border:none;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
          <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#ef4444);display:flex;align-items:center;justify-content:center;color:#fff;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          <div>
            <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;">Level Saat Ini</div>
            <div style="font-size:14px;font-weight:800;color:#fff;">Level <?= $stats['level_saat_ini'] ?> — Guru Inspiratif</div>
          </div>
        </div>
        <?php
        $current_xp = (int)$stats['total_xp'];
        $level = (int)$stats['level_saat_ini'];
        if ($level < 1) $level = 1;
        $target_xp = $level * 1000;
        $xp_progress = $target_xp > 0 ? ($current_xp / $target_xp) * 100 : 0;
        if ($xp_progress > 100) $xp_progress = 100;
        $xp_left = $target_xp - $current_xp;
        if ($xp_left < 0) $xp_left = 0;
        $next_level = $level + 1;

        $rank = '-';
        if ($current_xp > 0) {
            $res_rank = $conn->query("SELECT COUNT(*) as higher FROM gb_mengajar_stats WHERE total_xp > $current_xp");
            if ($res_rank) {
                $rank = '#' . ($res_rank->fetch_assoc()['higher'] + 1);
            }
        }
        ?>
        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
          <span style="font-size:13px;font-weight:700;color:#fbbf24;"><?= number_format($current_xp) ?> XP</span>
          <span style="font-size:11px;color:rgba(255,255,255,.45);">Target: <?= number_format($target_xp) ?> XP</span>
        </div>
        <div style="height:8px;background:rgba(255,255,255,.12);border-radius:99px;overflow:hidden;">
          <div style="width:<?= $xp_progress ?>%;height:100%;background:linear-gradient(90deg,#f59e0b,#fbbf24);border-radius:99px;transition:width .5s ease;"></div>
        </div>
        <div style="font-size:10px;color:rgba(255,255,255,.45);margin-top:6px;"><?= number_format($xp_left) ?> XP lagi &rarr; Level <?= $next_level ?></div>
        <div style="display:flex;gap:8px;margin-top:14px;">
          <div style="flex:1;text-align:center;padding:8px;border-radius:10px;background:rgba(255,255,255,.08);">
            <div style="font-size:16px;font-weight:800;color:#fbbf24;"><?= $rank ?></div>
            <div style="font-size:9px;color:rgba(255,255,255,.45);">Peringkat</div>
          </div>
          <div style="flex:1;text-align:center;padding:8px;border-radius:10px;background:rgba(255,255,255,.08);">
            <div style="font-size:16px;font-weight:800;color:#34d399;"><?= $stats['hari_streak'] ?></div>
            <div style="font-size:9px;color:rgba(255,255,255,.45);">Hari Streak</div>
          </div>
          <div style="flex:1;text-align:center;padding:8px;border-radius:10px;background:rgba(255,255,255,.08);">
            <div style="font-size:16px;font-weight:800;color:#a78bfa;"><?= $stats['badge_diraih'] ?></div>
            <div style="font-size:9px;color:rgba(255,255,255,.45);">Badge</div>
          </div>
        </div>
      </div>

      <!-- Navigasi Fitur -->
      <div class="card card-body">
        <div class="section-head" style="margin-bottom:12px;">
          <h2>Menu Fitur</h2>
        </div>
        <?php
        $menus = [
          ['icon'=>'🎮','label'=>'Gamifikasi','desc'=>'Sistem poin & level','page'=>'gamifikasi','color'=>'var(--c-primary-pale)'],
          ['icon'=>'📈','label'=>'Impact Tracker','desc'=>'Pantau dampak pembelajaran','page'=>'impact','color'=>'var(--c-danger-pale)'],
          ['icon'=>'🏋️','label'=>'Pelatihan Offline','desc'=>'Workshop & sertifikat resmi','page'=>'pelatihan','color'=>'var(--c-blue-pale)'],
        ];
        foreach($menus as $m): ?>
        <div onclick="showPage('<?= $m['page'] ?>')" style="display:flex;align-items:center;gap:12px;padding:10px;border-radius:10px;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background='transparent'">
          <div style="width:36px;height:36px;border-radius:9px;background:<?= $m['color'] ?>;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;"><?= $m['icon'] ?></div>
          <div style="flex:1;min-width:0;">
            <div style="font-size:12px;font-weight:700;color:var(--c-text);"><?= $m['label'] ?></div>
            <div style="font-size:10px;color:var(--c-text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= $m['desc'] ?></div>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="var(--c-text-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <?php endforeach; ?>
      </div>

    </div><!-- /RIGHT -->
  </div>

  <!-- Motivasi -->
  <div style="background:linear-gradient(135deg,rgba(108,92,231,.08),rgba(0,184,148,.06));border:1px solid var(--c-border);border-radius:16px;padding:20px 24px;display:flex;align-items:center;gap:16px;">
    <div style="font-size:32px;">💡</div>
    <div>
      <div style="font-size:13px;font-weight:700;color:var(--c-text);margin-bottom:3px;">"Mendidik bukanlah pekerjaan — ini adalah misi."</div>
      <div style="font-size:11px;color:var(--c-text-muted);">Terus semangat, <?= htmlspecialchars($user_name ?? 'Guru') ?>! Setiap pelajaran yang Anda berikan membentuk masa depan bangsa. 🇮🇩</div>
    </div>
  </div>

</div><!-- /page-dashboard -->
