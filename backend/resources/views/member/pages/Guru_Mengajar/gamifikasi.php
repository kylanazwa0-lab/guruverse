<?php /* Gamifikasi — Guru Mengajar */ 
$has_gamifikasi_db = false;
$check_db = $conn->query("SHOW TABLES LIKE 'gb_mengajar_tantangan'");
if ($check_db && $check_db->num_rows > 0) {
    $has_gamifikasi_db = true;

    $uid = (int)($_SESSION['member_int_id'] ?? 3);
    
    // Fetch stats
    $stats = [];
    $res = $conn->query("SELECT * FROM gb_mengajar_stats WHERE member_id = $uid");
    if($res && $r = $res->fetch_assoc()) $stats = $r;
    if(empty($stats)) {
        $conn->query("INSERT INTO gb_mengajar_stats (member_id, total_xp, level_saat_ini, hari_streak, badge_diraih, free_gamification_left, is_premium_gamifikasi) VALUES ($uid, 0, 1, 0, 0, 3, 0)");
        $stats = ['total_xp'=>0,'level_saat_ini'=>1,'hari_streak'=>0,'badge_diraih'=>0,'free_gamification_left'=>3,'is_premium_gamifikasi'=>0];
    }
    
    // Fetch challenges
    $challenges = [];
    $res2 = $conn->query("SELECT * FROM gb_mengajar_tantangan WHERE member_id = $uid ORDER BY id DESC");
    if($res2) {
        while($r = $res2->fetch_assoc()) {
            $challenges[] = [
                'icon' => $r['ikon'],
                'name' => $r['nama_tantangan'],
                'desc' => 'Tantangan kelas',
                'xp' => '+'.$r['xp_reward'].' XP',
                'done' => (bool)$r['is_done'],
                'progress' => $r['progress'],
                'total' => $r['target']
            ];
        }
    }
    if(empty($challenges)) {
        // Berikan 1 tantangan awal agar tidak kosong
        $conn->query("INSERT INTO gb_mengajar_tantangan (member_id, tanggal, ikon, nama_tantangan, xp_reward, progress, target, is_done) VALUES ($uid, CURDATE(), '🎯', 'Bagikan 1 Game ke Murid', 50, 0, 1, 0)");
        $challenges = [
            ['icon'=>'🎯','name'=>'Bagikan 1 Game ke Murid','desc'=>'Tantangan kelas','xp'=>'+50 XP','done'=>false,'progress'=>0,'total'=>1]
        ];
    }
    
    // Fetch leaders
    $leaders = [];
    $res3 = $conn->query("SELECT s.*, m.full_name as member_name, m.institution FROM gb_mengajar_stats s JOIN members m ON s.member_id = m.id ORDER BY s.total_xp DESC LIMIT 10");
    if($res3 && $res3->num_rows > 0) {
        $rank = 1;
        while($r = $res3->fetch_assoc()) {
            $leaders[] = [
                'rank' => $rank++,
                'name' => $r['member_name'],
                'inst' => $r['institution'] ?? 'Guruverse',
                'level' => 'Level ' . $r['level_saat_ini'],
                'xp' => $r['total_xp'],
                'streak' => $r['hari_streak'],
                'badges' => $r['badge_diraih'],
                'you' => ($r['member_id'] == $uid)
            ];
        }
    }
    // Fetch kompetisi karya
    $karya_list = [];
    $res4 = $conn->query("SELECT k.*, m.full_name, m.institution,
            (SELECT COUNT(*) FROM gb_mengajar_karya_votes v WHERE v.karya_id = k.id AND v.member_id = $uid) as is_voted
            FROM gb_mengajar_karya k 
            JOIN members m ON k.member_id = m.id 
            ORDER BY k.vote_count DESC");
    if($res4 && $res4->num_rows > 0) {
        while($r = $res4->fetch_assoc()) {
            $karya_list[] = $r;
        }
    }
}

if (!$has_gamifikasi_db): 
?>
<div class="page" id="page-gamifikasi">
<style>
@keyframes gamifikasiStripes {
  from { background-position: 0 0; }
  to { background-position: 20px 0; }
}
@keyframes floatTrophy {
  0% { transform: translateY(0); }
  50% { transform: translateY(-8px); box-shadow:0 12px 30px rgba(245,158,11,.6); }
  100% { transform: translateY(0); }
}
.katalog-card {
  border-radius:14px;
  padding:20px;
  border:1px solid #e2e8f0;
  background:#fff;
  transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor:pointer;
  position:relative;
  top:0;
}
.katalog-card:hover {
  border-color:#cbd5e1;
  box-shadow:0 15px 30px rgba(0,0,0,0.08);
  top:-6px;
}
.katalog-card .locked-btn {
  transition:all 0.3s;
}
.katalog-card:hover .locked-btn {
  animation: shakeAlert 0.4s ease-in-out;
}
@keyframes shakeAlert {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-3px); }
  40%, 80% { transform: translateX(3px); }
}
</style>
  <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:60vh;text-align:center;">
    <div style="font-size:64px;margin-bottom:16px;">[o]</div>
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

