<?php 
/* Kolaborasi Proyek — Guru Inspira */ 
$current_user_id = $_SESSION['member_int_id'] ?? 0;
?>
<style>
/* ── Proyek page scoped ── */
#page-proyek .proyek-hero {
  background: linear-gradient(135deg, #0f0c2e 0%, #1a1242 50%, #2d1b6e 100%);
  border-radius: 20px;
  padding: 48px 52px;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 200px;
}
#page-proyek .proyek-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 55% 80% at 80% 50%, rgba(108,92,231,0.2) 0%, transparent 70%),
    radial-gradient(circle at 10% 90%, rgba(99,102,241,0.12) 0%, transparent 40%);
  pointer-events: none;
}
/* Star particles */
#page-proyek .proyek-hero-stars span {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,0.6);
  animation: twinkle var(--d, 3s) var(--delay, 0s) infinite;
}
@keyframes twinkle {
  0%,100% { opacity:0.2; transform:scale(1); }
  50% { opacity:1; transform:scale(1.5); }
}
#page-proyek .proyek-hero-text { position:relative; z-index:1; }
#page-proyek .proyek-hero-title {
  font-size: 36px;
  font-weight: 900;
  color: #fff;
  letter-spacing: -0.8px;
  line-height: 1.15;
  margin-bottom: 12px;
}
#page-proyek .proyek-hero-sub {
  color: rgba(255,255,255,0.65);
  font-size: 14px;
  line-height: 1.65;
  max-width: 440px;
  margin-bottom: 28px;
}
#page-proyek .proyek-hero-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #f59e0b, #f97316);
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 13px 24px;
  font-size: 14px;
  font-weight: 800;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 6px 20px rgba(245,158,11,0.4);
}
#page-proyek .proyek-hero-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(245,158,11,0.5);
}
#page-proyek .proyek-hero-stats {
  display: flex;
  gap: 20px;
  position: relative;
  z-index: 1;
  flex-shrink: 0;
}
#page-proyek .proyek-stat {
  background: rgba(255,255,255,0.07);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 16px;
  padding: 20px 24px;
  text-align: center;
  min-width: 90px;
}
#page-proyek .proyek-stat .num {
  font-size: 28px;
  font-weight: 900;
  color: #fff;
  line-height: 1;
  margin-bottom: 4px;
}
#page-proyek .proyek-stat .lbl {
  font-size: 10px;
  color: rgba(255,255,255,0.55);
  font-weight: 700;
  letter-spacing: 0.4px;
  text-transform: uppercase;
}

/* ── Tabs ── */
#page-proyek .proyek-tabs {
  display: flex;
  gap: 4px;
  background: var(--c-bg);
  border-radius: 12px;
  padding: 4px;
}
#page-proyek .proyek-tab {
  flex: 1;
  padding: 9px 16px;
  border-radius: 9px;
  border: none;
  background: transparent;
  font-size: 13px;
  font-weight: 700;
  color: var(--c-text-muted);
  cursor: pointer;
  transition: all 0.2s;
}
#page-proyek .proyek-tab.active {
  background: var(--c-card);
  color: var(--c-primary);
  box-shadow: 0 2px 8px rgba(44,48,122,0.08);
}

/* ── Filter pills ── */
#page-proyek .filter-pill {
  padding: 7px 14px;
  border-radius: 100px;
  border: 1.5px solid var(--c-border);
  background: var(--c-card);
  color: var(--c-text-muted);
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.18s;
}
#page-proyek .filter-pill.active {
  background: var(--c-primary);
  border-color: var(--c-primary);
  color: #fff;
  box-shadow: 0 4px 12px rgba(108,92,231,0.3);
}
#page-proyek .filter-pill:hover:not(.active) { background: var(--c-bg); }

/* ── Project cards ── */
#page-proyek .project-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
#page-proyek .project-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 18px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.25s cubic-bezier(.4,0,.2,1);
  box-shadow: 0 2px 8px rgba(44,48,122,0.04);
  cursor: pointer;
}
#page-proyek .project-card:hover {
  transform: translateY(-5px);
  border-color: var(--c-primary-light);
  box-shadow: 0 12px 36px rgba(108,92,231,0.14);
}
#page-proyek .project-cover {
  height: 130px;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}
