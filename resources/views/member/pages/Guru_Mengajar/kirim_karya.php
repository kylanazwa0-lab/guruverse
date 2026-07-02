<?php
/* ─── Kirim Karya Inovatif — Guru Mengajar ─── */
$uid = (int)($_SESSION['member_int_id'] ?? 3);

$karyas = [];
$res = $conn->query("
    SELECT k.*, m.full_name, m.institution,
           (SELECT COUNT(*) FROM gb_mengajar_karya_votes v WHERE v.karya_id = k.id AND v.member_id = $uid) AS sudah_vote
    FROM gb_mengajar_karya k
    JOIN members m ON k.member_id = m.id
    ORDER BY k.vote_count DESC, k.created_at DESC
");
if ($res) { while ($r = $res->fetch_assoc()) $karyas[] = $r; }

$total_karya = count($karyas);
$top_votes   = $total_karya > 0 ? max(array_column($karyas, 'vote_count')) : 0;
$my_karya    = count(array_filter($karyas, fn($k) => $k['member_id'] == $uid));
$top3        = array_slice($karyas, 0, 3);
?>

<div class="page" id="page-kirim-karya">
  
  <button onclick="showPage('gamifikasi')" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;font-size:0.8rem;font-weight:700;color:#475569;margin-bottom:20px;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Gamifikasi
  </button>

  <!-- ══════ HERO ══════ -->
  <div style="position:relative; overflow:hidden; border-radius:20px; margin-bottom:28px;
              background:linear-gradient(135deg,#3730a3 0%,#6d28d9 55%,#be185d 100%); padding:28px 32px; color:#fff;">
    <div style="position:absolute;top:-50px;right:-30px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.06)"></div>
    <div style="position:absolute;bottom:-60px;right:140px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.04)"></div>
    <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
      <div>
        <div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;background:rgba(255,255,255,0.15);
                    border-radius:20px;margin-bottom:10px;font-size:0.7rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;">
          Kompetisi Bulanan Aktif
        </div>
        <h2 style="margin:0 0 6px;font-size:1.5rem;font-weight:900;line-height:1.2;">Kirim Karya Inovatif</h2>
        <p style="margin:0;font-size:0.85rem;color:rgba(255,255,255,0.78);max-width:460px;line-height:1.55;">
          Bagikan RPP, Modul Ajar, atau Media Pembelajaran terbaik Anda. 3 karya
          dengan voting tertinggi menangkan <strong style="color:#fde68a;">Merchandise Eksklusif</strong> + <strong>5.000 XP</strong>!
        </p>
      </div>
      <div style="display:flex;gap:12px;flex-shrink:0;flex-wrap:wrap;">
        <?php foreach ([
          ['val'=>$total_karya, 'lbl'=>'Karya Masuk'],
          ['val'=>$top_votes,   'lbl'=>'Vote Tertinggi'],
          ['val'=>$my_karya,    'lbl'=>'Karya Saya'],
        ] as $s): ?>
        <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.18);
                    border-radius:14px;padding:14px 20px;text-align:center;min-width:80px;">
          <div style="font-size:1.7rem;font-weight:900;line-height:1;"><?= $s['val'] ?></div>
          <div style="font-size:0.68rem;color:rgba(255,255,255,0.72);font-weight:600;margin-top:5px;"><?= $s['lbl'] ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- ══════ TOP 3 KPI CARDS ══════ -->
  <div style="margin-bottom:28px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
      <h3 style="margin:0;font-size:0.95rem;font-weight:800;color:var(--c-text);display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
        </svg>
        Dinding Karya Terpopuler
      </h3>
      <?php if ($total_karya > 3): ?>
      <button onclick="toggleAllKarya()"
        style="font-size:0.78rem;font-weight:700;color:#4f46e5;background:none;border:none;cursor:pointer;padding:4px 0;">
        Lihat semua <?= $total_karya ?> karya →
      </button>
      <?php endif; ?>
    </div>

    <?php if (empty($karyas)): ?>
    <div style="grid-column:1/-1;text-align:center;padding:48px 20px;border:2px dashed var(--c-border);border-radius:16px;color:var(--c-text-muted);">
      <div style="font-size:2.5rem;margin-bottom:10px;opacity:.35;">✏️</div>
      <p style="margin:0;font-size:0.9rem;font-weight:700;color:var(--c-text);">Belum ada karya</p>
      <p style="margin:6px 0 0;font-size:0.82rem;">Jadilah yang pertama mengirimkan karya inovatif!</p>
    </div>
    <?php else: ?>

    <!-- TOP 3 ROW -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
      <?php
      $medals = [
        ['icon'=>'🥇','bg'=>'linear-gradient(135deg,#fef3c7,#fde68a)','border'=>'#f59e0b','color'=>'#92400e','shadow'=>'rgba(245,158,11,0.2)'],
        ['icon'=>'🥈','bg'=>'linear-gradient(135deg,#f1f5f9,#e2e8f0)','border'=>'#94a3b8','color'=>'#475569','shadow'=>'rgba(148,163,184,0.2)'],
        ['icon'=>'🥉','bg'=>'linear-gradient(135deg,#fef3e2,#fed7aa)','border'=>'#f97316','color'=>'#9a3412','shadow'=>'rgba(249,115,22,0.15)'],
      ];
      foreach ($top3 as $i => $k):
        $m       = $medals[$i];
        $is_mine = ((int)$k['member_id'] === $uid);
        $voted   = (bool)$k['sudah_vote'];
        $av_cols = ['#4f46e5,#7c3aed','#0891b2,#0e7490','#dc2626,#be185d'];
        $av_g    = $av_cols[$i % 3];
      ?>
      <div style="background:var(--c-card);border:1.5px solid <?= $m['border'] ?>;border-radius:16px;
                  padding:20px;box-shadow:0 4px 16px <?= $m['shadow'] ?>;position:relative;
                  transition:transform .2s,box-shadow .2s;"
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px <?= $m['shadow'] ?>'"
           onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px <?= $m['shadow'] ?>'">

        <!-- Medal badge -->
        <div style="position:absolute;top:-1px;left:16px;background:<?= $m['bg'] ?>;border:1.5px solid <?= $m['border'] ?>;
                    border-top:none;border-radius:0 0 10px 10px;padding:2px 10px 5px;font-size:0.9rem;
                    font-weight:800;color:<?= $m['color'] ?>;">
          <?= $m['icon'] ?> #<?= $i+1 ?>
        </div>

        <!-- Top area -->
        <div style="margin-top:18px;display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
          <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,<?= $av_g ?>);
                      color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1rem;flex-shrink:0;">
            <?= strtoupper(substr($k['full_name'],0,1)) ?>
          </div>
          <!-- Vote count prominent -->
          <div style="text-align:center;">
            <div style="font-size:1.6rem;font-weight:900;color:<?= $voted ? '#10b981' : 'var(--c-text)' ?>;line-height:1;">
              <?= (int)$k['vote_count'] ?>
            </div>
            <div style="font-size:0.65rem;color:var(--c-text-muted);font-weight:700;text-transform:uppercase;">votes</div>
          </div>
        </div>

        <!-- Title -->
        <div style="font-weight:800;font-size:0.88rem;color:var(--c-text);margin-bottom:4px;
                    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.35;">
          <?= htmlspecialchars($k['judul']) ?>
        </div>
        <div style="font-size:0.72rem;color:var(--c-text-muted);margin-bottom:10px;">
          <?= htmlspecialchars($k['full_name']) ?>
        </div>

        <!-- Kategori -->
        <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:0.68rem;font-weight:700;
                     background:rgba(79,70,229,0.08);color:#4f46e5;border:1px solid rgba(79,70,229,0.15);margin-bottom:12px;">
          <?= htmlspecialchars($k['jenis']) ?>
        </span>

        <!-- Vote button -->
        <div style="border-top:1px solid var(--c-border);padding-top:12px;">
          <button onclick="voteKarya(<?= (int)$k['id'] ?>, this)"
            id="vote-btn-<?= (int)$k['id'] ?>"
            <?= ($is_mine || $voted) ? 'disabled' : '' ?>
            style="width:100%;padding:8px;border-radius:8px;font-size:0.8rem;font-weight:800;
                   display:flex;align-items:center;justify-content:center;gap:7px;cursor:<?= ($is_mine||$voted) ? 'default' : 'pointer' ?>;
                   border:1.5px solid <?= $voted ? '#10b981' : 'var(--c-border)' ?>;
                   background:<?= $voted ? 'rgba(16,185,129,0.08)' : 'transparent' ?>;
                   color:<?= $voted ? '#10b981' : 'var(--c-text-muted)' ?>;transition:.2s;font-family:inherit;"
            <?= (!$is_mine&&!$voted) ? 'onmouseover="this.style.borderColor=\'#ef4444\';this.style.color=\'#ef4444\';this.style.background=\'rgba(239,68,68,0.06)\'"
                 onmouseout="this.style.borderColor=\'var(--c-border)\';this.style.color=\'var(--c-text-muted)\';this.style.background=\'transparent\'"' : '' ?>>
            <svg width="14" height="14" viewBox="0 0 24 24"
                 fill="<?= $voted ? '#10b981' : 'none' ?>"
                 stroke="<?= $voted ? '#10b981' : 'currentColor' ?>"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
            <span id="vote-count-<?= (int)$k['id'] ?>">
              <?= $voted ? 'Sudah Didukung ✓' : ($is_mine ? 'Karya Saya' : 'Dukung Karya Ini') ?>
            </span>
          </button>
        </div>

      </div>
      <?php endforeach; ?>

      <!-- Placeholder jika karya < 3 -->
      <?php for ($p = count($top3); $p < 3; $p++): ?>
      <div style="border:2px dashed var(--c-border);border-radius:16px;padding:32px 20px;
                  display:flex;flex-direction:column;align-items:center;justify-content:center;
                  text-align:center;color:var(--c-text-muted);gap:8px;min-height:180px;">
        <div style="font-size:1.8rem;opacity:.3;"><?= ['🥇','🥈','🥉'][$p] ?></div>
        <div style="font-size:0.8rem;font-weight:700;">Posisi <?= $p+1 ?> masih kosong</div>
        <div style="font-size:0.73rem;opacity:.7;">Jadilah yang pertama!</div>
      </div>
      <?php endfor; ?>
    </div>

    <!-- ALL KARYA (hidden, toggled) -->
    <?php if ($total_karya > 3): ?>
    <div id="all-karya-list" style="display:none; margin-top:14px; display:flex; flex-direction:column; gap:10px;">
      <?php foreach (array_slice($karyas, 3) as $idx => $k):
        $ri = $idx + 3;
        $voted   = (bool)$k['sudah_vote'];
        $is_mine = ((int)$k['member_id'] === $uid);
      ?>
      <div style="background:var(--c-card);border:1px solid var(--c-border);border-radius:12px;padding:14px 16px;
                  display:flex;align-items:center;gap:12px;">
        <div style="font-size:0.82rem;font-weight:800;color:var(--c-text-muted);min-width:28px;text-align:center;">#<?= $ri+1 ?></div>
        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#8b2fc9);
                    color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.9rem;flex-shrink:0;">
          <?= strtoupper(substr($k['full_name'],0,1)) ?>
        </div>
        <div style="flex:1;min-width:0;">
          <div style="font-weight:800;font-size:0.86rem;color:var(--c-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            <?= htmlspecialchars($k['judul']) ?>
          </div>
          <div style="font-size:0.72rem;color:var(--c-text-muted);">
            <?= htmlspecialchars($k['full_name']) ?> &bull; <?= htmlspecialchars($k['jenis']) ?>
          </div>
        </div>
        <button onclick="voteKarya(<?= (int)$k['id'] ?>, this)"
          id="vote-btn-<?= (int)$k['id'] ?>"
          <?= ($is_mine || $voted) ? 'disabled' : '' ?>
          style="flex-shrink:0;display:flex;align-items:center;gap:5px;padding:6px 12px;border-radius:8px;
                 font-size:0.75rem;font-weight:800;cursor:<?= ($is_mine||$voted) ? 'default' : 'pointer' ?>;
                 border:1.5px solid <?= $voted ? '#10b981' : 'var(--c-border)' ?>;
                 background:<?= $voted ? 'rgba(16,185,129,0.07)' : 'transparent' ?>;
                 color:<?= $voted ? '#10b981' : 'var(--c-text-muted)' ?>;transition:.2s;font-family:inherit;"
          <?= (!$is_mine&&!$voted) ? 'onmouseover="this.style.borderColor=\'#ef4444\';this.style.color=\'#ef4444\'"
               onmouseout="this.style.borderColor=\'var(--c-border)\';this.style.color=\'var(--c-text-muted)\'"' : '' ?>>
          <svg width="12" height="12" viewBox="0 0 24 24" fill="<?= $voted ? '#10b981':'none' ?>"
               stroke="<?= $voted ? '#10b981':'currentColor' ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <span id="vote-count-<?= (int)$k['id'] ?>"><?= (int)$k['vote_count'] ?></span>
        </button>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php endif; // end empty check ?>
  </div>

  <!-- ══════ CTA + FORM ══════ -->
  <div style="border-radius:20px;overflow:hidden;border:1px solid var(--c-border);margin-top:8px;">

    <!-- CTA Row (always visible) -->
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;
                padding:22px 28px;background:var(--c-card);"
         id="cta-kirim-row">
      <div style="display:flex;align-items:center;gap:16px;">
        <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#4f46e5,#7c3aed);
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
          </svg>
        </div>
        <div>
          <div style="font-size:1rem;font-weight:800;color:var(--c-text);margin-bottom:3px;">
            Punya karya inovatif? Bagikan sekarang!
          </div>
          <div style="font-size:0.82rem;color:var(--c-text-muted);">
            Dapatkan <strong style="color:#4f46e5;">+100 XP</strong> setiap karya yang berhasil terkirim.
          </div>
        </div>
      </div>
      <button id="btn-toggle-form" onclick="toggleFormKarya()"
        style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;
               background:#4f46e5;border:none;border-radius:10px;font-size:0.875rem;font-weight:800;
               color:#fff;cursor:pointer;font-family:inherit;transition:.2s;white-space:nowrap;
               box-shadow:0 4px 14px rgba(79,70,229,0.35);"
        onmouseover="this.style.background='#4338ca';this.style.transform='translateY(-1px)'"
        onmouseout="this.style.background='#4f46e5';this.style.transform='translateY(0)'">
        <svg id="btn-toggle-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition:transform .3s;">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span id="btn-toggle-text">Kirim Karya Baru</span>
      </button>
    </div>

    <!-- Form Panel (hidden by default, slides in) -->
    <div id="form-panel" style="display:none; border-top:1px solid var(--c-border); background:var(--c-bg,#f8fafc);">
      <div style="padding:28px; max-width:680px; margin:0 auto;">

        <h4 style="margin:0 0 20px; font-size:1rem; font-weight:800; color:var(--c-text);
                   display:flex; align-items:center; gap:8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
          </svg>
          Form Pengiriman Karya
          <span style="font-size:0.72rem;font-weight:600;color:var(--c-text-muted);margin-left:4px;">
            — field bertanda <span style="color:#ef4444;">*</span> wajib diisi
          </span>
        </h4>

        <form id="form-karya" onsubmit="submitKarya(event)">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

            <!-- Judul -->
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.77rem;font-weight:700;color:var(--c-text-muted);
                            margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                Judul Karya <span style="color:#ef4444;">*</span>
              </label>
              <input type="text" id="karya-judul" required
                placeholder="Contoh: Modul Ajar Berdiferensiasi IPA Kelas 7"
                style="width:100%;padding:10px 14px;background:var(--c-bg);border:1.5px solid var(--c-border);
                       border-radius:9px;font-size:0.875rem;font-family:inherit;color:var(--c-text);
                       box-sizing:border-box;transition:border-color .2s,box-shadow .2s;outline:none;"
                onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                onblur="this.style.borderColor='var(--c-border)';this.style.boxShadow='none'">
            </div>

            <!-- Kategori -->
            <div>
              <label style="display:block;font-size:0.77rem;font-weight:700;color:var(--c-text-muted);
                            margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                Kategori <span style="color:#ef4444;">*</span>
              </label>
              <div style="position:relative;" id="custom-select-wrapper">
                <div id="custom-select-trigger" onclick="toggleCustomSelect()"
                  style="width:100%;padding:10px 34px 10px 14px;background:var(--c-bg);border:1.5px solid var(--c-border);
                         border-radius:9px;font-size:0.875rem;font-family:inherit;color:var(--c-text);
                         cursor:pointer;box-sizing:border-box;display:flex;align-items:center;justify-content:space-between;
                         transition:border-color .2s,box-shadow .2s; user-select:none;">
                  <span id="custom-select-text" style="color:var(--c-text-muted);">-- Pilih --</span>
                  <svg id="custom-select-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition:transform .2s;"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div id="custom-select-options"
                  style="display:none; position:absolute; top:calc(100% + 8px); left:0; right:0;
                         background:var(--c-card); border:1px solid var(--c-border); border-radius:12px;
                         box-shadow:0 10px 25px rgba(0,0,0,0.1); z-index:100; overflow:hidden; opacity:0;
                         transform:translateY(-10px); transition:opacity 0.2s, transform 0.2s;">
                  <div class="c-opt" onclick="selectOption('RPP / Modul Ajar', 'RPP / Modul Ajar')">RPP / Modul Ajar</div>
                  <div class="c-opt" onclick="selectOption('Instrumen Penilaian', 'Instrumen Penilaian')">Instrumen Penilaian</div>
                  <div class="c-opt" onclick="selectOption('Media Pembelajaran', 'Media Pembelajaran Interaktif')">Media Pembelajaran Interaktif</div>
                  <div class="c-opt" onclick="selectOption('Artikel/Jurnal', 'Artikel / Jurnal Praktik Baik')">Artikel / Jurnal Praktik Baik</div>
                  <div class="c-opt" onclick="selectOption('Lainnya', 'Lainnya')">Lainnya</div>
                </div>
                <!-- Hidden real select -->
                <select id="karya-jenis" required style="display:none;">
                  <option value="" disabled selected>-- Pilih --</option>
                  <option value="RPP / Modul Ajar">RPP / Modul Ajar</option>
                  <option value="Instrumen Penilaian">Instrumen Penilaian</option>
                  <option value="Media Pembelajaran">Media Pembelajaran Interaktif</option>
                  <option value="Artikel/Jurnal">Artikel / Jurnal Praktik Baik</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>
            </div>

            <!-- Link -->
            <div>
              <label style="display:block;font-size:0.77rem;font-weight:700;color:var(--c-text-muted);
                            margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                Link Google Drive
              </label>
              <input type="url" id="karya-link" placeholder="https://drive.google.com/..."
                style="width:100%;padding:10px 14px;background:var(--c-bg);border:1.5px solid var(--c-border);
                       border-radius:9px;font-size:0.875rem;font-family:inherit;color:var(--c-text);
                       box-sizing:border-box;transition:border-color .2s,box-shadow .2s;outline:none;"
                onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                onblur="this.style.borderColor='var(--c-border)';this.style.boxShadow='none'">
            </div>

            <!-- Upload -->
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.77rem;font-weight:700;color:var(--c-text-muted);
                            margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                Upload Dokumen <span style="font-weight:500;text-transform:none;">(PDF, DOCX, PPTX, ZIP — maks. 10MB)</span>
              </label>
              <input type="file" id="karya-file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip"
                style="width:100%;font-size:0.82rem;color:var(--c-text);background:var(--c-bg);
                       border:1.5px solid var(--c-border);border-radius:9px;padding:8px 12px;
                       box-sizing:border-box;cursor:pointer;">
            </div>

            <!-- Deskripsi -->
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.77rem;font-weight:700;color:var(--c-text-muted);
                            margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                Deskripsi <span style="color:#ef4444;">*</span>
              </label>
              <textarea id="karya-desk" required rows="4"
                placeholder="Ceritakan latar belakang karya ini, tujuan pembelajaran, atau panduan singkat cara menggunakannya..."
                style="width:100%;padding:10px 14px;background:var(--c-bg);border:1.5px solid var(--c-border);
                       border-radius:9px;font-size:0.875rem;font-family:inherit;color:var(--c-text);
                       resize:vertical;box-sizing:border-box;line-height:1.55;
                       transition:border-color .2s,box-shadow .2s;outline:none;"
                onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                onblur="this.style.borderColor='var(--c-border)';this.style.boxShadow='none'"></textarea>
            </div>

          </div>

          <!-- Action row -->
          <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;
                      padding-top:16px;border-top:1px solid var(--c-border);">
            <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;color:var(--c-text-muted);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Mendapat <strong style="color:#10b981;">+100 XP</strong> setelah terkirim
            </div>
            <div style="display:flex;gap:8px;">
              <button type="button"
                onclick="resetFormKarya()"
                style="padding:10px 18px;background:none;border:1.5px solid var(--c-border);border-radius:8px;
                       font-size:0.84rem;font-weight:700;color:var(--c-text-muted);cursor:pointer;font-family:inherit;transition:.2s;"
                onmouseover="this.style.background='var(--c-border)'"
                onmouseout="this.style.background='none'">Reset</button>
              <button type="submit" id="btn-submit-karya"
                style="padding:10px 28px;background:#4f46e5;border:none;border-radius:8px;font-size:0.875rem;
                       font-weight:800;color:#fff;cursor:pointer;font-family:inherit;
                       display:inline-flex;align-items:center;gap:8px;transition:.2s;
                       box-shadow:0 4px 14px rgba(79,70,229,0.35);"
                onmouseover="this.style.background='#4338ca';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.background='#4f46e5';this.style.transform='translateY(0)'">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
                Kirim Karya
              </button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /form-panel -->

  </div><!-- /cta+form wrapper -->

