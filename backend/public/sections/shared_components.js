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

/* ── NAVBAR ── */
const Nav = ({ view, go }) => {
  const [scrolled, setScrolled] = useState(false);
  useEffect(() => {
    const handle = () => setScrolled(window.scrollY > 50);
    window.addEventListener('scroll', handle);
    // Re-initialize FlyonUI for dynamic elements
    if (window.HSStaticMethods) window.HSStaticMethods.autoInit();
    return () => window.removeEventListener('scroll', handle);
  }, []);

  return (
    <nav className="nav" style={{ 
      background: 'var(--header-bg)',
      backdropFilter: 'blur(20px)',
      borderBottom: scrolled ? '1px solid var(--border)' : '1px solid transparent'
    }}>
      <a className="nav-logo" href="../index.php">
        <img src="../asset/img/logo guruverse FA.ai.png" alt="GV" onError={e => e.target.style.display = 'none'} />
        <span>GURUVERSE<em>.ID</em></span>
      </a>
      <ul className="nav-links flex items-center gap-6">
        <li><a href="../index.php" className="hover:text-white transition-colors">Beranda</a></li>
        
        {/* FlyonUI Dropdown for Program */}
        <li className="dropdown relative inline-flex">
          <button id="nav-dropdown-program" type="button" className="dropdown-toggle text-sm font-semibold text-slate-400 hover:text-white flex items-center gap-1 transition-colors" aria-haspopup="menu" aria-expanded="false" aria-label="Program">
            Program
          </button>
          <ul className="dropdown-menu dropdown-open:opacity-100 hidden min-w-48 bg-slate-900 border border-slate-700 shadow-2xl py-2 mt-2" role="menu" aria-orientation="vertical" aria-labelledby="nav-dropdown-program">
            <li><a className="dropdown-item text-white hover:bg-slate-800 py-2 px-4 flex items-center gap-2" href="../guru-belajar/Dashboard/program.php"><Ico n="BookOpen" s={14}/> Guru Belajar</a></li>
            <li><a className="dropdown-item text-white hover:bg-slate-800 py-2 px-4 flex items-center gap-2" href="#"><Ico n="Users" s={14}/> Guru Mengajar</a></li>
            <li><a className="dropdown-item text-white hover:bg-slate-800 py-2 px-4 flex items-center gap-2" href="#"><Ico n="Zap" s={14}/> Guru Inspira</a></li>
          </ul>
        </li>

        <li><a href="../guru-belajar/Dashboard/testimoni.php" className="hover:text-white transition-colors">Testimoni</a></li>
        <li><a href="learn-more.php" className={view === 'about' ? 'on' : 'hover:text-white transition-colors'}>Tentang</a></li>
        {window.isMemberLoggedIn && (
          <li>
            <a href="../guru-belajar/member/index.php?page=cart" className="hover:text-white transition-colors flex items-center gap-1.5">
              <Ico n="ShoppingCart" s={15} /> Keranjang Saya
            </a>
          </li>
        )}
        <li>
          {window.isMemberLoggedIn ? (
            <a href="../guru-belajar/member/index.php" className="nav-btn" style={{ background: 'linear-gradient(135deg, #10b981, #059669)', boxShadow: '0 4px 12px rgba(16,185,129,0.3)' }}>
              <Ico n="LayoutDashboard" s={16} /> Dashboard Saya
            </a>
          ) : (
            <a href="#" className="nav-btn" onClick={e => { e.preventDefault(); go('register'); }}>
              <Ico n="User" s={16} /> Akses Anggota
            </a>
          )}
        </li>
      </ul>
    </nav>
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
