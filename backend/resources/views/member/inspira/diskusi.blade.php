@extends('layouts.inspira')

@section('title', 'Rekan Kolaborasi - Guru Inspira')

@section('styles')
<style>
.rekan-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 20px;
}
.rekan-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 18px;
  padding: 24px;
  text-align: center;
  transition: all 0.25s;
  display: flex;
  flex-direction: column;
}
.rekan-card:hover {
  transform: translateY(-5px);
  border-color: var(--c-primary);
  box-shadow: 0 12px 36px rgba(0,0,0,0.1);
}
.rekan-av {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--c-primary), #8b5cf6);
  color: #fff;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: 800;
  margin: 0 auto 16px;
}
.rekan-name {
  font-size: 16px;
  font-weight: 800;
  color: var(--c-text);
  margin-bottom: 4px;
}
.rekan-inst {
  font-size: 12px;
  color: var(--c-text-muted);
  margin-bottom: 12px;
}
.rekan-minat {
  display: inline-block;
  padding: 4px 10px;
  background: var(--c-primary-pale);
  color: var(--c-primary);
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  margin: 0 auto 16px;
  max-width: fit-content;
}
.rekan-desc {
  font-size: 12px;
  color: var(--c-text-muted);
  line-height: 1.5;
  margin-bottom: 20px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
}
</style>
@endsection

@section('content')

<div class="page active" id="page-diskusi" style="animation: fadeIn 0.3s ease-out;">

  <!-- PAGE HEADER -->
  <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
    <div>
      <h1 style="font-size:36px; font-weight:900; color:var(--c-text); letter-spacing:-0.8px; line-height:1.2; margin-bottom:10px;">Rekan Kolaborasi</h1>
      <p style="color:var(--c-text-muted); font-size:14px; line-height:1.65; max-width:500px;">Temukan guru-guru lain di seluruh Indonesia yang memiliki minat sama untuk berkolaborasi dan mengembangkan proyek bersama.</p>
    </div>
    <button class="btn btn-primary" onclick="openProfilRekanModal()" style="margin-top:6px; padding:11px 22px; font-size:13px; font-weight:800; border:none; box-shadow:0 6px 18px rgba(0,0,0,0.15); display:inline-flex; align-items:center; gap:6px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
      Profil Kolaborasi Saya
    </button>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <!-- PEERS NETWORKING GRID -->
  <div class="rekan-grid" id="rekanListContainer">
    @if ($rekans->isEmpty())
      <div style="grid-column: 1 / -1; background:var(--c-card); padding:48px; border-radius:20px; text-align:center; border:1.5px dashed var(--c-border);">
        <h3 style="font-weight:800; font-size:18px; margin-bottom:8px; color:var(--c-text);">Belum Ada Rekan Terdaftar</h3>
        <p style="color:var(--c-text-muted); font-size:14px;">Jadilah yang pertama untuk membuka peluang kolaborasi dengan guru lain.</p>
      </div>
    @else
      @foreach ($rekans as $r)
        @php
          $parts = explode(' ', $r->full_name);
          $initials = strtoupper(substr($parts[0], 0, 1));
          if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
        @endphp
        <div class="rekan-card">
          <div class="rekan-av">{{ $initials }}</div>
          <h3 class="rekan-name">{{ $r->full_name }} {{ $r->user_id == $member->id ? '(Anda)' : '' }}</h3>
          <div class="rekan-inst">{{ $r->institution ?? 'Instansi tidak diketahui' }}</div>
          <div class="rekan-minat">{{ $r->bidang_minat }}</div>
          <div class="rekan-desc">{{ $r->deskripsi ?? 'Belum ada deskripsi profil.' }}</div>
          
          @if ($r->user_id != $member->id)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $r->phone) }}" target="_blank" class="btn btn-outline" style="width:100%; font-size:12px; padding:8px 0; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px; color:var(--c-primary); border-color:var(--c-primary);">
              Sapa Rekan (WA)
            </a>
          @else
            <button class="btn btn-outline" style="width:100%; font-size:12px; padding:8px 0; font-weight:700;" onclick="openProfilRekanModal()">
              Edit Profil Saya
            </button>
          @endif
        </div>
      @endforeach
    @endif
  </div>

</div>

<!-- Modal Profil Kolaborasi -->
<div class="modal-overlay" id="modalProfilRekan" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:500px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s; max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Profil Kolaborasi Saya</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Atur bagaimana orang lain melihat Anda di halaman jejaring.</p>
      </div>
      <button onclick="closeProfilRekanModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; cursor:pointer; color:var(--c-text-muted); display:flex; align-items:center; justify-content:center; flex-shrink:0;">&times;</button>
    </div>

    <form action="{{ route('member.inspira.diskusi.register') }}" method="POST">
      @csrf
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Status Kolaborasi</label>
        <select name="status_open" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;">
          <option value="1" {{ $user_rekan && $user_rekan->status_open == 1 ? 'selected' : '' }}>Terbuka untuk Kolaborasi</option>
          <option value="0" {{ $user_rekan && $user_rekan->status_open == 0 ? 'selected' : '' }}>Sedang Sibuk / Tidak Tersedia</option>
        </select>
      </div>
      
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Bidang Minat Utama</label>
        <input type="text" name="bidang_minat" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" value="{{ $user_rekan->bidang_minat ?? '' }}" placeholder="Contoh: STEM, Literasi Digital, Kurikulum Merdeka">
      </div>
      
      <div class="form-group mb-24">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Bio Singkat / Keahlian</label>
        <textarea name="deskripsi" required class="form-control" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; min-height:100px;" placeholder="Ceritakan sedikit tentang keahlian dan proyek yang ingin Anda kerjakan...">{{ $user_rekan->deskripsi ?? '' }}</textarea>
      </div>
      
      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeProfilRekanModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Profil</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function openProfilRekanModal() {
  const m = document.getElementById('modalProfilRekan');
  m.style.display = 'flex';
  requestAnimationFrame(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  });
}

function closeProfilRekanModal() {
  const m = document.getElementById('modalProfilRekan');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}
</script>
@endsection