</div><!-- /page -->

<script>
/* ── Toggle form karya ── */
let kkFormOpen = false;
function toggleFormKarya() {
    kkFormOpen = !kkFormOpen;
    const panel  = document.getElementById('form-panel');
    const icon   = document.getElementById('btn-toggle-icon');
    const txt    = document.getElementById('btn-toggle-text');
    const btn    = document.getElementById('btn-toggle-form');

    if (kkFormOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(45deg)';
        txt.textContent = 'Tutup Form';
        btn.style.background = '#64748b';
        btn.onmouseover = () => { btn.style.background='#475569'; btn.style.transform='translateY(-1px)'; };
        btn.onmouseout  = () => { btn.style.background='#64748b'; btn.style.transform='translateY(0)'; };
        // Smooth scroll to form
        setTimeout(() => panel.scrollIntoView({ behavior:'smooth', block:'start' }), 50);
    } else {
        panel.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
        txt.textContent = 'Kirim Karya Baru';
        btn.style.background = '#4f46e5';
        btn.onmouseover = () => { btn.style.background='#4338ca'; btn.style.transform='translateY(-1px)'; };
        btn.onmouseout  = () => { btn.style.background='#4f46e5'; btn.style.transform='translateY(0)'; };
    }
}

function resetFormKarya() {
    document.getElementById('form-karya').reset();
    const st = document.getElementById('custom-select-text');
    if(st) { st.textContent = '-- Pilih --'; st.style.color = 'var(--c-text-muted)'; }
}

