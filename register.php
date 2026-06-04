<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="asset/img/logo guruverse FA.ai.png"/>
<title>Guruverse.id — Daftar Anggota</title>

<!-- 1. React -->
<script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

<!-- 2. Lucide Icons -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

<!-- 3. Babel Standalone — WAJIB sebelum script type="text/babel" -->
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

<!-- 4. Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;0,900;1,600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet"/>

<style>
:root{
  --ink:#0f0c29;
  --deep:#1a1560;
  --purple:#6d28d9;
  --violet:#7c3aed;
  --accent:#a78bfa;
  --sky:#38bdf8;
  --nav-h:64px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html,body{min-height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:var(--ink);color:#fff;overflow-x:hidden;overflow-y:auto;}
body::-webkit-scrollbar{display:none;}
.mono{font-family:'JetBrains Mono',monospace;}

/* starfield */
.sf{position:fixed;inset:0;z-index:0;pointer-events:none;
  background:radial-gradient(ellipse at 20% 50%,rgba(109,40,217,.22) 0%,transparent 55%),
  radial-gradient(ellipse at 80% 20%,rgba(55,48,163,.28) 0%,transparent 50%),
  linear-gradient(135deg,#0f0c29 0%,#1a1560 50%,#0f0c29 100%);}
.star{position:absolute;border-radius:50%;background:#fff;animation:twinkle var(--d,3s) ease-in-out infinite var(--delay,0s);}

@keyframes twinkle{0%,100%{opacity:var(--op,.5);transform:scale(1)}50%{opacity:.08;transform:scale(.4)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-9px)}}
@keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.2}}
@keyframes orbit{from{transform:rotate(0deg) translateX(var(--r)) rotate(0deg)}to{transform:rotate(360deg) translateX(var(--r)) rotate(-360deg)}}
@keyframes pring{0%{transform:translate(-50%,-50%) scale(.9);opacity:.6}70%,100%{transform:translate(-50%,-50%) scale(1.2);opacity:0}}
@keyframes flipIn{from{transform:rotateY(90deg);opacity:0}to{transform:rotateY(0deg);opacity:1}}

.fu{animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both}
.fu1{animation:fadeUp .6s .08s cubic-bezier(.22,1,.36,1) both}
.fu2{animation:fadeUp .6s .16s cubic-bezier(.22,1,.36,1) both}
.fu3{animation:fadeUp .6s .24s cubic-bezier(.22,1,.36,1) both}
.skel{background:linear-gradient(90deg,rgba(255,255,255,.05) 25%,rgba(255,255,255,.11) 50%,rgba(255,255,255,.05) 75%);background-size:200% 100%;animation:shimmer 1.4s infinite;border-radius:5px;}
.sp{display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.25);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
.bl{animation:blink 1.3s ease-in-out infinite;}

/* NAV */
.nav{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;padding:0 2.5rem;background:rgba(15,12,41,.82);backdrop-filter:blur(18px);border-bottom:1px solid rgba(255,255,255,.07);}
.nav-logo{display:flex;align-items:center;gap:9px;text-decoration:none;}
.nav-logo img{height:34px;object-fit:contain;}
.nav-logo span{font-weight:900;font-size:.95rem;color:#fff;letter-spacing:-.02em;}
.nav-links{display:flex;gap:2rem;list-style:none;}
.nav-links a{font-size:.83rem;font-weight:600;color:rgba(255,255,255,.6);text-decoration:none;transition:color .2s;position:relative;padding-bottom:3px;}
.nav-links a:hover,.nav-links a.on{color:#fff;}
.nav-links a.on::after{content:'';position:absolute;bottom:0;left:0;right:0;height:1.5px;background:var(--accent);border-radius:2px;}
.nav-cta{background:var(--violet);color:#fff;border:none;padding:.46rem 1.2rem;border-radius:2rem;font-weight:700;font-size:.8rem;cursor:pointer;font-family:inherit;box-shadow:0 4px 14px rgba(124,58,237,.4);transition:opacity .2s;}
.nav-cta:hover{opacity:.85;}

/* PAGE LAYOUT */
.page{position:relative;z-index:1;min-height:100vh;display:grid;grid-template-rows:var(--nav-h) 1fr;}
.page-body{display:grid;grid-template-columns:1fr 200px 400px;gap:1.5rem;align-items:center;max-width:1320px;margin:0 auto;padding:0 2.5rem;width:100%;overflow:hidden;}

/* LEFT HERO */
.hleft{display:flex;flex-direction:column;gap:.85rem;}
.badge{display:inline-flex;align-items:center;gap:.4rem;background:rgba(167,139,250,.12);border:1px solid rgba(167,139,250,.28);border-radius:2rem;padding:.28rem .8rem;font-size:.62rem;font-weight:700;color:var(--accent);letter-spacing:.1em;text-transform:uppercase;width:fit-content;}
.h1{font-size:clamp(1.6rem,2.5vw,2.6rem);font-weight:900;line-height:1.07;letter-spacing:-.04em;color:#fff;}
.h1 .gr{background:linear-gradient(135deg,var(--accent),var(--sky));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.sub{font-size:.82rem;font-weight:500;color:rgba(255,255,255,.55);line-height:1.65;max-width:380px;}
.pillars{display:flex;flex-direction:column;gap:.4rem;}
.pillar{display:flex;align-items:center;gap:.7rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:.75rem;padding:.5rem .85rem;transition:border-color .2s;}
.pillar:hover{border-color:rgba(167,139,250,.25);}
.pdot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
.pillar p{font-size:.78rem;font-weight:700;color:rgba(255,255,255,.8);}
.pillar span{font-size:.67rem;color:rgba(255,255,255,.38);display:block;margin-top:1px;}

/* COSMOS */
.cosmos-wrap{display:flex;align-items:center;justify-content:center;animation:float 5s ease-in-out infinite;}
.cosmos{position:relative;width:185px;height:185px;}
.ring{position:absolute;top:50%;left:50%;border-radius:50%;border:1px solid rgba(255,255,255,.08);}
.r1{width:90px;height:90px;margin:-45px 0 0 -45px;}
.r2{width:135px;height:135px;margin:-67.5px 0 0 -67.5px;}
.r3{width:185px;height:185px;margin:-92.5px 0 0 -92.5px;}
.core{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:58px;height:58px;border-radius:50%;background:linear-gradient(135deg,var(--violet),var(--deep));box-shadow:0 0 28px rgba(124,58,237,.6),inset -6px -6px 14px rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center;}
.pring{position:absolute;top:50%;left:50%;border-radius:50%;border:1.5px solid rgba(124,58,237,.4);animation:pring 2.5s ease-out infinite;}
.orb-track{position:absolute;top:50%;left:50%;width:0;height:0;}
.orb{border-radius:50%;display:flex;align-items:center;justify-content:center;position:absolute;transform:translate(-50%,-50%);}
.lbl{position:absolute;white-space:nowrap;background:rgba(255,255,255,.06);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.1);border-radius:6px;padding:.2rem .5rem;font-size:.52rem;font-weight:700;color:rgba(255,255,255,.7);}

/* FORM PANEL */
.panel{background:rgba(255,255,255,.04);backdrop-filter:blur(22px);border:1px solid rgba(255,255,255,.1);border-radius:1.5rem;padding:1.4rem 1.45rem;display:flex;flex-direction:column;gap:.7rem;box-shadow:0 24px 70px rgba(0,0,0,.45),inset 0 1px 0 rgba(255,255,255,.09);max-height:calc(100vh - var(--nav-h) - 20px);overflow-y:auto;align-self:center;}
.panel::-webkit-scrollbar{display:none;}
.ptitle{font-size:1rem;font-weight:900;letter-spacing:-.02em;}
.psub{font-size:.7rem;color:rgba(255,255,255,.45);margin-top:.06rem;}
.fg{display:flex;flex-direction:column;gap:.22rem;}
.fg label{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.38);}
.fi-wrap{position:relative;}
.fico{position:absolute;left:.72rem;top:50%;transform:translateY(-50%);display:flex;align-items:center;color:rgba(255,255,255,.28);pointer-events:none;}
.fi{width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:.75rem;padding:.64rem .9rem .64rem 2.35rem;font-family:inherit;font-size:.87rem;font-weight:600;color:#fff;outline:none;transition:border-color .2s,background .2s;-webkit-appearance:none;}
.fi:focus{border-color:var(--accent);background:rgba(167,139,250,.07);}
.fi::placeholder{color:rgba(255,255,255,.2);font-weight:500;}
.btn{background:linear-gradient(135deg,var(--violet),var(--purple));color:#fff;border:none;cursor:pointer;font-family:inherit;font-weight:800;border-radius:.85rem;padding:.82rem 1.4rem;width:100%;font-size:.9rem;letter-spacing:.02em;box-shadow:0 6px 20px rgba(124,58,237,.35);transition:opacity .2s,transform .1s;}
.btn:hover{opacity:.88;}
.btn:active{transform:scale(.98);}
.btn:disabled{opacity:.35;cursor:not-allowed;}
.btn-sm{display:inline-flex;align-items:center;gap:4px;padding:.36rem .78rem;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;cursor:pointer;font-family:inherit;border-radius:7px;transition:all .15s;white-space:nowrap;border:none;}
.photo-box{width:66px;height:66px;border-radius:.9rem;flex-shrink:0;border:1.5px dashed rgba(255,255,255,.18);overflow:hidden;cursor:pointer;background:rgba(255,255,255,.04);position:relative;display:flex;align-items:center;justify-content:center;transition:border-color .2s,box-shadow .2s;}
.photo-box.has{border-color:var(--accent);box-shadow:0 0 0 3px rgba(167,139,250,.14);}
.pbar{position:absolute;bottom:0;left:0;right:0;background:rgba(109,40,217,.85);padding:2px;display:flex;justify-content:center;}
.err-box{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:.7rem;padding:.5rem .8rem;display:flex;gap:.4rem;align-items:flex-start;font-size:.76rem;font-weight:600;color:#fca5a5;}

/* KARTU PAGE */
.kpage{position:relative;z-index:1;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:calc(var(--nav-h) + 1rem) 1rem 1.5rem;gap:.75rem;overflow-y:auto;}
.kpage::-webkit-scrollbar{display:none;}
.ktopbar{display:flex;align-items:center;justify-content:space-between;width:100%;max-width:460px;}

/* CARD SHELL */
.cshell{position:relative;width:100%;aspect-ratio:1.586/1;border-radius:1.5rem;overflow:hidden;background:var(--deep);box-shadow:0 24px 60px rgba(0,0,0,.65),0 0 0 1px rgba(255,255,255,.07);}
.cin{position:relative;z-index:10;height:100%;display:flex;flex-direction:column;padding:1.3rem 1.5rem;}

/* FLIP CARD */
.flip-scene{width:100%;max-width:460px;perspective:1200px;}
.flip-card{position:relative;width:100%;aspect-ratio:1.586/1;transform-style:preserve-3d;transition:transform .7s cubic-bezier(.4,0,.2,1);}
.flip-card.flipped{transform:rotateY(180deg);}
.face{position:absolute;inset:0;backface-visibility:hidden;-webkit-backface-visibility:hidden;border-radius:1.5rem;overflow:hidden;}
.face-back{transform:rotateY(180deg);}

/* INFO BOX */
.infobox{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:1.1rem;padding:.85rem 1.1rem;display:grid;grid-template-columns:1fr 1fr;gap:.75rem;font-size:.7rem;width:100%;max-width:460px;}

/* BACK CARD details */
.back-row{display:flex;flex-direction:column;gap:2px;margin-bottom:8px;}
.back-lbl{font-size:5.5px;text-transform:uppercase;letter-spacing:.22em;color:rgba(255,255,255,.38);font-weight:700;}
.back-val{font-size:.72rem;font-weight:700;color:#fff;line-height:1.25;}

/* ADMIN */
.adm{min-height:100vh;background:transparent;position:relative;z-index:1;padding:calc(var(--nav-h) + 1.5rem) 1.5rem 2rem;}
.adm::-webkit-scrollbar{width:8px;}
.adm::-webkit-scrollbar-track{background:rgba(255,255,255,.02);}
.adm::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:10px;}
.adm::-webkit-scrollbar-thumb:hover{background:rgba(255,255,255,.2);}
.adm-inner{max-width:1000px;margin:0 auto;display:flex;flex-direction:column;gap:1.2rem;}
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:.85rem;}
.sc{border-radius:1.1rem;padding:.9rem 1.1rem;display:flex;align-items:center;gap:11px;}
.tbl-card{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:1.1rem;overflow:hidden;}
table{width:100%;border-collapse:collapse;font-size:.78rem;min-width:580px;}
th{padding:.7rem .9rem;text-align:left;font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.3);border-bottom:1px solid rgba(255,255,255,.06);}
td{padding:.72rem .9rem;border-bottom:1px solid rgba(255,255,255,.04);}
tr:last-child td{border-bottom:none;}
tr:hover td{background:rgba(109,40,217,.07);}
.fi-search{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);border-radius:.75rem;padding:.6rem .6rem .6rem 2.3rem;font-family:inherit;font-weight:600;font-size:.83rem;outline:none;color:#fff;flex:1;min-width:150px;-webkit-appearance:none;}
.fi-search::placeholder{color:rgba(255,255,255,.25);}
.fi-search:focus{border-color:var(--accent);}

/* OVERLAY / MODAL */
.overlay{position:fixed;inset:0;z-index:300;background:rgba(0,0,0,.72);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:1rem;}
.modal{background:rgba(20,16,50,.97);border:1px solid rgba(255,255,255,.1);backdrop-filter:blur(20px);border-radius:1.5rem;overflow:hidden;width:100%;max-width:360px;box-shadow:0 32px 80px rgba(0,0,0,.55);animation:fadeUp .35s cubic-bezier(.22,1,.36,1) both;}

/* PRINT */
@media print{
  .noprint{display:none!important;}
  body{background:#fff!important;overflow:auto!important;}
  .sf,.nav{display:none!important;}
  .kpage{padding:0!important;justify-content:flex-start!important;height:auto!important;min-height:auto!important;}
  .ktopbar,.infobox,.flip-btns{display:none!important;}
  .flip-scene{max-width:100%!important;}
  .flip-card{transform:none!important;aspect-ratio:1.586/1!important;position:relative!important;}
  .face-back{display:none!important;}
  .face{position:relative!important;-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;}
}

@media(max-width:900px){
  .nav-links{display:none;}
  .page-body{grid-template-columns:1fr;overflow-y:auto;padding:1.25rem;}
  html,body{overflow:auto;height:auto;}
  .page{overflow:auto;height:auto;}
  .cosmos-wrap{display:none;}
  .stats{grid-template-columns:1fr 1fr;}
}

/* DASHBOARD STYLES */
.dash-container{background:#f8fafc;color:#1e293b;min-height:100vh;position:relative;z-index:200;display:flex;flex-direction:column;animation:fadeUp .5s ease-out;}
.dash-header{height:64px;padding:0 5%;display:flex;align-items:center;justify-content:space-between;background:#fff;border-bottom:1px solid #f1f5f9;position:sticky;top:0;z-index:10;}
.dash-logo{display:flex;align-items:center;gap:10px;}
.dash-logo img{height:32px;}
.dash-logo span{font-weight:800;font-size:1rem;color:#0f172a;}
.dash-actions{display:flex;gap:12px;}
.dash-btn-card{display:flex;align-items:center;gap:8px;background:#fff;border:1px solid #3b82f6;color:#3b82f6;padding:.5rem 1.1rem;border-radius:10px;font-weight:700;font-size:.85rem;cursor:pointer;transition:all .2s;}
.dash-btn-card:hover{background:#3b82f6;color:#fff;}
.dash-btn-out{display:flex;align-items:center;gap:8px;background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;padding:.5rem 1.1rem;border-radius:10px;font-weight:700;font-size:.85rem;cursor:pointer;transition:all .2s;}
.dash-btn-out:hover{background:#f1f5f9;color:#0f172a;}

.dash-main{flex:1;max-width:1200px;margin:0 auto;width:100%;padding:2rem 5% 4rem;display:flex;flex-direction:column;gap:2.5rem;}

.dash-hero{display:grid;grid-template-columns:1fr 380px;gap:2rem;align-items:center;background:linear-gradient(to right,#eff6ff,#fff);border-radius:2rem;padding:2.2rem 3rem;position:relative;overflow:hidden;}
.dash-greeting{font-size:2.2rem;font-weight:900;color:#0f172a;line-height:1.1;margin-bottom:0.8rem;}
.dash-greeting-line{width:50px;height:4px;background:#3b82f6;border-radius:2px;margin-bottom:1.2rem;}
.dash-sub{font-size:.9rem;color:#64748b;line-height:1.6;max-width:380px;}
.dash-hero-img{position:relative;display:flex;justify-content:center;}
.dash-hero-img img{width:100%;max-width:280px;z-index:2;filter:drop-shadow(0 20px 40px rgba(0,0,0,.1));}
.dash-floating-icon{position:absolute;background:#fff;width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 24px rgba(0,0,0,.08);z-index:3;animation:float 4s ease-in-out infinite;}
.fi-1{top:10%;left:-5%;color:#3b82f6;animation-delay:0s;}
.fi-2{bottom:15%;right:-5%;color:#f59e0b;animation-delay:1s;}

.dash-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;}
.dash-p-card{background:#fff;border-radius:2rem;padding:1.2rem;display:flex;flex-direction:column;gap:1.2rem;border:1px solid #f1f5f9;transition:all .3s cubic-bezier(0.4, 0, 0.2, 1);cursor:pointer;}
.dash-p-card:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,.05);border-color:#e2e8f0;}
.dash-p-visual{height:160px;border-radius:1.5rem;overflow:hidden;display:flex;align-items:center;justify-content:center;}
.dash-p-visual img{height:85%;object-fit:contain;transition:transform .5s;}
.dash-p-card:hover .dash-p-visual img{transform:scale(1.1) translateY(-5px);}
.dash-p-content{padding:0 .5rem;}
.dash-p-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;}
.dash-p-title{font-size:1.4rem;font-weight:800;color:#0f172a;}
.dash-p-desc{font-size:.9rem;color:#64748b;line-height:1.6;margin-bottom:1.8rem;min-height:3em;}
.dash-p-btn{display:inline-flex;align-items:center;gap:8px;color:#fff;text-decoration:none;font-weight:800;font-size:.9rem;padding:.8rem 1.8rem;border-radius:12px;transition:opacity .2s;box-shadow:0 8px 20px rgba(0,0,0,.1);}
.dash-p-btn:hover{opacity:.9;}

.dash-help{background:#ecfdf5;border-radius:2rem;padding:1.5rem 3rem;display:flex;justify-content:space-between;align-items:center;overflow:hidden;position:relative;border:1px solid #d1fae5;}
.dash-help-left{display:flex;align-items:center;gap:1.5rem;}
.dash-wa-icon{width:64px;height:64px;background:#10b981;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 24px rgba(16,185,129,.3);}
.dash-help-title{font-size:1.3rem;font-weight:900;color:#064e3b;margin-bottom:1px;}
.dash-help-sub{font-size:.85rem;color:#059669;font-weight:600;}
.dash-wa-num{font-size:1.5rem;font-weight:900;color:#10b981;margin-top:2px;}

@media(max-width:1000px){
  .dash-hero{grid-template-columns:1fr;padding:2rem;}
  .dash-hero-img{display:none;}
  .dash-greeting{font-size:2rem;}
  .dash-help{flex-direction:column;text-align:center;gap:2rem;padding:2rem;}
  .dash-help-left{flex-direction:column;gap:1rem;}
  .dash-help-right{display:none;}
}
</style>
</head>
<body>
<div class="sf" id="sf"></div>
<div id="root"></div>

<!-- Starfield generator -->
<script>
(function(){
  const sf=document.getElementById('sf');
  const n=window.innerWidth<600?50:110;
  for(let i=0;i<n;i++){
    const s=document.createElement('div');s.className='star';
    const sz=Math.random()*2.2+.4;
    s.style.cssText=`width:${sz}px;height:${sz}px;top:${Math.random()*100}%;left:${Math.random()*100}%;--d:${(Math.random()*4+2).toFixed(1)}s;--delay:${(Math.random()*6).toFixed(1)}s;--op:${(Math.random()*.6+.15).toFixed(2)};`;
    sf.appendChild(s);
  }
})();
</script>

<!-- 5. Load JSX dari file eksternal (Babel sudah siap di atas) -->
<script type="text/babel" src="my-script.js?v=<?= time() ?>"></script>

</body>
</html>

