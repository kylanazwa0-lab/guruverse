@extends('layouts.inspira')

@section('title', 'Kolaborasi Proyek - Guru Inspira')

@section('styles')
<style>
/* Hero & Stats styling matching premium dashboard look */
.proyek-hero {
  background: linear-gradient(135deg, #0f0c2e 0%, #1a1242 50%, #2d1b6e 100%);
  border-radius: 20px;
  padding: 40px;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 180px;
  margin-bottom: 32px;
}
.proyek-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 55% 80% at 80% 50%, rgba(108,92,231,0.2) 0%, transparent 70%),
    radial-gradient(circle at 10% 90%, rgba(99,102,241,0.12) 0%, transparent 40%);
  pointer-events: none;
}
.proyek-hero-text { position:relative; z-index:1; }
.proyek-hero-title {
  font-size: 32px;
  font-weight: 900;
  color: #fff;
  letter-spacing: -0.8px;
  line-height: 1.2;
  margin-bottom: 8px;
}
.proyek-hero-sub {
  color: rgba(255,255,255,0.7);
  font-size: 13px;
  line-height: 1.6;
  max-width: 440px;
  margin-bottom: 24px;
}
.proyek-hero-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #f59e0b, #f97316);
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 11px 20px;
  font-size: 13px;
  font-weight: 800;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 6px 20px rgba(245,158,11,0.4);
}
.proyek-hero-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(245,158,11,0.5);
}
.proyek-hero-stats {
  display: flex;
  gap: 16px;
  position: relative;
  z-index: 1;
  flex-shrink: 0;
}
.proyek-stat {
  background: rgba(255,255,255,0.07);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 16px;
  padding: 16px 20px;
  text-align: center;
  min-width: 100px;
}
.proyek-stat .num {
  font-size: 26px;
  font-weight: 900;
  color: #fff;
  line-height: 1;
  margin-bottom: 4px;
}
.proyek-stat .lbl {
  font-size: 9px;
  color: rgba(255,255,255,0.5);
  font-weight: 700;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}

/* Tabs & Filters */
.proyek-tabs {
  display: flex;
  gap: 4px;
  background: var(--c-bg);
  border-radius: 12px;
  padding: 4px;
}
.proyek-tab {
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
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}
.proyek-tab.active {
  background: var(--c-card);
  color: var(--c-primary);
  box-shadow: 0 2px 8px rgba(44,48,122,0.08);
}
.filter-pill {
  padding: 7px 14px;
  border-radius: 100px;
  border: 1.5px solid var(--c-border);
  background: var(--c-card);
  color: var(--c-text-muted);
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.18s;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.filter-pill.active {
  background: var(--c-primary);
  border-color: var(--c-primary);
  color: #fff;
  box-shadow: 0 4px 12px rgba(108,92,231,0.3);
}

/* Grid layout */
.project-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
}
.project-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 18px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.25s cubic-bezier(.4,0,.2,1);
  box-shadow: 0 2px 8px rgba(44,48,122,0.04);
  cursor: pointer;
  text-decoration: none;
}
.project-card:hover {
  transform: translateY(-5px);
  border-color: var(--c-primary-light);
  box-shadow: 0 12px 36px rgba(108,92,231,0.14);
}
.project-cover {
  height: 120px;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}