#page-proyek .project-cover-icon {
  font-size: 52px;
  opacity: 0.18;
}
#page-proyek .project-cover-label {
  position: absolute;
  top: 12px;
  left: 14px;
  background: rgba(0,0,0,0.35);
  backdrop-filter: blur(6px);
  border: 1px solid rgba(255,255,255,0.15);
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 0.4px;
  padding: 4px 10px;
  border-radius: 100px;
}
#page-proyek .project-status-dot {
  position: absolute;
  top: 14px;
  right: 14px;
  display: flex;
  align-items: center;
  gap: 5px;
  background: rgba(0,0,0,0.4);
  backdrop-filter: blur(6px);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 100px;
  padding: 4px 10px;
  font-size: 10px;
  font-weight: 800;
  color: #fff;
}
#page-proyek .project-status-dot::before {
  content: '';
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #a3e635;
  box-shadow: 0 0 6px #a3e635;
}
#page-proyek .project-body {
  padding: 18px 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
#page-proyek .project-title {
  font-size: 15px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.4;
  margin-bottom: 8px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
#page-proyek .project-desc {
  font-size: 12px;
  color: var(--c-text-muted);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
  margin-bottom: 16px;
}
#page-proyek .project-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 14px;
  border-top: 1px solid var(--c-border-light);
}
#page-proyek .project-author {
  display: flex;
  align-items: center;
  gap: 8px;
}
#page-proyek .project-author-av {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: var(--c-primary-pale);
  color: var(--c-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 800;
  flex-shrink: 0;
}
#page-proyek .project-member-bar {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  font-weight: 800;
  color: var(--c-success);
}

/* ── Progress bar ── */
#page-proyek .progress-wrap {
  background: var(--c-border-light);
  border-radius: 100px;
  height: 4px;
  margin: 10px 0 14px;
  overflow: hidden;
}
#page-proyek .progress-bar {
  height: 100%;
  border-radius: 100px;
  background: linear-gradient(90deg, var(--c-primary), var(--c-primary-light));
  transition: width 0.6s ease;
}

/* ── Empty state dark card ── */
#page-proyek .empty-proyek {
  grid-column: 1/-1;
  background: linear-gradient(135deg, #1a1242 0%, #2d1b6e 100%);
  border-radius: 20px;
  padding: 48px 40px;
  display: flex;
  align-items: center;
  gap: 40px;
  border: 1.5px solid rgba(108,92,231,0.25);
  box-shadow: 0 8px 40px rgba(108,92,231,0.12);
}
#page-proyek .empty-proyek img {
  width: 220px;
  flex-shrink: 0;
  filter: drop-shadow(0 8px 24px rgba(0,0,0,0.4));
}
#page-proyek .empty-proyek-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  border: 2px solid rgba(245,158,11,0.7);
  color: #f59e0b;
  border-radius: 12px;
  padding: 12px 24px;
  font-size: 14px;
  font-weight: 800;
  cursor: pointer;
  transition: all 0.2s;
  margin-top: 20px;
}
#page-proyek .empty-proyek-cta:hover {
  background: rgba(245,158,11,0.1);
  border-color: #f59e0b;
}

/* ── Skeleton ── */
#page-proyek .skel {
  background: linear-gradient(90deg, var(--c-border) 25%, var(--c-border-light) 50%, var(--c-border) 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 8px;
}
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
</style>

