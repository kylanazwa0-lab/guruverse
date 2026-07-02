@extends('layouts.inspira')

@section('title', 'Jendela Dunia - Guru Inspira')

@section('styles')
<style>
.jendela-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
}
.jendela-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 18px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.25s;
  cursor: pointer;
  text-decoration: none;
}
.jendela-card:hover {
  transform: translateY(-5px);
  border-color: var(--c-primary);
  box-shadow: 0 12px 36px rgba(0,0,0,0.1);
}
.jendela-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.jendela-category {
  font-size:10px;
  font-weight:800;
  color:var(--c-primary);
  text-transform:uppercase;
  letter-spacing:0.5px;
  margin-bottom:8px;
}
.jendela-title {
  font-size: 16px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.4;
  margin-bottom: 10px;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}
.jendela-preview {
  font-size: 13px;
  color: var(--c-text-muted);
  line-height: 1.65;
  display:-webkit-box;
  -webkit-line-clamp:3;
  -webkit-box-orient:vertical;
  overflow:hidden;
  flex:1;
  margin-bottom:16px;
}
.empty-jendela {
  grid-column: 1 / -1;
  background: var(--c-card);
  border-radius: 20px;
  padding: 48px;
  text-align: center;
  border: 3px dashed var(--c-border);
}
</style>
@endsection

@section('content')

<div class="page active" id="page-jendela" style="animation: fadeIn 0.3s ease-out;">

  <!-- HERO BANNER — selaras dengan Agenda, Proyek, Cerita -->
  <div class="card mb-24" style="background:linear-gradient(135deg, #0f0c2e 0%, #1a1242 50%, #2d1b6e 100%); color:#fff; padding:32px; border-radius:24px; position:relative; overflow:hidden;">
    <!-- Decorative SVG -->
    <svg style="position:absolute; right:-20px; top:-20px; width:200px; height:200px; opacity:0.08; transform:rotate(-15deg);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"/>
      <line x1="2" y1="12" x2="22" y2="12"/>
      <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
    </svg>
    <div style="position:relative; z-index:1; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:11px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:14px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          Artikel &amp; Inovasi
        </div>
        <h1 style="font-size:28px; font-weight:800; margin-bottom:8px; line-height:1.2;">Jendela Dunia</h1>
        <p style="color:rgba(255,255,255,0.85); max-width:500px; font-size:14px; line-height:1.6;">Eksplorasi inovasi pendidikan, artikel, dan tren global. Tambahkan wawasan baru untuk kemajuan pendidikan kita.</p>
      </div>
      <button class="btn" onclick="openNewJendelaModal()" style="background:linear-gradient(135deg,#f59e0b,#f97316); color:#fff; border:none; padding:12px 22px; border-radius:14px; font-size:13px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:8px; white-space:nowrap; box-shadow:0 6px 20px rgba(249,115,22,0.4); transition:all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Artikel
      </button>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <!-- ARTICLES LIST -->
  <div class="jendela-grid" id="jendelaListContainer">
    @if ($jendelas->isEmpty())
      <div class="empty-jendela">
        <div style="font-size:40px; margin-bottom:12px;">🌍</div>
        <h3 style="font-weight:800; font-size:18px; margin-bottom:8px; color:var(--c-text);">Belum Ada Artikel</h3>
        <p style="color:var(--c-text-muted); font-size:14px;">Jadilah yang pertama membagikan inovasi dunia pendidikan.</p>
      </div>
    @else
      @foreach ($jendelas as $j)
        @php
          $preview = strlen($j->konten) > 120 ? substr(strip_tags($j->konten), 0, 120) . '...' : strip_tags($j->konten);
        @endphp
        <a href="{{ route('member.inspira.jendela.detail', $j->id) }}" class="jendela-card">
          <div style="height:140px; background:var(--c-primary-pale); display:flex; align-items:center; justify-content:center; font-size:48px;">🌍</div>
          <div class="jendela-body">
            <div class="jendela-category">{{ $j->kategori }}</div>
            <h3 class="jendela-title">{{ $j->judul }}</h3>
            <p class="jendela-preview">{{ $preview }}</p>
            <div style="font-size:11px; color:var(--c-text-muted); margin-top:auto; padding-top:10px; border-top:1px solid var(--c-border-light);">
              Oleh: <strong style="color:var(--c-text);">{{ $j->author_name }}</strong> &bull; {{ date('d M Y', strtotime($j->created_at)) }}
            </div>
          </div>
        </a>
      @endforeach
    @endif
  </div>

</div>

<!-- Modal Tambah Artikel -->
<div class="modal-overlay" id="modalNewJendela" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:600px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s; max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Tambah Artikel / Inovasi</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Bagikan inovasi pendidikan yang menarik.</p>
      </div>
      <button onclick="closeNewJendelaModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; cursor:pointer; color:var(--c-text-muted); display:flex; align-items:center; justify-content:center; flex-shrink:0;">&times;</button>
    </div>

    <form action="{{ route('member.inspira.jendela.create') }}" method="POST">
      @csrf
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Judul Artikel</label>
        <input type="text" name="judul" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="Contoh: Penggunaan AI dalam Pendidikan">
      </div>
      
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Kategori</label>
        <select name="kategori" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;">
          <option value="Inovasi">Inovasi</option>
          <option value="Metode Belajar">Metode Belajar</option>
          <option value="Teknologi">Teknologi</option>
        </select>
      </div>
      
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Sumber (URL Opsional)</label>
        <input type="url" name="sumber" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="https://...">
      </div>

      <div class="form-group mb-24">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Isi Artikel</label>
        <textarea name="konten" required class="form-control" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; min-height:160px;" placeholder="Tulis rangkuman atau isi artikel..."></textarea>
      </div>

      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeNewJendelaModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Artikel</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function openNewJendelaModal() {
  const m = document.getElementById('modalNewJendela');
  m.style.display = 'flex';
  requestAnimationFrame(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  });
}

function closeNewJendelaModal() {
  const m = document.getElementById('modalNewJendela');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}
</script>
@endsection