<style>
/* ADMIN DESIGN SYSTEM PORTED TO MEMBER */
.admin-panel {
  background: var(--c-card,#ffffff);
  border-radius: 14px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.04);
  border: 1px solid var(--c-border,#e2e8f0);
  margin-bottom: 2rem;
  overflow: hidden;
}
.admin-panel-head {
  padding: 18px 24px;
  border-bottom: 1px solid var(--c-border,#e2e8f0);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: var(--c-bg,#f8fafc);
}
.admin-panel-title {
  font-weight: 800;
  font-size: 1.1rem;
  color: var(--c-text,#0f172a);
}
.admin-tbl-wrap {
  width: 100%;
  overflow-x: auto;
}
.admin-tbl-wrap table {
  width: 100%;
  border-collapse: collapse;
}
.admin-tbl-wrap th, .admin-tbl-wrap td {
  padding: 14px 24px;
  text-align: left;
  border-bottom: 1px solid var(--c-border-light,#f1f5f9);
  vertical-align: middle;
}
.admin-tbl-wrap th {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--c-text-muted,#64748b);
  font-weight: 700;
  background: rgba(0,0,0,0.015);
}
.admin-tbl-wrap tbody tr:hover {
  background: rgba(0,0,0,0.01);
}
.admin-btn-sm {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 700;
  cursor: pointer;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
}
.admin-btn-sm:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.admin-badge {
  font-size: 0.65rem;
  font-weight: 800;
  padding: 4px 10px;
  border-radius: 20px;
  text-transform: uppercase;
}
.admin-mono {
  font-family: monospace;
  font-weight: 700;
  color: var(--c-text-muted,#94a3b8);
}
.c-opt {
  padding: 12px 16px;
  font-size: 0.875rem;
  color: var(--c-text);
  cursor: pointer;
  transition: background 0.15s, color 0.15s;
}
.c-opt:hover {
  background: rgba(16,185,129,0.08);
  color: #10b981;
  font-weight: 700;
}
</style>

<div class="page" id="page-gamifikasi">

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">
    <!-- KARTU STATS ALA ADMIN -->
    <div class="admin-panel" style="margin-bottom:0;">
        <div class="admin-panel-head">
            <span class="admin-panel-title">Statistik Anda</span>
        </div>
        <div style="padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div style="padding:16px; border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
                <div style="font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase;">Level Mengajar</div>
                <div style="font-size:1.8rem; font-weight:900; color:#4f46e5; margin:4px 0;"><?= $stats['level_saat_ini'] ?? 4 ?></div>
                <div style="font-size:0.75rem; color:#94a3b8; font-weight:600;"><?= $stats['total_xp'] ?? 850 ?> XP Terkumpul</div>
            </div>
            <div style="padding:16px; border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
                <div style="font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase;">Peringkat Guru</div>
                <div style="font-size:1.8rem; font-weight:900; color:#f59e0b; margin:4px 0;">#12</div>
                <div style="font-size:0.75rem; color:#94a3b8; font-weight:600;">Top 100 bulan ini</div>
            </div>
        </div>
    </div>

    <!-- TANTANGAN KELAS (ADMIN TABLE STYLE) -->
    <div class="admin-panel" style="margin-bottom:0;">
        <div class="admin-panel-head">
            <span class="admin-panel-title">Tantangan Kelas Aktif</span>
        </div>
        <div class="admin-tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Tantangan</th>
                        <th style="text-align:center;">Progress</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                                <tbody>
                    <?php foreach($challenges as $i => $ch): ?>
                    <tr>
                        <td><span class="admin-mono"><?= $i+1 ?></span></td>
                        <td>
                            <div style="font-weight:800; font-size:0.85rem; color:#1e293b;"><?= htmlspecialchars($ch['name']) ?></div>
                            <div style="font-size:0.7rem; color:#64748b; margin-top:2px; font-weight:700; color:#4f46e5;"><?= $ch['xp'] ?></div>
                        </td>
                        <td style="text-align:center;">
                            <div style="font-size:0.75rem; font-weight:700; color:#475569; margin-bottom:4px;"><?= $ch['progress'] ?> / <?= $ch['total'] ?></div>
                            <div style="width:100px; height:6px; background:#e2e8f0; border-radius:99px; overflow:hidden; margin:0 auto;">
                                <div style="height:100%; width:<?= $ch['total']>0 ? round($ch['progress']/$ch['total']*100) : 0 ?>%; background:#10b981;"></div>
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <?php if($ch['done']): ?>
                            <span class="admin-badge" style="background:rgba(16,185,129,0.1); color:#10b981;">SELESAI</span>
                            <?php else: ?>
                            <span class="admin-badge" style="background:rgba(245,158,11,0.1); color:#f59e0b;">BERJALAN</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>

    <!-- KOMPETISI INOVASI PENDIDIK -->
    <div class="admin-panel" style="margin-top:24px;">
        <div class="admin-panel-head" style="background:linear-gradient(90deg, rgba(79,70,229,0.05), transparent);">
            <div style="display:flex; align-items:center; gap:12px;">
                <span class="admin-panel-title">Kompetisi Inovasi Pendidik</span>
            </div>
            <button onclick="showPage('kirim-karya')" class="admin-btn-sm" style="background:#10b981; color:#fff;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Kirim Karya Saya
            </button>
        </div>
        
        <div style="padding:24px;">
            <p style="color:#64748b; font-size:0.85rem; margin-top:0; margin-bottom:20px;">Bagikan karya terbaikmu (RPP, Modul Ajar, Rubrik) dan dapatkan dukungan dari guru lainnya. 3 Karya teratas akan mendapatkan hadiah spesial!</p>
            
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
                <?php $rank=1; foreach($karya_list as $k): 
                    $medal = '';
                    if($rank == 1) $medal = '🥇';
                    else if($rank == 2) $medal = '🥈';
                    else if($rank == 3) $medal = '🥉';
                ?>
                <div style="border:1px solid <?= $rank<=3 ? '#f59e0b' : '#e2e8f0' ?>; border-radius:12px; padding:16px; background:<?= $rank<=3 ? 'rgba(245,158,11,0.02)' : '#fff' ?>; position:relative;">
                    <?php if($rank<=3): ?>
                    <div style="position:absolute; top:-12px; right:16px; font-size:24px; filter:drop-shadow(0 4px 6px rgba(0,0,0,0.1));"><?= $medal ?></div>
                    <?php endif; ?>
                    <div style="font-size:0.65rem; font-weight:800; color:#4f46e5; text-transform:uppercase; margin-bottom:4px;"><?= htmlspecialchars($k['jenis']) ?></div>
                    <div style="font-weight:800; font-size:1rem; color:#0f172a; margin-bottom:6px; line-height:1.3;"><?= htmlspecialchars($k['judul']) ?></div>
                    <div style="font-size:0.75rem; color:#64748b; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;"><?= htmlspecialchars($k['deskripsi']) ?></div>
                    
                    <div style="display:flex; justify-content:space-between; align-items:flex-end; border-top:1px dashed #e2e8f0; padding-top:12px; margin-top:auto;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:24px; height:24px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:800; color:#64748b;">
                                <?= substr(htmlspecialchars($k['full_name']), 0, 1) ?>
                            </div>
                            <div style="font-size:0.75rem; font-weight:700; color:#475569;"><?= htmlspecialchars($k['full_name']) ?></div>
                        </div>
                        <button onclick="voteKarya(<?= $k['id'] ?>, this)" <?= $k['is_voted'] ? 'disabled' : '' ?> class="admin-btn-sm" style="padding:6px 12px; font-size:0.75rem; background:<?= $k['is_voted'] ? '#f8fafc' : '#fef3c7' ?>; color:<?= $k['is_voted'] ? '#94a3b8' : '#f59e0b' ?>; border:1px solid <?= $k['is_voted'] ? '#e2e8f0' : '#fcd34d' ?>; gap:4px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="<?= $k['is_voted'] ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                            <span class="vote-count"><?= $k['vote_count'] ?></span>
                        </button>
                    </div>
                </div>
                <?php $rank++; endforeach; ?>
            </div>
        </div>
    </div>

    <!-- FLOATING CART BUTTON -->
  <div id="floating-cart" style="position:fixed; bottom:100px; right:30px; background:#4f46e5; color:#fff; width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 10px 25px rgba(79,70,229,0.4); z-index:999; transition:transform 0.2s;" onclick="showPage('cart-gamifikasi')">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
      <div id="cart-badge" style="position:absolute; top:-5px; right:-5px; background:#ef4444; color:#fff; font-size:12px; font-weight:800; width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #fff;">0</div>
  </div>

    <!-- BANK MATERI GAMIFIKASI (CARD GRID) -->
  <div style="margin-top: 30px; margin-bottom: 20px;">
      <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 5px;">Bank Materi Gamifikasi</h2>
      <p style="color: #64748b; font-size: 0.9rem;">Eksplorasi kumpulan game, kuis, dan ice breaking untuk kelasmu.</p>
  </div>
  
  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
      <?php 
      foreach($katalog as $item): 
          $item_is_premium = isset($item['is_premium']) ? filter_var($item['is_premium'], FILTER_VALIDATE_BOOLEAN) : true;
          // Simulasi harga
          $price = $item_is_premium ? 25000 : 0;
          $gameId = $item['id'] ?? $item['path'];
          $tipe_label = strtoupper($item['tipe']);
          
          // Generate background based on category (Professional Dark Palette)
          $bg_color = "linear-gradient(135deg, #1e293b, #0f172a)"; // Default: Deep Slate
          $show_icon = false; // Karena ikon sudah dihapus, flag ini bisa dibiarkan false
          if(stripos($item['kategori'], 'Ice') !== false) {
              $bg_color = "linear-gradient(135deg, #1e3a8a, #172554)"; // Deep Navy Blue
          } else if(stripos($item['kategori'], 'Kuis') !== false) {
              $bg_color = "linear-gradient(135deg, #312e81, #1e1b4b)"; // Deep Indigo
          } else if(stripos($item['kategori'], 'Buku') !== false) {
              $bg_color = "linear-gradient(135deg, #064e3b, #022c22)"; // Dark Emerald
          }
      ?>
      <div class="card-item" data-game-id="<?= $gameId ?>" data-price="<?= $price ?>" data-title="<?= htmlspecialchars($item['judul']) ?>" data-path="<?= $item['path'] ?>" style="background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.02); transition: all 0.3s; display: flex; flex-direction: column;">
          
          <!-- Card Cover -->
          <div style="height: 160px; background: <?= $bg_color ?>; position: relative; display: flex; align-items: center; justify-content: center;">
              <div style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.5px;">
                  <?= $tipe_label ?>
              </div>

          </div>
          
          <!-- Card Body -->
          <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
              <div style="font-size: 0.7rem; font-weight: 800; color: #8b2fc9; text-transform: uppercase; margin-bottom: 6px;">
                  <?= htmlspecialchars($item['kategori']) ?>
              </div>
              <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                  <?= htmlspecialchars($item['judul']) ?>
              </h3>
              <p style="font-size: 0.8rem; color: #64748b; line-height: 1.6; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1;">
                  <?= htmlspecialchars($item['deskripsi']) ?>
              </p>
              
              <!-- Card Footer (Action Area) -->
              <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                  <div class="card-price" style="flex-shrink: 0;">
                      <?php if($price === 0): ?>
                          <span style="display:inline-flex; align-items:center; gap:5px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#059669; font-size:0.78rem; font-weight:800; padding:5px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">
                              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                              Gratis
                          </span>
                      <?php else: ?>
                          <span style="font-size: 1.05rem; font-weight: 900; color: #0f172a;">Rp <?= number_format($price, 0, ',', '.') ?></span>
                      <?php endif; ?>
                  </div>
                  <div class="card-action" style="flex-shrink: 0;">
                      <!-- Buttons injected by JS -->
                  </div>
              </div>
          </div>
      </div>
      <?php endforeach; ?>
  </div>

<script>
  let cart = JSON.parse(localStorage.getItem('gv_gamifikasi_cart') || '[]');
  let ownedGames = JSON.parse(localStorage.getItem('gv_owned_games') || '[]');

  // Sinkronisasi data ketika ada perubahan di tab/halaman lain
  window.addEventListener('storage', function(e) {
      if(e.key === 'gv_gamifikasi_cart' || e.key === 'gv_owned_games') {
          cart = JSON.parse(localStorage.getItem('gv_gamifikasi_cart') || '[]');
          ownedGames = JSON.parse(localStorage.getItem('gv_owned_games') || '[]');
          updateCartUI();
          renderTableButtons();
      }
  });

  async function voteKarya(id, btnElement) {
      if(btnElement.disabled) return;
      btnElement.disabled = true;
      const oldColor = btnElement.style.color;
      btnElement.style.color = '#94a3b8';

      const fd = new FormData();
      fd.append('karya_id', id);

      try {
          const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_kompetisi.php?action=vote_karya', {
              method: 'POST', body: fd
          });
          const data = await res.json();
          if(data.status === 'success') {
              // Update UI optimistically
              const span = btnElement.querySelector('.vote-count');
              if(span) span.innerText = parseInt(span.innerText) + 1;
              btnElement.style.background = '#f8fafc';
              btnElement.style.borderColor = '#e2e8f0';
              const svg = btnElement.querySelector('svg');
              if(svg) svg.setAttribute('fill', 'currentColor');
          } else {
              alert(data.message);
              btnElement.disabled = false;
              btnElement.style.color = oldColor;
          }
      } catch (err) {
          alert('Terjadi kesalahan jaringan.');
          btnElement.disabled = false;
          btnElement.style.color = oldColor;
      }
  }

  /* ── Form Kirim Karya (In-place) ── */
  let gfOpen = false;
  function toggleGamifikasiForm() {
      gfOpen = !gfOpen;
      const panel = document.getElementById('gamifikasi-form-panel');
      const icon = document.getElementById('g-form-icon');
      const txt = document.getElementById('g-form-text');
      const btn = document.getElementById('btn-toggle-gamifikasi-form');

      if (gfOpen) {
          panel.style.display = 'block';
          icon.style.transform = 'rotate(45deg)';
          txt.textContent = 'Batal';
          btn.style.background = '#64748b';
          btn.onmouseover = () => { btn.style.background='#475569'; };
          btn.onmouseout  = () => { btn.style.background='#64748b'; };
      } else {
          panel.style.display = 'none';
          icon.style.transform = 'rotate(0deg)';
          txt.textContent = 'Kirim Karya Saya';
          btn.style.background = '#10b981';
          btn.onmouseover = () => { btn.style.background='#059669'; };
          btn.onmouseout  = () => { btn.style.background='#10b981'; };
      }
  }

  function resetFormKarya() {
      document.getElementById('form-karya').reset();
      const st = document.getElementById('custom-select-text');
      if(st) { st.textContent = '-- Pilih --'; st.style.color = 'var(--c-text-muted)'; }
  }

  let cSelectOpen = false;
  function toggleCustomSelect() {
      cSelectOpen = !cSelectOpen;
      const opts = document.getElementById('custom-select-options');
      const trig = document.getElementById('custom-select-trigger');
      const icon = document.getElementById('custom-select-icon');
      if (cSelectOpen) {
          opts.style.display = 'block';
          void opts.offsetWidth;
          opts.style.opacity = '1';
          opts.style.transform = 'translateY(0)';
          trig.style.borderColor = '#10b981';
          trig.style.boxShadow = '0 0 0 3px rgba(16,185,129,0.1)';
          icon.style.transform = 'rotate(180deg)';
      } else {
          closeCustomSelect();
      }
  }
  function closeCustomSelect() {
      cSelectOpen = false;
      const opts = document.getElementById('custom-select-options');
      const trig = document.getElementById('custom-select-trigger');
      const icon = document.getElementById('custom-select-icon');
      if(!opts) return;
      opts.style.opacity = '0';
      opts.style.transform = 'translateY(-10px)';
      trig.style.borderColor = 'var(--c-border)';
      trig.style.boxShadow = 'none';
      icon.style.transform = 'rotate(0deg)';
      setTimeout(() => { if(!cSelectOpen) opts.style.display = 'none'; }, 200);
  }
  function selectOption(val, text) {
      document.getElementById('karya-jenis').value = val;
      const st = document.getElementById('custom-select-text');
      st.textContent = text;
      st.style.color = 'var(--c-text)';
      closeCustomSelect();
  }
  document.addEventListener('click', (e) => {
      const wrap = document.getElementById('custom-select-wrapper');
      if (wrap && !wrap.contains(e.target) && cSelectOpen) {
          closeCustomSelect();
      }
  });

  async function submitKarya(e) {
      e.preventDefault();
      const judul = document.getElementById('karya-judul').value.trim();
      const jenis = document.getElementById('karya-jenis').value;
      const desk  = document.getElementById('karya-desk').value.trim();
      if (!judul || !jenis || !desk) { alert('Mohon lengkapi semua field wajib (*).'); return; }

      const btn = document.getElementById('btn-submit-karya');
      const old = btn.innerHTML;
      btn.innerHTML = 'Mengirim...';
      btn.disabled = true;

      const fd = new FormData();
      fd.append('judul', judul); fd.append('jenis', jenis); fd.append('deskripsi', desk);
      fd.append('link_karya', document.getElementById('karya-link').value);
      const fi = document.getElementById('karya-file');
      if (fi.files.length > 0) fd.append('file_karya', fi.files[0]);

      try {
          const res  = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_kompetisi.php?action=submit_karya', { method:'POST', body:fd });
          const data = await res.json();
          if (data.status === 'success') {
              alert(data.message);
              resetFormKarya();
              setTimeout(() => window.location.reload(), 200);
          } else {
              alert(data.message || 'Gagal mengirim karya.');
              btn.innerHTML = old; btn.disabled = false;
          }
      } catch (err) { alert('Kesalahan jaringan.'); btn.innerHTML = old; btn.disabled = false; }
  }

  function saveCart() {
      localStorage.setItem('gv_gamifikasi_cart', JSON.stringify(cart));
      updateCartUI();
      renderTableButtons();
  }

  function addToCart(id, title, price) {
      if(!cart.find(i => i.id === id)) {
          cart.push({ id, title, price });
          saveCart();
      }
  }

  function updateCartUI() {
      const badge = document.getElementById('cart-badge');
      if(badge) {
          badge.innerText = cart.length;
          badge.style.display = cart.length > 0 ? 'flex' : 'none';
      }
  }

  function renderTableButtons() {
      const rows = document.querySelectorAll('.card-item[data-game-id]');
      rows.forEach(row => {
          const id = row.getAttribute('data-game-id');
          const price = parseInt(row.getAttribute('data-price'));
          const title = row.getAttribute('data-title');
          const path = row.getAttribute('data-path');
          const td = row.querySelector('.card-action');
          const priceEl = row.querySelector('.card-price');
          
          let btnHtml = '';
          const isJson = path.toLowerCase().endsWith('.json');
          const safeTitle = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
          
          // Shared button style variables for consistency
          const btnBase = `padding:10px 20px; border-radius:10px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:7px; font-size:0.82rem; border:none; transition:all 0.2s; white-space:nowrap;`;

          const isOwned = ownedGames.includes(id);
          const isFree  = price === 0;

          if(isFree || isOwned) {
              // Update label harga agar selalu konsisten dengan tombol
              if(priceEl) {
                  if(isFree) {
                      // Benar-benar gratis → badge hijau
                      priceEl.innerHTML = `<span style="display:inline-flex; align-items:center; gap:5px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#059669; font-size:0.78rem; font-weight:800; padding:5px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Gratis</span>`;
                  } else {
                      // Sudah dibeli → badge ungu "Dimiliki"
                      priceEl.innerHTML = `<span style="display:inline-flex; align-items:center; gap:5px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); color:#7c3aed; font-size:0.78rem; font-weight:800; padding:5px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Dimiliki</span>`;
                  }
              }

              if(isJson) {
                  // JSON game → langsung mainkan
                  btnHtml = `<button style="${btnBase} background:linear-gradient(135deg,#10b981,#059669); color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" onclick="openGame('${path}', '${id}')">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg> Mainkan
                  </button>`;
              } else {
                  // File (PDF, PPTX, dll) → tampilkan modal pilihan
                  btnHtml = `<button style="${btnBase} background:linear-gradient(135deg,#10b981,#059669); color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" onclick="showFreeAccessModal('${path}', '${safeTitle}', '${id}')">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> Akses Gratis
                  </button>`;
              }
          } else {
              // Item BERBAYAR
              if(cart.find(i => i.id === id)) {
                  btnHtml = `<button style="${btnBase} background:#eef2ff; color:#4f46e5; border:2px solid #c7d2fe;" onmouseover="this.style.background='#e0e7ff'" onmouseout="this.style.background='#eef2ff'" onclick="showPage('cart-gamifikasi')">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Di Keranjang
                  </button>`;
              } else {
                  btnHtml = `<button style="${btnBase} background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; box-shadow:0 4px 12px rgba(79,70,229,0.35);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" onclick="addToCart('${id}', '${safeTitle}', ${price})">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Beli
                  </button>`;
              }
          }
          td.innerHTML = btnHtml;
      });
  }

  function openGame(p, gId) {
      if (p.endsWith('.json')) {
          window.location.href = '/guruverse/member/pages/Guru_Gamifikasi/index.php?play=' + encodeURIComponent(gId ? gId : p);
      } else {
          // Deteksi file Office (PPT, DOC, XLS)
          const ext = p.split('.').pop().toLowerCase();
          const isOfficeFile = ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'].includes(ext);
          
          if (isOfficeFile) {
              // Bangun URL absolut menggunakan window.location.origin
              // Jika p sudah berformat absolut http/https, kita tidak perlu nambah origin
              let absoluteUrl = p.startsWith('http') ? p : window.location.origin + p;
              
              // Arahkan ke Google Docs Viewer
              window.location.href = 'https://docs.google.com/viewer?url=' + encodeURIComponent(absoluteUrl) + '&embedded=true';
          } else {
              // Jika PDF atau format lain yang didukung native browser
              window.location.href = p;
          }
      }
  }

  /* ── Modal Akses Gratis ── */
  let _freeModalPath = '', _freeModalId = '';

  function showFreeAccessModal(path, title, gId) {
      _freeModalPath = path;
      _freeModalId   = gId;
      document.getElementById('freeModalTitle').textContent = title;

      // Tentukan apakah bisa di-download
      const ext = path.split('.').pop().toLowerCase();
      const downloadable = ['pdf','pptx','ppt','docx','doc','xlsx','zip'].includes(ext);
      document.getElementById('freeModalDownloadBtn').style.display = downloadable ? 'flex' : 'none';

      const overlay = document.getElementById('freeAccessModalOverlay');
      overlay.style.display = 'flex';
      setTimeout(() => { overlay.style.opacity = '1'; overlay.querySelector('.free-modal-box').style.transform = 'translateY(0) scale(1)'; }, 10);
  }

  function closeFreeModal() {
      const overlay = document.getElementById('freeAccessModalOverlay');
      overlay.style.opacity = '0';
      overlay.querySelector('.free-modal-box').style.transform = 'translateY(20px) scale(0.96)';
      setTimeout(() => { overlay.style.display = 'none'; }, 280);
  }

  function freeDownload() {
      closeFreeModal();
      const a = document.createElement('a');
      a.href = _freeModalPath;
      a.download = '';
      a.target = '_blank';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
  }

  function freeReadOnline() {
      closeFreeModal();
      openGame(_freeModalPath, _freeModalId);
  }

  function initGamifikasi() {
      updateCartUI();
      renderTableButtons();
  }

  if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initGamifikasi);
  } else {
      initGamifikasi();
      setTimeout(initGamifikasi, 500);
  }
</script>

<!-- ══ MODAL AKSES GRATIS ══ -->
<div id="freeAccessModalOverlay" style="display:none; opacity:0; position:fixed; inset:0; background:rgba(15,23,42,0.55); backdrop-filter:blur(6px); z-index:9998; align-items:center; justify-content:center; transition:opacity 0.28s ease;" onclick="if(event.target===this) closeFreeModal()">
  <div class="free-modal-box" style="background:#fff; border-radius:20px; padding:36px 32px; max-width:460px; width:90%; box-shadow:0 30px 80px rgba(0,0,0,0.25); transform:translateY(20px) scale(0.96); transition:transform 0.28s cubic-bezier(0.34,1.56,0.64,1);">
    
    <!-- Icon -->
    <div style="width:64px; height:64px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    </div>

    <!-- Badge -->
    <div style="text-align:center; margin-bottom:12px;">
      <span style="background:#d1fae5; color:#059669; font-size:0.7rem; font-weight:800; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Konten Gratis</span>
    </div>

    <!-- Title -->
    <h3 id="freeModalTitle" style="font-size:1.15rem; font-weight:900; color:#0f172a; text-align:center; margin-bottom:6px; line-height:1.4;"></h3>
    <p style="text-align:center; color:#64748b; font-size:0.85rem; margin-bottom:28px;">Pilih cara mengakses materi ini:</p>

    <!-- Choices -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
      
      <!-- Download -->
      <button id="freeModalDownloadBtn" onclick="freeDownload()" style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:20px 16px; background:#f0fdf4; border:2px solid #bbf7d0; border-radius:14px; cursor:pointer; transition:all 0.2s; font-weight:800; color:#059669; font-size:0.85rem;" onmouseover="this.style.background='#dcfce7'; this.style.borderColor='#86efac'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#f0fdf4'; this.style.borderColor='#bbf7d0'; this.style.transform='translateY(0)'">
        <div style="width:44px; height:44px; background:linear-gradient(135deg,#10b981,#059669); border-radius:12px; display:flex; align-items:center; justify-content:center;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        </div>
        Download
        <span style="font-size:0.72rem; font-weight:600; color:#6ee7b7;">Simpan ke perangkat</span>
      </button>

      <!-- Baca Online -->
      <button onclick="freeReadOnline()" style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:20px 16px; background:#eff6ff; border:2px solid #bfdbfe; border-radius:14px; cursor:pointer; transition:all 0.2s; font-weight:800; color:#2563eb; font-size:0.85rem;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#93c5fd'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe'; this.style.transform='translateY(0)'">
        <div style="width:44px; height:44px; background:linear-gradient(135deg,#3b82f6,#2563eb); border-radius:12px; display:flex; align-items:center; justify-content:center;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        Baca Online
        <span style="font-size:0.72rem; font-weight:600; color:#93c5fd;">Langsung di browser</span>
      </button>
    </div>

    <!-- Cancel -->
    <button onclick="closeFreeModal()" style="width:100%; padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; font-weight:700; color:#64748b; font-size:0.85rem; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">Batal</button>
  </div>
</div>
</div><!-- /page-gamifikasi -->
<?php endif; ?>