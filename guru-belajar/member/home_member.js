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
const AksiDropdown=({m,onCard,onDelete})=>{
  const [open,setOpen]=useState(false);
  const ref=useRef(null);
  useEffect(()=>{
    const handler=e=>{if(ref.current&&!ref.current.contains(e.target))setOpen(false);};
    document.addEventListener('mousedown',handler);
    return()=>document.removeEventListener('mousedown',handler);
  },[]);
  const items=[
    {ic:'IdCard',  label:'Lihat Kartu',color:'#a78bfa',action:()=>{onCard(m);setOpen(false);}},
    {ic:'Pencil',  label:'Edit',       color:'#38bdf8',action:()=>{alert('Fitur edit segera hadir!');setOpen(false);}},
    {ic:'Trash2',  label:'Hapus',      color:'#f87171',action:()=>{if(confirm(`Hapus ${m.fullName}?`))onDelete(m);setOpen(false);}},
  ];
  return(
    <div ref={ref} style={{position:'relative',display:'inline-block',textAlign:'left'}}>
      <button onClick={()=>setOpen(o=>!o)} style={{
        display:'inline-flex',alignItems:'center',gap:5,
        background:open?'rgba(109,40,217,.35)':'rgba(109,40,217,.2)',
        color:'#a78bfa',border:'1px solid rgba(109,40,217,.4)',
        borderRadius:8,padding:'.34rem .7rem',cursor:'pointer',
        fontFamily:'inherit',fontWeight:700,fontSize:'.66rem',
        textTransform:'uppercase',letterSpacing:'.06em',transition:'all .15s',whiteSpace:'nowrap',
      }}>
        <Ico n="MoreHorizontal" s={12}/>Aksi
        <span style={{display:'inline-block',transform:open?'rotate(180deg)':'rotate(0deg)',transition:'transform .2s',lineHeight:0}}>
          <Ico n="ChevronDown" s={11}/>
        </span>
      </button>
      {open&&(
        <div style={{
          position:'absolute',right:0,top:'calc(100% + 6px)',zIndex:999,
          background:'rgba(20,16,50,.97)',border:'1px solid rgba(255,255,255,.12)',
          borderRadius:12,overflow:'hidden',boxShadow:'0 16px 40px rgba(0,0,0,.55)',
          minWidth:148,animation:'fadeUp .18s cubic-bezier(.22,1,.36,1) both',
        }}>
          {items.map((it,i)=>(
            <button key={i} onClick={it.action} style={{
              width:'100%',display:'flex',alignItems:'center',gap:9,
              padding:'.58rem .85rem',background:'transparent',border:'none',
              cursor:'pointer',fontFamily:'inherit',fontSize:'.72rem',fontWeight:700,
              color:it.color,textAlign:'left',transition:'background .12s',
              borderBottom:i<items.length-1?'1px solid rgba(255,255,255,.05)':'none',
            }}
            onMouseOver={e=>e.currentTarget.style.background='rgba(255,255,255,.06)'}
            onMouseOut={e=>e.currentTarget.style.background='transparent'}>
              <Ico n={it.ic} s={13}/>{it.label}
            </button>
          ))}
        </div>
      )}
    </div>
  );
};

