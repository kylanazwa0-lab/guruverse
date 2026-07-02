/* ── ADMIN ── */
const Admin=({onCard,onOut})=>{
  const [mem,setMem]=useState([]);const [st,setSt]=useState({total:0,today:0,month:0});
  const [q,setQ]=useState('');const [ld,setLd]=useState(true);const [er,setEr]=useState('');

  const load=useCallback(async()=>{
    setLd(true);setEr('');
    try{
      const r=await fetch('../modules/dashboard/get_members.php');
      if(r.status===401){onOut();return;}
      const d=await r.json();
      if(d.success){setMem(d.members);setSt(d.stats);}else setEr(d.message);
    }catch{setEr('Gagal memuat data.');}finally{setLd(false);}
  },[]);

  useEffect(()=>{load();},[]);

  const handleDelete=async(m)=>{
    try{
      const fd=new FormData();fd.append('memberId',m.memberId);
      const r=await fetch('../modules/dashboard/delete_member.php',{method:'POST',body:fd});
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
            <button className="btn-sm" onClick={()=>window.open('../modules/dashboard/export_xlsx.php','_blank')}
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
