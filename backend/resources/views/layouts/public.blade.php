<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guruverse.ID &mdash; Semesta Kompetensi Guru Indonesia</title>
<meta name="description" content="Guruverse.ID adalah ruang semesta bagi guru Indonesia untuk terhubung, bertumbuh, dan menjadi lebih kompeten bersama.">
<link rel="icon" type="image/png" href="{{ asset('asset/img/logo guruverse FA.ai.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script>
  (function(){
    var saved = localStorage.getItem('guruverse_theme');
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  })();
</script>
<style>
/* ========================
   RESET & BASE
======================== */
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:#0a0820;color:#fff;min-height:100vh}
a{text-decoration:none;}

/* ========================
   CSS VARIABLES
======================== */
:root{
  --purple:#7c3aed;
  --purple-dark:#6d28d9;
  --purple-light:#a78bfa;
  --purple-faint:#1e1560;
  --navy:#0a0820;
  --navy2:#0f0c2e;
  --navy3:#13103a;
  --navy4:#1a1242;
  --primary-dark:#5b21b6;
  --secondary:#a78bfa;
  --secondary-dark:#7c3aed;
  --border:rgba(124,58,237,.18);
  --text-muted:#9b93d4;
  --text-dim:#6b63a8;

  /* Semantic bindings for Dark Mode */
  --bg: var(--navy);
  --card: var(--navy3);
  --text: #ffffff;
  --primary: var(--purple);
}