/* ── Custom Select Kategori ── */
let cSelectOpen = false;
function toggleCustomSelect() {
    cSelectOpen = !cSelectOpen;
    const opts = document.getElementById('custom-select-options');
    const trig = document.getElementById('custom-select-trigger');
    const icon = document.getElementById('custom-select-icon');
    if (cSelectOpen) {
        opts.style.display = 'block';
        // force reflow
        void opts.offsetWidth;
        opts.style.opacity = '1';
        opts.style.transform = 'translateY(0)';
        trig.style.borderColor = '#4f46e5';
        trig.style.boxShadow = '0 0 0 3px rgba(79,70,229,0.1)';
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
// Close on outside click
document.addEventListener('click', (e) => {
    const wrap = document.getElementById('custom-select-wrapper');
    if (wrap && !wrap.contains(e.target) && cSelectOpen) {
        closeCustomSelect();
    }
});

/* ── Toggle semua karya ── */
let kkAllOpen = false;
function toggleAllKarya() {
    kkAllOpen = !kkAllOpen;
    const list = document.getElementById('all-karya-list');
    if (!list) return;
    list.style.display = kkAllOpen ? 'flex' : 'none';
    event.target.textContent = kkAllOpen
        ? '← Sembunyikan'
        : 'Lihat semua <?= $total_karya ?> karya →';
}

/* ── Submit karya ── */
async function submitKarya(e) {
    e.preventDefault();
    const judul = document.getElementById('karya-judul').value.trim();
    const jenis = document.getElementById('karya-jenis').value;
    const desk  = document.getElementById('karya-desk').value.trim();
    if (!judul || !jenis || !desk) { alert('Mohon lengkapi semua field wajib (*).'); return; }

    const btn = document.getElementById('btn-submit-karya');
    const old = btn.innerHTML;
    btn.innerHTML = '<svg style="animation:kk-spin 1s linear infinite" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Mengirim...';
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

/* ── Vote karya ── */
async function voteKarya(id, btn) {
    if (btn.disabled) return;
    btn.disabled = true; btn.style.opacity = '0.6';
    const fd = new FormData(); fd.append('karya_id', id);
    try {
        const res  = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_kompetisi.php?action=vote_karya', { method:'POST', body:fd });
        const data = await res.json();
        if (data.status === 'success') {
            // Update vote count
            const ce = document.getElementById('vote-count-' + id);
            if (ce) {
                const cur = parseInt(ce.textContent) || 0;
                ce.textContent = cur + 1;
                ce.style.color = '#10b981';
            }
            btn.style.borderColor = '#10b981'; btn.style.background = 'rgba(16,185,129,0.07)';
            btn.style.color = '#10b981'; btn.style.opacity = '1'; btn.style.cursor = 'not-allowed';
            btn.querySelector('svg').setAttribute('fill','#10b981'); btn.querySelector('svg').setAttribute('stroke','#10b981');
            btn.onmouseover = null; btn.onmouseout = null;
            // Update KPI card button if exists
            const kpiBtn = document.getElementById('vote-btn-' + id);
            if (kpiBtn && kpiBtn !== btn) {
                kpiBtn.style.borderColor='#10b981'; kpiBtn.style.color='#10b981';
                kpiBtn.style.background='rgba(16,185,129,0.08)'; kpiBtn.disabled=true;
                const kpiSpan = document.getElementById('vote-count-' + id);
                if(kpiSpan) kpiSpan.textContent = (parseInt(kpiSpan.textContent)||0)+1;
            }
        } else {
            alert(data.message || 'Gagal memberikan vote.'); btn.disabled = false; btn.style.opacity = '1';
        }
    } catch (err) { alert('Kesalahan jaringan.'); btn.disabled = false; btn.style.opacity = '1'; }
}
</script>

<style>
@keyframes kk-spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
@keyframes kk-spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
@media (max-width: 860px) {
  #page-kirim-karya .kk-top3 { grid-template-columns: 1fr !important; }
}
.c-opt {
  padding: 12px 16px;
  font-size: 0.875rem;
  color: var(--c-text);
  cursor: pointer;
  transition: background 0.15s, color 0.15s;
}
.c-opt:hover {
  background: rgba(79, 70, 229, 0.08);
  color: #4f46e5;
  font-weight: 700;
}
</style>
