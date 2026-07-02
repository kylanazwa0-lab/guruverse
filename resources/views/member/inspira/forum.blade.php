@extends('layouts.inspira')

@section('title', 'Forum Diskusi - Guru Inspira')

@section('content')

<div class="page active" id="page-forum">
  <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px;">
    <div>
      <h1 style="font-size: 36px; font-weight: 900; color: var(--c-text); letter-spacing: -0.8px; line-height: 1.2; margin-bottom: 10px;">Forum Diskusi</h1>
      <p style="color: var(--c-text-muted); font-size: 14px; line-height: 1.65; max-width: 500px;">
        @if ($activeForum)
          Kategori: <strong>{{ $activeForum->judul }}</strong> &mdash; {{ $activeForum->deskripsi }}
        @else
          Ruang diskusi terbuka untuk berbagi wawasan, kolaborasi, dan memecahkan kendala di kelas.
        @endif
      </p>
    </div>
    <button class="btn btn-primary" onclick="openNewTopicModal()" style="margin-top:6px; padding:11px 22px; font-size:13px; font-weight:800; border:none; box-shadow:0 6px 18px rgba(0,0,0,0.15);">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Topik
    </button>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <!-- Category Filter Chips -->
  <div style="display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap;">
    <a href="{{ route('member.inspira.forum') }}" 
       style="padding:8px 16px; border-radius:30px; font-size:12px; font-weight:700; text-decoration:none; border:1.5px solid var(--c-border); {{ !$forumId ? 'background:var(--c-primary); color:#fff; border-color:var(--c-primary);' : 'background:transparent; color:var(--c-text-muted);' }}">
       Semua Diskusi
    </a>
    @foreach ($forums as $f)
      <a href="{{ route('member.inspira.forum', ['forum_id' => $f->id]) }}" 
         style="padding:8px 16px; border-radius:30px; font-size:12px; font-weight:700; text-decoration:none; border:1.5px solid var(--c-border); {{ $forumId == $f->id ? 'background:var(--c-primary); color:#fff; border-color:var(--c-primary);' : 'background:transparent; color:var(--c-text-muted);' }}">
         {{ $f->judul }}
      </a>
    @endforeach
  </div>

  <!-- Thread List -->
  <div class="card p-0" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; overflow: hidden;">
    @if ($threads->isEmpty())
      <div style="padding: 60px 20px; text-align: center; color: var(--c-text-muted);">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:16px; opacity:0.3;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 8px;">Belum ada topik diskusi</h3>
        <p style="font-size: 13px;">Jadilah pendidik pertama yang memulai diskusi menarik di sini!</p>
      </div>
    @else
      @foreach ($threads as $t)
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--c-border-light); display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: background 0.2s;" 
             onclick="window.location.href='{{ route('member.inspira.forum.thread', $t->id) }}'"
             onmouseover="this.style.background='var(--c-bg)'" onmouseout="this.style.background='transparent'">
          <div style="display:flex; gap:16px; align-items:center;">
            <div style="width: 42px; height: 42px; border-radius: 50%; background: var(--c-primary-pale); color: var(--c-primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; flex-shrink: 0;">
              {{ strtoupper(substr($t->author_name, 0, 1)) }}
            </div>
            <div>
              <h3 style="font-size: 15px; font-weight: 800; color: var(--c-text); margin-bottom: 4px; line-height: 1.3;">{{ $t->judul }}</h3>
              <div style="font-size: 11px; color: var(--c-text-muted);">
                Oleh: <strong style="color: var(--c-text);">{{ $t->author_name }}</strong> ({{ $t->author_institution ?? 'Member' }}) &bull; {{ date('d M Y, H:i', strtotime($t->created_at)) }}
              </div>
            </div>
          </div>
          <div style="text-align: right; display: flex; gap: 24px;">
            <div style="text-align: center;">
              <div style="font-size: 14px; font-weight: 800; color: var(--c-text);">{{ $t->views }}</div>
              <div style="font-size: 9px; color: var(--c-text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Views</div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>

<!-- Modal Tambah Topik -->
<div class="modal-overlay" id="modalNewTopic" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:600px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s; max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Mulai Diskusi Baru</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Tuliskan apa yang ingin Anda diskusikan dengan komunitas.</p>
      </div>
      <button onclick="closeNewTopicModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; cursor:pointer; color: var(--c-text);">&times;</button>
    </div>

    <form action="{{ route('member.inspira.forum.thread.create') }}" method="POST" id="formNewTopic">
      @csrf
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Pilih Kategori Forum</label>
        <select name="forum_id" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;">
          @foreach ($forums as $f)
            <option value="{{ $f->id }}" {{ $forumId == $f->id ? 'selected' : '' }}>{{ $f->judul }}</option>
          @endforeach
        </select>
      </div>
      
      <div class="form-group mb-20">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Judul Topik</label>
        <input type="text" name="judul" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="Contoh: Mengatasi kebosanan siswa saat jam siang">
      </div>

      <div class="form-group mb-24">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Isi Topik / Deskripsi</label>
        <textarea name="konten" required class="form-control" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; min-height:160px;" placeholder="Tulis secara lengkap wawasan atau kendala yang ingin didiskusikan..."></textarea>
      </div>

      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeNewTopicModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Terbitkan Diskusi</button>
      </div>
    </form>
  </div>
</div>

<script>
function openNewTopicModal() {
  const m = document.getElementById('modalNewTopic');
  m.style.display = 'flex';
  requestAnimationFrame(() => { m.style.opacity = '1'; m.querySelector('.modal-content').style.transform = 'translateY(0)'; });
}
function closeNewTopicModal() {
  const m = document.getElementById('modalNewTopic');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}
</script>

@endsection
