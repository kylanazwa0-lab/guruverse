@extends('layouts.inspira')

@section('title', $thread->judul . ' - Forum Diskusi')

@section('content')

<div class="page active" id="page-forum-thread" style="animation: fadeIn 0.3s ease-out;">

  <!-- Back Button -->
  <div class="mb-24">
    <a class="btn btn-ghost btn-sm" href="{{ route('member.inspira.forum', ['forum_id' => $thread->forum_id]) }}" style="font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--c-text-muted);">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
      Kembali ke Forum
    </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <!-- Main Thread Card -->
  <div class="card mb-24" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; padding: 28px;">
    <!-- Header: Category badge + time -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
      <span class="badge" style="background: {{ $thread->forum_warna ?? 'var(--c-primary-pale)' }}; color: var(--c-primary); padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 800;">
        {{ $thread->forum_name }}
      </span>
      <span style="color: var(--c-text-muted); font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        {{ date('d M Y, H:i', strtotime($thread->created_at)) }}
      </span>
    </div>

    <!-- Title -->
    <h2 style="font-size: 26px; font-weight: 900; color: var(--c-text); margin-bottom: 20px; line-height: 1.35; letter-spacing: -0.5px;">
      {{ $thread->judul }}
    </h2>

    <!-- Author -->
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--c-border-light);">
      <div style="width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, var(--c-primary), var(--c-primary-light)); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px;">
        {{ strtoupper(substr($thread->author_name, 0, 1)) }}
      </div>
      <div>
        <div style="font-size: 14px; font-weight: 800; color: var(--c-text);">{{ $thread->author_name }}</div>
        <div style="font-size: 11px; color: var(--c-text-muted);">{{ $thread->author_institution ?? 'Member' }} &bull; Penulis Topik</div>
      </div>
    </div>

    <!-- Body -->
    <div style="color: var(--c-text); line-height: 1.75; white-space: pre-wrap; font-size: 15px;">{{ $thread->konten }}</div>
  </div>

  <!-- Replies Section -->
  <div class="mb-24">
    <div style="margin-bottom: 16px;">
      <h3 style="font-size: 18px; font-weight: 800; color: var(--c-text);">
        Balasan ({{ count($replies) }})
      </h3>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
      @if ($replies->isEmpty())
        <div style="text-align: center; padding: 40px 20px; background: var(--c-card); border-radius: 18px; border: 1px dashed var(--c-border); color: var(--c-text-muted);">
          <div style="font-size: 32px; margin-bottom: 8px;">💬</div>
          <h4 style="font-size: 14px; font-weight: 800; color: var(--c-text); margin-bottom: 4px;">Belum ada balasan</h4>
          <p style="font-size: 12px;">Jadilah yang pertama membalas topik ini!</p>
        </div>
      @else
        @foreach ($replies as $reply)
          <div class="card" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; padding: 20px;">
            <div style="display: flex; align-items: start; gap: 12px;">
              <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--c-primary-pale); color: var(--c-primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; flex-shrink: 0;">
                {{ strtoupper(substr($reply->author_name, 0, 1)) }}
              </div>
              <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                  <span style="font-size: 13px; font-weight: 800; color: var(--c-text);">{{ $reply->author_name }}</span>
                  <span style="font-size: 10px; color: var(--c-text-muted);">({{ $reply->author_institution ?? 'Member' }})</span>
                  <span style="font-size: 11px; color: var(--c-text-muted); margin-left: auto;">{{ date('d M Y, H:i', strtotime($reply->created_at)) }}</span>
                </div>
                <div style="color: var(--c-text); line-height: 1.65; font-size: 14px; white-space: pre-wrap;">{{ $reply->konten }}</div>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>

  <!-- Write Reply Box -->
  <div class="card" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; padding: 24px;">
    <h4 style="font-size: 15px; font-weight: 800; color: var(--c-text); margin-bottom: 12px;">Tulis Balasan</h4>
    <form action="{{ route('member.inspira.forum.reply.create') }}" method="POST">
      @csrf
      <input type="hidden" name="thread_id" value="{{ $thread->id }}">
      <textarea name="konten" required rows="4" class="form-control mb-16" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; font-size:14px; margin-bottom: 16px;" placeholder="Tulis komentar atau jawaban Anda di sini..."></textarea>
      <div style="text-align: right;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700;">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          Kirim Balasan
        </button>
      </div>
    </form>
  </div>

</div>

@endsection
