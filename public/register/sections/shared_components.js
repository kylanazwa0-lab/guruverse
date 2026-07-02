const {useState,useEffect,useRef,useMemo,useCallback}=React;

/* ── ICON ── */
const Ico=({n,s=16,cls=''})=>{
  const r=useRef(null);
  useEffect(()=>{
    if(!r.current||!window.lucide)return;
    r.current.innerHTML='';
    const svg=lucide.createElement(lucide[n]||lucide.HelpCircle);
    svg.setAttribute('width',s);svg.setAttribute('height',s);svg.setAttribute('stroke-width','2');
    r.current.appendChild(svg);
  },[n,s]);
  return <span ref={r} className={`inline-flex items-center justify-center ${cls}`}/>;
};

/* ── BARCODE ── */
const Bar=({val=''})=>(
  <svg viewBox={`0 0 ${val.length*6} 36`} style={{height:22,display:'block'}}>
    {val.split('').map((c,i)=>(
      <rect key={i} x={i*6} y="0" width={(c.charCodeAt(0)%3)+1.3} height="36" fill="white" opacity=".72"/>
    ))}
  </svg>
);

/* ── DROPDOWN AKSI ── */
const AksiDropdown = ({ m, onCard, onDelete }) => {
  const items = [
    { ic: 'IdCard', label: 'Lihat Kartu', color: 'text-primary', action: () => onCard(m) },
    { ic: 'Pencil', label: 'Edit', color: 'text-info', action: () => alert('Fitur edit segera hadir!') },
    { ic: 'Trash2', label: 'Hapus', color: 'text-error', action: () => { if (confirm(`Hapus ${m.fullName}?`)) onDelete(m); } },
  ];

  return (
    <div className="dropdown relative inline-flex">
      <button 
        id={`dropdown-${m.memberId || Math.random()}`} 
        type="button" 
        className="dropdown-toggle btn btn-soft btn-primary btn-sm gap-2" 
        aria-haspopup="menu" 
        aria-expanded="false" 
        aria-label="Aksi"
      >
        <Ico n="MoreHorizontal" s={14} />
        Aksi
        <span className="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
      </button>
      <ul className="dropdown-menu dropdown-open:opacity-100 hidden min-w-48 bg-slate-900 border border-slate-700 shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby={`dropdown-${m.memberId}`}>
        {items.map((it, i) => (
          <li key={i}>
            <button 
              className={`dropdown-item flex items-center gap-2 ${it.color} hover:bg-slate-800 w-full text-left`} 
              onClick={it.action}
            >
              <Ico n={it.ic} s={14} />
              {it.label}
            </button>
          </li>
        ))}
      </ul>
    </div>
  );
};

