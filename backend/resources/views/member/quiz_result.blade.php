@extends('layouts.member')

@section('title', ucwords(str_replace('_', ' ', 'quiz_result')))

@section('content')

<div class="page active" id="page-quiz-result" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
  <div style="max-width: 900px; margin: 0 auto; padding: 40px 24px;">
      
      <div style="display:flex; flex-direction:column; align-items:flex-start; gap:24px; margin-bottom:32px;">
        <button class="btn btn-outline" id="qr-btn-back" style="display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:8px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
          Kembali ke Daftar Kuis
        </button>
        <div>
          <h1 class="t-h2" style="margin:0 0 8px 0; font-size:28px; font-weight:800; color:var(--c-text); line-height:1.3;">Hasil Kuis</h1>
          <p class="t-body t-muted" id="qr-module-title" style="margin:0; font-size:15px; font-weight:600;">Modul</p>
        </div>
      </div>
      
      <div id="qr-content-container">
          <!-- Result content will be injected here via JS -->
      </div>
      
  </div>
</div>

@endsection