.project-cover-icon {
  font-size: 48px;
  opacity: 0.22;
}
.project-cover-label {
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
.project-status-dot {
  position: absolute;
  top: 12px;
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
.project-status-dot::before {
  content: '';
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #a3e635;
  box-shadow: 0 0 6px #a3e635;
}
.project-status-dot.status-berjalan::before {
  background: #0ea5e9;
  box-shadow: 0 0 6px #0ea5e9;
}
.project-status-dot.status-selesai::before {
  background: #10b981;
  box-shadow: 0 0 6px #10b981;
}
.project-body {
  padding: 18px 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.project-title {
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
.project-desc {
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
.progress-wrap {
  background: var(--c-border-light);
  border-radius: 100px;
  height: 4px;
  margin: 10px 0 14px;
  overflow: hidden;
}
.progress-bar {
  height: 100%;
  border-radius: 100px;
  background: linear-gradient(90deg, var(--c-primary), var(--c-primary-light));
  transition: width 0.6s ease;
}
.project-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 14px;
  border-top: 1px solid var(--c-border-light);
}
.project-author {
  display: flex;
  align-items: center;
  gap: 8px;
}
.project-author-av {
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
.empty-proyek {
  grid-column: 1/-1;
  background: transparent;
  border-radius: 20px;
  padding: 48px 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  text-align: center;
  gap: 20px;
  border: 3px dashed var(--c-text-subtle);
}
.empty-proyek-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--c-primary);
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 12px 24px;
  font-size: 14px;
  font-weight: 800;
  cursor: pointer;
  transition: all 0.2s;
  margin-top: 10px;
}
.empty-proyek-cta:hover {
  background: var(--c-primary-dark);
  transform: translateY(-2px);
}
</style>
@endsection

@section('content')

<div class="page active" id="page-proyek" style="animation: fadeIn 0.3s ease-out;">

  <!-- HERO -->
  <div class="proyek-hero">
    <div class="proyek-hero-text">
      <h1 class="proyek-hero-title">Kolaborasi Proyek</h1>
      <p class="proyek-hero-sub">Bentuk tim, ciptakan inovasi. Temukan rekan guru dengan visi yang sama untuk mewujudkan proyek pendidikan Anda.</p>
      <button class="proyek-hero-btn" onclick="openNewProjectModal()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle;"><path d="M4.5 16.5c-1.5 1.25-2.5 3.5-2.5 3.5h20s-1-2.25-2.5-3.5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 15c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5z"/><circle cx="12" cy="12" r="1"/></svg>
        Inisiasi Proyek Baru
      </button>
    </div>

    @php
      $totalProyek = count($proyeks);
      $totalAnggota = $proyeks->sum('member_count');
    @endphp
    <!-- Stats -->
    <div class="proyek-hero-stats">
      <div class="proyek-stat">
        <div class="num">{{ $totalProyek }}</div>
        <div class="lbl">Proyek</div>
      </div>
      <div class="proyek-stat">
        <div class="num">{{ $totalAnggota }}</div>
        <div class="lbl">Anggota</div>
      </div>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger mb-24" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.25); color: #ef4444; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('error') }}
    </div>
  @endif

  @if (!$proyeks->isEmpty())
  <!-- TOOLBAR -->
  <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <!-- Tabs -->
    <div class="proyek-tabs" style="max-width:320px; width:100%;">
      <button class="proyek-tab active" id="tabJelajahi" onclick="switchProyekTab('jelajahi')">
        Jelajahi
      </button>
      <button class="proyek-tab" id="tabSaya" onclick="switchProyekTab('saya')">
        Proyek Saya
      </button>
    </div>

    <!-- Filter pills -->
    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
      <button class="filter-pill active" data-filter="semua" onclick="setProyekFilter('semua', this)">Semua</button>
      <button class="filter-pill" data-filter="Mencari Anggota" onclick="setProyekFilter('Mencari Anggota', this)">
        Mencari Anggota
      </button>
      <button class="filter-pill" data-filter="Berjalan" onclick="setProyekFilter('Berjalan', this)">
        Sedang Berjalan
      </button>
      <button class="filter-pill" data-filter="Selesai" onclick="setProyekFilter('Selesai', this)">
        Selesai
      </button>
    </div>
  </div>
  @endif

  <!-- PROJECT GRID -->
  <div class="project-grid" id="projectListContainer">
    @if ($proyeks->isEmpty())
      <div class="empty-proyek">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--c-text-subtle); margin-bottom: -10px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        <div style="flex: 1;">
          <div style="font-size:18px;font-weight:800;color:var(--c-text);line-height:1.3;margin-bottom:8px;">
            Belum Ada Proyek.
          </div>
          <p style="color:var(--c-text-muted);font-size:13px;line-height:1.65;max-width:380px;margin: 0 auto;">
            Jadilah inisiator pertama yang mengajak rekan-rekan guru berkolaborasi untuk menciptakan dampak nyata di dunia pendidikan!
          </p>
          <button class="empty-proyek-cta" onclick="openNewProjectModal()">
            Mulai Proyek Baru
          </button>
        </div>
      </div>
    @else
      @php
        $labelColors = [
          'Modul Ajar' => ['from' => '#6C5CE7', 'to' => '#A29BFE'],
          'Aplikasi/Web' => ['from' => '#0ea5e9', 'to' => '#38bdf8'],
          'Penelitian' => ['from' => '#059669', 'to' => '#34d399'],
          'Gerakan Sosial' => ['from' => '#f59e0b', 'to' => '#fcd34d'],
          'Media Pembelajaran' => ['from' => '#e11d48', 'to' => '#fb7185'],
          'Komunitas Belajar' => ['from' => '#7c3aed', 'to' => '#c4b5fd'],
          'Kolaborasi' => ['from' => '#0369a1', 'to' => '#38bdf8'],
        ];
        $icons = [
          'Modul Ajar' => '📚',
          'Aplikasi/Web' => '💻',
          'Penelitian' => '🔬',
          'Gerakan Sosial' => '🤝',
          'Media Pembelajaran' => '🎨',
          'Komunitas Belajar' => '🌱',
          'Kolaborasi' => '🤝',
        ];
      @endphp

      @foreach ($proyeks as $p)
        @php
          $colors = $labelColors[$p->label] ?? ['from' => '#6C5CE7', 'to' => '#A29BFE'];
          $icon = $icons[$p->label] ?? '📁';
          $pct = ($p->kebutuhan_anggota > 0) ? round(($p->member_count / $p->kebutuhan_anggota) * 100) : 0;
          $clampedPct = min($pct, 100);
          
          $parts = explode(' ', $p->author_name);
          $initials = strtoupper(substr($parts[0], 0, 1));
          if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
          
          $statusDotClass = '';
          if($p->status === 'Berjalan') $statusDotClass = 'status-berjalan';
          elseif($p->status === 'Selesai') $statusDotClass = 'status-selesai';
        @endphp
        <a href="{{ route('member.inspira.proyek.detail', $p->id) }}" class="project-card" data-author="{{ $p->author_id }}" data-status="{{ $p->status }}">
          <div class="project-cover" style="background: linear-gradient(135deg, {{ $colors['from'] }} 0%, {{ $colors['to'] }} 100%);">
            <span class="project-cover-icon">{{ $icon }}</span>
            <span class="project-cover-label">{{ $p->label }}</span>
            <span class="project-status-dot {{ $statusDotClass }}">{{ $p->status }}</span>
          </div>
          <div class="project-body">
            <h3 class="project-title">{{ $p->judul }}</h3>
            <p class="project-desc">{{ $p->deskripsi }}</p>

            <!-- Progress bar -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
              <span style="font-size:10px; font-weight:700; color:var(--c-text-muted);">Anggota</span>
              <span style="font-size:10px; font-weight:800; color:var(--c-success);">{{ $p->member_count }}/{{ $p->kebutuhan_anggota }} orang</span>
            </div>
            <div class="progress-wrap">
              <div class="progress-bar" style="width: {{ $clampedPct }}%;"></div>
            </div>

            <div class="project-footer">
              <div class="project-author">
                <div class="project-author-av">{{ $initials }}</div>
                <div>
                  <div style="font-size:11px; font-weight:800; color:var(--c-text);">{{ $p->author_name }}</div>
                  <div style="font-size:10px; color:var(--c-text-muted);">{{ $p->author_institution ?? 'Member' }}</div>
                </div>
              </div>
              <span class="btn btn-primary" style="padding:7px 14px; font-size:11px; font-weight:800; border-radius:10px; background:linear-gradient(135deg,{{ $colors['from'] }},{{ $colors['to'] }}); border:none;">
                Lihat &rarr;
              </span>
            </div>
          </div>
        </a>
      @endforeach
    @endif
  </div>

  @if (!$proyeks->isEmpty())
  <!-- Empty Search/Filter State (Hidden by default) -->
  <div id="emptyFilterState" style="display:none; margin-top:20px;">
    <div class="empty-proyek">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--c-text-subtle); margin-bottom: -10px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <div style="flex: 1;">
        <div style="font-size:18px;font-weight:800;color:var(--c-text);line-height:1.3;margin-bottom:8px;" id="emptyFilterTitle">
          Tidak ada proyek ditemukan.
        </div>
        <p style="color:var(--c-text-muted);font-size:13px;line-height:1.65;max-width:380px;margin: 0 auto;" id="emptyFilterDesc">
          Tidak ada proyek kolaborasi yang sesuai dengan kriteria filter saat ini.
        </p>
        <button class="empty-proyek-cta" onclick="openNewProjectModal()">
          Mulai Proyek Baru
        </button>
      </div>
    </div>
  </div>
  @endif
</div>

<!-- MODAL INISIASI PROYEK -->
<div class="modal-overlay" id="modalNewProject" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.65); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(4px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:580px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1); max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.2);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Inisiasi Proyek Baru</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Bagikan ide proyek Anda dan ajak rekan guru berkolaborasi.</p>
      </div>
      <button onclick="closeNewProjectModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; color:var(--c-text-muted); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;">&times;</button>
    </div>

    <form action="{{ route('member.inspira.proyek.create') }}" method="POST">
      @csrf
      <div class="form-group mb-16">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Nama Proyek</label>
        <input type="text" name="judul" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="Contoh: Pembuatan Modul Numerasi Digital">
      </div>
      
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Kategori</label>
          <select name="label" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;">
            <option value="Modul Ajar">📚 Modul Ajar</option>
            <option value="Aplikasi/Web">💻 Aplikasi / Web</option>
            <option value="Penelitian">🔬 Penelitian (PTK)</option>
            <option value="Gerakan Sosial">🤝 Gerakan Sosial</option>
            <option value="Media Pembelajaran">🎨 Media Pembelajaran</option>
            <option value="Komunitas Belajar">🌱 Komunitas Belajar</option>
            <option value="Kolaborasi">🤝 Kolaborasi Lainnya</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Kebutuhan Anggota</label>
          <input type="number" name="kebutuhan_anggota" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" value="2" min="1" max="20">
        </div>
      </div>
      
      <div class="form-group mb-28">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Deskripsi Proyek</label>
        <textarea name="deskripsi" required class="form-control" rows="4" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; min-height:120px;" placeholder="Jelaskan tujuan proyek dan kualifikasi anggota yang Anda butuhkan..."></textarea>
      </div>

      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeNewProjectModal()">Batal</button>
        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#059669,#10b981); border-color:#059669;">
          Buat Proyek
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
const currentUserId = {{ $member->id }};
let activeTab = 'jelajahi';
let activeFilter = 'semua';

