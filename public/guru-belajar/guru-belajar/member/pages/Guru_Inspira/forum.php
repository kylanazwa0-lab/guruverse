<?php /* Forum Diskusi — Guru Inspira */ ?>
<style>
/* ── Forum-page scoped styles ── */
#page-forum .forum-hero {
  background: linear-gradient(135deg, #1e1b4b 0%, #4c1d95 45%, #6C5CE7 100%);
  border-radius: 20px;
  padding: 0;
  overflow: hidden;
  display: flex;
  align-items: stretch;
  min-height: 220px;
  position: relative;
}
#page-forum .forum-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 80% at 70% 50%, rgba(108,92,231,0.25) 0%, transparent 70%),
    radial-gradient(circle at 15% 80%, rgba(255,255,255,0.05) 0%, transparent 40%);
  pointer-events: none;
}
#page-forum .forum-hero-dots {
  position: absolute;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
}
#page-forum .forum-hero-dots span {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,0.07);
}
#page-forum .forum-hero-left {
  flex: 1;
  padding: 40px 48px;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
#page-forum .forum-hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.2);
  backdrop-filter: blur(8px);
  border-radius: 100px;
  padding: 5px 12px;
  font-size: 11px;
  font-weight: 700;
  color: rgba(255,255,255,0.9);
  letter-spacing: 0.5px;
  text-transform: uppercase;
  margin-bottom: 16px;
  width: fit-content;
}
#page-forum .forum-hero-badge::before {
  content: '';
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #a3e635;
  box-shadow: 0 0 8px #a3e635;
  flex-shrink: 0;
}
#page-forum .forum-hero h1 {
  font-size: 30px;
  font-weight: 800;
  color: #fff;
  line-height: 1.25;
  margin-bottom: 12px;
  letter-spacing: -0.5px;
}
#page-forum .forum-hero p {
  color: rgba(255,255,255,0.75);
  font-size: 13.5px;
  line-height: 1.65;
  max-width: 480px;
  margin-bottom: 28px;
}
#page-forum .forum-hero-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #fff;
  color: #4c1d95;
  border: none;
  border-radius: 12px;
  padding: 12px 22px;
  font-size: 13px;
  font-weight: 800;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
  width: fit-content;
}
#page-forum .forum-hero-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.35);
}
#page-forum .forum-hero-right {
  width: 380px;
  flex-shrink: 0;
  position: relative;
  display: flex;
  align-items: flex-end;
  justify-content: center;
  overflow: hidden;
}
#page-forum .forum-hero-right img {
  width: 110%;
  height: auto;
  object-fit: contain;
  margin-bottom: -10px;
}
#page-forum .forum-hero-stats {
  position: absolute;
  top: 50%;
  right: 32px;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  gap: 8px;
}
#page-forum .forum-stat-chip {
  background: rgba(255,255,255,0.12);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.18);
  border-radius: 12px;
  padding: 8px 14px;
  text-align: center;
  min-width: 80px;
}
#page-forum .forum-stat-chip .num {
  font-size: 18px;
  font-weight: 800;
  color: #fff;
  line-height: 1;
  margin-bottom: 2px;
}
#page-forum .forum-stat-chip .lbl {
  font-size: 10px;
  color: rgba(255,255,255,0.65);
  font-weight: 600;
  letter-spacing: 0.3px;
}

/* ── Kategori chips ── */
#page-forum .cat-scroll {
  display: flex;
  gap: 12px;
  overflow-x: auto;
  padding-bottom: 8px;
  scrollbar-width: none;
}
#page-forum .cat-scroll::-webkit-scrollbar { display: none; }
#page-forum .cat-card {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 18px;
  border-radius: 14px;
  border: 1.5px solid var(--c-border);
  background: var(--c-card);
  cursor: pointer;
  min-width: 200px;
  flex-shrink: 0;
  transition: all 0.22s cubic-bezier(.4,0,.2,1);
  box-shadow: 0 2px 8px rgba(44,48,122,0.04);
}
#page-forum .cat-card:hover,
#page-forum .cat-card.active {
  border-color: var(--c-primary);
  box-shadow: 0 4px 20px rgba(108,92,231,0.14);
  transform: translateY(-2px);
}
#page-forum .cat-icon-box {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 22px;
}

