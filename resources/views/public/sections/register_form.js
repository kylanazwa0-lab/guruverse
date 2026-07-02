/* ── FORM PENDAFTARAN ── */
const RegForm=({onOk, onSwitch})=>{
  const [f,setF]=useState({fullName:'',username:'',institution:'',phone:'',password:'',refCode:new URLSearchParams(window.location.search).get('ref')||''});
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
      const rs=await fetch('../modules/member/register/register.php',{method:'POST',body:fd});
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