/* ── NAVBAR ── */
const Nav=({view,go})=>(
  <nav className="nav">
        <a className="nav-logo" href="../../index.php">
          <img src="../../asset/img/FA Logo Guruverse.ID - main.png" className="brand-logo-light" alt="Guruverse" style={{ display: 'none' }} />
          <img src="../../asset/img/FA Logo Guruverse.ID - nrgative.png" className="brand-logo-dark" alt="Guruverse" style={{ display: 'block' }} />
      <span>GURUVERSE.ID</span>
    </a>
    <ul className="nav-links">
      <li><a href="../../index.php">Beranda</a></li>
      <li><a href="#" className={view==='register'?'on':''} onClick={e=>{e.preventDefault();go('register');}}>Akses Anggota</a></li>
      <li><a href="../Dashboard/about.php">Tentang Kami</a></li>
    </ul>
  </nav>
);

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
        <div style={{display:'flex',flexDirection:'column',alignItems:'center',gap:16}}>
          <img src="../../asset/img/FA Logo Guruverse.ID - main.png" className="brand-logo-light" style={{width:32,objectFit:'contain',display:'none'}} alt="G"/>
          <img src="../../asset/img/FA Logo Guruverse.ID - nrgative.png" className="brand-logo-dark" style={{width:32,objectFit:'contain',display:'block'}} alt="G"/>
        </div>
        {orbs.map((o,i)=>(
          <div key={i} className="orb-track" style={{animation:`orbit ${o.d}s linear infinite`,animationDelay:o.dl,'--r':o.r+'px'}}>
            <div className="orb" style={{width:o.sz,height:o.sz,background:o.bg,boxShadow:`0 0 12px ${o.gw}`,marginLeft:-o.r,marginTop:-o.sz/2}}>
              <Ico n={o.ic} s={Math.round(o.sz*.44)} cls="text-white"/>
            </div>
          </div>
        ))}
        <div className="lbl" style={{top:'6%',left:'48%'}}>Learning</div>
        <div className="lbl" style={{top:'66%',left:'-5%'}}>Teaching</div>
        <div className="lbl" style={{bottom:'4%',right:'-8%'}}>Innovation</div>
      </div>
    </div>
  );
};


