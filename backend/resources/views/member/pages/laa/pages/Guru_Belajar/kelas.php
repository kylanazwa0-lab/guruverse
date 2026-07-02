<?php
// ── Query Kelas (hanya dimuat dari halaman ini) ───────────────────────────
$enrollments = [];
$stmt_enroll = $conn->prepare("SELECT e.id, e.course_id, e.status, e.enrolled_at, e.progress_percent, e.completed_modules, e.current_module,
        c.title, c.category, c.duration_hours, c.total_modules, c.mentor_name, c.rating, c.total_reviews, c.is_free,
        cert.pdf_path
    FROM gb_enrollments e
    JOIN gb_courses c ON e.course_id = c.id
    LEFT JOIN gb_certificates cert ON cert.course_id = e.course_id AND cert.user_id = e.user_id
    WHERE e.user_id = ?
    ORDER BY e.enrolled_at DESC");
$stmt_enroll->bind_param("i", $user_id);
$stmt_enroll->execute();
$res_enroll = $stmt_enroll->get_result();
if ($res_enroll) {
    while ($row = $res_enroll->fetch_assoc()) $enrollments[] = $row;
}
$stmt_enroll->close();

// Kursus tersedia: LEFT JOIN lebih efisien dari NOT IN subquery
$available_courses = [];
$stmt_avail = $conn->prepare("SELECT c.id, c.title, c.category, c.duration_hours, c.total_modules, c.is_free, c.rating FROM gb_courses c
    LEFT JOIN gb_enrollments e ON e.course_id = c.id AND e.user_id = ?
    WHERE c.status = 'active' AND e.id IS NULL
    LIMIT 6");
$stmt_avail->bind_param("i", $user_id);
$stmt_avail->execute();
$res_avail = $stmt_avail->get_result();
if ($res_avail) {
    while ($row = $res_avail->fetch_assoc()) $available_courses[] = $row;
}
$stmt_avail->close();
?>
<div class="page" id="page-kelas">
  <style>
    /* ── Dropdown Sort (vanilla, SPA-safe) ──────── */
    .ks-dropdown {
      position: relative;
      display: inline-block;
    }
    .ks-dropdown-btn {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 0 14px;
      height: 36px;
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.08);
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      color: #64748b;
      cursor: pointer;
      transition: all 0.2s ease;
      outline: none;
      white-space: nowrap;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .ks-dropdown-btn:hover,
    .ks-dropdown-btn[aria-expanded="true"] {
      border-color: var(--c-primary, #6c5ce7);
      background: #1e1b4b;
      color: #ffffff;
    }
    .ks-chevron {
      transition: transform 0.2s ease;
      flex-shrink: 0;
      color: var(--c-text-muted, #a8a8b3);
    }
    .ks-dropdown-btn[aria-expanded="true"] .ks-chevron {
      transform: rotate(180deg);
    }
    .ks-dropdown-menu {
      display: none;
      position: absolute;
      top: calc(100% + 6px);
      right: 0;
      min-width: 190px;
      background: #1a1740;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 14px;
      padding: 6px;
      list-style: none;
      margin: 0;
      z-index: 9999;
      box-shadow: 0 16px 48px rgba(0,0,0,0.45), 0 0 0 1px rgba(108,92,231,0.15);
      animation: ksDropIn 0.18s ease;
    }
    .ks-dropdown-menu.open { display: block; }
    @keyframes ksDropIn {
      from { opacity:0; transform:translateY(-6px) scale(0.97); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }
    .ks-dropdown-item {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 9px 12px;
      border-radius: 9px;
      font-size: 13px;
      font-weight: 500;
      color: rgba(255,255,255,0.75);
      cursor: pointer;
      transition: background 0.15s, color 0.15s;
    }
    .ks-dropdown-item:hover { background:rgba(108,92,231,0.15); color:#fff; }
    .ks-dropdown-item.active { background:rgba(108,92,231,0.2); color:#c4b5fd; font-weight:700; }
    .ks-dropdown-divider { height:1px; background:rgba(255,255,255,0.07); margin:4px 8px; }

    /* ── Existing styles ────────────────────────── */
    .kelas-stats-row {
      display: flex;
      gap: 12px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    .kelas-stat-badge {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 100px;
      font-size: 12px;
      font-weight: 600;
      color: #fff;
    }
    .kelas-stat-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
    .empty-state-card {
      text-align: center;
      padding: 80px 40px;
      background: var(--c-bg-card);
      border: 2px dashed var(--c-border);
      border-radius: 24px;
      margin-top: 20px;
      transition: all 0.3s ease;
    }
    .empty-state-card:hover {
      border-color: var(--c-primary);
      background: rgba(108,92,231,0.03);
    }
    .empty-state-icon-wrap {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg,rgba(108,92,231,0.1),rgba(129,236,236,0.1));
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 24px;
      color: var(--c-primary);
    }
    .kelas-tabs-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      border-bottom: 1px solid var(--c-border);
      flex-wrap: wrap;
      gap: 8px;
    }
    .kelas-tab-item {
      padding: 12px 20px;
      font-weight: 600;
      font-size: 14px;
      color: var(--c-text-muted);
      cursor: pointer;
      position: relative;
      transition: color 0.2s;
      white-space: nowrap;
      user-select: none;
    }
    .kelas-tab-item:hover { color: var(--c-primary); }
    .kelas-tab-item.active { color: var(--c-primary); }
    .kelas-tab-item.active::after {
      content: '';
      position: absolute;
      bottom: -1px; left: 0; right: 0;
      height: 2px;
      background: var(--c-primary);
      box-shadow: 0 -2px 10px var(--c-primary);
      border-radius: 2px 2px 0 0;
    }
    .kelas-tab-count {
      margin-left: 6px;
      font-size: 11px;
      background: var(--c-border);
      color: var(--c-text-muted);
      padding: 2px 6px;
      border-radius: 6px;
    }
    .kelas-tab-item.active .kelas-tab-count {
      background: var(--c-primary);
      color: #fff;
    }
  </style>

  <!-- ── Hero Section ─────────────────────────── -->
  <div class="hero-section mb-16" style="padding:14px 24px;min-height:auto">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:15%;left:10%;--d:3s;--delay:0s"></span>
      <span style="top:40%;left:60%;--d:3.5s;--delay:1s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge">
        <span class="hero-badge-dot" style="background:#10b981"></span> Aktif Belajar
      </div>
      <h1 style="font-size:22px">Kelas Saya</h1>
      <p style="font-size:13px">Kelola dan lanjutkan semua kelas yang sedang kamu pelajari.</p>
      <div class="kelas-stats-row">
        <div class="kelas-stat-badge"><span class="kelas-stat-dot" style="background:#60a5fa"></span><span><?= $total_kelas ?> Total</span></div>
        <div class="kelas-stat-badge"><span class="kelas-stat-dot" style="background:#fbbf24"></span><span><?= $total_kelas - $kelas_selesai ?> Berjalan</span></div>
        <div class="kelas-stat-badge"><span class="kelas-stat-dot" style="background:#10b981"></span><span><?= $kelas_selesai ?> Selesai</span></div>
      </div>
    </div>
  </div>

  <!-- ── Tabs + Dropdown ───────────────────────── -->
  <div class="kelas-tabs-container">
    <div style="display:flex">
      <div class="kelas-tab-item active" data-tab="dipelajari">
        Semua <span class="kelas-tab-count"><?= $total_kelas - $kelas_selesai ?></span>
      </div>
      <div class="kelas-tab-item" data-tab="selesai">
        Selesai <span class="kelas-tab-count"><?= $kelas_selesai ?></span>
      </div>

    </div>

    <div style="display:flex;gap:10px;align-items:center;padding-bottom:12px">
      <div class="ks-dropdown" id="ks-sort-wrap">
        <button class="ks-dropdown-btn" id="ks-sort-btn" type="button" aria-haspopup="true" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m3 16 4 4 4-4"/><path d="M7 20V4"/><path d="M11 8h4"/><path d="M11 12h7"/><path d="M11 4h10"/>
          </svg>
          <span id="ks-sort-label">Terbaru</span>
          <svg class="ks-chevron" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"/>
          </svg>
        </button>
        <ul class="ks-dropdown-menu" id="ks-sort-menu" role="menu">
          <li class="ks-dropdown-item active" data-value="terbaru" role="menuitem">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m3 16 4 4 4-4"/><path d="M7 20V4"/><path d="M11 8h4"/><path d="M11 12h7"/><path d="M11 4h10"/>
            </svg>
            Terbaru
          </li>
          <li class="ks-dropdown-item" data-value="az" role="menuitem">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m3 8 4-4 4 4"/><path d="M7 4v16"/><path d="M11 12h4"/><path d="M11 16h7"/><path d="M11 20h10"/>
            </svg>
            Nama A–Z
          </li>
          <li class="ks-dropdown-divider" role="separator"></li>
          <li class="ks-dropdown-item" data-value="progress" role="menuitem">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/>
            </svg>
            Progress Belajar
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- ── Kelas Grid ────────────────────────────── -->
  <div class="kelas-grid">
    <!-- Empty state dinamis (ditampilkan via JS saat tab tidak punya konten) -->
    <div id="kelas-empty-state" style="display:none;grid-column:1/-1;text-align:center;padding:80px 40px;background:var(--c-bg-card);border:2px dashed var(--c-border);border-radius:24px;margin-top:4px;">
      <div class="empty-state-icon-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
        </svg>
      </div>
      <h2 class="t-h2" style="margin-bottom:12px" id="kelas-empty-title">Belum ada kelas selesai</h2>
      <p class="t-body t-muted" style="max-width:400px;margin:0 auto 32px" id="kelas-empty-desc">
        Selesaikan kelas yang sedang kamu ikuti untuk melihatnya di sini dan mendapatkan sertifikat.
      </p>
      <button class="btn btn-outline" onclick="document.querySelector('[data-tab=\'dipelajari\']').click()">
        ← Kembali ke Kelas Aktif
      </button>
    </div>

    <?php if (empty($enrollments)): ?>
      <div class="empty-state-card" style="grid-column:1/-1">
        <div class="empty-state-icon-wrap">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
          </svg>
        </div>
        <h2 class="t-h2" style="margin-bottom:12px">Kelas akan segera hadir</h2>
        <p class="t-body t-muted" style="max-width:460px;margin:0 auto 32px">
          Konten kelas sedang disiapkan dan akan segera diunggah. Nantikan pembaruan materi menarik dari para mentor ahli kami!
        </p>
        <button class="btn btn-primary" onclick="showPage('dashboard')">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
               style="margin-right:8px">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          Jelajahi Kelas Lain
        </button>
      </div>
    <?php else: ?>
      <?php foreach ($enrollments as $en): 
        $pct = $en['total_modules'] > 0 ? round(($en['completed_modules'] / $en['total_modules']) * 100) : 0;
        $is_completed = ($en['status'] === 'completed' || $pct >= 100);
        // Kelas selesai: sembunyikan dari default view, hanya tampil di tab 'Selesai'
        $card_display = $is_completed ? 'none' : 'flex';
      ?>
      <div class="card p-0 overflow-hidden" style="display:<?= $card_display ?>;flex-direction:column;" data-status="<?= htmlspecialchars($en['status']) ?>" data-completed="<?= $is_completed ? '1' : '0' ?>">
        <div style="height:140px;background:<?= $is_completed ? 'linear-gradient(135deg,#10b981,#059669)' : 'linear-gradient(135deg,var(--c-primary-light),var(--c-primary))' ?>;position:relative;">
          <div style="position:absolute;top:12px;right:12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(4px);color:#fff;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;">
            <?= htmlspecialchars($en['category']) ?>
          </div>
          <?php if ($is_completed): ?>
          <div style="position:absolute;bottom:12px;left:12px;background:rgba(16,185,129,0.9);backdrop-filter:blur(4px);color:#fff;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;display:flex;align-items:center;gap:5px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Selesai
          </div>
          <?php endif; ?>
        </div>
        <div style="padding:16px;flex:1;display:flex;flex-direction:column;">
          <h3 style="font-size:15px;font-weight:800;margin-bottom:8px;line-height:1.4"><?= htmlspecialchars($en['title']) ?></h3>
          <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:16px;display:flex;gap:12px;">
            <span style="display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> <?= $en['duration_hours'] ?> Jam</span>
            <span style="display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> <?= $en['total_modules'] ?> Modul</span>
          </div>
          <div style="margin-top:auto;">
            <div style="display:flex;justify-content:space-between;font-size:11px;font-weight:700;margin-bottom:6px;color:var(--c-text-muted)">
              <span>Progress</span>
              <span style="color:<?= $is_completed ? '#10b981' : 'var(--c-primary)' ?>"><?= $pct ?>%</span>
            </div>
            <div style="height:6px;background:var(--c-border);border-radius:99px;overflow:hidden;margin-bottom:16px;">
              <div style="width:<?= $pct ?>%;height:100%;background:<?= $is_completed ? '#10b981' : 'var(--c-primary)' ?>;border-radius:99px;"></div>
            </div>
            <?php if ($is_completed): ?>
              <?php if (!empty($en['pdf_path'])): ?>
                <button class="btn btn-sm" style="width:100%;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;" onclick="viewCertificate('<?= htmlspecialchars($en['pdf_path']) ?>')">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                  Lihat Sertifikat
                </button>
              <?php else: ?>
                <button class="btn btn-sm" style="width:100%;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;opacity:0.7;cursor:not-allowed" disabled>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                  Sertifikat Diproses
                </button>
              <?php endif; ?>
            <?php else: ?>
            <button class="btn btn-outline btn-sm" style="width:100%" onclick="openCoursePlayer(<?= $en['course_id'] ?>)">Lanjutkan Belajar</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div><!-- /page-kelas -->

<script>
(function () {
  'use strict';

  /* ── Dropdown Sort ─────────────────────────── */
  function initKelasDropdown() {
    var wrap  = document.getElementById('ks-sort-wrap');
    var btn   = document.getElementById('ks-sort-btn');
    var menu  = document.getElementById('ks-sort-menu');
    var label = document.getElementById('ks-sort-label');
    if (!btn || !menu || !wrap) return;

    function openMenu() {
      menu.classList.add('open');
      btn.setAttribute('aria-expanded', 'true');
    }
    function closeMenu() {
      menu.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    }

    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      menu.classList.contains('open') ? closeMenu() : openMenu();
    });

    menu.querySelectorAll('.ks-dropdown-item').forEach(function (item) {
      item.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.querySelectorAll('.ks-dropdown-item').forEach(function (i) { i.classList.remove('active'); });
        item.classList.add('active');
        label.textContent = item.textContent.trim();
        closeMenu();
        // Dispatch custom event — hook into this for actual sort logic
        document.dispatchEvent(new CustomEvent('kelas:sort', { detail: { sort: item.getAttribute('data-value') } }));
      });
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!wrap.contains(e.target)) closeMenu();
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMenu();
    });
  }

  /* ── Tab Switching ─────────────────────────── */
  function initKelasTabs() {
    var tabs = document.querySelectorAll('#page-kelas .kelas-tab-item');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        document.dispatchEvent(new CustomEvent('kelas:tab', { detail: { tab: tab.getAttribute('data-tab') } }));
      });
    });
  }

  /* ── Init (SPA-safe: works even if DOMContentLoaded already fired) ── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initKelasDropdown();
      initKelasTabs();
    });
  } else {
    initKelasDropdown();
    initKelasTabs();
  }

  /* ── Listen for custom events to filter cards ── */
  document.addEventListener('kelas:tab', function(e) {
    var tab = e.detail.tab;
    var cards = document.querySelectorAll('#page-kelas .kelas-grid .card');
    var emptyEl = document.getElementById('kelas-empty-state');
    var visibleCount = 0;

    cards.forEach(function(card) {
      var completed = card.getAttribute('data-completed') === '1';
      var show = false;

      if (tab === 'dipelajari') {
        // Tab default: hanya tampil kelas yang BELUM selesai
        show = !completed;
      } else if (tab === 'selesai') {
        // Tab selesai: hanya tampil kelas yang sudah selesai
        show = completed;
      }

      card.style.display = show ? 'flex' : 'none';
      if (show) visibleCount++;
    });

    // Tampilkan empty state jika tidak ada card yang visible
    if (emptyEl) {
      emptyEl.style.display = visibleCount === 0 ? 'block' : 'none';
    }
  });

  /* ── Sort listener ─────────────────────────── */
  document.addEventListener('kelas:sort', function(e) {
    var sortVal = e.detail.sort; // 'terbaru' | 'az' | 'progress'
    var grid = document.querySelector('#page-kelas .kelas-grid');
    if (!grid) return;
    var cards = Array.from(grid.querySelectorAll('.card'));

    cards.sort(function(a, b) {
      if (sortVal === 'az') {
        var ta = (a.querySelector('.kelas-card-title') || a).textContent.trim().toLowerCase();
        var tb = (b.querySelector('.kelas-card-title') || b).textContent.trim().toLowerCase();
        return ta.localeCompare(tb);
      } else if (sortVal === 'progress') {
        var pa = parseFloat(a.getAttribute('data-progress') || 0);
        var pb = parseFloat(b.getAttribute('data-progress') || 0);
        return pb - pa; // descending: highest progress first
      } else { // terbaru (default)
        var da = a.getAttribute('data-enrolled') || '0';
        var db = b.getAttribute('data-enrolled') || '0';
        return db.localeCompare(da);
      }
    });

    cards.forEach(function(c) { grid.appendChild(c); });
  });
})();
</script>