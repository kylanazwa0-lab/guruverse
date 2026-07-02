<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="/asset/img/logo guruverse FA.ai.png"/>
<title>Login Admin — Guruverse.id</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<style>
:root{--v1:#8b2fc9;--v2:#6a1b9a;--amber:#f59e0b;--bg:#f0f2f9;--border:#e8eaf2;--muted:#6b7280;--muted2:#9ca3b8;--t:#111827;}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--t);min-height:100vh;display:flex;align-items:center;justify-content:center;}
.login-page{width:100%;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem;background:radial-gradient(ellipse 60% 50% at 15% 70%,rgba(139,47,201,.08) 0%,transparent 60%),radial-gradient(ellipse 50% 45% at 85% 20%,rgba(245,158,11,.06) 0%,transparent 55%),var(--bg);}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
.login-box{width:100%;max-width:380px;background:#fff;border:1px solid var(--border);border-radius:22px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.10);animation:fadeUp .45s cubic-bezier(.22,1,.36,1) both;}
.login-accent{height:4px;background:linear-gradient(90deg,var(--v1) 0%,var(--v2) 50%,var(--amber) 100%);}
.login-header{padding:2rem 2rem 1rem;text-align:center;}
.login-logo{display:block;margin:0 auto 1.25rem;height:36px;object-fit:contain;max-width:180px;}
.login-shield{width:52px;height:52px;border-radius:14px;margin:0 auto .9rem;background:linear-gradient(135deg,rgba(139,47,201,.12),rgba(106,27,154,.06));border:1px solid rgba(139,47,201,.18);display:flex;align-items:center;justify-content:center;}
.login-title{font-size:1.1rem;font-weight:900;letter-spacing:-.025em;}
.login-sub{font-size:.73rem;color:var(--muted);margin-top:.3rem;}
.login-body{padding:.75rem 1.75rem 1.75rem;display:flex;flex-direction:column;gap:.75rem;}
.login-err{background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:.5rem .85rem;font-size:.73rem;font-weight:700;color:#ef4444;display:flex;align-items:center;gap:.45rem;}
.fg{display:flex;flex-direction:column;gap:.3rem;}
.fg label{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--muted2);}
.fi-wrap{position:relative;}
.fi-ico{position:absolute;left:.75rem;top:50%;transform:translateY(-50%);display:flex;color:var(--muted2);pointer-events:none;}
.fi{width:100%;background:#fff;border:1px solid var(--border);border-radius:10px;padding:.68rem .9rem .68rem 2.4rem;font-family:inherit;font-size:.875rem;font-weight:600;color:var(--t);outline:none;transition:border-color .2s;}
.fi:focus{border-color:var(--v1);box-shadow:0 0 0 3px rgba(139,47,201,.1);}
.fi::placeholder{color:var(--muted2);}
.btn-primary{width:100%;background:linear-gradient(135deg,var(--v1),var(--v2));border:none;border-radius:10px;padding:.76rem;font-family:inherit;font-weight:800;font-size:.9rem;color:#fff;cursor:pointer;box-shadow:0 6px 20px rgba(139,47,201,.3);transition:opacity .2s;}
.btn-primary:hover{opacity:.88;}
.btn-primary:disabled{opacity:.4;cursor:not-allowed;}
.login-footer{text-align:center;font-size:.62rem;color:var(--muted2);border-top:1px solid var(--border);padding:.9rem 1.75rem;}
.btn-back{display:block;text-align:center;text-decoration:none;margin-top:4px;background:transparent;border:1px solid var(--border);color:var(--muted);padding:10px 15px;border-radius:10px;font-weight:600;font-size:0.85rem;transition:0.2s;font-family:inherit;}
.btn-back:hover{background:rgba(0,0,0,.03);color:#1e293b;}
</style>
</head>
<body>
<div class="login-page">
  <div class="login-box">
    <div class="login-accent"></div>
    <div class="login-header">
      <img src="/asset/img/FA Logo Guruverse.ID - main.png" alt="Guruverse.ID" class="login-logo" onerror="this.style.display='none'">
      <div class="login-shield">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(139,47,201,.9)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
      </div>
      <h1 class="login-title">Admin Panel</h1>
      <p class="login-sub">Masuk dengan kredensial Admin Anda</p>
    </div>
    <div class="login-body">
      @if(session('error') || $errors->any())
        <div class="login-err">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          {{ session('error') ?? $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('admin.login.post') }}" id="adminLoginForm">
        @csrf
        <div class="fg">
          <label>Username / Email</label>
          <div class="fi-wrap">
            <span class="fi-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
            <input type="text" name="user" id="admin-user" class="fi" placeholder="Masukkan username admin" value="{{ old('user') }}" required/>
          </div>
        </div>
        <div class="fg" style="margin-top:8px">
          <label>Kata Sandi</label>
          <div class="fi-wrap">
            <span class="fi-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
            <input type="password" name="pass" id="admin-pass" class="fi" placeholder="••••••••" autocomplete="current-password" required/>
          </div>
        </div>
        <button type="submit" class="btn-primary" id="login-btn" style="margin-top:12px">Masuk ke Dashboard</button>
      </form>
      <a href="{{ url('/') }}" class="btn-back">← Kembali ke Halaman Utama</a>
    </div>
    <div class="login-footer">Halaman ini hanya untuk administrator Guruverse.id</div>
  </div>
</div>
{{-- Support AJAX login (backward-compatible with existing JS) --}}
<script>
  // Expose route for legacy JS
  window.ADMIN_LOGIN_URL = "{{ route('admin.login.post') }}";
  window.ADMIN_DASHBOARD_URL = "{{ route('admin.dashboard') }}";
  window.CSRF_TOKEN = "{{ csrf_token() }}";
</script>
</body>
</html>