/* ── Filter pills ── */
#page-forum .pill-wrap {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  align-items: center;
}
#page-forum .pill {
  padding: 7px 16px;
  border-radius: 100px;
  border: 1.5px solid var(--c-border);
  background: var(--c-card);
  color: var(--c-text-muted);
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.18s;
  letter-spacing: 0.2px;
}
#page-forum .pill:hover { background: var(--c-bg); color: var(--c-text); border-color: var(--c-primary-light); }
#page-forum .pill.active {
  background: var(--c-primary);
  border-color: var(--c-primary);
  color: #fff;
  box-shadow: 0 4px 12px rgba(108,92,231,0.3);
}

/* ── Thread cards ── */
#page-forum .thread-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
}
#page-forum .thread-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 16px;
  padding: 20px;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  transition: all 0.22s cubic-bezier(.4,0,.2,1);
  box-shadow: 0 2px 8px rgba(44,48,122,0.03);
  position: relative;
  overflow: hidden;
}
#page-forum .thread-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--c-primary), var(--c-primary-light));
  opacity: 0;
  transition: opacity 0.22s;
}
#page-forum .thread-card:hover {
  transform: translateY(-4px);
  border-color: var(--c-primary-light);
  box-shadow: 0 8px 28px rgba(108,92,231,0.13);
}
#page-forum .thread-card:hover::before { opacity: 1; }
#page-forum .thread-cat-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  border-radius: 100px;
  padding: 3px 10px;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 0.3px;
  margin-bottom: 12px;
  width: fit-content;
}
#page-forum .thread-title {
  font-size: 13.5px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.45;
  margin-bottom: 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 40px;
  flex-shrink: 0;
}
#page-forum .thread-snippet {
  font-size: 11.5px;
  color: var(--c-text-muted);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
  margin-bottom: 16px;
}
#page-forum .thread-author {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 12px;
}
#page-forum .thread-author-avatar {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--c-border);
  flex-shrink: 0;
}
#page-forum .thread-author-name {
  font-size: 11px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.2;
}
#page-forum .thread-author-sub {
  font-size: 10px;
  color: var(--c-text-muted);
}
#page-forum .thread-meta {
  display: flex;
  align-items: center;
  gap: 14px;
  padding-top: 12px;
  border-top: 1px solid var(--c-border-light);
  margin-top: auto;
}
#page-forum .thread-meta-item {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-weight: 700;
  color: var(--c-text-muted);
}
#page-forum .thread-meta-item i { font-size: 13px; }

/* ── Hot badge ── */
#page-forum .hot-badge {
  position: absolute;
  top: 14px;
  right: 14px;
  background: linear-gradient(135deg, #ef4444, #f97316);
  color: #fff;
  font-size: 9px;
  font-weight: 800;
  letter-spacing: 0.4px;
  padding: 3px 8px;
  border-radius: 100px;
}

/* ── Empty state ── */
#page-forum .empty-state {
  grid-column: 1/-1;
  text-align: center;
  padding: 64px 32px;
  background: var(--c-bg);
  border: 2px dashed var(--c-border);
  border-radius: 20px;
}

/* ── Skeleton loader ── */
#page-forum .skeleton {
  background: linear-gradient(90deg, var(--c-border) 25%, var(--c-border-light) 50%, var(--c-border) 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 8px;
}
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
</style>

