<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('asset/img/logo guruverse FA.ai.png') }}"/>
<title>Daftar — Guruverse.id</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,600&display=swap" rel="stylesheet"/>
<style>
:root{--ink:#0f0c29;--deep:#1a1560;--purple:#6d28d9;--violet:#7c3aed;--accent:#a78bfa;--sky:#38bdf8;--nav-h:65px;}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html,body{height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:var(--ink);color:#fff;overflow:hidden;}

.sf{position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(ellipse at 20% 50%,rgba(109,40,217,.22) 0%,transparent 55%),radial-gradient(ellipse at 80% 20%,rgba(55,48,163,.28) 0%,transparent 50%),linear-gradient(135deg,#0f0c29 0%,#1a1560 50%,#0f0c29 100%);}
.star{position:absolute;border-radius:50%;background:#fff;animation:twinkle var(--d,3s) ease-in-out infinite var(--delay,0s);}
@keyframes twinkle{0%,100%{opacity:var(--op,.5);transform:scale(1)}50%{opacity:.08;transform:scale(.4)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

/* Container */
.page-wrap { width: 100%; height: 100vh; overflow: hidden; position: relative; z-index: 1;}
.page-wrap::-webkit-scrollbar { display: none; }

.page-body{
  display:grid;grid-template-columns:1.2fr 420px;gap:7rem;max-width:1250px;margin:0 auto;
  padding: calc(var(--nav-h) + 2rem) 2rem 3rem; align-items: center; min-height: 100%;
}

.nav{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;padding:0 3rem;background:rgba(15,12,41,.82);backdrop-filter:blur(18px);border-bottom:1px solid rgba(255,255,255,.07);}
.nav-logo{display:flex;align-items:center;gap:12px;text-decoration:none;transition:opacity 0.2s;}
.nav-logo:hover{opacity:0.85;}
.nav-logo img{height:30px;object-fit:contain;}

.nav-links{display:flex;align-items:center;gap:2.5rem;transform:translateX(-3rem);}
.nav-links a{color:rgba(255,255,255,.75);text-decoration:none;font-size:.9rem;font-weight:600;transition:color 0.2s;}
.nav-links a:hover{color:var(--sky);}

.hleft{display:flex;flex-direction:column;gap:1.5rem;animation:fadeUp .8s cubic-bezier(.22,1,.36,1) both;}
.hero-top{display:flex;align-items:center;gap:1rem;justify-content:space-between;}
.hero-text{display:flex;flex-direction:column;gap:.8rem;flex:1;}
.badge{display:inline-flex;align-items:center;gap:.4rem;background:rgba(167,139,250,.12);border:1px solid rgba(167,139,250,.28);border-radius:2rem;padding:.3rem .8rem;font-size:.65rem;font-weight:700;color:var(--accent);letter-spacing:.05em;text-transform:uppercase;width:fit-content;}
.h1{font-size:clamp(1.7rem,2.5vw,2.4rem);font-weight:900;line-height:1.2;letter-spacing:-.03em;}
.h1 .gr{background:linear-gradient(135deg,var(--accent),var(--sky));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.sub{font-size:.85rem;font-weight:500;color:rgba(255,255,255,.65);line-height:1.5;max-width:95%;}

/* COSMOS */
.cosmos-wrap{display:flex;align-items:center;justify-content:center;animation:float 5s ease-in-out infinite;flex-shrink:0;}
.cosmos{position:relative;width:150px;height:150px;}
.ring{position:absolute;top:50%;left:50%;border-radius:50%;border:1px solid rgba(255,255,255,.08);}
.r1{width:76px;height:76px;margin:-38px 0 0 -38px;}
.r2{width:114px;height:114px;margin:-57px 0 0 -57px;}
.r3{width:150px;height:150px;margin:-75px 0 0 -75px;}
.core{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--violet),var(--deep));box-shadow:0 0 28px rgba(124,58,237,.6),inset -6px -6px 14px rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center;}
.pring{position:absolute;top:50%;left:50%;border-radius:50%;border:1.5px solid rgba(124,58,237,.4);animation:pring 2.5s ease-out infinite;}
.orb-track{position:absolute;top:50%;left:50%;width:0;height:0;}
.orb{border-radius:50%;display:flex;align-items:center;justify-content:center;position:absolute;transform:translate(-50%,-50%);}
.lbl{position:absolute;white-space:nowrap;background:rgba(255,255,255,.06);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.1);border-radius:6px;padding:.15rem .4rem;font-size:.5rem;font-weight:700;color:rgba(255,255,255,.7);}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-9px)}}
@keyframes pring{0%{transform:translate(-50%,-50%) scale(.9);opacity:.6}70%,100%{transform:translate(-50%,-50%) scale(1.2);opacity:0}}
@keyframes orbit{from{transform:rotate(0deg) translateX(var(--r)) rotate(0deg)}to{transform:rotate(360deg) translateX(var(--r)) rotate(-360deg)}}

.pillars{display:flex;flex-direction:column;gap:.6rem;}
.pillar{display:flex;align-items:center;gap:.8rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:.8rem;padding:.6rem 1rem;transition:transform 0.2s, background 0.2s;}
.pillar:hover{transform:translateX(5px);background:rgba(255,255,255,.06);}
.pdot{width:8px;height:8px;border-radius:50%;flex-shrink:0;box-shadow:0 0 10px currentColor;}
.pillar p{font-size:.8rem;font-weight:700;color:rgba(255,255,255,.9);margin-bottom:0.1rem;}
.pillar span{font-size:.65rem;color:rgba(255,255,255,.5);}

.panel{background:rgba(255,255,255,.04);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.12);border-radius:1.2rem;padding:1.6rem 1.8rem;box-shadow:0 24px 80px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.15);animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both;align-self:center; width: 100%;}
.ptitle{font-size:1.25rem;font-weight:800;letter-spacing:-.02em;margin-bottom:.2rem;}
.psub{font-size:.8rem;color:rgba(255,255,255,.55);margin-bottom:1.4rem;}
.fg{display:flex;flex-direction:column;gap:.3rem;margin-bottom:.8rem;}
.fg label{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(255,255,255,.6);}

