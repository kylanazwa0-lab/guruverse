@extends('layouts.inspira')

@section('title', $cerita->judul . ' - Cerita Inspiratif')

@section('content')

<div class="page active" id="page-cerita-detail" style="animation: fadeIn 0.3s ease-out;">
  
  <div style="margin-bottom: 24px;">
    <a class="btn btn-ghost btn-sm" href="{{ route('member.inspira.cerita') }}" style="font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--c-text-muted);">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
      Kembali ke Daftar Cerita
    </a>
  </div>

  @php
    $parts = explode(' ', $cerita->author_name);
    $initials = strtoupper(substr($parts[0], 0, 1));
    if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
  @endphp

  <div style="max-width: 800px; margin: 0 auto;">
    <div class="card" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
      
      <div style="text-align: center; margin-bottom: 32px;">
        <h2 style="font-size: 32px; font-weight: 800; color: var(--c-text); margin-bottom: 24px; line-height: 1.35; letter-spacing: -0.5px;">
          {{ $cerita->judul }}
        </h2>
        
        <div style="display: flex; justify-content: center; align-items: center; gap: 16px;">
          <div style="width: 56px; height: 56px; border-radius: 50%; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px;">
            {{ $initials }}
          </div>
          <div style="text-align: left;">
            <div style="font-weight: 800; color: var(--c-text); font-size: 16px;">{{ $cerita->author_name }}</div>
            <div style="font-size: 13px; color: var(--c-text-muted);">
              {{ date('d M Y, H:i', strtotime($cerita->created_at)) }} &bull; 
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:2px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              {{ $cerita->views }} Kali dibaca
            </div>
          </div>
        </div>
      </div>
      
      <!-- Pemisah Visual -->
      <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 40px;">
        <div style="width: 8px; height: 8px; border-radius: 50%; background: #fcd34d;"></div>
        <div style="width: 8px; height: 8px; border-radius: 50%; background: #fbbf24;"></div>
        <div style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b;"></div>
      </div>
      
      <div style="font-size: 17px; color: var(--c-text); line-height: 1.9; white-space: pre-wrap; font-family: 'Plus Jakarta Sans', sans-serif;">{{ $cerita->konten }}</div>
      
    </div>
  </div>

</div>

@endsection