<div class="page" id="page-forum" style="animation: fadeIn 0.3s ease-out;">

  <!-- ═══════════════════════════════════════════════════════
       HERO SECTION
  ═══════════════════════════════════════════════════════ -->
  <div class="forum-hero mb-32">
    <!-- Decorative dots -->
    <div class="forum-hero-dots" aria-hidden="true">
      <span style="width:180px;height:180px;top:-60px;right:320px;opacity:0.5;"></span>
      <span style="width:80px;height:80px;bottom:-20px;left:200px;opacity:0.4;"></span>
      <span style="width:50px;height:50px;top:30%;left:40%;opacity:0.3;"></span>
    </div>

    <!-- Left text -->
    <div class="forum-hero-left">
      <div class="forum-hero-badge">
        <i class="ti ti-messages" style="font-size:12px;"></i>
        Forum Komunitas
      </div>
      <h1>Forum Diskusi<br>Guru Nusantara</h1>
      <p>Tempat berbagi praktik baik, mencari solusi pembelajaran, berdiskusi tentang tantangan pendidikan, dan membangun kolaborasi bersama guru dari seluruh Indonesia.</p>
      <button class="forum-hero-cta" onclick="openNewThreadModal()">
        <i class="ti ti-plus" style="font-size:15px;"></i>
        Mulai Diskusi Baru
      </button>
    </div>

    <!-- Right illustration -->
    <div class="forum-hero-right">
      <img src="/guruverse/asset/img/community_teachers_muslim (2).png" alt="Guru Diskusi" onerror="this.style.display='none'">
    </div>

    <!-- Floating stat chips -->
    <div class="forum-hero-stats">
      <div class="forum-stat-chip">
        <div class="num" id="statThread">–</div>
        <div class="lbl">Topik</div>
      </div>
      <div class="forum-stat-chip">
        <div class="num" id="statCategory">–</div>
        <div class="lbl">Kategori</div>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       KATEGORI FORUM
  ═══════════════════════════════════════════════════════ -->
  <div class="mb-32">
    <div class="section-head mb-18">
      <h2 class="t-h2 t-primary">Kategori Forum</h2>
      <span class="link-action" onclick="setForumFilter('semua', document.querySelector('.pill.active'))">Lihat semua →</span>
    </div>
    <div class="cat-scroll" id="forumCategoryList">
      <?php for($i=0;$i<5;$i++): ?>
      <div style="min-width:200px; height:68px; border-radius:14px;" class="skeleton"></div>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       FILTER BAR
  ═══════════════════════════════════════════════════════ -->
  <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div class="pill-wrap">
      <button class="pill active" onclick="setForumFilter('semua', this)">
        <i class="ti ti-border-all" style="font-size:12px;"></i> Semua
      </button>
      <button class="pill" onclick="setForumFilter('terbaru', this)">
        <i class="ti ti-clock" style="font-size:12px;"></i> Terbaru
      </button>
      <button class="pill" onclick="setForumFilter('populer', this)">
        <i class="ti ti-trending-up" style="font-size:12px;"></i> Populer
      </button>
      <button class="pill" onclick="setForumFilter('belum', this)">
        <i class="ti ti-help-circle" style="font-size:12px;"></i> Belum Terjawab
      </button>
      <button class="pill" onclick="setForumFilter('inspiratif', this)">
        <i class="ti ti-star" style="font-size:12px;"></i> Inspiratif
      </button>
    </div>
    <div class="search-wrap" style="max-width:240px;">
      <span class="search-icon"><i class="ti ti-search"></i></span>
      <input type="text" class="search-input" placeholder="Cari topik diskusi..." oninput="filterThreadsBySearch(this.value)">
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       THREAD GRID
  ═══════════════════════════════════════════════════════ -->
  <div class="thread-grid mb-32" id="forumThreadListContainer">
    <?php for($i=0;$i<8;$i++): ?>
    <div class="thread-card" style="pointer-events:none;">
      <div class="skeleton" style="height:20px;width:60%;margin-bottom:14px;"></div>
      <div class="skeleton" style="height:14px;width:100%;margin-bottom:6px;"></div>
      <div class="skeleton" style="height:14px;width:80%;margin-bottom:20px;"></div>
      <div class="skeleton" style="height:14px;width:40%;margin-bottom:16px;"></div>
      <div style="border-top:1px solid var(--c-border-light);padding-top:12px;display:flex;gap:16px;">
        <div class="skeleton" style="height:12px;width:50px;"></div>
        <div class="skeleton" style="height:12px;width:50px;"></div>
      </div>
    </div>
    <?php endfor; ?>
  </div>

  <!-- Load More -->
  <div style="text-align:center; padding-bottom:40px;">
    <button class="btn btn-ghost" id="btnLoadMore" style="padding:12px 32px;" onclick="gbShowAlert('Info', 'Semua topik sudah ditampilkan.', 'info')">
      Muat Lebih Banyak <i class="ti ti-chevron-down"></i>
    </button>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MODAL BUAT DISKUSI
