<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('asset/img/logo guruverse FA.ai.png') }}"/>
<title>Login — Guruverse.id</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,600&display=swap" rel="stylesheet"/>
<style>
:root{--ink:#0f0c29;--deep:#1a1560;--purple:#6d28d9;--violet:#7c3aed;--accent:#a78bfa;--sky:#38bdf8;}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html,body{height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:var(--ink);color:#fff;overflow:hidden;}
.sf{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden;background:radial-gradient(ellipse at 20% 50%,rgba(109,40,217,.22) 0%,transparent 55%),radial-gradient(ellipse at 80% 20%,rgba(55,48,163,.28) 0%,transparent 50%),linear-gradient(135deg,#0f0c29 0%,#1a1560 50%,#0f0c29 100%);}
.star{position:absolute;border-radius:50%;background:#fff;animation:twinkle var(--d,3s) ease-in-out infinite var(--delay,0s);}
@keyframes twinkle{0%,100%{opacity:var(--op,.5);transform:scale(1)}50%{opacity:.08;transform:scale(.4)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
/* Page — fixed height, no overflow so browser never shows scrollbar */
.page{position:relative;z-index:1;height:100vh;overflow:hidden;display:flex;align-items:center;justify-content:center;padding:.75rem;}
/* Panel — compact */
.panel{background:rgba(255,255,255,.05);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.12);border-radius:1.25rem;padding:1.35rem 1.6rem;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.15);animation:fadeUp .45s cubic-bezier(.22,1,.36,1) both;}
.logo{display:block;margin:0 auto .9rem;height:30px;object-fit:contain;transition:opacity 0.2s;}
.logo:hover{opacity:0.85;}
h1{font-size:1.1rem;font-weight:800;text-align:center;letter-spacing:-.025em;margin-bottom:.2rem;}
.sub{text-align:center;font-size:.75rem;color:rgba(255,255,255,.5);margin-bottom:1.1rem;}
.fg{display:flex;flex-direction:column;gap:.25rem;margin-bottom:.65rem;}
.fg label{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(255,255,255,.6);}
.fi-wrap{position:relative;transition:transform .3s cubic-bezier(.4,0,.2,1);}
.fi-wrap:focus-within{transform:translateY(-2px);}
.fico{position:absolute;left:.75rem;top:50%;transform:translateY(-50%);display:flex;align-items:center;color:rgba(255,255,255,.35);pointer-events:none;transition:all .3s ease;}
.fi-wrap:focus-within .fico{color:var(--accent);transform:translateY(-50%) scale(1.1);}
.fi{width:100%;background:rgba(0,0,0,.2);border:1px solid rgba(255,255,255,.15);border-radius:.7rem;padding:.52rem .85rem .52rem 2.4rem;font-family:inherit;font-size:.82rem;font-weight:500;color:#fff;outline:none;transition:all .3s cubic-bezier(.4,0,.2,1);}
.fi:hover{background:rgba(255,255,255,.03);border-color:rgba(255,255,255,.25);}
.fi:focus{border-color:var(--accent);background:rgba(0,0,0,.3);box-shadow:0 0 0 3px rgba(167,139,250,.18);}
.fi::placeholder{color:rgba(255,255,255,.3);}
.fi:-webkit-autofill,
.fi:-webkit-autofill:hover, 
.fi:-webkit-autofill:focus, 
.fi:-webkit-autofill:active{
  -webkit-box-shadow: 0 0 0 30px #1e1b4b inset !important;
  -webkit-text-fill-color: #ffffff !important;
  transition: background-color 5000s ease-in-out 0s;
}
.fi.is-invalid{border-color:#ef4444;background:rgba(239,68,68,.05);}
.toggle-pwd{position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.35);cursor:pointer;display:flex;align-items:center;padding:4px;transition:color .2s;}
.toggle-pwd:hover{color:#fff;}
.err{font-size:.65rem;color:#fca5a5;margin-top:.15rem;}
.btn{position:relative;overflow:hidden;background:linear-gradient(135deg,var(--violet),var(--purple));color:#fff;border:none;cursor:pointer;font-family:inherit;font-weight:700;border-radius:.7rem;padding:.62rem 1rem;width:100%;font-size:.84rem;letter-spacing:0.02em;box-shadow:0 5px 16px rgba(124,58,237,.4);transition:all .3s ease;margin-top:.35rem;}
.btn::after{content:'';position:absolute;top:0;left:-100%;width:50%;height:100%;background:linear-gradient(to right,transparent,rgba(255,255,255,.2),transparent);transform:skewX(-20deg);transition:0.6s ease;}
.btn:hover::after{left:120%;}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(124,58,237,.6);}
.btn:active{transform:translateY(1px);}
.divider{text-align:center;font-size:.65rem;color:rgba(255,255,255,.3);margin:.75rem 0;position:relative;}
.divider::before,.divider::after{content:'';position:absolute;top:50%;width:40%;height:1px;background:rgba(255,255,255,.08);}
.divider::before{left:0;}.divider::after{right:0;}
.link-row{text-align:center;font-size:.75rem;color:rgba(255,255,255,.5);}
.link-row a{color:var(--accent);font-weight:700;text-decoration:none;transition:color 0.2s;}
.link-row a:hover{color:#fff;}
.remember{display:flex;align-items:center;gap:.5rem;font-size:.72rem;color:rgba(255,255,255,.5);margin:.4rem 0;cursor:pointer;user-select:none;}
.remember input[type="checkbox"]{accent-color:var(--accent);width:13px;height:13px;cursor:pointer;}
.back-link{display:inline-flex;align-items:center;gap:5px;font-size:.72rem;color:rgba(255,255,255,.38);font-weight:600;text-decoration:none;transition:color .2s;margin-top:.65rem;}
.back-link:hover{color:rgba(255,255,255,.75);}
</style>
</head>
<body>
<div class="sf" id="sf"></div>

<div class="page">
  <div class="panel">
    <a href="{{ url('/') }}">
      <img src="{{ asset('asset/img/FA Logo Guruverse.ID - main.png') }}" alt="Guruverse.ID" class="logo" onerror="this.style.display='none'">
    </a>
    <h1>Selamat Datang Kembali</h1>
    <p class="sub">Masuk ke akun Guruverse.id Anda</p>

    @if(session('error'))
      <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:.7rem;padding:.6rem .9rem;font-size:.75rem;color:#fca5a5;margin-bottom:.9rem;text-align:center;">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="fg">
        <label>Username</label>
        <div class="fi-wrap">
          <span class="fico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
          <input type="text" name="username" class="fi @error('username') is-invalid @enderror"
                 placeholder="Masukkan username" value="{{ old('username') }}" autocomplete="username"/>
        </div>
        @error('username')<div class="err">{{ $message }}</div>@enderror
      </div>

      <div class="fg">
        <label>Kata Sandi</label>
        <div class="fi-wrap">
          <span class="fico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
          <input type="password" name="password" id="password" class="fi @error('password') is-invalid @enderror"
                 placeholder="••••••••" autocomplete="current-password" style="padding-right:2.5rem;"/>
          <button type="button" class="toggle-pwd" onclick="togglePassword()" title="Tampilkan/Sembunyikan Sandi">
            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
        @error('password')<div class="err">{{ $message }}</div>@enderror
      </div>

      <label class="remember">
        <input type="checkbox" name="remember"> Ingat saya
      </label>

      <button type="submit" class="btn">Masuk ke Dashboard</button>
    </form>

    <div class="divider">atau</div>
    <div class="link-row">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
    <div style="text-align:center;">
      <a href="{{ url('/') }}" class="back-link">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Beranda
      </a>
    </div>
  </div>
</div>
<script>
(function(){const sf=document.getElementById('sf');const n=50;for(let i=0;i<n;i++){const s=document.createElement('div');s.className='star';const sz=Math.random()*2+.5;s.style.cssText=`width:${sz}px;height:${sz}px;top:${Math.random()*100}%;left:${Math.random()*100}%;--d:${(Math.random()*4+2).toFixed(1)}s;--delay:${(Math.random()*6).toFixed(1)}s;--op:${(Math.random()*.5+.2).toFixed(2)};`;sf.appendChild(s);}})();

function togglePassword() {
  const pwd = document.getElementById('password');
  const icon = document.getElementById('eye-icon');
  if (pwd.type === 'password') {
    pwd.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
  } else {
    pwd.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
  }
}
</script>
</body>
</html>
