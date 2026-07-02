/* ── APP ── */
const App=()=>{
  const [view,setView]=useState('register'); // register, card, admin, menu
  const [mode,setMode]=useState('login');    // login, register
  const [mem,setMem]=useState(null);
  const [back,setBack]=useState('register');
  const [isAdm,setIsAdm]=useState(false);

  useEffect(()=>{
    fetch('../modules/dashboard/get_members.php').then(r=>{if(r.ok)setIsAdm(true);}).catch(()=>{});
  },[]);

  const onReg=d=>{
    // Hard redirect ke home_member.php agar persist saat refresh
    window.location.href = '/guruverse/guru-belajar/member/home_member.php';
  };
  const onLogin=d=>{
    // Hard redirect ke home_member.php agar persist saat refresh
    window.location.href = '/guruverse/guru-belajar/member/home_member.php';
  };
  const onAdminLogin=()=>{
    window.location.href = '../admin/index.php';
  };
  const onCard=m=>{setMem(m);setBack(isAdm && view === 'admin' ? 'admin' : 'menu');setView('card');};
  const onOut=async()=>{
    try{await fetch('../modules/member/login/admin_logout.php');}catch{}
    setIsAdm(false);setMem(null);setView('register');setMode('login');
  };

  const pillars=[
    {t:'Guru Belajar',s:'Pengembangan diri dan kompetensi berkelanjutan',c:'#a78bfa'},
    {t:'Guru Mengajar',s:'Aksi nyata dan kontribusi untuk dampak nyata',c:'#38bdf8'},
    {t:'Guru Inspira',s:'Jejaring kolaborasi dan cerita inspiratif',c:'#34d399'},
  ];

  return(
    <>
      <Nav view={view} go={v=>{
        if (v === 'register' && mem) { setView('menu'); }
        else { setView(v); }
      }}/>
      {view==='register'&&(
        <div className="page">
          <div/>
          <div className="page-body">
            <div className="hleft">
              <div className="badge fu"><span style={{width:6,height:6,borderRadius:'50%',background:'var(--accent)'}}/>Ekosistem Digital Guru Indonesia</div>
              <h1 className="h1 fu1">Semesta Kompetensi,<br/><span className="gr">Untuk Guru Indonesia</span></h1>
              <p className="sub fu2">Bergabunglah bersama ribuan guru profesional Indonesia dalam ekosistem yang membantu Anda terhubung, bertumbuh, dan kompeten.</p>
              <div className="pillars fu3">
                {pillars.map(p=>(
                  <div key={p.t} className="pillar">
                    <div className="pdot" style={{background:p.c}}/>
                    <div><p>{p.t}</p><span>{p.s}</span></div>
                  </div>
                ))}
              </div>
            </div>
            <Cosmos/>
            {mode === 'login' ? (
              <LoginForm onOk={onLogin} onAdminOk={onAdminLogin} onSwitch={() => setMode('register')} />
            ) : (
              <RegForm onOk={onReg} onSwitch={() => setMode('login')} />
            )}
          </div>
        </div>
      )}
      {view==='menu'&&mem&&<MemberMenu member={mem} onCard={()=>{setBack('menu'); setView('card');}} onOut={onOut}/>}
      {view==='card'&&mem&&<Kartu m={mem} onBack={()=>setView(back)}/>}
      {view==='admin'&&<Admin onCard={onCard} onOut={onOut}/>}
    </>
  );
};

ReactDOM.createRoot(document.getElementById('root')).render(<App/>);