function switchProyekTab(tab) {
  activeTab = tab;
  document.getElementById('tabJelajahi').classList.toggle('active', tab === 'jelajahi');
  document.getElementById('tabSaya').classList.toggle('active', tab === 'saya');
  filterCards();
}

function setProyekFilter(filter, btn) {
  activeFilter = filter;
  document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  filterCards();
}

function filterCards() {
  const cards = document.querySelectorAll('.project-card');
  let visibleCount = 0;

  cards.forEach(card => {
    const authorId = parseInt(card.getAttribute('data-author'));
    const status = card.getAttribute('data-status');

    let matchTab = true;
    if (activeTab === 'saya' && authorId !== currentUserId) {
      matchTab = false;
    }

    let matchFilter = true;
    if (activeFilter !== 'semua' && status !== activeFilter) {
      matchFilter = false;
    }

    if (matchTab && matchFilter) {
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  const emptyState = document.getElementById('emptyFilterState');
  if (visibleCount === 0) {
    emptyState.style.display = 'block';
    
    if (activeTab === 'saya') {
      document.getElementById('emptyFilterTitle').textContent = 'Anda Belum Memiliki Proyek';
      document.getElementById('emptyFilterDesc').textContent = 'Anda belum menginisiasi proyek kolaborasi apa pun dengan kriteria ini. Mulai bagikan ide Anda sekarang.';
    } else {
      document.getElementById('emptyFilterTitle').textContent = 'Tidak Ada Proyek Ditemukan';
      document.getElementById('emptyFilterDesc').textContent = 'Tidak ada proyek kolaborasi yang sesuai dengan filter status yang Anda pilih.';
    }
  } else {
    emptyState.style.display = 'none';
  }
}

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
</script>
@endsection
