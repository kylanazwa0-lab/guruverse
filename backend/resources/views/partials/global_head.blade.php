<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="{{ asset('asset/img/logo guruverse FA.ai.png') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<script>
  (function(){
    var saved = localStorage.getItem('guruverse_theme');
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  })();
</script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --purple:#7c3aed;
  --purple-light:#a78bfa;
  --navy:#0a0820;
  --navy-light:#13103a;
  --bg-light:#f8fafc;
  --border:rgba(124,58,237,.18);
  --glass: rgba(255, 255, 255, 0.7);
  --glass-border: rgba(255, 255, 255, 0.4);
  
  /* Semantic bindings for Dark Mode */
  --bg: var(--navy);
  --card: var(--navy-light);
  --text: #ffffff;
  --text-muted: #9b93d4;
  --primary: var(--purple);
}
html,body{
  font-family:'Plus Jakarta Sans',sans-serif;
  background:var(--bg);
  color:var(--text);
  overflow-x:hidden;
  scroll-behavior: smooth;
  transition: background-color 0.3s ease, color 0.2s ease;
}

/* ── Light Mode Palette: Creative Violet (Logo Theme) ── */
[data-theme="light"] {
  --primary: #093C5D;          /* Dark Blue */
  --primary-dark: #062c45;     /* Darker Blue */
  --primary-light: #357A9E;    /* Slate/Steel Blue */
  --secondary: #76D4E2;        /* Light Cyan/Teal */
  --secondary-dark: #2d93a4;   /* Darker Cyan */
  --bg: #F5F8FA;               /* Soft cool-tinted background */
  --border: #D2E3EB;           /* Soft blue-tinted borders */
  --text: #092B40;             /* Sleek deep slate blue text */
  --text-muted: #3D6175;       /* Medium slate blue text */
  --glass: rgba(255,255,255,0.85);
  --glass-border: rgba(9,60,93,0.15);
}
[data-theme="light"] html,
[data-theme="light"] body {
  background: var(--bg) !important;
  color: var(--text) !important;
}
[data-theme="light"] .story-container,
[data-theme="light"] .articles-container,
[data-theme="light"] .programs-wrapper,
[data-theme="light"] .testimonial-wrapper {
  background-color: var(--bg) !important;
  border-color: var(--border) !important;
  background-image: none !important;
}
[data-theme="light"] .navbar { background: #093C5D !important; border-bottom: 1px solid rgba(255,255,255,0.15) !important; }
[data-theme="light"] .nav-link { color: rgba(255,255,255,0.75) !important; }
[data-theme="light"] .nav-link:hover { color: #ffffff !important; background: rgba(255,255,255,0.1) !important; }
[data-theme="light"] .footer { background: #093C5D !important; }
[data-theme="light"] .footer-logo { color: #ffffff !important; }
[data-theme="light"] .footer-copy { color: rgba(255,255,255,0.5) !important; }
[data-theme="light"] .btn-cta { background: linear-gradient(135deg, var(--primary), var(--secondary)) !important; }
[data-theme="light"] .visual-card,
[data-theme="light"] .pillar-card,
[data-theme="light"] .art-card,
[data-theme="light"] .prog-card,
[data-theme="light"] .testi-card {
  background: #ffffff !important;
  border-color: var(--border) !important;
}
[data-theme="light"] .detail-quote { background: rgba(9, 60, 93, 0.08) !important; border-left-color: var(--primary) !important; }
[data-theme="light"] .detail-quote span { color: var(--text) !important; }

/* ── Dark Mode: public/light pages ── */
[data-theme="dark"] html,
[data-theme="dark"] body {
  background: var(--bg) !important;
  color: var(--text) !important;
}
[data-theme="dark"] .story-container,
[data-theme="dark"] .articles-container,
[data-theme="dark"] .programs-wrapper,
[data-theme="dark"] .testimonial-wrapper {
  background-color: var(--card) !important;
  border-color: var(--border) !important;
  background-image: none !important;
}
[data-theme="dark"] .visual-card,
[data-theme="dark"] .pillar-card,
[data-theme="dark"] .art-card,
[data-theme="dark"] .prog-card,
[data-theme="dark"] .testi-card {
  background: var(--card) !important;
  border-color: var(--border) !important;
  box-shadow: 0 4px 24px rgba(0,0,0,0.3) !important;
}
[data-theme="dark"] .prog-card:hover,
[data-theme="dark"] .testi-card:hover {
  background: rgba(35,39,62,0.98) !important;
}
[data-theme="dark"] .section-title,
[data-theme="dark"] .visual-title,
[data-theme="dark"] .pillar-name,
[data-theme="dark"] .art-title,
[data-theme="dark"] .card-title,
[data-theme="dark"] .hero-title,
[data-theme="dark"] .title-premium,
[data-theme="dark"] .main-title { color: var(--text) !important; }
[data-theme="dark"] .story-text p,
[data-theme="dark"] .pillar-desc,
[data-theme="dark"] .art-excerpt,
[data-theme="dark"] .visual-desc,
[data-theme="dark"] .card-desc,
[data-theme="dark"] .desc-premium,
[data-theme="dark"] .sub-title,
[data-theme="dark"] .hero-subtitle { color: var(--text-muted) !important; }
[data-theme="dark"] .testi-content { color: var(--text-muted) !important; }
[data-theme="dark"] .user-details h4 { color: var(--text) !important; }
[data-theme="dark"] .footer {
  background: #090b14 !important;
}
[data-theme="dark"] .btn-detail {
  background: var(--card) !important;
  border-color: var(--border) !important;
  color: var(--text) !important;
}
[data-theme="dark"] .btn-detail:hover {
  background: var(--primary) !important;
  color: #fff !important;
  border-color: var(--primary) !important;
}
[data-theme="dark"] .page-hero { background: var(--bg) !important; }
[data-theme="dark"] .art-thumb { background: var(--card) !important; }

/* ── Dark Mode Toggle Button (identik dengan Beranda) ── */
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

/* Smooth transitions */
*, *::before, *::after {
  transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
}
.navbar, .nav-link, .nav-cta, .pillar-card, .art-card, .testi-card, .btn-detail {
  transition: all 0.2s ease;
}

/* ========================
   NAVBAR — identik dengan Beranda
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
.nav-logo{text-decoration:none !important;border:none !important;display:flex;align-items:center;gap:8px;}
.nav-logo img{height:34px;display:block;border:none !important;}
.nav-links{display:flex;align-items:center;gap:6px;}
.nav-link{
  position:relative;color:var(--text-muted);font-size:13px;font-weight:500;
  padding:7px 14px;border-radius:8px;
  cursor:pointer;transition:all .3s ease;
  border:none;background:none;font-family:inherit;
}
.nav-link:hover{color:#fff;background:rgba(124,58,237,.12); transform:translateY(-1px);}
.nav-link.active{color:#fff !important; font-weight:800; background:rgba(255,255,255,.1);}
.nav-link.active::after{content:'';position:absolute;bottom:0px;left:50%;transform:translateX(-50%);width:5px;height:5px;background:#fff;border-radius:50%;box-shadow:0 0 8px #fff;animation:popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;}
@keyframes popIn { 0% { transform:translateX(-50%) scale(0); opacity:0; } 100% { transform:translateX(-50%) scale(1); opacity:1; } }
.nav-cta{
  background:none;border:1.5px solid var(--purple);
  color:var(--purple-light);border-radius:50px;
  padding:8px 24px;font-size:13px;font-weight:700;
  cursor:pointer;font-family:inherit;transition:all .25s;
  white-space:nowrap;
}
.nav-cta:hover{background:var(--purple);color:#fff;box-shadow:0 4px 20px rgba(124,58,237,.4);}
.nav-hamburger{
  display:none;flex-direction:column;gap:5px;
  background:none;border:none;cursor:pointer;padding:4px;
}
.nav-hamburger span{
  display:block;width:22px;height:2px;
  background:#a78bfa;border-radius:2px;transition:all .3s;
}
.nav-mobile{
  display:none;
  background:rgba(10,8,32,.98);
  border-top:1px solid var(--border);
  padding:16px 24px;
  flex-direction:column;gap:4px;
  position:sticky;top:64px;z-index:99;
}
.nav-mobile.open{display:flex;}
.nav-mobile .nav-link{text-align:left;padding:10px 14px;}

/* ── Responsive: show hamburger, hide desktop links ── */
@media(max-width:900px){
  .nav-links{ display:none; }
  .nav-hamburger{ display:flex; }
}


@keyframes float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-30px) rotate(10deg); }
}
.floating-blob {
  position:absolute;z-index:0;filter:blur(40px);opacity:0.6;
  animation: float 6s ease-in-out infinite;
}

/* Common Section Header (Wannathis Style) */
.header-wrapper{ text-align:center; max-width:800px; margin:0 auto 80px; position:relative; z-index:2; }
.badge-premium{
  font-size:12px; font-weight:800; color:var(--purple); text-transform:uppercase;
  letter-spacing:1px; margin-bottom:16px; display:inline-block;
  background:rgba(124, 58, 237, 0.1); padding:6px 16px; border-radius:20px;
}
.title-premium{
  font-size:clamp(36px, 6vw, 56px); font-weight:900; color:var(--navy);
  line-height:1.1; margin-bottom:24px; letter-spacing:-1.5px;
}
.title-premium em{
  color:var(--purple); font-style:normal;
  background: linear-gradient(135deg, #7c3aed, #4f46e5);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}
.desc-premium{ color:#64748b; font-size:1.1rem; line-height:1.6; }

/* Centralized Footer Styles */
.footer{ background:#06040f; padding:24px 5%; text-align:center; color:white; }
.footer-logo img{height:32px; margin-bottom:12px;}
.footer-copy{font-size:12px; color:#7c6fab; margin:0;}
</style>