<div class="page" id="page-proyek" style="animation: fadeIn 0.3s ease-out;">

  <!-- ═══════════ HERO ═══════════ -->
  <div class="proyek-hero mb-32">
    <!-- Stars -->
    <div class="proyek-hero-stars" aria-hidden="true">
      <span style="width:3px;height:3px;top:15%;left:5%;--d:2.5s;--delay:0s;"></span>
      <span style="width:2px;height:2px;top:60%;left:15%;--d:3s;--delay:0.5s;"></span>
      <span style="width:3px;height:3px;top:25%;left:30%;--d:2s;--delay:1s;"></span>
      <span style="width:2px;height:2px;top:70%;left:42%;--d:3.5s;--delay:0.3s;"></span>
      <span style="width:3px;height:3px;top:10%;left:60%;--d:2.8s;--delay:1.5s;"></span>
    </div>

    <!-- Text -->
    <div class="proyek-hero-text">
      <h1 class="proyek-hero-title">Kolaborasi Proyek</h1>
      <p class="proyek-hero-sub">Bentuk tim, ciptakan inovasi. Temukan rekan guru dengan visi yang sama untuk mewujudkan proyek pendidikan Anda.</p>
      <button class="proyek-hero-btn" onclick="openNewProjectModal()">
        <i class="ti ti-rocket" style="font-size:16px;"></i>
        Inisiasi Proyek Baru
      </button>
    </div>

    <!-- Stats -->
    <div class="proyek-hero-stats">
      <div class="proyek-stat">
        <div class="num" id="statTotalProyek">–</div>
        <div class="lbl">Proyek</div>
      </div>
      <div class="proyek-stat">
        <div class="num" id="statAnggota">–</div>
        <div class="lbl">Anggota</div>
      </div>
    </div>
  </div>

  <!-- ═══════════ TOOLBAR ═══════════ -->
  <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <!-- Tabs -->
    <div class="proyek-tabs" style="max-width:320px; width:100%;">
      <button class="proyek-tab active" id="tabJelajahi" onclick="switchProyekTab('jelajahi')">
        <i class="ti ti-world" style="font-size:13px;"></i> Jelajahi
      </button>
      <button class="proyek-tab" id="tabSaya" onclick="switchProyekTab('saya')">
        <i class="ti ti-user-circle" style="font-size:13px;"></i> Proyek Saya
      </button>
    </div>

    <!-- Filter pills -->
    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
      <button class="filter-pill active" onclick="setProyekFilter('semua', this)">Semua</button>
      <button class="filter-pill" onclick="setProyekFilter('mencari', this)">
        <i class="ti ti-user-plus" style="font-size:11px;"></i> Mencari Anggota
      </button>
      <button class="filter-pill" onclick="setProyekFilter('berjalan', this)">
        <i class="ti ti-player-play" style="font-size:11px;"></i> Sedang Berjalan
      </button>
      <button class="filter-pill" onclick="setProyekFilter('selesai', this)">
        <i class="ti ti-circle-check" style="font-size:11px;"></i> Selesai
      </button>
    </div>
  </div>

  <!-- ═══════════ PROJECT GRID ═══════════ -->
  <div class="project-grid" id="projectListContainer">
    <!-- Skeleton -->
    <?php for($i=0; $i<6; $i++): ?>
    <div class="project-card" style="pointer-events:none;">
      <div class="skel" style="height:130px;border-radius:0;"></div>
      <div class="project-body">
        <div class="skel" style="height:16px;width:80%;margin-bottom:8px;"></div>
        <div class="skel" style="height:12px;width:100%;margin-bottom:5px;"></div>
        <div class="skel" style="height:12px;width:65%;margin-bottom:24px;"></div>
        <div style="display:flex;justify-content:space-between;padding-top:14px;border-top:1px solid var(--c-border-light);">
          <div class="skel" style="height:30px;width:100px;border-radius:100px;"></div>
          <div class="skel" style="height:30px;width:60px;border-radius:8px;"></div>
        </div>
      </div>
    </div>
    <?php endfor; ?>
  </div>

  <div style="text-align:center; padding:40px 0 20px;">
    <button class="btn btn-ghost" id="btnLoadMoreProyek" style="display:none; padding:11px 32px;" onclick="gbShowAlert('Info','Semua proyek sudah ditampilkan.','info')">
      Muat Lebih Banyak <i class="ti ti-chevron-down"></i>
    </button>
  </div>
</div>

<!-- ═══════════ MODAL INISIASI PROYEK ═══════════ -->
<div class="modal-overlay" id="modalNewProject" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.65); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(4px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:580px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1); max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.2);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Inisiasi Proyek Baru</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Bagikan ide proyek Anda dan ajak rekan guru berkolaborasi.</p>
      </div>
      <button onclick="closeNewProjectModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; color:var(--c-text-muted); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;">&times;</button>
    </div>

    <div class="form-group mb-16">
      <label class="form-label">Nama Proyek</label>
      <input type="text" id="newProjectTitle" class="form-control" placeholder="Contoh: Pembuatan Modul Numerasi Digital">
    </div>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
      <div class="form-group">
        <label class="form-label">Kategori</label>
        <select id="newProjectLabel" class="form-control">
          <option value="Modul Ajar">📚 Modul Ajar</option>
          <option value="Aplikasi/Web">💻 Aplikasi / Web</option>
          <option value="Penelitian">🔬 Penelitian (PTK)</option>
          <option value="Gerakan Sosial">🤝 Gerakan Sosial</option>
          <option value="Media Pembelajaran">🎨 Media Pembelajaran</option>
          <option value="Komunitas Belajar">🌱 Komunitas Belajar</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Kebutuhan Anggota</label>
        <input type="number" id="newProjectMembers" class="form-control" value="2" min="1" max="20">
      </div>
    </div>
    <div class="form-group mb-28">
      <label class="form-label">Deskripsi Proyek</label>
      <textarea id="newProjectDesc" class="form-control" rows="4" placeholder="Jelaskan tujuan proyek dan kualifikasi anggota yang Anda butuhkan..."></textarea>
    </div>

    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-ghost" onclick="closeNewProjectModal()" style="padding:10px 20px;">Batal</button>
      <button class="btn btn-primary" onclick="submitNewProject()" style="padding:10px 24px; background:linear-gradient(135deg,#059669,#10b981); border-color:#059669;">
        <i class="ti ti-rocket"></i> Buat Proyek
      </button>
    </div>
  </div>