.fi-wrap{position:relative;transition:transform .3s cubic-bezier(.4,0,.2,1);}
.fi-wrap:focus-within{transform:translateY(-2px);}
.fico{position:absolute;left:.8rem;top:50%;transform:translateY(-50%);display:flex;align-items:center;color:rgba(255,255,255,.35);pointer-events:none;transition:all .3s ease;}
.fico svg{width:15px;height:15px;}
.fi-wrap:focus-within .fico{color:var(--accent);transform:translateY(-50%) scale(1.1);}
.fi{width:100%;background:rgba(0,0,0,.2);border:1px solid rgba(255,255,255,.12);border-radius:.6rem;padding:.6rem .8rem .6rem 2.4rem;font-family:inherit;font-size:.8rem;font-weight:500;color:#fff;outline:none;transition:all .3s cubic-bezier(.4,0,.2,1);}
.fi:hover{background:rgba(255,255,255,.03);border-color:rgba(255,255,255,.25);}
.fi:focus{border-color:var(--accent);background:rgba(0,0,0,.3);box-shadow:0 0 0 4px rgba(167,139,250,.2);}
.fi::placeholder{color:rgba(255,255,255,.3);}
.fi.is-invalid{border-color:#ef4444;background:rgba(239,68,68,.05);}
.err{font-size:.7rem;color:#fca5a5;margin-top:.2rem;}

.btn{position:relative;overflow:hidden;background:linear-gradient(135deg,var(--violet),var(--purple));color:#fff;border:none;cursor:pointer;font-family:inherit;font-weight:700;border-radius:.6rem;padding:.75rem 1.2rem;width:100%;font-size:.85rem;letter-spacing:0.02em;box-shadow:0 6px 20px rgba(124,58,237,.4);transition:all .3s ease;margin-top:.4rem;}
.btn::after{content:'';position:absolute;top:0;left:-100%;width:50%;height:100%;background:linear-gradient(to right,transparent,rgba(255,255,255,.2),transparent);transform:skewX(-20deg);transition:0.6s ease;}
.btn:hover::after{left:120%;}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(124,58,237,.6);}
.btn:active{transform:translateY(1px);}
.link-row{text-align:center;font-size:.75rem;color:rgba(255,255,255,.55);margin-top:1rem;}
.link-row a{color:var(--accent);font-weight:700;text-decoration:none;transition:color 0.2s;}
.link-row a:hover{color:#fff;}
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:.8rem;}

@media(max-width:900px){
  html,body{height:auto;overflow:auto;}
  .page-wrap{height:auto;overflow:auto;}
  .page-body{grid-template-columns:1fr;gap:2rem;padding:calc(var(--nav-h) + 1.5rem) 1.5rem 2rem;align-items:start;}
  .nav-links{display:none;}
  .hleft{align-items:center;text-align:center;}
  .hero-top{flex-direction:column;}
  .sub{max-width:100%;}
  .cosmos-wrap{align-self:center;padding-left:0;}
  .panel{padding:1.8rem 1.4rem;max-width:450px;margin:0 auto;}
  .two-col{grid-template-columns:1fr;gap:0;}
}
</style>
</head>
<body>
<div class="sf" id="sf"></div>

<nav class="nav">
  <a class="nav-logo" href="{{ url('/') }}">
    <img src="{{ asset('asset/img/FA Logo Guruverse.ID - main.png') }}" alt="Guruverse" onerror="this.style.display='none'">
  </a>
  <div class="nav-links">
    <a href="{{ url('/') }}">Beranda</a>
    <a href="{{ url('/about') }}">Tentang Kami</a>
    <a href="{{ url('/program') }}">Program</a>
  </div>
</nav>

<div class="page-wrap">
  <div class="page-body">
    <div class="hleft">
      <div class="hero-top">
        <div class="hero-text">
          <div class="badge">✦ Platform Guru #1 di Indonesia</div>
          <h1 class="h1">Bergabung dan<br><span class="gr">Berkembang Bersama</span><br>Ribuan Guru</h1>
          <p class="sub">Platform pengembangan profesional terlengkap untuk guru Indonesia.</p>
        </div>
        <div class="cosmos-wrap">
          <div class="cosmos">
            <div class="ring r1"></div>
            <div class="ring r2"></div>
            <div class="ring r3"></div>
            <div class="orb-track" style="--r:38px; animation:orbit 8s linear infinite;">
              <div class="orb" style="width:10px; height:10px; background:var(--sky); box-shadow:0 0 8px var(--sky); animation:orbit 8s linear infinite reverse;"><span class="lbl" style="left:14px">Belajar</span></div>
            </div>
            <div class="orb-track" style="--r:57px; animation:orbit 12s linear infinite;">
              <div class="orb" style="width:12px; height:12px; background:var(--accent); box-shadow:0 0 10px var(--accent); animation:orbit 12s linear infinite reverse;"><span class="lbl" style="right:18px">Inspira</span></div>
            </div>
            <div class="orb-track" style="--r:75px; animation:orbit 18s linear infinite;">
              <div class="orb" style="width:10px; height:10px; background:#fb923c; box-shadow:0 0 8px #fb923c; animation:orbit 18s linear infinite reverse;"><span class="lbl" style="left:16px">Mengajar</span></div>
            </div>
            <div class="core">
              <div class="pring"></div>
              <img src="{{ asset('asset/img/logo guruverse FA.ai.png') }}" style="width:24px; object-fit:contain; filter:brightness(0) invert(1);" alt="core"/>
            </div>
          </div>
        </div>
      </div>
  
      <div class="pillars">
        <div class="pillar"><div class="pdot" style="background:#818cf8; color:#818cf8"></div><div><p>Guru Belajar</p><span>Kelas online & modul belajar terstruktur</span></div></div>
        <div class="pillar"><div class="pdot" style="background:#fb923c; color:#fb923c"></div><div><p>Guru Inspira</p><span>Artikel inspiratif & agenda komunitas</span></div></div>
      </div>
    </div>
  
    <div class="panel">
      <div class="ptitle">Daftar Akun Baru</div>
      <div class="psub">Gratis selamanya. Mulai perjalanan belajarmu!</div>
  
      @if ($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:.8rem;padding:.8rem 1rem;font-size:.8rem;color:#fca5a5;margin-bottom:1rem;">
          <ul style="margin:0;padding-left:1.2rem;">
          @foreach ($errors->all() as $error)
            <li style="margin-bottom:0.2rem;">{{ $error }}</li>
          @endforeach
          </ul>
        </div>
      @endif
  
      <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
        @csrf
        <div class="fg">
          <label>Nama Lengkap</label>
          <div class="fi-wrap">
            <span class="fico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
            <input type="text" name="full_name" class="fi @error('full_name') is-invalid @enderror" placeholder="Nama lengkap Anda" value="{{ old('full_name') }}" required/>
          </div>
          @error('full_name')<div class="err">{{ $message }}</div>@enderror
        </div>
  
        <div class="two-col">
          <div class="fg">
            <label>Username</label>
            <div class="fi-wrap">
              <span class="fico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"/></svg></span>
              <input type="text" name="username" class="fi @error('username') is-invalid @enderror" placeholder="username_kamu" value="{{ old('username') }}" required/>
            </div>
            @error('username')<div class="err">{{ $message }}</div>@enderror
          </div>
          <div class="fg">
            <label>WhatsApp</label>
            <div class="fi-wrap">
              <span class="fico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.1 3.26 2 2 0 0 1 3.1 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16z"/></svg></span>
              <input type="text" name="phone" class="fi @error('phone') is-invalid @enderror" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required/>
            </div>
            @error('phone')<div class="err">{{ $message }}</div>@enderror
          </div>
        </div>
  
        <div class="fg">
          <label>Instansi (opsional)</label>
          <div class="fi-wrap">
            <span class="fico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
            <input type="text" name="institution" class="fi" placeholder="Nama instansi" value="{{ old('institution') }}" />
          </div>
        </div>
  
        <div class="two-col">
          <div class="fg">
            <label>Kata Sandi</label>
            <div class="fi-wrap">
              <span class="fico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
              <input type="password" name="password" class="fi @error('password') is-invalid @enderror" placeholder="Min. 8" required/>
            </div>
            @error('password')<div class="err">{{ $message }}</div>@enderror
          </div>
          <div class="fg">
            <label>Konfirmasi Sandi</label>
            <div class="fi-wrap">
              <span class="fico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
              <input type="password" name="password_confirmation" class="fi" placeholder="Ulangi sandi" required/>
            </div>
          </div>
        </div>
  
        <button type="submit" class="btn">Buat Akun Gratis &rarr;</button>
      </form>
      <div class="link-row">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></div>
    </div>
  </div>
</div>

<script>
(function(){const sf=document.getElementById('sf');for(let i=0;i<60;i++){const s=document.createElement('div');s.className='star';const sz=Math.random()*2+.5;s.style.cssText=`width:${sz}px;height:${sz}px;top:${Math.random()*100}%;left:${Math.random()*100}%;--d:${(Math.random()*4+2).toFixed(1)}s;--delay:${(Math.random()*6).toFixed(1)}s;--op:${(Math.random()*.5+.2).toFixed(2)};`;sf.appendChild(s);}})();
</script>
</body>
</html>