/* ── Light Mode ── */
[data-theme="light"] {
  --primary: #093C5D;
  --primary-dark: #062c45;
  --primary-light: #357A9E;
  --secondary: #76D4E2;
  --secondary-dark: #2d93a4;
  --bg: #F5F8FA;
  --border: #D2E3EB;
  --text: #092B40;
  --text-muted: #3D6175;
  --glass: rgba(255,255,255,0.85);
  --glass-border: rgba(9,60,93,0.15);
}
[data-theme="light"] body {
  background: var(--bg);
  color: var(--text);
}
[data-theme="light"] .navbar { background: #093C5D !important; border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important; }
[data-theme="light"] .nav-link { color: rgba(255, 255, 255, 0.75) !important; }
[data-theme="light"] .nav-link:hover { color: #ffffff !important; background: rgba(255, 255, 255, 0.1) !important; }
[data-theme="light"] .nav-mobile { background: #ffffff !important; border-color: var(--border) !important; }
[data-theme="light"] .hero { background: linear-gradient(135deg, #EEF2FF 0%, var(--bg) 100%); }
[data-theme="light"] .hero-title { color: var(--primary) !important; }
[data-theme="light"] .hero-subtitle { color: var(--text) !important; }
[data-theme="light"] .hero-eyebrow { color: var(--secondary) !important; }
[data-theme="light"] .pillars { background: #E0E7FF; }
[data-theme="light"] .section-title { color: var(--primary); }
[data-theme="light"] .section-subtitle { color: var(--text-muted); }
[data-theme="light"] .pillar-card { background: #ffffff; border-color: var(--border); }
[data-theme="light"] .pillar-title { color: var(--primary); }
[data-theme="light"] .pillar-desc { color: var(--text-muted); }
[data-theme="light"] .stats { background: #ffffff; border-color: var(--border); }
[data-theme="light"] .stat { border-color: var(--border); }
[data-theme="light"] .stat-num { color: var(--primary); }
[data-theme="light"] .stat-lbl { color: var(--text-muted); }
[data-theme="light"] .content-section { background: var(--bg); }
[data-theme="light"] .content-section.alt { background: #ffffff; }
[data-theme="light"] .content-section.dark { background: #1E1B4B; }
[data-theme="light"] .sec-title { color: var(--primary); }
[data-theme="light"] .sec-desc { color: var(--text-muted); }
[data-theme="light"] .feat-card { background: #ffffff; border-color: var(--border); }
[data-theme="light"] .fc-name { color: var(--primary); }
[data-theme="light"] .fc-sub, [data-theme="light"] .fc-desc { color: var(--text-muted); }
[data-theme="light"] .course-card { background: #ffffff; border-color: var(--border); }
[data-theme="light"] .cc-title { color: var(--primary) !important; }
[data-theme="light"] .story-card { background: #ffffff; border-color: var(--border); }
[data-theme="light"] .st-title { color: var(--primary) !important; }
[data-theme="light"] .st-name { color: var(--text) !important; }
[data-theme="light"] .detail-navbar { background: #093C5D !important; border-color: rgba(255, 255, 255, 0.15) !important; }
[data-theme="light"] .detail-navbar .nav-link { color: rgba(255, 255, 255, 0.75) !important; }
[data-theme="light"] .detail-navbar .nav-link:hover { color: #ffffff !important; background: rgba(255, 255, 255, 0.1) !important; }
[data-theme="light"] .detail-hero { background: linear-gradient(135deg, #EEF2FF 0%, var(--bg) 100%); }
[data-theme="light"] .detail-title { color: var(--primary); }
[data-theme="light"] .detail-subtitle { color: var(--text-muted); }
[data-theme="light"] .detail-quote { background: rgba(9, 60, 93, 0.08) !important; border-left-color: var(--primary) !important; }
[data-theme="light"] .detail-quote span { color: var(--text) !important; }
[data-theme="light"] .footer { background: #093C5D !important; border-top: 1px solid rgba(255, 255, 255, 0.15) !important; }
[data-theme="light"] .hero-features{background:rgba(255,255,255,0.84);border-color:rgba(9,60,93,0.08);box-shadow:0 28px 80px rgba(15,23,42,.08);}
[data-theme="light"] .feature-card{background:#ffffff;border-color:rgba(15,23,42,.08);box-shadow:0 24px 64px rgba(15,23,42,.08);}
[data-theme="light"] .feature-card-title{color:#111;}
[data-theme="light"] .feature-card-desc{color:#475569;}
[data-theme="light"] .footer-logo { color: #ffffff !important; }
[data-theme="light"] .footer-addr { color: rgba(255, 255, 255, 0.7) !important; }
[data-theme="light"] .footer-copy { color: rgba(255, 255, 255, 0.5) !important; border-top-color: rgba(255, 255, 255, 0.15) !important; }
[data-theme="light"] .fpost { background: var(--bg); border-color: var(--border); }
[data-theme="light"] .fp-name { color: var(--primary); }
[data-theme="light"] .fp-q { color: var(--text); }
[data-theme="light"] .cta-banner { background: #1E1B4B; }

/* Smooth theme transitions */
*, *::before, *::after {
  transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
}
.navbar, .nav-link, .nav-cta, .pillar-card, .feat-card, .course-card {
  transition: all 0.2s ease;
}

/* Dark mode toggle button */
.theme-toggle-btn {
  width: 34px; height: 34px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  background: rgba(255,255,255,0.07); border: 1px solid rgba(167,139,250,0.2);
  color: rgba(255,255,255,0.65); cursor: pointer; transition: all 0.2s;
  font-family: inherit;
}
.theme-toggle-btn:hover { background: rgba(124,58,237,0.2); color: #fff; border-color: rgba(167,139,250,0.45); }
.theme-toggle-btn .icon-sun { display: flex; align-items:center; justify-content:center; }
.theme-toggle-btn .icon-moon { display: none; align-items:center; justify-content:center; }
[data-theme="light"] .theme-toggle-btn .icon-sun { display: none; }
[data-theme="light"] .theme-toggle-btn .icon-moon { display: flex; }
[data-theme="light"] .theme-toggle-btn { background: rgba(124,58,237,0.08); border-color: rgba(124,58,237,0.2); color: #7c3aed; }

/* CSS Logo Swapping - No FOUC */
.logo-img-light { display: none !important; }
.logo-img-dark { display: block !important; }
[data-theme="light"] .logo-img-dark { display: none !important; }
[data-theme="light"] .logo-img-light { display: block !important; }

/* ========================
   LAYOUT
======================== */
.container{max-width:1200px;margin:0 auto;padding:0 24px}
.page{display:none}.page.on{display:block}

/* ========================
   NAVBAR
======================== */
.navbar{
  position:sticky;top:0;z-index:100;
  background:rgba(10,8,32,.95);
  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);
  border-bottom:1px solid var(--border);
  padding:0 24px;
}
.navbar-inner{
  max-width:1200px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;
  height:64px;
}
.nav-logo{font-size:20px;font-weight:900;color:#fff;letter-spacing:.04em;cursor:pointer;text-decoration:none!important;border:none!important;}
.nav-logo em{font-style:normal;color:var(--purple-light)}
.nav-links{display:flex;align-items:center;gap:6px}
.nav-link{position:relative;color:var(--text-muted);font-size:13px;font-weight:500;padding:7px 14px;border-radius:8px;cursor:pointer;transition:all .3s ease;border:none;background:none;font-family:inherit;text-decoration:none;}
.nav-link:hover{color:#fff;background:rgba(124,58,237,.12); transform:translateY(-1px);}
.nav-link.active{color:#fff !important; font-weight:800; background:rgba(255,255,255,.1);}
.nav-cta{
  background:none;border:1.5px solid var(--purple);
  color:var(--purple-light);border-radius:50px;
  padding:8px 24px;font-size:13px;font-weight:700;
  cursor:pointer;font-family:inherit;transition:all .25s;
  white-space:nowrap;
}
.nav-cta:hover{background:var(--purple);color:#fff;box-shadow:0 4px 20px rgba(124,58,237,.4)}
.nav-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:4px}
.nav-hamburger span{display:block;width:22px;height:2px;background:#a78bfa;border-radius:2px;transition:all .3s}
.nav-mobile{display:none;background:rgba(10,8,32,.98);border-top:1px solid var(--border);padding:16px 24px;flex-direction:column;gap:4px}
.nav-mobile.open{display:flex}
.nav-mobile .nav-link{text-align:left;padding:10px 14px}

/* ========================
   HERO SECTION
======================== */
.hero{
  position:relative;overflow:hidden;
  padding:84px 24px 60px;
  background:linear-gradient(135deg,var(--navy) 0%,var(--navy2) 45%,var(--bg) 100%);
}
.hero::before{
  content:'';position:absolute;inset:0;z-index:0;
  background:radial-gradient(ellipse 70% 60% at 80% 30%,rgba(124,58,237,.14) 0%,transparent 60%),
             radial-gradient(ellipse 50% 50% at 20% 70%,rgba(67,56,202,.08) 0%,transparent 60%);
}
.hero-stars{position:absolute;inset:0;z-index:0;overflow:hidden}
.hero-star{position:absolute;border-radius:50%;background:rgba(124,58,237,.24)}
.hero-inner{position:relative;z-index:1;max-width:1200px;margin:0 auto;display:grid;grid-template-columns:minmax(320px,1.02fr) minmax(320px,620px);gap:48px;align-items:center;}
.hero-text{display:flex;flex-direction:column;justify-content:center;gap:22px;}
.hero-eyebrow{font-size:12px;font-weight:800;color:var(--primary);letter-spacing:.24em;text-transform:uppercase;margin-bottom:8px;opacity:.95;}
.hero-title{font-size:clamp(36px,5vw,56px);font-weight:900;line-height:1.05;color:var(--primary);margin-bottom:16px;letter-spacing:-.04em;}
.hero-subtitle{font-size:clamp(15px,1.4vw,18px);color:var(--text-muted);line-height:1.8;max-width:520px;}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;align-items:center;}
.hero-search{display:grid;gap:18px;margin-top:8px;max-width:740px;}
.search-box{display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.96);border:1px solid rgba(9,60,93,0.12);border-radius:999px;padding:14px 18px;box-shadow:0 24px 60px rgba(15,23,42,0.08);}
.search-input{flex:1;border:none;background:transparent;color:var(--text);font-size:15px;outline:none;min-width:0;}
.search-input::placeholder{color:var(--text-muted);}
.search-btn{background:linear-gradient(135deg,var(--primary),var(--secondary));border:none;border-radius:999px;color:#fff;font-weight:700;padding:14px 26px;cursor:pointer;transition:transform .2s,box-shadow .2s;}
.search-btn:hover{transform:translateY(-1px);box-shadow:0 14px 28px rgba(9,60,93,0.18);}
.hero-tags{display:flex;flex-wrap:wrap;gap:10px;justify-content:flex-start;}
.tag-pill{padding:10px 18px;border-radius:999px;background:rgba(9,60,93,0.06);color:var(--text-muted);font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;}
.tag-pill:hover{background:rgba(9,60,93,0.12);color:var(--primary);}
.hero-image{width:clamp(340px,48vw,720px);display:flex;align-items:center;justify-content:center;}
.hero-image img{width:100%;max-width:760px;height:auto;display:block;filter:drop-shadow(0 24px 52px rgba(0,0,0,.18));transform:translateY(-8%) scale(1.22);}
.hero-features{padding:48px 24px 64px;background:rgba(10,8,32,0.88);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.08);border-radius:32px;box-shadow:0 28px 80px rgba(0,0,0,.35);margin:0 24px 40px;}
.hero-features .section-header{text-align:left;max-width:none;margin:0 0 32px;}
.hero-features .section-eyebrow{font-size:12px;font-weight:800;color:var(--primary);letter-spacing:.24em;text-transform:uppercase;margin-bottom:12px;}
.hero-features .section-title{font-size:clamp(24px,2.5vw,32px);color:var(--primary);margin-bottom:14px;}
.hero-features .section-subtitle{color:var(--text-muted);max-width:640px;margin:0;}
.feature-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;}
.feature-card{background:var(--navy3);border-radius:28px;padding:32px;box-shadow:0 24px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,.08);transition:transform .3s,box-shadow .3s;min-height:250px;display:flex;flex-direction:column;justify-content:space-between;}
.feature-card:hover{transform:translateY(-4px);box-shadow:0 34px 90px rgba(0,0,0,.45), inset 0 0 0 1px rgba(255,255,255,0.08);}
.feature-card-title{font-size:20px;font-weight:900;color:var(--text);line-height:1.2;margin-bottom:14px;}
.feature-card-desc{font-size:15px;color:var(--text-muted);line-height:1.8;flex-grow:1;}
.feature-card-link{margin-top:24px;align-self:flex-start;background:linear-gradient(135deg,var(--primary-dark),var(--primary));color:#fff;border:none;border-radius:999px;padding:12px 26px;font-weight:700;cursor:pointer;transition:transform .2s,box-shadow .2s;}
.feature-card-link:hover{transform:translateY(-1px);box-shadow:0 14px 28px rgba(9,60,93,.18);}
.btn-primary{
  background:linear-gradient(135deg,var(--primary-dark),var(--primary));
  border:none;border-radius:50px;
  padding:14px 34px;color:#fff;font-weight:800;font-size:14px;
  cursor:pointer;font-family:inherit;
  box-shadow:0 10px 32px rgba(9,60,93,.24);
  transition:all .25s;
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 14px 42px rgba(9,60,93,.28)}
.btn-secondary{
  background:#ffffff;border:1.5px solid rgba(9,60,93,.18);
  border-radius:50px;padding:14px 32px;
  color:var(--primary);font-weight:700;font-size:14px;
  cursor:pointer;font-family:inherit;transition:all .25s;
}
.btn-secondary:hover{border-color:var(--primary-dark);background:rgba(9,60,93,.05)}

/* ========================
   PILLARS SECTION
======================== */
.pillars{padding:60px 24px;background:var(--navy4)}
.section-header{text-align:center;margin-bottom:40px}
.section-title{font-size:clamp(22px,3vw,32px);font-weight:900;color:#fff;margin-bottom:10px;letter-spacing:-.02em}
.section-subtitle{font-size:clamp(13px,1.5vw,15px);color:var(--text-muted);max-width:540px;margin:0 auto;line-height:1.7}
.pillars-grid{
  max-width:1200px;margin:0 auto;
  display:grid;grid-template-columns:repeat(3,1fr);gap:20px;
}
.pillar-card{
  background:var(--navy3);border-radius:24px;
  overflow:hidden;cursor:pointer;
  border:1px solid var(--border);
  transition:transform .25s,box-shadow .25s,border-color .25s;
  display:flex; flex-direction:column; height:100%;
}
.pillar-card:hover{transform:translateY(-6px);box-shadow:0 20px 48px rgba(0,0,0,.4);border-color:rgba(124,58,237,.4)}
.pillar-img{width:100%;aspect-ratio:4/3;overflow:hidden;position:relative;flex-shrink:0;}
.pillar-img img{width:100%;height:100%;object-fit:cover;object-position:center top;transition:transform .35s}
.pillar-card:hover .pillar-img img{transform:scale(1.04)}
.pillar-body{padding:20px; display:flex; flex-direction:column; flex-grow:1;}
.pillar-title{font-size:16px;font-weight:800;color:#fff;margin-bottom:8px;letter-spacing:-.01em}
.pillar-desc{font-size:12px;color:var(--text-muted);line-height:1.65;margin-bottom:16px; flex-grow:1;}
.pillar-arrow{
  width:36px;height:36px;border-radius:50%;
  background:linear-gradient(135deg,var(--purple-dark),var(--purple));
  border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;
  margin-left:auto;box-shadow:0 4px 14px rgba(124,58,237,.4);transition:transform .2s;
  flex-shrink:0;
}
.pillar-arrow:hover{transform:scale(1.1)}

/* ========================
   DETAIL PAGES NAV
======================== */
.detail-navbar{
  position:sticky;top:0;z-index:100;
  background:rgba(10,8,32,.97);
  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);
  border-bottom:1px solid var(--border);
}
.detail-nav-top{
  max-width:1200px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;
  height:60px;padding:0 24px;
}
.detail-navbar .nav-link{color:var(--text-muted)!important;}
.detail-navbar .nav-link:hover{color:#fff!important;background:rgba(124,58,237,.12)!important;}
.detail-navbar .nav-cta{
  background:linear-gradient(135deg,var(--purple-dark),var(--purple))!important;
  color:#fff!important;border:none!important;
  box-shadow:0 4px 14px rgba(124,58,237,.3)!important;
}
.detail-navbar .nav-hamburger span{background:#fff!important;}
.detail-navbar .nav-mobile{background:var(--navy)!important;border-top:1px solid var(--border)!important;}
.detail-breadcrumb{
  max-width:1200px;margin:0 auto;
  display:flex;align-items:center;gap:8px;
  padding:8px 24px;border-top:1px solid rgba(124,58,237,.1);
}
.breadcrumb-back{
  display:flex;align-items:center;gap:6px;
  background:none;border:1px solid rgba(124,58,237,.25);
  border-radius:8px;padding:5px 14px;
  color:#c4bdf0;font-size:11px;font-weight:700;
  cursor:pointer;font-family:inherit;transition:all .2s;
}
.breadcrumb-back:hover{background:rgba(124,58,237,.1);border-color:var(--purple);color:#fff}
.breadcrumb-trail{font-size:11px;color:var(--text-dim);display:flex;align-items:center;gap:5px}
.breadcrumb-trail .sep{color:rgba(124,58,237,.4)}
.breadcrumb-trail .current{color:var(--purple-light);font-weight:700}

/* ========================
   DETAIL HERO
======================== */
.detail-hero{
  padding:64px 24px 52px;
  background:var(--navy2);
  position:relative;overflow:hidden;
  border-bottom:1px solid var(--border);
}
.detail-hero::before{
  content:'';position:absolute;inset:0;z-index:0;
  background:radial-gradient(ellipse 70% 80% at 95% 10%,rgba(124,58,237,.15) 0%,transparent 60%),
             radial-gradient(ellipse 40% 50% at 5% 80%,rgba(109,40,217,.1) 0%,transparent 50%);
}
.detail-hero-inner{
  max-width:1200px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;gap:64px;
  position:relative;z-index:1;
}
.detail-hero-text{flex:1;max-width:560px}
.detail-badge{
  display:inline-block;font-size:10px;font-weight:800;
  letter-spacing:.14em;text-transform:uppercase;
  padding:5px 14px;border-radius:50px;border:1px solid;
  margin-bottom:16px;
  background:rgba(167,139,250,.15);color:var(--purple-light);border-color:rgba(167,139,250,.35);
}
.detail-title{font-size:clamp(32px,4.5vw,52px);font-weight:900;color:#fff;line-height:1.1;margin-bottom:14px;letter-spacing:-.04em}
.detail-title em{font-style:normal;color:var(--purple-light)}
.detail-subtitle{font-size:clamp(14px,1.5vw,16px);color:var(--text-muted);line-height:1.75;margin-bottom:28px}
.detail-quote{
  display:flex;align-items:flex-start;gap:10px;
  background:rgba(124,58,237,.12);border-left:3px solid var(--purple);
  border-radius:0 10px 10px 0;padding:14px 18px;margin-bottom:28px;
}
.detail-quote span{color:#c4bdf0;font-weight:600;font-size:14px;line-height:1.6;font-style:italic}
.detail-btns{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
.detail-img{flex-shrink:0;width:clamp(260px,45vw,550px)}
.detail-img img{width:100%;height:auto;display:block;filter:drop-shadow(0 16px 40px rgba(0,0,0,.4))}

/* ========================
   STATS STRIP
======================== */
.stats{
  background:var(--navy);
  border-top:1px solid var(--border);
  border-bottom:1px solid var(--border);
}
.stats-inner{
  max-width:1200px;margin:0 auto;
  display:grid;grid-template-columns:repeat(4,1fr);
}
.stat{
  padding:24px 16px;text-align:center;
  border-right:1px solid var(--border);
  transition:background .2s;
}
.stat:last-child{border-right:none}
.stat:hover{background:rgba(124,58,237,.06)}
.stat-num{font-size:clamp(20px,2.5vw,28px);font-weight:900;letter-spacing:-.03em;color:#fff}
.stat-lbl{font-size:11px;color:var(--text-muted);margin-top:4px;font-weight:600;letter-spacing:.02em}

/* ========================
   CONTENT SECTIONS
======================== */
.content-section{padding:64px 24px; background:var(--navy); color:var(--text-muted)}
.content-section.alt{background:var(--navy2)}
.content-section.dark{background:var(--navy4); color:var(--text-muted)}
.content-inner{max-width:1200px;margin:0 auto}
.sec-title{
  font-size:clamp(22px,3vw,32px);font-weight:900;color:#fff;
  margin-bottom:8px;letter-spacing:-.03em;text-align:center;
}
.sec-desc{font-size:14px;color:var(--text-dim);margin-bottom:40px;line-height:1.6;text-align:center}
.content-section.dark .sec-title{color:#fff}
.content-section.dark .sec-desc{color:var(--text-muted)}

/* Feature cards grid */
.feat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
.feat-card{
  background:#fff;border-radius:16px;padding:20px;
  border:1px solid #e2e8f0;transition:border-color .2s,transform .2s;
  box-shadow:0 4px 20px rgba(0,0,0,.04);
}
.feat-card:hover{border-color:var(--purple);transform:translateY(-2px);box-shadow:0 12px 32px rgba(124,58,237,.1)}
.feat-card.alt{background:#f8fafc}
.feat-card.wide{grid-column:span 2}
.feat-card.accent-green{border-color:rgba(22,101,52,.6)}
.fc-head{display:flex;align-items:flex-start;gap:12px;margin-bottom:10px}
.fc-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fc-name{font-size:13px;font-weight:700;color:#1e293b;line-height:1.2}
.fc-sub{font-size:11px;color:#64748b;margin-bottom:8px;font-weight:600}
.fc-desc{font-size:11px;color:#475569;line-height:1.6;opacity:.9}
.fc-list{margin-top:9px;padding-left:14px}
.fc-list li{font-size:11px;color:#475569;margin-bottom:4px;line-height:1.45}
.fc-list li::marker{color:var(--purple)}
.fc-tags{display:flex;gap:5px;flex-wrap:wrap;margin-top:10px}
.tag{font-size:10px;padding:3px 10px;border-radius:6px;font-weight:700;background:#f3e8ff;color:#7c3aed}
.tag.green{background:#f8fafc;color:#648db3}

/* Course cards */
.course-list{display:flex;flex-direction:column;gap:10px}
.course-card{
  background:var(--navy2);border-radius:14px;padding:14px 18px;
  border:1px solid var(--border);display:flex;align-items:center;gap:14px;
  transition:border-color .2s;
}
.course-card:hover{border-color:rgba(124,58,237,.4)}
.course-card.alt{background:var(--navy3)}
.cc-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.cc-badge{font-size:9px;font-weight:800;padding:2px 8px;border-radius:6px;margin-bottom:5px;display:inline-block;letter-spacing:.02em}
.cc-title{font-size:12px;font-weight:700;color:#e8e4ff;margin-bottom:2px}
.cc-meta{font-size:10px;color:var(--text-dim)}
.cc-free{font-size:9px;background:#52357b;color:#648db3;padding:4px 10px;border-radius:20px;font-weight:800;margin-left:auto;flex-shrink:0}

/* Forum posts */
.forum-list{display:flex;flex-direction:column;gap:10px}
.fpost{background:#fff;border-radius:14px;padding:16px;border:1px solid #e2e8f0;box-shadow:0 2px 10px rgba(0,0,0,.02)}
.fpost.alt{background:#f8fafc}
.fp-head{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.fp-av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:800;flex-shrink:0}
.fp-name{font-size:11px;font-weight:700;color:#1e293b}
.fp-school{font-size:10px;color:#64748b}
.fp-badge{font-size:9px;padding:3px 9px;border-radius:20px;margin-left:auto;font-weight:700}
.fp-q{font-size:11px;color:#334155;line-height:1.6;margin-bottom:8px;font-weight:500}
.fp-meta{display:flex;gap:14px}
.fp-m{font-size:10px;color:#64748b;display:flex;align-items:center;gap:3px}

/* Story cards */
.story-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
.story-card{background:var(--navy2);border-radius:16px;padding:16px;border:1px solid var(--border);transition:border-color .2s}
.story-card:hover{border-color:rgba(124,58,237,.35)}
.story-card.alt{background:var(--navy3)}
.st-cat{font-size:9px;font-weight:800;padding:3px 10px;border-radius:20px;margin-bottom:10px;display:inline-block;letter-spacing:.04em}
.st-title{font-size:12px;font-weight:700;color:#e8e4ff;line-height:1.45;margin-bottom:8px}
.st-preview{font-size:11px;color:var(--text-muted);line-height:1.6;margin-bottom:10px}
.st-foot{display:flex;align-items:center;gap:9px;border-top:1px solid var(--border);padding-top:10px}
.st-av{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:800;flex-shrink:0}
.st-name{font-size:10px;color:#c4bdf0;font-weight:700}
.st-sch{font-size:9px;color:var(--text-dim)}
.st-like{font-size:10px;color:var(--text-dim);margin-left:auto}

/* Steps */
.steps{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;position:relative}
.steps::before{
  content:'';position:absolute;top:20px;
  left:calc(16.7% + 4px);right:calc(16.7% + 4px);
  height:1px;background:linear-gradient(to right,var(--purple-dark),var(--purple-light));
  z-index:0;opacity:.5;
}
.step{text-align:center;position:relative;z-index:1}
.step-num{
  width:40px;height:40px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:14px;font-weight:900;color:#fff;
  margin:0 auto 12px;box-shadow:0 4px 16px rgba(124,58,237,.45);
  background:linear-gradient(135deg,var(--purple-dark),var(--purple));
}
.step-title{font-size:12px;font-weight:800;color:var(--text);margin-bottom:5px}
.step-desc{font-size:11px;color:var(--text-muted);line-height:1.55}

/* CTA Banner */
.cta-banner{
  padding:80px 24px;text-align:center;
  background:#0f172a;
  position:relative;overflow:hidden;
}
.cta-banner::before{
  content:'';position:absolute;inset:0;z-index:0;
  background:radial-gradient(ellipse 60% 70% at 50% 0%,rgba(29,78,216,.2) 0%,transparent 70%);
}
.cta-inner{max-width:620px;margin:0 auto;position:relative;z-index:1;}
.cta-title{font-size:clamp(24px,3.5vw,36px);font-weight:900;color:#f8fafc;margin-bottom:12px;letter-spacing:-.03em;line-height:1.15}
.cta-sub{font-size:clamp(13px,1.5vw,15px);color:#94a3b8;margin-bottom:32px;line-height:1.75}
.cta-note{font-size:12px;color:#475569;margin-top:16px;display:flex;justify-content:center;gap:20px;flex-wrap:wrap}
.cta-note span{display:flex;align-items:center;gap:6px;}
.cta-btn-main{
  display:inline-flex;align-items:center;gap:10px;
  background:#ffffff;color:#0f172a;
  border:none;border-radius:14px;padding:15px 36px;
  font-size:15px;font-weight:800;cursor:pointer;
  font-family:inherit;transition:all .25s;
  box-shadow:0 8px 24px rgba(0,0,0,.3);
}
.cta-btn-main:hover{transform:translateY(-2px);box-shadow:0 16px 32px rgba(0,0,0,.35);}

/* View all button */
.btn-outline{
  background:none;border:1.5px solid rgba(124,58,237,.4);
  color:var(--purple);border-radius:50px;
  padding:9px 24px;font-size:12px;font-weight:700;
  cursor:pointer;font-family:inherit;transition:all .2s;
}
.btn-outline:hover{border-color:var(--purple);background:rgba(124,58,237,.1)}
.content-section.dark .btn-outline { color:var(--purple-light) }
.text-center{text-align:center}
.mt-16{margin-top:16px}

/* FOOTER */
.footer{background:var(--navy4);padding:40px 24px 20px;border-top:1px solid var(--border)}
.footer-inner{max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:24px}
.footer-logo{font-size:18px;font-weight:900;color:#fff;margin-bottom:8px}
.footer-logo em{font-style:normal;color:var(--purple-light)}
.footer-addr{font-size:12px;color:var(--text-muted);line-height:1.8}
.footer-socials{display:flex;gap:10px;margin-top:14px}
.social-btn{
  width:36px;height:36px;border-radius:50%;
  background:rgba(124,58,237,.1);display:flex;
  align-items:center;justify-content:center;
  cursor:pointer;border:1px solid var(--border);transition:all .2s;
  text-decoration:none;
}
.social-btn:hover{background:rgba(124,58,237,.2);border-color:var(--purple)}
.footer-copy{
  max-width:1200px;margin:24px auto 0;
  padding-top:16px;border-top:1px solid var(--border);
  text-align:center;font-size:11px;color:var(--text-dim);
}

/* ========================
   RESPONSIVE
======================== */
@media(max-width:900px){
  .pillars-grid{grid-template-columns:repeat(2,1fr)}
  .pillar-card:last-child{grid-column:span 2}
  .stats-inner{grid-template-columns:repeat(2,1fr)}
  .stat:nth-child(2){border-right:none}
  .stat:nth-child(3){border-right:1px solid var(--border)}
  .stat:last-child{border-right:none}
  .story-grid{grid-template-columns:1fr}
  .feat-card.wide{grid-column:span 1}
}
@media(max-width:1024px){
  .hero-inner{grid-template-columns:1fr;gap:32px;text-align:center;}
  .hero-image{width:100%;max-width:520px;margin:0 auto;}
  .hero-search{justify-items:center;}
  .hero-tags{justify-content:center;}
}
@media(max-width:768px){
  .hero{padding:60px 20px 40px}
  .hero-title{font-size:clamp(28px,6vw,42px);}
  .hero-inner{gap:24px;}
  .hero-image{max-width:380px;margin:0 auto;}
  .hero-subtitle{margin:0 auto 28px;}
  .hero-actions{justify-content:center;}
  .feature-grid{grid-template-columns:1fr;}
  .hero-features{padding-top:32px;}
  .detail-hero{padding:40px 20px 32px}
  .detail-hero-inner{flex-direction:column-reverse;gap:20px}
  .detail-img{width:100%;max-width:340px;margin:0 auto}
  .detail-nav-top{padding:0 16px}
  .detail-breadcrumb{padding:8px 16px}
  .feat-grid{grid-template-columns:1fr}
  .feat-card.wide{grid-column:span 1}
  .steps{grid-template-columns:1fr;gap:24px}
  .steps::before{display:none}
  .footer-inner{flex-direction:column}
  .content-section{padding:40px 20px}
  .pillars{padding:48px 20px}
}
@media(max-width:640px){
  .navbar-inner{padding:0 16px}
  .nav-links{display:none}
  .nav-hamburger{display:flex}
  .pillars-grid{grid-template-columns:1fr}
  .pillar-card:last-child{grid-column:span 1}
  .stats-inner{grid-template-columns:repeat(2,1fr)}
  .stats-inner .stat:nth-child(2){border-right:none}
  .stats-inner .stat:nth-child(3){border-right:1px solid var(--border)}
  .story-grid{grid-template-columns:1fr}
  .detail-title{font-size:26px}
}
@media(max-width:400px){
  .hero-title{font-size:28px}
  .container{padding:0 16px}
  .detail-btns{flex-direction:column}
  .detail-btns .btn-primary,.detail-btns .btn-secondary{text-align:center}
}
</style>
</head>
<body>

{{-- ===== GLOBAL NAVBAR (dari global_header.php) ===== --}}
<nav class="navbar">
  <div class="navbar-inner">
    <a href="{{ route('home') }}" class="nav-logo" style="text-decoration:none !important; border:none !important;">
      <img src="{{ asset('asset/img/FA Logo Guruverse.ID - main.png') }}"
           alt="Guruverse.ID"
           class="logo-img-light"
           style="height:36px; border:none; object-fit:contain;">
      <img src="{{ asset('asset/img/FA Logo Guruverse.ID - nrgative.png') }}"
           alt="Guruverse.ID"
           class="logo-img-dark"
           style="height:36px; border:none; object-fit:contain;">
    </a>
    <div class="nav-links">
      <a class="nav-link" id="nav-index" href="{{ route('home') }}">Beranda</a>
      <a class="nav-link" id="nav-about" href="{{ route('about') }}">Tentang Kami</a>
      <a class="nav-link" id="nav-program" href="{{ route('program') }}">Program</a>
      <a class="nav-link" id="nav-testimoni" href="{{ route('testimoni') }}">Testimoni</a>
      <a class="nav-link" id="nav-artikel" href="{{ route('artikel') }}">Artikel</a>
      @auth('web')
        <a class="nav-link" href="{{ route('member.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('logout') }}">Keluar</a>
      @else
        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
      @endauth
      {{-- Dark/Light Mode Toggle --}}
      <button class="theme-toggle-btn" id="globalThemeToggle" onclick="toggleDarkMode()" title="Ganti Mode Tampilan" aria-label="Toggle Dark Mode">
        <span class="icon-moon">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </span>
        <span class="icon-sun">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </span>
      </button>
      <button class="nav-cta" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
    </div>
    <button class="nav-hamburger" onclick="toggleMenu()" id="hamburger">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
<div class="nav-mobile" id="navMobile">
  <a class="nav-link" href="{{ route('home') }}">Beranda</a>
  <a class="nav-link" href="{{ route('about') }}">Tentang Kami</a>
  <a class="nav-link" href="{{ route('program') }}">Program</a>
  <a class="nav-link" href="{{ route('testimoni') }}">Testimoni</a>
  <a class="nav-link" href="{{ route('artikel') }}">Artikel</a>
  @auth('web')
    <a class="nav-link" href="{{ route('member.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('logout') }}">Keluar</a>
  @else
    <a class="nav-link" href="{{ route('login') }}">Masuk</a>
    <a class="nav-link" href="{{ route('register') }}">Daftar</a>
  @endauth
  <button class="nav-cta" style="margin-top:8px;border-radius:10px" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
</div>

{{-- ===== KONTEN HALAMAN ===== --}}
@yield('content')

{{-- ===== FOOTER (dari footer.php) ===== --}}
<script>
function toggleMenu(){
  const m=document.getElementById('navMobile');
  m.classList.toggle('open');
}

// Close mobile menu on link click
document.querySelectorAll('.nav-mobile .nav-link, .nav-mobile .nav-cta').forEach(el=>{
  el.addEventListener('click',()=>{
    document.querySelectorAll('.nav-mobile').forEach(m=>m.classList.remove('open'));
  });
});

function toggleDarkMode() {
  var html = document.documentElement;
  var next = (html.getAttribute('data-theme') === 'dark') ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('guruverse_theme', next);
}

// Init active nav link
document.addEventListener('DOMContentLoaded', () => {
  const currentUrl = window.location.href.split('?')[0].replace(/\/$/, "");
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.href.split('?')[0].replace(/\/$/, "");
    if (href === currentUrl || (currentUrl.endsWith('public') && href.endsWith('public'))) {
      link.classList.add('active');
    }
  });
});
</script>
</body>
</html>
