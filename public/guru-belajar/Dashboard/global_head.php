<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="../../asset/img/logo guruverse FA.ai.png"/>
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
[data-theme="light"] .nav-link.active { color: #ffffff !important; }
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

/* ── Dark Mode Toggle Button ── */
.theme-toggle-btn {
  width: 36px; height: 36px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  background: rgba(255,255,255,0.08); border: 1px solid rgba(167,139,250,0.2);
  color: rgba(255,255,255,0.7); cursor: pointer;
  transition: all 0.2s ease; flex-shrink: 0;
  font-family: inherit;
}
.theme-toggle-btn:hover { background: rgba(124,58,237,0.2); color: #fff; border-color: rgba(167,139,250,0.5); }
.theme-toggle-btn .icon-sun { display: none; align-items:center; justify-content:center; }
.theme-toggle-btn .icon-moon { display: flex; align-items:center; justify-content:center; }
[data-theme="dark"] .theme-toggle-btn .icon-sun { display: flex; }
[data-theme="dark"] .theme-toggle-btn .icon-moon { display: none; }

/* Smooth transitions */
*, *::before, *::after {
  transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
}
.theme-toggle-btn, .nav-link, .nav-cta, .prog-card, .pillar-card, .art-card, .testi-card, .btn-detail {
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

/* Centralized Navbar Styles (Wannathis Style) */
.navbar{
  background:rgba(10,7,24,.9);
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
  border-bottom:1px solid rgba(167,139,250,.1);
  padding:0 5%;
  position:sticky;top:0;z-index:100;
  display:flex;align-items:center;justify-content:space-between;height:72px;
  transition: all 0.3s ease;
}
.nav-logo img{height:32px;display:block;}
.nav-links{display:flex;gap:32px;align-items:center;}
.nav-link{
  background:none;border:none;color:rgba(255,255,255,0.7);
  font-size:14px;cursor:pointer;font-weight:600;
  transition:all 0.3s ease;font-family:inherit;
  position:relative;
}
.nav-link:hover{color:#fff;}
.nav-link.active{color:#a78bfa;}
.nav-link.active::after{
  content:'';position:absolute;bottom:-6px;left:0;width:100%;height:2px;
  background:#a78bfa;border-radius:2px;
}
.nav-cta{
  background:linear-gradient(135deg,#7c3aed,#4f46e5);
  color:#fff;border:none;border-radius:100px;
  padding:10px 24px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;
  transition:all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
  box-shadow: 0 10px 20px -5px rgba(124, 58, 237, 0.3);
}
.nav-cta:hover{
  transform: translateY(-2px);
  box-shadow: 0 15px 30px -5px rgba(124, 58, 237, 0.4);
}

/* Floating Elements Global Keyframes */
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