/* ── NAVBAR — identik dengan Beranda ── */
const Nav = ({ view, go }) => {
  const [scrolled, setScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  useEffect(() => {
    const handle = () => setScrolled(window.scrollY > 50);
    window.addEventListener('scroll', handle);
    return () => window.removeEventListener('scroll', handle);
  }, []);

  const navStyle = {
    position: 'sticky', top: 0, zIndex: 1000,
    background: 'rgba(10,8,32,.95)',
    backdropFilter: 'blur(12px)',
    WebkitBackdropFilter: 'blur(12px)',
    borderBottom: scrolled ? '1px solid rgba(124,58,237,.18)' : '1px solid transparent',
    padding: '0 24px',
    transition: 'border-color 0.3s ease',
  };
  const innerStyle = {
    maxWidth: 1200, margin: '0 auto',
    display: 'flex', alignItems: 'center', justifyContent: 'space-between',
    height: 64,
  };
  const linkStyle = (active) => ({
    color: active ? '#a78bfa' : 'rgba(255,255,255,0.65)',
    fontSize: 13, fontWeight: 500,
    padding: '7px 14px', borderRadius: 8,
    cursor: 'pointer', transition: 'all .2s',
    border: 'none', background: 'none',
    fontFamily: 'inherit', textDecoration: 'none',
    display: 'inline-block',
    borderBottom: active ? '2px solid #a78bfa' : '2px solid transparent',
  });
  const ctaStyle = {
    background: 'none', border: '1.5px solid #7c3aed',
    color: '#a78bfa', borderRadius: 50,
    padding: '8px 24px', fontSize: 13, fontWeight: 700,
    cursor: 'pointer', fontFamily: 'inherit',
    whiteSpace: 'nowrap', textDecoration: 'none',
    display: 'inline-flex', alignItems: 'center', gap: 6,
    transition: 'all .25s',
  };
  const links = [
    { label: 'Beranda',     href: '../guru-belajar/Dashboard/index.php', key: 'home' },
    { label: 'Tentang Kami', href: 'learn-more.php',                    key: 'about' },
    { label: 'Program',     href: '../guru-belajar/Dashboard/program.php', key: 'program' },
    { label: 'Testimoni',   href: '../guru-belajar/Dashboard/testimoni.php', key: 'testimoni' },
    { label: 'Artikel',     href: '../guru-belajar/Dashboard/artikel.php', key: 'artikel' },
  ];

  return (
    <>
      <nav style={navStyle}>
        <div style={innerStyle}>
          {/* Logo */}
          <a href="../guru-belajar/Dashboard/index.php" style={{ display:'flex', alignItems:'center', gap:8, textDecoration:'none !important', border:'none !important', outline:'none' }}>
            <img src="../asset/img/logo guruverse FA.ai.png" alt="GV" style={{ height:34, border:'none' }} onError={e => e.target.style.display='none'} />
          </a>

          {/* Desktop Links */}
          <div style={{ display:'flex', alignItems:'center', gap:6 }} className="nav-desktop-links">
            {links.map(l => (
              <a key={l.key} href={l.href} style={linkStyle(view === l.key)}
                onMouseOver={e => { if(view !== l.key) { e.currentTarget.style.color='#fff'; e.currentTarget.style.background='rgba(124,58,237,.12)'; }}}
                onMouseOut={e => { if(view !== l.key) { e.currentTarget.style.color='rgba(255,255,255,0.65)'; e.currentTarget.style.background='none'; }}}
              >{l.label}</a>
            ))}

            {/* Dark Mode Toggle */}
            <button onClick={() => {
              const cur = document.documentElement.getAttribute('data-theme');
              const next = cur === 'dark' ? 'light' : 'dark';
              document.documentElement.setAttribute('data-theme', next);
              localStorage.setItem('guruverse_theme', next);
            }} style={{ width:34, height:34, borderRadius:'50%', display:'flex', alignItems:'center', justifyContent:'center', background:'rgba(255,255,255,.07)', border:'1px solid rgba(167,139,250,.2)', color:'rgba(255,255,255,.65)', cursor:'pointer', flexShrink:0 }}
              title="Ganti Mode Tampilan">
              ☀
            </button>

            {/* CTA */}
            {window.isMemberLoggedIn ? (
              <a href="../guru-belajar/member/index.php" style={{ ...ctaStyle, background:'linear-gradient(135deg,#10b981,#059669)', border:'none', color:'#fff' }}>
                <Ico n="LayoutDashboard" s={15}/> Dashboard
              </a>
            ) : (
              <button style={ctaStyle} onClick={() => go('register')}
                onMouseOver={e => { e.currentTarget.style.background='#7c3aed'; e.currentTarget.style.color='#fff'; }}
                onMouseOut={e => { e.currentTarget.style.background='none'; e.currentTarget.style.color='#a78bfa'; }}>
                Contact Us
              </button>
            )}
          </div>

          {/* Hamburger */}
          <button onClick={() => setMenuOpen(o => !o)} style={{ display:'none', flexDirection:'column', gap:5, background:'none', border:'none', cursor:'pointer', padding:4 }} className="nav-hamburger-btn">
            <span style={{ display:'block', width:22, height:2, background:'#a78bfa', borderRadius:2 }}/>
            <span style={{ display:'block', width:22, height:2, background:'#a78bfa', borderRadius:2 }}/>
            <span style={{ display:'block', width:22, height:2, background:'#a78bfa', borderRadius:2 }}/>
          </button>
        </div>
      </nav>

      {/* Mobile Menu */}
      {menuOpen && (
        <div style={{ position:'sticky', top:64, zIndex:999, background:'rgba(10,8,32,.98)', borderTop:'1px solid rgba(124,58,237,.18)', padding:'16px 24px', display:'flex', flexDirection:'column', gap:4 }}>
          {links.map(l => (
            <a key={l.key} href={l.href} style={{ ...linkStyle(view===l.key), display:'block', textAlign:'left', padding:'10px 14px' }}>{l.label}</a>
          ))}
          <button style={{ ...ctaStyle, marginTop:8, borderRadius:10, textAlign:'center', display:'block' }} onClick={() => { setMenuOpen(false); go('register'); }}>Contact Us</button>
        </div>
      )}

      <style>{`
        @media(max-width:900px){
          .nav-desktop-links { display: none !important; }
          .nav-hamburger-btn { display: flex !important; }
        }
      `}</style>
    </>
  );
};

/* ── COSMOS ── */
const Cosmos=()=>{
  const orbs=[
    {r:45,d:8,dl:'0s',sz:20,bg:'linear-gradient(135deg,#7c3aed,#a78bfa)',gw:'rgba(124,58,237,.7)',ic:'BookOpen'},
    {r:67,d:13,dl:'-5s',sz:18,bg:'linear-gradient(135deg,#0ea5e9,#38bdf8)',gw:'rgba(56,189,248,.7)',ic:'GraduationCap'},
    {r:90,d:19,dl:'-9s',sz:15,bg:'linear-gradient(135deg,#a78bfa,#38bdf8)',gw:'rgba(167,139,250,.7)',ic:'Zap'},
  ];
  return(
    <div className="cosmos-wrap">
      <div className="cosmos">
        <div className="ring r1"/><div className="ring r2"/><div className="ring r3"/>
        <div className="pring" style={{width:58,height:58}}/>
        <div className="pring" style={{width:58,height:58,animationDelay:'1.2s',opacity:.4}}/>
        <div className="core">
          <img src="../asset/img/favicon_logo_2.png" style={{width:32,objectFit:'contain',filter:'brightness(2.5)'}} onError={e=>e.target.style.display='none'} alt="G"/>
        </div>
        {orbs.map((o,i)=>(
          <div key={i} className="orb-track" style={{animation:`orbit ${o.d}s linear infinite`,animationDelay:o.dl,'--r':o.r+'px'}}>
            <div className="orb" style={{width:o.sz,height:o.sz,background:o.bg,boxShadow:`0 0 12px ${o.gw}`,marginLeft:-o.r,marginTop:-o.sz/2}}>
              <Ico n={o.ic} s={Math.round(o.sz*.44)} cls="text-white"/>
            </div>
          </div>
        ))}
        <div className="lbl" style={{top:'6%',left:'48%'}}>Guru Belajar</div>
        <div className="lbl" style={{top:'66%',left:'-5%'}}>Guru Mengajar</div>
        <div className="lbl" style={{bottom:'4%',right:'-8%'}}>Guru Inspira</div>
      </div>
    </div>
  );
};
