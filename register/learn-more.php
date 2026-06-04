<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="../asset/img/logo guruverse FA.ai.png"/>
<title>Pelajari Lebih Lanjut — Guruverse.id</title>
<script>
  (function(){
    var saved = localStorage.getItem('guruverse_theme');
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  })();
</script>
<script>
  window.isMemberLoggedIn = <?php echo isset($_SESSION['member_int_id']) ? 'true' : 'false'; ?>;
</script>

<!-- React -->
<script src="js/react.production.min.js"></script>
<script src="js/react-dom.production.min.js"></script>
<!-- Lucide Icons -->
<script src="js/lucide.min.js"></script>
<!-- Babel -->
<script src="js/babel.min.js"></script>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;0,900;1,600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet"/>

<!-- Tailwind & FlyonUI -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flyonui/dist/full.min.css" />

<?php
// Inject global_head.php CSS (navbar styles, CSS variables, dark mode)
ob_start();
include '../guru-belajar/Dashboard/global_head.php';
$head = ob_get_clean();
$head = str_replace('../../asset/', '../asset/', $head);
echo $head;
?>

<style>
/* ── Page-specific overrides ── */
*, *::before, *::after { box-sizing: border-box; }
html, body {
  min-height: 100%;
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: #0a0820;
  color: #fff;
  overflow-x: hidden;
  scroll-behavior: smooth;
  font-size: 15px;
}
[data-theme="light"] body { background: var(--bg) !important; color: var(--text) !important; }

/* Background starfield */
.sf {
  position: fixed; inset: 0; z-index: 0; pointer-events: none;
  background:
    radial-gradient(ellipse at 20% 50%, rgba(124,58,237,.12) 0%, transparent 55%),
    radial-gradient(ellipse at 80% 20%, rgba(55,48,163,.15) 0%, transparent 50%),
    linear-gradient(135deg, #0a0820 0%, #0f0c2e 100%);
}
.star { position: absolute; border-radius: 50%; background: #fff; animation: twinkle var(--d,3s) ease-in-out infinite var(--delay,0s); }
@keyframes twinkle { 0%,100%{opacity:var(--op,.5);transform:scale(1)} 50%{opacity:.08;transform:scale(.4)} }
@keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

.fu  { animation: fadeUp .6s cubic-bezier(.16,1,.3,1) both; }
.fu1 { animation: fadeUp .6s .1s cubic-bezier(.16,1,.3,1) both; }
.fu2 { animation: fadeUp .6s .2s cubic-bezier(.16,1,.3,1) both; }

/* Component styles needed by lm_*.js sections */
.container { max-width: 1100px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }
.badge {
  display: inline-flex; align-items: center; gap: 6px; padding: .35rem .85rem;
  background: rgba(124,58,237,.1); color: #a78bfa; border-radius: 100px; border: 1px solid rgba(124,58,237,.2);
  font-size: .65rem; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 1rem;
}
.h1 { font-size: clamp(1.8rem,4vw,2.8rem); font-weight: 900; line-height: 1.15; color: var(--text); letter-spacing: -.03em; margin-bottom: 1rem; }
.h1 span { color: #a78bfa; }
.p-desc { font-size: .95rem; color: var(--text-muted); line-height: 1.6; max-width: 520px; margin-bottom: 2rem; }

.btn-primary {
  background: linear-gradient(135deg, #6d28d9, #7c3aed);
  color: #fff; border: none; padding: .85rem 1.8rem; border-radius: 50px;
  font-weight: 800; font-size: .9rem; cursor: pointer; transition: all .3s;
  display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 6px 20px rgba(124,58,237,.35);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(124,58,237,.45); }

.btn-outline {
  background: none; border: 1.5px solid rgba(124,58,237,.2); padding: .8rem 1.8rem;
  border-radius: 50px; color: #a78bfa; font-weight: 700; font-size: .9rem; cursor: pointer; transition: all .2s;
  display: inline-flex; align-items: center; gap: 8px;
}
.btn-outline:hover { border-color: #7c3aed; background: rgba(124,58,237,.08); color: #fff; }

.pillar-card {
  background: #1a1d36; border: 1px solid rgba(124,58,237,.2); border-radius: 20px; padding: 1.75rem;
  transition: all .3s ease; position: relative; overflow: hidden;
}
.pillar-card:hover { transform: translateY(-6px); border-color: rgba(124,58,237,.4); box-shadow: 0 16px 40px rgba(0,0,0,.35); }

.cta-banner {
  background: #232742; border: 1px solid rgba(124,58,237,.2); border-radius: 24px; padding: 3rem;
  display: grid; grid-template-columns: 1.2fr .8fr; align-items: center; gap: 2rem;
  position: relative; overflow: hidden; margin: 3rem 0;
}
.cta-banner::before {
  content: ''; position: absolute; inset: 0;
  background: radial-gradient(circle at 70% 30%, rgba(124,58,237,.1) 0%, transparent 70%); z-index: 0;
}

@media(max-width:968px){
  .cta-banner { grid-template-columns: 1fr; text-align: center; padding: 2.5rem 1.5rem; }
  .h1 { font-size: 1.8rem; }
}
</style>
</head>
<body>

<div class="sf" id="sf"></div>
<div id="root"></div>

<!-- Starfield -->
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

<!-- Load React Sections -->
<script type="text/babel">
<?php
  include 'sections/shared_components.js';
  include 'sections/lm_hero.js';
  include 'sections/lm_story.js';
  include 'sections/lm_pillars.js';
  include 'sections/lm_extra.js';
  include 'sections/lm_cta.js';
?>

const LearnMoreApp = () => {
  return (
    <>
      <Nav view="about" go={(v) => { if(v==='register') window.location.href='register.php'; else window.location.href='../guru-belajar/Dashboard/index.php'; }} />
      <div style={{position:'relative', zIndex:1}}>
        <LMHero />
        <LMStory />
        <LMPillars />
        <LMExtra />
        <LMCTA />

        <footer style={{ background: '#232742', padding: '2.5rem 0', color: '#fff', borderTop: '1px solid rgba(124,58,237,.2)' }}>
          <div className="container" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: '1.5rem' }}>
            <p style={{ color: '#6b63a8', fontSize: '.8rem', fontWeight: 600 }}>&copy; {new Date().getFullYear()} GURUVERSE.ID — ACF EDUHUB</p>
            <div style={{ display: 'flex', gap: '2rem' }}>
              <a href="#" style={{ color: '#6b63a8', textDecoration: 'none', fontSize: '.8rem', fontWeight: 600 }} onMouseOver={e=>e.target.style.color='#fff'} onMouseOut={e=>e.target.style.color='#6b63a8'}>Kebijakan Privasi</a>
              <a href="#" style={{ color: '#6b63a8', textDecoration: 'none', fontSize: '.8rem', fontWeight: 600 }} onMouseOver={e=>e.target.style.color='#fff'} onMouseOut={e=>e.target.style.color='#6b63a8'}>Syarat &amp; Ketentuan</a>
            </div>
          </div>
        </footer>
      </div>
    </>
  );
};

ReactDOM.createRoot(document.getElementById('root')).render(<LearnMoreApp />);
</script>

<!-- FlyonUI JS -->
<script src="https://cdn.jsdelivr.net/npm/flyonui/dist/js/flyonui.js"></script>

</body>
</html>