/* ── LOGIN FORM ── */
const LoginForm = ({ onOk, onAdminOk, onSwitch }) => {
  const [f, setF] = useState({ user: '', pass: '' });
  const [ld, setLd] = useState(false);
  const [err, setErr] = useState('');
  const [showPass, setShowPass] = useState(false);
  const [remember, setRemember] = useState(false);
  const [accounts, setAccounts] = useState([]);
  const [matching, setMatching] = useState([]);
  const [showHistory, setShowHistory] = useState(false);

  useEffect(() => {
    const saved = localStorage.getItem('gv_accounts');
    if (saved) {
      try {
        setAccounts(JSON.parse(saved));
      } catch { setAccounts([]); }
    }
  }, []);

  const handleUserChange = (val) => {
    setF({ ...f, user: val });
    if (val.trim().length > 0) {
      const filtered = accounts.filter(acc => acc.user.toLowerCase().includes(val.toLowerCase()));
      setMatching(filtered);
      setShowHistory(filtered.length > 0);
    } else {
      setMatching([]);
      setShowHistory(false);
    }
  };

  const selectAccount = (acc) => {
    setF({ user: acc.user, pass: acc.pass });
    setShowHistory(false);
  };
  
  const sub = async (e) => {
    e.preventDefault();
    setLd(true); setErr('');
    try {
      let success = false;
      if (f.user.toLowerCase() === 'admin') {
        const fd = new FormData(); fd.append('pass', f.pass);
        const r = await fetch('../../modules/member/login/admin_login.php', { method: 'POST', body: fd });
        const d = await r.json();
        if (d.success) { success = true; onAdminOk(); } 
        else setErr(d.message || 'Password Admin salah.');
      } else {
        const fd = new FormData(); fd.append('username', f.user); fd.append('password', f.pass);
        const r = await fetch('../../modules/member/login/member_login.php', { method: 'POST', body: fd });
        const d = await r.json();
        if (d.success) { success = true; onOk(d.member); } 
        else if (d.need_setup) {
          alert(d.message);
          window.location.href = 'set-password.php';
        }
        else setErr(d.message || 'Login gagal.');
      }

      if (success && remember) {
        let newAccs = [...accounts];
        const idx = newAccs.findIndex(a => a.user.toLowerCase() === f.user.toLowerCase());
        if (idx > -1) newAccs[idx] = { user: f.user, pass: f.pass };
        else newAccs.push({ user: f.user, pass: f.pass });
        localStorage.setItem('gv_accounts', JSON.stringify(newAccs));
        setAccounts(newAccs);
      }
    } catch { setErr('Gagal menghubungi server.'); } finally { setLd(false); }
  };

  return (
    <div className="panel fu">
      <div>
        <div style={{display:'flex',alignItems:'center',gap:7,marginBottom:'.5rem'}}>
          <div style={{width:7,height:7,borderRadius:'50%',background:'var(--accent)'}}/>
          <span style={{fontSize:'.6rem',fontWeight:700,textTransform:'uppercase',letterSpacing:'.18em',color:'var(--accent)'}}>Guruverse.id</span>
        </div>
        <p className="ptitle">Masuk Akun</p>
        <p className="psub">Gunakan akun Anggota atau Admin Anda</p>
      </div>
      {err && <div className="err-box"><Ico n="AlertCircle" s={13} cls="text-red-400" />{err}</div>}
      <form onSubmit={sub} style={{ display: 'flex', flexDirection: 'column', gap: '.8rem', position: 'relative' }}>
        <div className="fg">
          <label>Username / Email</label>
          <div className="fi-wrap">
            <span className="fico"><Ico n="User" s={14} /></span>
            <input required type="text" placeholder="Masukkan username" className="fi" value={f.user} onChange={e => handleUserChange(e.target.value)} onFocus={() => f.user && matching.length > 0 && setShowHistory(true)} onBlur={() => setTimeout(() => setShowHistory(false), 200)} />
            
            {showHistory && (
              <div style={{ position: 'absolute', top: '110%', left: 0, right: 0, background: 'rgba(20,16,50,.97)', border: '1px solid rgba(255,255,255,.12)', borderRadius: 12, zIndex: 99, overflow: 'hidden', boxShadow: '0 10px 25px rgba(0,0,0,.5)' }}>
                {matching.map((acc, i) => (
                  <div key={i} onClick={() => selectAccount(acc)} style={{ padding: '.65rem .9rem', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: 10, transition: 'background .2s', borderBottom: i < matching.length - 1 ? '1px solid rgba(255,255,255,0.05)' : 'none' }}
                       onMouseOver={e => e.currentTarget.style.background = 'rgba(255,255,255,.08)'} onMouseOut={e => e.currentTarget.style.background = 'transparent'}>
                    <div style={{ width: 24, height: 24, borderRadius: '50%', background: 'var(--accent)', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '.7rem', fontWeight: 800, color: '#fff' }}>{acc.user[0].toUpperCase()}</div>
                    <span style={{ fontSize: '.8rem', fontWeight: 600, color: '#fff' }}>{acc.user}</span>
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>
        <div className="fg">
          <label>Kata Sandi</label>
          <div className="fi-wrap">
            <span className="fico"><Ico n="KeyRound" s={14} /></span>
            <input required type={showPass ? "text" : "password"} placeholder="••••••••" className="fi" value={f.pass} onChange={e => setF({ ...f, pass: e.target.value })} style={{ paddingRight: '2.5rem' }} />
            <span onClick={() => setShowPass(!showPass)} style={{ position: 'absolute', right: '0.8rem', top: '50%', transform: 'translateY(-50%)', cursor: 'pointer', display: 'flex', alignItems: 'center', color: 'rgba(255,255,255,.3)' }}>
              <Ico n={showPass ? "EyeOff" : "Eye"} s={14} />
            </span>
          </div>
        </div>
        <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginTop: '-0.2rem' }}>
          <input type="checkbox" id="remember" checked={remember} onChange={e => setRemember(e.target.checked)} style={{ cursor: 'pointer', accentColor: 'var(--accent)' }} />
          <label htmlFor="remember" style={{ fontSize: '.7rem', fontWeight: 600, color: 'rgba(255,255,255,.5)', cursor: 'pointer', textTransform: 'none', letterSpacing: 'normal' }}>Ingat Saya</label>
        </div>
        <button type="submit" className="btn" disabled={ld} style={{marginTop:'.5rem'}}>
          {ld ? <><span className="sp" />&nbsp;Memproses...</> : 'Masuk Sekarang →'}
        </button>
      </form>
      <p style={{ textAlign: 'center', fontSize: '.72rem', color: 'rgba(255,255,255,.4)', marginTop:'.5rem' }}>
        Belum punya akun? <a href="#" onClick={(e)=>{e.preventDefault(); onSwitch();}} style={{ color: 'var(--accent)', fontWeight: 700, textDecoration: 'none' }}>Daftar di sini</a>
      </p>
    </div>
  );
};

/* ── FORM PENDAFTARAN ── */
const RegForm=({onOk, onSwitch})=>{
  const [f,setF]=useState({fullName:'',username:'',institution:'',phone:'',password:''});
  const [ph,setPh]=useState(null);const [ld,setLd]=useState(false);const [err,setErr]=useState('');
  const fref=useRef(null);
  const upd=k=>ev=>setF(p=>({...p,[k]:ev.target.value}));
  const onFile=ev=>{
    const file=ev.target.files[0];if(!file)return;
    if(file.size>2*1024*1024){setErr('Ukuran foto maks 2MB.');return;}
    const rd=new FileReader();rd.onloadend=()=>{setPh(rd.result);setErr('');};rd.readAsDataURL(file);
  };
  const sub=async ev=>{
    ev.preventDefault();setLd(true);setErr('');
    try{
      const fd=new FormData();
      Object.entries(f).forEach(([k,v])=>fd.append(k,v));
      if(ph)fd.append('photoBase64',ph);
      const rs=await fetch('../../modules/member/register/register.php',{method:'POST',body:fd});
      const d=await rs.json();
      if(d.success)onOk(d);else setErr(d.message||'Pendaftaran gagal.');
    }catch{setErr('Gagal menghubungi server.');}finally{setLd(false);}
  };
  return(
    <div className="panel fu">
      <div>
        <div style={{display:'flex',alignItems:'center',gap:7,marginBottom:'.5rem'}}>
          <div style={{width:7,height:7,borderRadius:'50%',background:'var(--accent)'}}/>
          <span style={{fontSize:'.6rem',fontWeight:700,textTransform:'uppercase',letterSpacing:'.18em',color:'var(--accent)'}}>Guruverse.id</span>
        </div>
        <p className="ptitle">Daftar Anggota</p>
        <p className="psub">Bergabunglah dalam ekosistem guru Indonesia</p>
      </div>
      {err&&<div className="err-box"><Ico n="AlertCircle" s={13} cls="text-red-400"/>{err}</div>}
      <div style={{display:'flex',alignItems:'flex-end',gap:'.85rem'}}>
        <div>
          <p style={{fontSize:'.58rem',fontWeight:700,textTransform:'uppercase',letterSpacing:'.1em',color: 'rgba(255,255,255,.38)',marginBottom:'.3rem'}}>Foto</p>
          <div className={`photo-box${ph?' has':''}`} onClick={()=>fref.current?.click()}>
            {ph?<img src={ph} style={{width:'100%',height:'100%',objectFit:'cover'}} alt="p"/>
              :<div style={{display:'flex',flexDirection:'column',alignItems:'center',color:'rgba(255,255,255,.25)'}}>
                <Ico n="Camera" s={18}/><span style={{fontSize:'.52rem',fontWeight:700,textTransform:'uppercase',letterSpacing:'.07em',marginTop:2}}>Foto</span>
              </div>}
            <div className="pbar"><Ico n="Upload" s={8} cls="text-white"/></div>
          </div>
          <input type="file" ref={fref} style={{display:'none'}} accept="image/*" onChange={onFile}/>
          {ph&&<button type="button" onClick={()=>setPh(null)} style={{background:'none',border:'none',cursor:'pointer',marginTop:'.25rem',display:'flex',alignItems:'center',gap:2,color:'#f87171',fontSize:'.58rem',fontWeight:700,textTransform:'uppercase',letterSpacing:'.05em'}}>
            <Ico n="X" s={9}/> Hapus
          </button>}
        </div>
        <div className="fg" style={{flex:1}}>
          <label>Nama Lengkap & Gelar</label>
          <div className="fi-wrap">
            <span className="fico"><Ico n="User" s={14}/></span>
            <input required type="text" placeholder="Budi Santoso, S.Pd." className="fi" value={f.fullName} onChange={upd('fullName')}/>
          </div>
        </div>
      </div>
      <form onSubmit={sub} style={{display:'flex',flexDirection:'column',gap:'.65rem'}}>
        {[
          {k:'username',ic:'Mail',lb:'Alamat Surel',ph:'nama@email.com',t:'email'},
          {k:'password',ic:'KeyRound',lb:'Kata Sandi',ph:'••••••••',t:'password'},
          {k:'institution',ic:'School',lb:'Asal Sekolah / Instansi',ph:'SMA Negeri 1 Bandung',t:'text'},
          {k:'phone',ic:'Phone',lb:'No. WhatsApp',ph:'08xxxxxxxxxx',t:'tel'},
        ].map(fl=>(
          <div key={fl.k} className="fg">
            <label>{fl.lb}</label>
            <div className="fi-wrap">
              <span className="fico"><Ico n={fl.ic} s={14}/></span>
              <input required type={fl.t} placeholder={fl.ph} className="fi" value={f[fl.k]} onChange={upd(fl.k)}/>
            </div>
          </div>
        ))}
        <button type="submit" className="btn" disabled={ld} style={{marginTop:'.1rem'}}>
          {ld?<><span className="sp"/>&nbsp;Memproses...</>:'Daftar Sekarang →'}
        </button>
      </form>
      <p style={{ textAlign: 'center', fontSize: '.72rem', color: 'rgba(255,255,255,.4)', marginTop:'.3rem' }}>
        Sudah punya akun? <a href="#" onClick={(e)=>{e.preventDefault(); onSwitch();}} style={{ color: 'var(--accent)', fontWeight: 700, textDecoration: 'none' }}>Masuk di sini</a>
      </p>
    </div>
  );
};

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

/* ── ADMIN ── */
const Admin=({onCard,onOut})=>{
  const [mem,setMem]=useState([]);const [st,setSt]=useState({total:0,today:0,month:0});
  const [q,setQ]=useState('');const [ld,setLd]=useState(true);const [er,setEr]=useState('');

  const load=useCallback(async()=>{
    setLd(true);setEr('');
    try{
      const r=await fetch('../../modules/dashboard/get_members.php');
      if(r.status===401){onOut();return;}
      const d=await r.json();
      if(d.success){setMem(d.members);setSt(d.stats);}else setEr(d.message);
    }catch{setEr('Gagal memuat data.');}finally{setLd(false);}
  },[]);

  useEffect(()=>{load();},[]);

  const handleDelete=async(m)=>{
    try{
      const fd=new FormData();fd.append('memberId',m.memberId);
      const r=await fetch('../../modules/dashboard/delete_member.php',{method:'POST',body:fd});
      const d=await r.json();
      if(d.success)load();else alert(d.message||'Gagal menghapus.');
    }catch{alert('Gagal menghubungi server.');}
  };

  const rows=useMemo(()=>mem.filter(m=>[m.fullName,m.institution,m.memberId,m.email].some(v=>v&&v.toLowerCase().includes(q.toLowerCase()))),[mem,q]);
  const wa=p=>{let n=p.replace(/\D/g,'');if(n.startsWith('0'))n='62'+n.slice(1);return`https://wa.me/${n}`;};

  return(
    <div className="adm">
      <div className="adm-inner">
        <div style={{display:'flex',alignItems:'center',justifyContent:'space-between',flexWrap:'wrap',gap:'.8rem'}}>
          <div>
            <h2 style={{fontWeight:900,fontSize:'1.2rem',letterSpacing:'-.02em'}}>Dashboard Admin</h2>
            <p style={{fontSize:'.63rem',fontWeight:600,color:'rgba(255,255,255,.4)',textTransform:'uppercase',letterSpacing:'.1em',marginTop:2}}>Rekapitulasi Anggota Guruverse.id</p>
          </div>
          <div style={{display:'flex',gap:'.45rem',flexWrap:'wrap'}}>
            <button className="btn-sm" onClick={()=>window.open('../../modules/dashboard/export_xlsx.php','_blank')}
              style={{background:'rgba(52,211,153,.12)',color:'#34d399',border:'1px solid rgba(52,211,153,.22)'}}>
              <Ico n="FileDown" s={12}/>Export Excel
            </button>
            <button className="btn-sm" onClick={load}
              style={{background:'rgba(255,255,255,.05)',color:'rgba(255,255,255,.6)',border:'1px solid rgba(255,255,255,.1)'}}>
              <Ico n="RefreshCw" s={12}/>Refresh
            </button>
            <button className="btn-sm" onClick={onOut}
              style={{background:'rgba(239,68,68,.1)',color:'#f87171',border:'1px solid rgba(239,68,68,.2)'}}>
              <Ico n="LogOut" s={12}/>Keluar
            </button>
          </div>
        </div>

        <div className="stats">
          {[
            {ic:'Users',lb:'Total Anggota',val:st.total,bg:'rgba(255,255,255,.04)',border:true},
            {ic:'CalendarDays',lb:'Hari Ini',val:st.today,bg:'linear-gradient(135deg,#7c3aed,#4c1d95)',border:false},
            {ic:'TrendingUp',lb:'Bulan Ini',val:st.month,bg:'rgba(255,255,255,.04)',border:true},
          ].map((s,i)=>(
            <div key={i} className="sc" style={{background:s.bg,border:s.border?'1px solid rgba(255,255,255,.08)':'none',boxShadow:!s.border?'0 8px 24px rgba(109,40,217,.28)':'none'}}>
              <div style={{width:40,height:40,borderRadius:10,background:'rgba(255,255,255,.1)',display:'flex',alignItems:'center',justifyContent:'center',flexShrink:0}}>
                <Ico n={s.ic} s={18} cls="text-white opacity-70"/>
              </div>
              <div>
                <p style={{fontSize:'.6rem',fontWeight:700,textTransform:'uppercase',letterSpacing:'.1em',color:'rgba(255,255,255,.45)',marginBottom:2}}>{s.lb}</p>
                <p style={{fontSize:'1.65rem',fontWeight:900,lineHeight:1}}>{s.val}</p>
              </div>
            </div>
          ))}
        </div>

        <div className="tbl-card">
          <div style={{padding:'.8rem 1rem',borderBottom:'1px solid rgba(255,255,255,.06)',display:'flex',gap:'.5rem',alignItems:'center',flexWrap:'wrap'}}>
            <div style={{position:'relative',flex:1,display:'flex',alignItems:'center'}}>
              <span style={{position:'absolute',left:10,display:'flex',alignItems:'center',color:'rgba(255,255,255,.25)'}}>
                <Ico n="Search" s={13}/>
              </span>
              <input className="fi-search" style={{paddingLeft:'2.2rem'}} placeholder="Cari nama, instansi, email, atau ID..." value={q} onChange={e=>setQ(e.target.value)}/>
            </div>
            <span style={{fontSize:'.63rem',fontWeight:600,color:'rgba(255,255,255,.28)',whiteSpace:'nowrap'}}>{rows.length} anggota</span>
          </div>
          {er&&<div style={{padding:'.7rem 1rem',color:'#f87171',fontWeight:600,fontSize:'.78rem'}}>{er}</div>}
          <div style={{overflowX:'auto'}}>
            <table>
              <thead>
                <tr>
                  <th>Identitas</th><th>Instansi & Kontak</th><th>Bergabung</th><th style={{textAlign:'right'}}>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {ld&&[...Array(5)].map((_,i)=>(
                  <tr key={i}>
                    {[120,160,80,90].map((w,j)=>(<td key={j}><div className="skel" style={{height:11,width:w}}/></td>))}
                  </tr>
                ))}
                {!ld&&rows.length===0&&(
                  <tr><td colSpan="4" style={{textAlign:'center',padding:'2.5rem',color:'rgba(255,255,255,.25)',fontSize:'.8rem',fontWeight:600}}>Tidak ada anggota ditemukan.</td></tr>
                )}
                {!ld&&rows.map((m,i)=>(
                  <tr key={i}>
                    <td>
                      <div style={{display:'flex',alignItems:'center',gap:9}}>
                        <div style={{width:34,height:34,borderRadius:9,overflow:'hidden',background:'rgba(109,40,217,.2)',border:'1px solid rgba(167,139,250,.18)',display:'flex',alignItems:'center',justifyContent:'center',fontWeight:800,fontSize:'.6rem',color:'var(--accent)',flexShrink:0}}>
                          {m.photo?<img src={m.photo} style={{width:'100%',height:'100%',objectFit:'cover'}} alt=""/>:'GV'}
                        </div>
                        <div>
                          <p style={{fontWeight:700,color:'#fff',fontSize:'.79rem'}}>{m.fullName}</p>
                          <p className="mono" style={{fontSize:'.61rem',color:'rgba(255,255,255,.35)',fontWeight:600}}>{m.memberId}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p style={{fontWeight:600,color:'rgba(255,255,255,.6)',fontStyle:'italic',fontSize:'.75rem'}}>{m.institution}</p>
                      <a href={wa(m.phone)} target="_blank" rel="noreferrer"
                        style={{display:'inline-flex',alignItems:'center',gap:3,color:'#4ade80',fontWeight:700,fontSize:'.67rem',textDecoration:'none',marginTop:2}}>
                        <Ico n="MessageCircle" s={9}/>{m.phone}
                      </a>
                    </td>
                    <td style={{color:'rgba(255,255,255,.38)',fontWeight:600,fontSize:'.71rem',whiteSpace:'nowrap'}}>
                      {new Date(m.joinedAt).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'})}
                    </td>
                    <td style={{textAlign:'right'}}>
                      <AksiDropdown m={m} onCard={onCard} onDelete={handleDelete}/>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        <p style={{textAlign:'center',fontSize:'.63rem',color:'rgba(255,255,255,.15)',fontWeight:600,letterSpacing:'.1em',textTransform:'uppercase'}}>
          &copy; {new Date().getFullYear()} Guruverse.id — ACF Eduhub
        </p>
      </div>
    </div>
  );
};

/* ── MEMBER MENU ── */
const MemberMenu = ({ member, onCard, onOut }) => {
  const pillars = [
    { t: 'Guru Belajar', s: '"Guru yang terus tumbuh dan memperdalam ilmunya."', c: '#3b82f6', ic: 'BookOpen', href: 'index.php', img: '../../asset/img/pilar_learning.png', bg: '#eff6ff' },
    { t: 'Guru Mengajar', s: "Guru yang mengimplementasikan nilai dan berdampak bagi murid serta komunitas.", c: '#10b981', ic: 'Users', href: 'pages/Guru_Mengajar/index.php', img: '../../asset/img/pilar_teaching.png', bg: '#ecfdf5' },
    { t: 'Guru Inspira', s: 'Guru yang saling menguatkan dan berbagi semangat.', c: '#8b5cf6', ic: 'Zap', href: 'pages/Guru_Inspira/index.php', img: '../../asset/img/pilar_innovation.png', bg: '#f5f3ff' },
  ];

  return (
    <div className="dash-container">
      {/* Header */}
      <header className="dash-header">
        <div className="dash-logo">
          <img src="../../asset/img/FA Logo Guruverse.ID - main.png" className="brand-logo-light" alt="GV" style={{ height: 32, display: 'block' }} />
          <img src="../../asset/img/FA Logo Guruverse.ID - nrgative.png" className="brand-logo-dark" alt="GV" style={{ height: 32, display: 'none' }} />
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
            <img src="../../asset/img/hero_illustration_new.png" alt="Hero" />
            <div className="dash-floating-icon fi-1"><Ico n="GraduationCap" s={24} /></div>
            <div className="dash-floating-icon fi-2"><Ico n="Award" s={20} /></div>
          </div>
        </section>

        {/* Pillars Grid */}
        <section className="dash-grid">
          {pillars.map((p, i) => (
            <div key={i} className="dash-p-card">
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
                <a href={p.href} className="dash-p-btn" style={{ background: p.c }}>
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
            <img src="../../asset/img/help_phone.png" alt="Phone" style={{ width: 140, transform: 'rotate(10deg) translateY(20px)' }} />
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
  const doLogout=async()=>{
    try{await fetch('../../modules/member/login/member_logout.php');}catch{}
    window.location.href='/guruverse/register/register.php';
  };

  if(!mem) return(
    <div style={{display:'flex',alignItems:'center',justifyContent:'center',minHeight:'100vh',color:'rgba(255,255,255,.6)',flexDirection:'column',gap:12}}>
      <Ico n="AlertCircle" s={32}/>
      <p>Sesi tidak ditemukan. <a href="/guruverse/register/register.php" style={{color:'var(--accent)'}}>Login kembali</a></p>
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