═══════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="modalNewThread" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.65); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(4px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:620px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Mulai Diskusi Baru</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Ajukan pertanyaan atau bagikan pengalaman Anda kepada komunitas guru.</p>
      </div>
      <button onclick="closeNewThreadModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; color:var(--c-text-muted); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background 0.2s; flex-shrink:0;">&times;</button>
    </div>

    <div class="form-group mb-18">
      <label class="form-label">Kategori</label>
      <select id="newThreadCategory" class="form-control"></select>
    </div>
    <div class="form-group mb-18">
      <label class="form-label">Judul Topik</label>
      <input type="text" id="newThreadTitle" class="form-control" placeholder="Tuliskan inti pertanyaan atau diskusi Anda...">
    </div>
    <div class="form-group mb-28">
      <label class="form-label">Isi Diskusi</label>
      <textarea id="newThreadContent" class="form-control" rows="5" placeholder="Ceritakan lebih detail: latar belakang, apa yang sudah dicoba, dll..."></textarea>
    </div>

    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-ghost" onclick="closeNewThreadModal()" style="padding:10px 20px;">Batal</button>
      <button class="btn btn-primary" onclick="submitNewThread()" style="padding:10px 24px;">
        <i class="ti ti-send"></i> Posting Diskusi
      </button>
    </div>
  </div>
</div>

<script>
/* ─── State ─── */
let forumDataCache = { categories: [], threads: [] };

/* ─── Boot — langsung panggil karena DOMContentLoaded sudah lewat ─── */
loadForumData();

/* ─── Load ─── */
function loadForumData() {
  fetch('api_forum.php?action=get_all')
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'success') {
        renderForumCategories();
        renderForumThreads([]);
        return;
      }
      forumDataCache = res.data;
      renderForumCategories();
      renderForumThreads(forumDataCache.threads);
      document.getElementById('statThread').textContent   = forumDataCache.threads.length || '0';
      document.getElementById('statCategory').textContent = forumDataCache.categories.length || '0';
      const sel = document.getElementById('newThreadCategory');
      sel.innerHTML = forumDataCache.categories.map(c =>
        `<option value="${c.id}">${c.judul}</option>`
      ).join('');
    })
    .catch(err => {
      console.error('Forum API error:', err);
      renderForumCategories();
      renderForumThreads([]);
    });
}

/* ─── Categories ─── */
function renderForumCategories() {
  const list = document.getElementById('forumCategoryList');
  if (!forumDataCache.categories || !forumDataCache.categories.length) {
    list.innerHTML = `
      <div style="display:flex;align-items:center;gap:12px;padding:20px 0;color:var(--c-text-muted);">
        <div style="width:44px;height:44px;border-radius:12px;background:var(--c-border-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="ti ti-folder-open" style="font-size:22px;opacity:0.45;"></i>
        </div>
        <div>
          <div style="font-size:13px;font-weight:700;color:var(--c-text);margin-bottom:3px;">Belum ada kategori forum</div>
          <div style="font-size:11px;">Kategori akan muncul setelah ditambahkan oleh admin.</div>
        </div>
      </div>`;
    return;
  }
  const palettes = [
    { bg:'#EEF0FF', color:'#6C5CE7' },
    { bg:'#FFF5F0', color:'#e17055' },
    { bg:'#E6F9F5', color:'#00b894' },
    { bg:'#FFF8E7', color:'#f39c12' },
    { bg:'#EBF4FF', color:'#4A90E2' },
    { bg:'#FFF0F6', color:'#e91e8c' },
  ];
  list.innerHTML = forumDataCache.categories.map((c, i) => {
    const pal   = palettes[i % palettes.length];
    const bg    = c.warna_bg   || pal.bg;
    const color = c.icon_color || pal.color;
    return `
    <div class="cat-card" onclick="filterByCategory(${c.id}, this)">
      <div class="cat-icon-box" style="background:${bg};">
        <i class="${c.icon || 'ti ti-messages'}" style="color:${color};"></i>
      </div>
      <div>
        <div style="font-size:13px;font-weight:800;color:var(--c-text);line-height:1.25;margin-bottom:3px;">${c.judul}</div>
        <div style="font-size:11px;color:var(--c-text-muted);font-weight:600;">${c.thread_count || 0} topik</div>
      </div>
    </div>`;
  }).join('');
}

