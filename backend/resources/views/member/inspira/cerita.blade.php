@extends('layouts.inspira')

@section('title', 'Cerita Inspiratif - Guru Inspira')

@section('styles')
<style>
/* Cerita card grid */
.cerita-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
}
.cerita-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 18px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.25s cubic-bezier(.4,0,.2,1);
  cursor: pointer;
  text-decoration: none;
}
.cerita-card:hover {
  transform: translateY(-5px);
  border-color: #fcd34d;
  box-shadow: 0 12px 36px rgba(245,158,11,0.14);
}
.cerita-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.cerita-author-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}
.cerita-author-av {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #fef3c7;
  color: #d97706;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 800;
  flex-shrink: 0;
}
.cerita-title {
  font-size: 16px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.4;
  margin-bottom: 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.cerita-preview {
  font-size: 13px;
  color: var(--c-text-muted);
  line-height: 1.65;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
  margin-bottom: 16px;
}
.cerita-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 14px;
  border-top: 1px dashed var(--c-border-light);
}
.cerita-read-btn {
  padding: 6px 14px;
  font-size: 11px;
  font-weight: 800;
  border-radius: 9px;
  background: transparent;
  color: #f59e0b;
  border: 1.5px solid #fcd34d;
  cursor: pointer;
  transition: all 0.15s;
}
.cerita-read-btn:hover {
  background: rgba(245,158,11,0.1);
}
.empty-cerita-card {
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
  min-height: 240px;
}
.empty-cerita-title {
  font-size: 18px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.3;
  margin-bottom: 8px;
}
.empty-cerita-desc {
  color: var(--c-text-muted);
  font-size: 13px;
  line-height: 1.65;
  max-width: 380px;
  margin: 0 auto 24px;
}
.empty-cerita-btn {
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
  letter-spacing: 0.2px;
}
.empty-cerita-btn:hover {
  background: var(--c-primary-dark);
  transform: translateY(-2px);
}
</style>
@endsection

@section('content')

<div class="page active" id="page-cerita" style="animation: fadeIn 0.3s ease-out;">

  <!-- PAGE HEADER -->
  <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px;">
    <div>
      <h1 style="font-size:36px; font-weight:900; color:var(--c-text); letter-spacing:-0.8px; line-height:1.2; margin-bottom:10px;">Cerita Inspiratif</h1>
      <p style="color:var(--c-text-muted); font-size:14px; line-height:1.65; max-width:500px;">Setiap guru memiliki kisah perjuangan. Bagikan momen tak terlupakan Anda di kelas dan inspirasi ribuan guru lainnya.</p>
    </div>
    @if (!$ceritas->isEmpty())
      <button class="btn btn-primary" onclick="openNewCeritaModal()" style="margin-top:6px; padding:11px 22px; font-size:13px; font-weight:800; background:linear-gradient(135deg,#f59e0b,#f97316); border:none; box-shadow:0 6px 18px rgba(245,158,11,0.35);">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        Tulis Cerita
      </button>
    @endif
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <!-- CONTENT AREA -->
  <div class="cerita-grid" id="ceritaListContainer">
    @if ($ceritas->isEmpty())
      <div class="empty-cerita-card">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--c-text-subtle); margin-bottom: -10px;"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
        <div style="flex: 1;">
          <div class="empty-cerita-title">Belum Ada Cerita.</div>
          <div class="empty-cerita-desc">
            Jadilah penulis pertama dan inspirasi rekan pendidik di seluruh Indonesia! Bagikan momen berharga Anda di kelas.
          </div>
          <button class="empty-cerita-btn" onclick="openNewCeritaModal()">
            Mulai Tulis Cerita Baru
          </button>
        </div>
      </div>
    @else
      @foreach ($ceritas as $c)
        @php
          $preview = strlen($c->konten) > 160 ? substr(strip_tags($c->konten), 0, 160) . '...' : strip_tags($c->konten);
          
          $parts = explode(' ', $c->author_name);
          $initials = strtoupper(substr($parts[0], 0, 1));
          if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
        @endphp
        <a href="{{ route('member.inspira.cerita.detail', $c->id) }}" class="cerita-card">
          <div class="cerita-body">
            <div class="cerita-author-row">
              <div style="display:flex; align-items:center; gap:9px;">
                <div class="cerita-author-av">{{ $initials }}</div>
                <div>
                  <div style="font-size:12px; font-weight:800; color:var(--c-text);">{{ $c->author_name }}</div>
                  <div style="font-size:10px; color:var(--c-text-muted);">{{ $c->author_institution ?? 'Member' }}</div>
                </div>
              </div>
              <div style="font-size:11px; color:var(--c-text-muted);">
                {{ date('d M Y', strtotime($c->created_at)) }}
              </div>
            </div>
            <h3 class="cerita-title">{{ $c->judul }}</h3>
            <p class="cerita-preview">{{ $preview }}</p>
            <div class="cerita-footer">
              <div style="font-size:11px; font-weight:700; color:var(--c-text-muted); display:flex; align-items:center; gap:5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                {{ $c->views }} Kali dibaca
              </div>
              <span class="cerita-read-btn">
                Baca Selengkapnya
              </span>
            </div>
          </div>
        </a>
      @endforeach
    @endif
  </div>

</div>

<!-- MODAL TULIS CERITA -->
<div class="modal-overlay" id="modalNewCerita" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:680px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1); max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Tulis Kisah Anda</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Bagikan pengalaman Anda dan inspirasi guru-guru lain di seluruh Indonesia.</p>
      </div>
      <button onclick="closeNewCeritaModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; color:var(--c-text-muted); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;">&times;</button>
    </div>

    <form action="{{ route('member.inspira.cerita.create') }}" method="POST">
      @csrf
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Judul Cerita</label>
        <input type="text" name="judul" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="Contoh: Senyum Pertama Budi di Kelas Remedial">
      </div>

      <div class="form-group mb-24">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Isi Cerita</label>
        <textarea name="konten" required class="form-control" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; min-height:260px;" placeholder="Mulailah mengetik kisah inspiratif Anda..."></textarea>
        <small style="color:var(--c-text-muted); margin-top:10px; display:block; font-size:11px;">Gunakan Enter untuk memisahkan paragraf. Kisah Anda akan langsung diterbitkan ke komunitas.</small>
      </div>

      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeNewCeritaModal()">Batal</button>
        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#f59e0b,#f97316); border-color:#f59e0b;">
          Terbitkan Cerita
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function openNewCeritaModal() {
  const m = document.getElementById('modalNewCerita');
  m.style.display = 'flex';
  requestAnimationFrame(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  });
}

function closeNewCeritaModal() {
  const m = document.getElementById('modalNewCerita');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 320);
}
</script>
@endsection