</div>

<script>
const currentUserId = <?= (int)$current_user_id ?>;
let projectDataCache = [];
let proyekActiveTab   = 'jelajahi';
let proyekActiveFilter = 'semua';

/* ── Boot ── */
loadProjectData();

/* ── Load ── */
function loadProjectData() {
  fetch('api_proyek.php?action=get_all')
    .then(r => r.json())
    .then(res => {
      if (res.status === 'success') {
        projectDataCache = res.data || [];
      } else {
        projectDataCache = [];
      }
      updateProyekStats();
      renderProjects();
    })
    .catch(err => {
      console.error('Proyek API error:', err);
      projectDataCache = [];
      renderProjects();
    });
}

function updateProyekStats() {
  document.getElementById('statTotalProyek').textContent = projectDataCache.length || '0';
  const totalAnggota = projectDataCache.reduce((sum, p) => sum + (parseInt(p.member_count) || 0), 0);
  document.getElementById('statAnggota').textContent = totalAnggota || '0';
}

/* ── Switch Tab ── */
function switchProyekTab(tab) {
  proyekActiveTab = tab;
  document.getElementById('tabJelajahi').classList.toggle('active', tab === 'jelajahi');
  document.getElementById('tabSaya').classList.toggle('active', tab === 'saya');
  renderProjects();
}