/* ─── Threads ─── */
function renderForumThreads(threads) {
  const grid = document.getElementById('forumThreadListContainer');
  
  // Trigger animation refresh for visual feedback
  grid.style.animation = 'none';
  void grid.offsetWidth; // trigger reflow
  grid.style.animation = 'fadeIn 0.4s ease-out';

  if (!threads || !threads.length) {
    const activePill = document.querySelector('#page-forum .pill.active');
    const filterName = activePill ? activePill.innerText.trim() : 'Semua';
    
    grid.innerHTML = `
      <div style="grid-column:1/-1;text-align:center;padding:64px 32px;background:var(--c-bg);border:2px dashed var(--c-border);border-radius:20px;">
        <div style="font-size:52px;margin-bottom:16px;">💬</div>
        <div style="font-size:18px;font-weight:800;margin-bottom:10px;color:var(--c-text);">Belum Ada Diskusi</div>
        <p style="color:var(--c-text-muted);font-size:13px;line-height:1.7;max-width:380px;margin:0 auto 24px;">
          Tidak ada topik yang ditemukan untuk kategori atau filter "<strong>${filterName}</strong>". Jadilah yang pertama memulai diskusi — ajukan pertanyaan atau ceritakan inovasi Anda!
        </p>
        <button class="btn btn-primary" onclick="openNewThreadModal()">
          <i class="ti ti-plus"></i> Mulai Diskusi Pertama
        </button>
      </div>`;
    return;
  }

  // Color palette for cat badge
  const palettes = [
    { bg:'#EEF0FF', color:'#6C5CE7' },
    { bg:'#FFF5F0', color:'#e17055' },
    { bg:'#E6F9F5', color:'#00b894' },
    { bg:'#FFF8E7', color:'#f39c12' },
    { bg:'#EBF4FF', color:'#4A90E2' },
    { bg:'#FFF0F6', color:'#e91e8c' },
  ];

  grid.innerHTML = threads.map((t, i) => {
    const snippet  = (t.konten || '').length > 90 ? t.konten.substring(0, 90) + '...' : (t.konten || '');
    const isHot    = t.likes > 100;
    const catIdx   = (forumDataCache.categories.findIndex(c => c.id == t.forum_id)) % palettes.length;
    const pal      = catIdx >= 0 ? palettes[catIdx] : palettes[0];
    const badgeBg  = t.forum_bg    || pal.bg;
    const badgeCol = t.forum_color || pal.color;

    return `
    <div class="thread-card" onclick="openForumThread(${t.id})">
      ${isHot ? '<div class="hot-badge">🔥 Hot</div>' : ''}
      
      <div class="thread-cat-badge" style="background:${badgeBg}; color:${badgeCol};">
        <i class="${t.forum_icon || 'ti ti-messages'}" style="font-size:10px;"></i>
        ${t.forum_name || 'Forum'}
      </div>

      <div class="thread-title">${t.judul}</div>
      <div class="thread-snippet">${snippet}</div>

      <div class="thread-author">
        <img class="thread-author-avatar" src="/guruverse/asset/img/default_avatar.png" alt="${t.author_name}" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 40 40%22><circle cx=%2220%22 cy=%2220%22 r=%2220%22 fill=%22%23EEF0FF%22/><text x=%2250%%25%22 y=%2256%%25%22 text-anchor=%22middle%22 font-size=%2216%22 fill=%22%236C5CE7%22>${(t.author_name || 'G').charAt(0)}</text></svg>'">
        <div>
          <div class="thread-author-name">${t.author_name || 'Guru'}</div>
          <div class="thread-author-sub">${t.author_role || ''} · ${t.time_ago || ''}</div>
        </div>
      </div>

      <div class="thread-meta">
        <div class="thread-meta-item">
          <i class="ti ti-message-2" style="color:var(--c-primary);"></i>
          <span>${t.reply_count || 0} Balasan</span>
        </div>
        <div class="thread-meta-item">
          <i class="ti ti-eye" style="color:var(--c-blue);"></i>
          <span>${t.views || 0} Views</span>
        </div>
        ${t.likes > 0 ? `
        <div class="thread-meta-item" style="margin-left:auto;">
          <i class="ti ti-heart" style="color:#e17055;"></i>
          <span>${t.likes}</span>
        </div>` : ''}
      </div>
    </div>`;
  }).join('');
}

