@extends('layouts.inspira')

@section('title', $jendela->judul . ' - Jendela Dunia')

@section('content')

<div class="page active" id="page-jendela-detail" style="animation: fadeIn 0.3s ease-out;">
  
  <div style="margin-bottom: 24px;">
    <a class="btn btn-ghost btn-sm" href="{{ route('member.inspira.jendela') }}" style="font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--c-text-muted);">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
      Kembali ke Jendela Dunia
    </a>
  </div>

  @php
    $parts = explode(' ', $jendela->author_name);
    $initials = strtoupper(substr($parts[0], 0, 1));
    if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
  @endphp

  <div style="max-width: 800px; margin: 0 auto;">
    <div style="background:var(--c-card); border-radius:24px; padding:48px; border:1px solid var(--c-border); box-shadow:0 12px 40px rgba(0,0,0,0.05);">
      
      <div style="text-align:center; margin-bottom:32px;">
        <span style="font-size:12px; font-weight:800; color:var(--c-primary); text-transform:uppercase; letter-spacing:1px;">
          {{ $jendela->kategori }}
        </span>
        <h1 style="font-size:32px; font-weight:900; color:var(--c-text); line-height:1.35; margin:12px 0; letter-spacing: -0.5px;">
          {{ $jendela->judul }}
        </h1>
        <div style="font-size:13px; color:var(--c-text-muted); display:flex; align-items:center; justify-content:center; gap:8px;">
          <div style="width:24px; height:24px; border-radius:50%; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:800;">
            {{ $initials }}
          </div>
          <span>{{ $jendela->author_name }}</span> &bull; 
          <span>{{ date('d M Y, H:i', strtotime($jendela->created_at)) }}</span>
        </div>
      </div>
      
      <div style="height:200px; background:var(--c-primary-pale); border-radius:16px; margin-bottom:40px; display:flex; align-items:center; justify-content:center; font-size:64px;">
        🌍
      </div>
      
      <div style="font-size:16px; line-height:1.8; color:var(--c-text); max-width:760px; margin:0 auto; white-space: pre-wrap;">{{ $jendela->konten }}</div>
      
      @if ($jendela->sumber)
        <div style="margin-top:40px; padding:16px; background:var(--c-bg); border: 1px solid var(--c-border-light); border-radius:12px; font-size:13px; color:var(--c-text-muted); text-align:center;">
          Sumber referensi: 
          <a href="{{ $jendela->sumber }}" target="_blank" style="color:var(--c-primary); font-weight:600; text-decoration: underline; word-break: break-all;">
            {{ $jendela->sumber }}
          </a>
        </div>
      @endif
    </div>
  </div>

</div>

@endsection