/* ── Filter ── */
function setProyekFilter(filter, btn) {
  proyekActiveFilter = filter;
  document.querySelectorAll('#page-proyek .filter-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderProjects();
}

/* ── Render ── */
function renderProjects() {
  const grid = document.getElementById('projectListContainer');
  let data = [...projectDataCache];

  // Tab filter
  if (proyekActiveTab === 'saya') {
    data = data.filter(p => parseInt(p.author_id) === currentUserId);
  }

  // Status filter
  if (proyekActiveFilter === 'mencari') data = data.filter(p => p.status === 'Mencari Anggota');
  else if (proyekActiveFilter === 'berjalan') data = data.filter(p => p.status === 'Berjalan');
  else if (proyekActiveFilter === 'selesai') data = data.filter(p => p.status === 'Selesai');

  if (!data.length) {
    let emptyTitle = "Belum Ada Proyek.";
    let emptyDesc = "Jadilah inisiator pertama yang mengajak rekan-rekan guru berkolaborasi untuk menciptakan dampak nyata di dunia pendidikan!";
    
    if (proyekActiveTab === 'saya') {
      emptyTitle = "Anda Belum Memiliki Proyek.";
      emptyDesc = "Anda belum menginisiasi proyek kolaborasi apa pun dengan kriteria ini. Mulai bagikan ide Anda sekarang.";
    } else if (proyekActiveFilter !== 'semua') {
      emptyTitle = "Tidak Ada Proyek Ditemukan.";
      emptyDesc = "Tidak ada proyek kolaborasi yang sesuai dengan filter status yang Anda pilih.";
    }

    grid.innerHTML = `
      <div class="empty-proyek">
        <img src="/guruverse/asset/img/community_teachers_muslim (2).png" alt="Belum ada proyek" onerror="this.style.display='none'">
        <div>
          <div style="font-size:22px;font-weight:900;color:#fff;line-height:1.3;margin-bottom:10px;">
            ${emptyTitle}
          </div>
          <p style="color:rgba(255,255,255,0.6);font-size:14px;line-height:1.65;max-width:380px;">
            ${emptyDesc}
          </p>
          <button class="empty-proyek-cta" onclick="openNewProjectModal()">
            <i class="ti ti-rocket"></i> Mulai Proyek Baru
          </button>
        </div>
      </div>`;
    return;
  }

  // Color palettes per label
  const labelColors = {
    'Modul Ajar':         { from:'#6C5CE7', to:'#A29BFE' },
    'Aplikasi/Web':       { from:'#0ea5e9', to:'#38bdf8' },
    'Penelitian':         { from:'#059669', to:'#34d399' },
    'Gerakan Sosial':     { from:'#f59e0b', to:'#fcd34d' },
    'Media Pembelajaran': { from:'#e11d48', to:'#fb7185' },
    'Komunitas Belajar':  { from:'#7c3aed', to:'#c4b5fd' },
    'Kolaborasi':         { from:'#0369a1', to:'#38bdf8' },
  };
  const icons = {
    'Modul Ajar':'📚','Aplikasi/Web':'💻','Penelitian':'🔬',
    'Gerakan Sosial':'🤝','Media Pembelajaran':'🎨','Komunitas Belajar':'🌱','Kolaborasi':'🤝'
  };

  grid.innerHTML = data.map(p => {
    const colors = labelColors[p.label] || { from:'#6C5CE7', to:'#A29BFE' };
    const icon   = icons[p.label] || '📁';
    const pct    = Math.round((parseInt(p.member_count)||0) / (parseInt(p.kebutuhan_anggota)||1) * 100);
    const clampedPct = Math.min(pct, 100);
    const statusLabel = p.status === 'Mencari Anggota' ? 'Open' : (p.status === 'Berjalan' ? 'Active' : 'Done');
    return `
    <div class="project-card" onclick="openProjectDetail(${p.id})">
      <div class="project-cover" style="background:linear-gradient(135deg, ${colors.from} 0%, ${colors.to} 100%);">
        <span class="project-cover-icon">${icon}</span>
        <span class="project-cover-label">${p.label || 'Kolaborasi'}</span>
        <span class="project-status-dot">${statusLabel}</span>
      </div>
      <div class="project-body">
        <div class="project-title">${p.judul}</div>
        <div class="project-desc">${p.deskripsi || ''}</div>

        <!-- Progress bar anggota -->
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
          <span style="font-size:10px;font-weight:700;color:var(--c-text-muted);">Anggota</span>
          <span style="font-size:10px;font-weight:800;color:var(--c-success);">${p.member_count||0}/${p.kebutuhan_anggota} orang</span>
        </div>
        <div class="progress-wrap">
          <div class="progress-bar" style="width:${clampedPct}%;"></div>
        </div>

        <div class="project-footer">
          <div class="project-author">
            <div class="project-author-av">${p.author_initials || '?'}</div>
            <div>
              <div style="font-size:11px;font-weight:800;color:var(--c-text);">${p.author_name || 'Guru'}</div>
              <div style="font-size:10px;color:var(--c-text-muted);">${p.author_role || 'Guru'}</div>
            </div>
          </div>
          <button class="btn btn-primary" style="padding:7px 14px;font-size:11px;font-weight:800;border-radius:10px;background:linear-gradient(135deg,${colors.from},${colors.to});border:none;" onclick="event.stopPropagation(); openProjectDetail(${p.id})">
            Lihat →
          </button>
        </div>
      </div>
    </div>`;
  }).join('');

  document.getElementById('btnLoadMoreProyek').style.display = data.length >= 6 ? 'inline-flex' : 'none';
}

/* ── Modal ── */
function openNewProjectModal() {
  const m = document.getElementById('modalNewProject');
  m.style.display = 'flex';
  requestAnimationFrame(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  });
}
function closeNewProjectModal() {
  const m = document.getElementById('modalNewProject');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 320);
}

/* ── Submit ── */
function submitNewProject() {
  const judul   = document.getElementById('newProjectTitle').value.trim();
  const label   = document.getElementById('newProjectLabel').value;
  const desc    = document.getElementById('newProjectDesc').value.trim();
  const members = document.getElementById('newProjectMembers').value;

  if (!judul || !desc) {
    gbShowAlert('Oops!', 'Judul dan deskripsi proyek harus diisi.', 'error');
    return;
  }
  const fd = new FormData();
  fd.append('judul', judul);
  fd.append('label', label);
  fd.append('deskripsi', desc);
  fd.append('kebutuhan_anggota', members);

  fetch('api_proyek.php?action=create', { method:'POST', body:fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'success') {
        closeNewProjectModal();
        gbShowAlert('Proyek Dibuat!', 'Proyek Anda berhasil diinisiasi. Selamat berkolaborasi!', 'success');
        document.getElementById('newProjectTitle').value = '';
        document.getElementById('newProjectDesc').value  = '';
        loadProjectData();
      } else {
        gbShowAlert('Gagal', res.message || 'Terjadi kesalahan.', 'error');
      }
    })
    .catch(err => console.error(err));
}

/* ── Open detail ── */
function openProjectDetail(id) {
  window.currentInspiraProyekId = id;
  if (typeof loadProjectDetail === 'function') loadProjectDetail(id);
  showPage('proyek-detail');
}
</script>