/* ─── Filters ─── */
function setForumFilter(filter, btn) {
  if (btn) {
    document.querySelectorAll('#page-forum .pill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }
  // reset cat active
  document.querySelectorAll('#page-forum .cat-card').forEach(c => c.classList.remove('active'));

  let filtered = [...forumDataCache.threads];
  if (filter === 'populer') filtered.sort((a, b) => b.likes - a.likes);
  else if (filter === 'terbaru') filtered.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
  else if (filter === 'belum') filtered = filtered.filter(t => t.reply_count == 0);
  else if (filter === 'inspiratif') filtered = filtered.filter(t => t.likes > 50);
  renderForumThreads(filtered);
}

function filterByCategory(categoryId, el) {
  document.querySelectorAll('#page-forum .pill').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('#page-forum .cat-card').forEach(c => c.classList.remove('active'));
  if (el) el.classList.add('active');
  renderForumThreads(forumDataCache.threads.filter(t => t.forum_id == categoryId));
}

function filterThreadsBySearch(query) {
  const q = query.toLowerCase().trim();
  document.querySelectorAll('#page-forum .cat-card').forEach(c => c.classList.remove('active'));
  if (!q) { renderForumThreads(forumDataCache.threads); return; }
  renderForumThreads(forumDataCache.threads.filter(t =>
    (t.judul || '').toLowerCase().includes(q) ||
    (t.konten || '').toLowerCase().includes(q) ||
    (t.author_name || '').toLowerCase().includes(q)
  ));
}

/* ─── Modal ─── */
function openNewThreadModal() {
  const m = document.getElementById('modalNewThread');
  m.style.display = 'flex';
  requestAnimationFrame(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  });
}
function closeNewThreadModal() {
  const m = document.getElementById('modalNewThread');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 320);
}

/* ─── Submit ─── */
function submitNewThread() {
  const forumId = document.getElementById('newThreadCategory').value;
  const judul   = document.getElementById('newThreadTitle').value.trim();
  const konten  = document.getElementById('newThreadContent').value.trim();
  if (!judul || !konten || !forumId) {
    gbShowAlert('Oops!', 'Kategori, judul, dan isi diskusi harus diisi.', 'error');
    return;
  }
  const fd = new FormData();
  fd.append('forum_id', forumId);
  fd.append('judul', judul);
  fd.append('konten', konten);
  fetch('api_forum.php?action=create_thread', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'success') {
        closeNewThreadModal();
        gbShowAlert('Berhasil!', 'Diskusi Anda berhasil dipublikasikan.', 'success');
        document.getElementById('newThreadTitle').value = '';
        document.getElementById('newThreadContent').value = '';
        loadForumData();
      } else {
        gbShowAlert('Gagal', res.message, 'error');
      }
    })
    .catch(err => console.error(err));
}

/* ─── Open thread detail ─── */
function openForumThread(id) {
  window.currentInspiraThreadId = id;
  if (typeof loadThreadDetail === 'function') loadThreadDetail(id);
  showPage('forum-thread');
}
</script>
