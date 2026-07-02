// Member Portal — React App
// Loaded externally so Blade/PHP never parses JSX

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

/* ── KARTU ── */
const Kartu=({m,onBack})=>{
  const [flipped,setFlipped]=useState(false);
  const fmt=ts=>new Date(ts).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'});

  const CardFront=()=>(
    <div className="face cshell">
      <img src="https://images.unsplash.com/photo-1614850715649-1d0106293bd1?q=80&w=2070&auto=format&fit=crop"
        style={{position:'absolute',inset:0,width:'100%',height:'100%',objectFit:'cover',opacity:.35}} alt=""/>
      <div style={{position:'absolute',inset:0,background:'linear-gradient(135deg,rgba(15,12,41,.93) 0%,rgba(109,40,217,.38) 60%,rgba(15,12,41,.28) 100%)'}}/>
      <div style={{position:'absolute',top:-40,right:-40,width:160,height:160,background:'rgba(167,139,250,.18)',borderRadius:'50%',filter:'blur(55px)'}}/>
      <div style={{position:'absolute',bottom:-30,left:-20,width:110,height:110,background:'rgba(56,189,248,.13)',borderRadius:'50%',filter:'blur(45px)'}}/>
      <div className="cin">
        <div style={{display:'flex',justifyContent:'space-between',alignItems:'flex-start'}}>
          <div style={{display:'flex',alignItems:'center',gap:9}}>
            <div style={{width:32,height:32,background:'rgba(255,255,255,.14)',borderRadius:8,display:'flex',alignItems:'center',justifyContent:'center',backdropFilter:'blur(4px)',border:'1px solid rgba(255,255,255,.18)'}}>
              <Ico n="Globe" s={15} cls="text-white"/>
            </div>
            <div>
              <p style={{fontWeight:900,fontSize:'.9rem',color:'#fff',letterSpacing:'-.01em',lineHeight:1}}>GURUVERSE.ID</p>
              <p style={{fontSize:'5.5px',textTransform:'uppercase',letterSpacing:'.32em',color:'rgba(255,255,255,.52)',fontWeight:700}}>EKOSISTEM DIGITAL GURU</p>
            </div>
          </div>
          <div style={{background:'rgba(167,139,250,.18)',border:'1px solid rgba(167,139,250,.28)',borderRadius:'.45rem',padding:'2px 9px'}}>
            <p style={{fontSize:'6.5px',fontWeight:700,color:'var(--accent)',textTransform:'uppercase',letterSpacing:'.12em'}}>Verified</p>
          </div>
        </div>
        <div style={{marginTop:'auto',marginBottom:'.85rem',display:'flex',alignItems:'center',gap:12}}>
          <div style={{width:58,height:58,borderRadius:13,overflow:'hidden',border:'1.5px solid rgba(167,139,250,.4)',boxShadow:'0 0 18px rgba(109,40,217,.4)',flexShrink:0,background:'rgba(26,21,96,.6)',display:'flex',alignItems:'center',justifyContent:'center'}}>
            {m.photo?<img src={m.photo} style={{width:'100%',height:'100%',objectFit:'cover'}} alt="f"/>:<Ico n="User" s={22} cls="text-white opacity-30"/>}
          </div>
          <div style={{overflow:'hidden'}}>
            <p style={{fontSize:'6px',textTransform:'uppercase',letterSpacing:'.2em',color:'rgba(255,255,255,.52)',fontWeight:700,marginBottom:3}}>ANGGOTA RESMI</p>
            <h2 style={{fontSize:'1.05rem',fontWeight:900,textTransform:'uppercase',color:'#fff',lineHeight:1.1,wordBreak:'break-word'}}>{m.fullName||'—'}</h2>
            <p style={{fontSize:'8px',color:'rgba(255,255,255,.62)',fontWeight:600,textTransform:'uppercase',fontStyle:'italic',marginTop:2,wordBreak:'break-word'}}>{m.institution||'—'}</p>
          </div>
        </div>
        <div style={{display:'flex',alignItems:'flex-end',justifyContent:'space-between',borderTop:'1px solid rgba(255,255,255,.1)',paddingTop:9}}>
          <div>
            <p style={{fontSize:'5.5px',textTransform:'uppercase',letterSpacing:'.2em',color:'rgba(255,255,255,.42)',fontWeight:700}}>ID ANGGOTA</p>
            <p className="mono" style={{fontSize:'.88rem',fontWeight:700,color:'#fff',marginTop:2,letterSpacing:'.05em'}}>{m.memberId||'—'}</p>
          </div>
          <Bar val={m.memberId||'GV0000'}/>
        </div>
      </div>
    </div>
  );

  const CardBack=()=>(
    <div className="face face-back cshell" style={{background:'linear-gradient(140deg,#1a0f3e 0%,#2a1865 35%,#3d2080 60%,#6030a0 100%)'}}>
      <div style={{position:'absolute',inset:0,background:'linear-gradient(135deg,transparent 30%,rgba(200,80,180,.22) 45%,rgba(170,60,160,.18) 55%,transparent 68%)',pointerEvents:'none'}}/>
      <div style={{position:'absolute',top:0,right:0,width:'50%',height:'55%',backgroundImage:'radial-gradient(circle,rgba(255,255,255,.1) 1.2px,transparent 1.2px)',backgroundSize:'13px 13px'}}/>
      <div style={{position:'absolute',bottom:'-15%',left:'-10%',width:'45%',height:'65%',background:'radial-gradient(ellipse,rgba(109,40,217,.3) 0%,transparent 65%)'}}/>
      <div style={{position:'relative',zIndex:10,height:'100%',display:'flex',flexDirection:'column',padding:'1rem 1.3rem',gap:0}}>
        <div style={{display:'flex',justifyContent:'space-between',alignItems:'center',marginBottom:8}}>
          <div>
            <p style={{fontWeight:900,fontSize:'.8rem',color:'#fff',letterSpacing:'-.01em',lineHeight:1}}>GURUVERSE<span style={{color:'#fbbf24'}}>.ID</span></p>
            <p style={{fontSize:'4.5px',textTransform:'uppercase',letterSpacing:'.3em',color:'rgba(255,255,255,.4)',fontWeight:700,marginTop:1}}>Member Card</p>
          </div>
          <div style={{background:'rgba(74,222,128,.1)',border:'1px solid rgba(74,222,128,.25)',borderRadius:20,padding:'2px 8px',display:'flex',alignItems:'center',gap:4}}>
            <span className="bl" style={{width:4,height:4,borderRadius:'50%',background:'#4ade80',display:'inline-block'}}/>
            <span style={{fontSize:'5.5px',fontWeight:800,color:'#4ade80',letterSpacing:'.12em',textTransform:'uppercase'}}>Aktif</span>
          </div>
        </div>
        <div style={{display:'grid',gridTemplateColumns:'1fr 1px 1fr',gap:'0 10px',flex:1,overflow:'hidden'}}>
          <div style={{display:'flex',flexDirection:'column',gap:5}}>
            {[
              {l:'Nama Lengkap',v:m.fullName||'—'},
              {l:'ID Anggota',v:m.memberId||'—',mono:true},
              {l:'Instansi',v:m.institution||'—'},
              {l:'Email',v:m.email||'—'},
              {l:'No. WhatsApp',v:m.phone||'—'},
              {l:'Bergabung',v:fmt(m.joinedAt)},
            ].map((row,i)=>(
              <div key={i} style={{display:'flex',flexDirection:'column',gap:1}}>
                <span style={{fontSize:'4.5px',textTransform:'uppercase',letterSpacing:'.18em',color:'rgba(255,255,255,.38)',fontWeight:700}}>{row.l}</span>
                <span style={{fontFamily:row.mono?'JetBrains Mono,monospace':undefined,fontSize:row.mono?'.58rem':'.62rem',fontWeight:700,color:'#fff',lineHeight:1.2,overflow:'hidden',textOverflow:'ellipsis',whiteSpace:'nowrap'}}>{row.v}</span>
              </div>
            ))}
          </div>
          <div style={{background:'rgba(255,255,255,.12)',borderRadius:2}}/>
          <div style={{display:'flex',flexDirection:'column',gap:6,paddingLeft:2}}>
            <div style={{display:'flex',flexDirection:'column',gap:8,height:'100%',justifyContent:'center'}}>
              <div style={{display:'flex',alignItems:'center',gap:4,marginBottom:2}}>
                <div style={{width:3,height:12,background:'#38bdf8',borderRadius:2}}/>
                <span style={{fontSize:'5.5px',fontWeight:800,textTransform:'uppercase',letterSpacing:'.18em',color:'#38bdf8'}}>3 Pilar Guruverse</span>
              </div>
              <div style={{display:'flex',flexDirection:'column',gap:6}}>
                {[
                  { t: 'Guru Belajar', d: 'Platform peningkatan kompetensi pendidik melalui pelatihan dan kelas terstruktur.' },
                  { t: 'Guru Mengajar', d: 'Wadah berbagi praktik baik, perangkat ajar, dan metode inovatif.' },
                  { t: 'Guru Inspira', d: 'Ruang publikasi karya, tulisan, dan pengalaman inspiratif.' }
                ].map((p,i)=>(
                  <div key={i} style={{display:'flex',flexDirection:'column',gap:1.5}}>
                    <div style={{display:'flex',gap:4,alignItems:'center'}}>
                      <span style={{width:4,height:4,borderRadius:'50%',background:'rgba(56,189,248,.8)'}}/>
                      <span style={{fontSize:'.58rem',fontWeight:800,color:'#fff'}}>{p.t}</span>
                    </div>
                    <span style={{fontSize:'.5rem',fontWeight:500,color:'rgba(255,255,255,.7)',lineHeight:1.35,paddingLeft:8}}>{p.d}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
        <div style={{borderTop:'1px solid rgba(255,255,255,.1)',paddingTop:6,marginTop:6}}>
          <Bar val={m.memberId||'GV0000'}/>
          <div style={{display:'flex',justifyContent:'space-between',marginTop:2}}>
            <p className="mono" style={{fontSize:'4.5px',color:'rgba(255,255,255,.3)',fontWeight:700,letterSpacing:'.04em'}}>{m.memberId||'—'}</p>
            <p style={{fontSize:'4.5px',color:'rgba(255,255,255,.25)',fontWeight:700,letterSpacing:'.1em',textTransform:'uppercase'}}>Guruverse.id © {new Date().getFullYear()}</p>
          </div>
        </div>
      </div>
    </div>
  );

  return(
    <div className="kpage">
      <div className="ktopbar noprint">
        <button onClick={onBack} style={{display:'flex',alignItems:'center',gap:5,fontWeight:700,fontSize:'.72rem',textTransform:'uppercase',letterSpacing:'.1em',color:'rgba(255,255,255,.5)',background:'none',border:'none',cursor:'pointer',transition:'color .2s'}}
          onMouseOver={e=>e.currentTarget.style.color='#fff'} onMouseOut={e=>e.currentTarget.style.color='rgba(255,255,255,.5)'}>
          <Ico n="ArrowLeft" s={13}/> Kembali
        </button>
        <span style={{fontWeight:700,fontSize:'.65rem',textTransform:'uppercase',letterSpacing:'.15em',color:'rgba(255,255,255,.35)',fontStyle:'italic'}}>Official Identity Card</span>
        <div style={{width:72}}/>
      </div>
      <div className="flip-scene" onClick={()=>setFlipped(f=>!f)} style={{cursor:'pointer'}} title="Klik untuk membalik">
        <div className={`flip-card${flipped?' flipped':''}`}>
          <CardFront/>
          <CardBack/>
        </div>
      </div>
      <div className="infobox noprint">
        <div style={{borderRight:'1px solid rgba(255,255,255,.07)',paddingRight:'.75rem'}}>
          <p style={{color:'rgba(255,255,255,.35)',fontWeight:700,textTransform:'uppercase',letterSpacing:'.1em',marginBottom:4,fontSize:'.58rem'}}>Tgl Penerbitan</p>
          <p style={{fontWeight:800,color:'#fff',fontSize:'.72rem'}}>{fmt(m.joinedAt)}</p>
        </div>
        <div style={{textAlign:'right'}}>
          <p style={{color:'rgba(255,255,255,.35)',fontWeight:700,textTransform:'uppercase',letterSpacing:'.1em',marginBottom:4,fontSize:'.58rem'}}>Status</p>
          <p style={{fontWeight:800,color:'#4ade80',display:'flex',alignItems:'center',justifyContent:'flex-end',gap:5,fontSize:'.72rem'}}>
            <span className="bl" style={{width:6,height:6,background:'#4ade80',borderRadius:'50%',display:'inline-block'}}/>Aktif
          </p>
        </div>
      </div>
      <div className="flip-btns noprint" style={{display:'flex',gap:'.6rem',width:'100%',maxWidth:460}}>
        <button onClick={()=>setFlipped(f=>!f)}
          style={{flex:1,display:'flex',alignItems:'center',justifyContent:'center',gap:6,background:'rgba(255,255,255,.06)',border:'1px solid rgba(255,255,255,.1)',borderRadius:10,padding:'.55rem',cursor:'pointer',fontFamily:'inherit',fontWeight:700,fontSize:'.72rem',color:'rgba(255,255,255,.55)',transition:'all .15s'}}
          onMouseOver={e=>{e.currentTarget.style.background='rgba(167,139,250,.12)';e.currentTarget.style.color='#fff';}}
          onMouseOut={e=>{e.currentTarget.style.background='rgba(255,255,255,.06)';e.currentTarget.style.color='rgba(255,255,255,.55)';}}>
          <Ico n="RefreshCw" s={13}/>{flipped?'Lihat Depan':'Lihat Belakang'}
        </button>
        <button onClick={()=>window.print()}
          style={{flex:1,display:'flex',alignItems:'center',justifyContent:'center',gap:6,background:'linear-gradient(135deg,#7c3aed,#6d28d9)',border:'none',borderRadius:10,padding:'.55rem',cursor:'pointer',fontFamily:'inherit',fontWeight:800,fontSize:'.72rem',color:'#fff',boxShadow:'0 4px 14px rgba(124,58,237,.4)',transition:'opacity .15s'}}
          onMouseOver={e=>e.currentTarget.style.opacity='.85'} onMouseOut={e=>e.currentTarget.style.opacity='1'}>
          <Ico n="Download" s={13}/> Simpan Kartu (PDF)
        </button>
      </div>
    </div>
  );
};

/* ── MEMBER MENU ── */
const MemberMenu = ({ member, onCard, onOut }) => {
  const pillars = [
    { t: 'Guru Belajar', s: '"Guru yang terus tumbuh dan memperdalam ilmunya."', c: '#3b82f6', ic: 'BookOpen', href: window.ROUTES.memberDashboard, img: '/asset/img/pilar_learning.png', bg: '#eff6ff' },
    { t: 'Guru Mengajar', s: "Guru yang mengimplementasikan nilai dan berdampak bagi murid serta komunitas.", c: '#10b981', ic: 'Users', href: '/member/mengajar', img: '/asset/img/pilar_teaching.png', bg: '#ecfdf5' },
    { t: 'Guru Inspira', s: "Guru yang saling menguatkan dan berbagi semangat.", c: '#8b5cf6', ic: 'Zap', href: '/member/inspira', img: '/asset/img/pilar_innovation.png', bg: '#f5f3ff' },
  ];

  return (
    <div className="dash-container">
      {/* Header */}
      <header className="dash-header">
        <div className="dash-logo">
          <img src="/asset/img/FA Logo Guruverse.ID - main.png" className="brand-logo-light" alt="GV" style={{ height: 32, display: 'block' }} />
          <img src="/asset/img/FA Logo Guruverse.ID - nrgative.png" className="brand-logo-dark" alt="GV" style={{ height: 32, display: 'none' }} />
          <span>Panel Member</span>
        </div>
        <div className="dash-actions">
          <button className="dash-btn-card" onClick={onCard}>
            <Ico n="IdCard" s={16} /> Kartu Saya
          </button>
          <button className="dash-btn-out" onClick={onOut}>
            <Ico n="LogOut" s={16} /> Keluar
          </button>
        </div>
      </header>

      <main className="dash-main">
        {/* Hero Section */}
        <section className="dash-hero">
          <div className="dash-hero-text">
            <h1 className="dash-greeting">Halo, {(member.fullName || 'Anggota').split(' ')[0]}!</h1>
            <div className="dash-greeting-line" />
            <p className="dash-sub">Selamat datang di Panel Member. Pilih portal yang ingin Anda akses sesuai kebutuhan Anda.</p>
          </div>
          <div className="dash-hero-img">
            <img src="/asset/img/hero_illustration_new.png" alt="Hero" />
            <div className="dash-floating-icon fi-1"><Ico n="GraduationCap" s={24} /></div>
            <div className="dash-floating-icon fi-2"><Ico n="Award" s={20} /></div>
          </div>
        </section>

        {/* Pillars Grid */}
        <section className="dash-grid">
          {pillars.map((p, i) => (
            <div key={i} className="dash-p-card" onClick={() => window.location.href = p.href}>
              <div className="dash-p-visual" style={{ background: p.bg }}>
                <img src={p.img} alt={p.t} />
              </div>
              <div className="dash-p-content">
                <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 12 }}>
                  <div className="dash-p-icon" style={{ color: p.c, background: `${p.c}15` }}>
                    <Ico n={p.ic} s={22} />
                  </div>
                  <h3 className="dash-p-title">{p.t}</h3>
                </div>
                <p className="dash-p-desc">{p.s}</p>
                <a href={p.href} className="dash-p-btn" style={{ background: p.c }} onClick={e => e.stopPropagation()}>
                  Masuk Portal <Ico n="ArrowRight" s={16} />
                </a>
              </div>
            </div>
          ))}
        </section>

        {/* Help Banner */}
        <section className="dash-help">
          <div className="dash-help-left">
            <div className="dash-wa-icon">
              <Ico n="MessageCircle" s={32} />
            </div>
            <div>
              <h4 className="dash-help-title">Butuh bantuan?</h4>
              <p className="dash-help-sub">Hubungi WhatsApp Support kami di</p>
              <p className="dash-wa-num">0831-3353-1303</p>
            </div>
          </div>
          <div className="dash-help-right">
            <img src="/asset/img/help_phone.png" alt="Phone" style={{ width: 140, transform: 'rotate(10deg) translateY(20px)' }} />
          </div>
        </section>
      </main>
    </div>
  );
};

/* ── LOGOUT MODAL ── */
const LogoutModal=({onConfirm,onCancel})=>(
  <div style={{position:'fixed',inset:0,zIndex:1000,background:'rgba(0,0,0,.55)',backdropFilter:'blur(6px)',display:'flex',alignItems:'center',justifyContent:'center',padding:'1rem'}}>
    <div style={{background:'#fff',borderRadius:20,padding:'2rem',width:'100%',maxWidth:340,boxShadow:'0 24px 60px rgba(0,0,0,.2)',animation:'fadeUp .3s cubic-bezier(.22,1,.36,1) both',textAlign:'center'}}>
      <div style={{width:56,height:56,borderRadius:'50%',background:'rgba(239,68,68,.1)',color:'#ef4444',display:'flex',alignItems:'center',justifyContent:'center',margin:'0 auto 1rem'}}>
        <Ico n="LogOut" s={26}/>
      </div>
      <h3 style={{fontSize:'1.15rem',fontWeight:900,color:'#0f172a',marginBottom:8}}>Keluar dari Akun?</h3>
      <p style={{fontSize:'.85rem',color:'#64748b',lineHeight:1.55,marginBottom:'1.5rem'}}>Anda harus login kembali untuk mengakses Panel Member Guruverse.</p>
      <div style={{display:'flex',gap:12}}>
        <button onClick={onCancel} style={{flex:1,padding:'.75rem',borderRadius:12,background:'#f1f5f9',color:'#475569',fontWeight:700,fontSize:'.9rem',border:'none',cursor:'pointer',transition:'background .2s'}}
          onMouseOver={e=>e.currentTarget.style.background='#e2e8f0'} onMouseOut={e=>e.currentTarget.style.background='#f1f5f9'}>
          Batal
        </button>
        <button onClick={onConfirm} style={{flex:1,padding:'.75rem',borderRadius:12,background:'#ef4444',color:'#fff',fontWeight:700,fontSize:'.9rem',border:'none',cursor:'pointer',boxShadow:'0 4px 14px rgba(239,68,68,.35)',transition:'opacity .2s'}}
          onMouseOver={e=>e.currentTarget.style.opacity='.85'} onMouseOut={e=>e.currentTarget.style.opacity='1'}>
          Ya, Keluar
        </button>
      </div>
    </div>
  </div>
);

/* ── APP ── */
const App=()=>{
  const [view,setView]=useState('menu');
  const [mem,setMem]=useState(window.CURRENT_MEMBER);
  const [showLogout,setShowLogout]=useState(false);

  const onCard=()=>setView('card');
  const onOut=()=>setShowLogout(true);
  const doLogout=()=>{
    document.getElementById('logout-form-member').submit();
  };

  useEffect(() => {
    var saved = localStorage.getItem('guruverse_theme');
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  }, []);

  if(!mem) return(
    <div style={{display:'flex',alignItems:'center',justifyContent:'center',minHeight:'100vh',color:'rgba(255,255,255,.6)',flexDirection:'column',gap:12}}>
      <Ico n="AlertCircle" s={32}/>
      <p>Sesi tidak ditemukan. <a href={window.ROUTES.login} style={{color:'var(--accent)'}}>Login kembali</a></p>
    </div>
  );

  return(
    <>
      {view==='menu'&&<MemberMenu member={mem} onCard={onCard} onOut={onOut}/>}
      {view==='card'&&<Kartu m={mem} onBack={()=>setView('menu')}/>}
      {showLogout&&<LogoutModal onConfirm={doLogout} onCancel={()=>setShowLogout(false)}/>}
    </>
  );
};

ReactDOM.createRoot(document.getElementById('root')).render(<App/>);
