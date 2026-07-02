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
    setF({ user: acc.user, pass: '' });
    setShowHistory(false);
  };
  
  const sub = async (e) => {
    e.preventDefault();
    setLd(true); setErr('');
    try {
      let success = false;
      if (f.user.toLowerCase() === 'admin') {
        const fd = new FormData(); fd.append('pass', f.pass);
        const r = await fetch('../modules/member/login/admin_login.php', { method: 'POST', body: fd });
        const d = await r.json();
        if (d.success) { success = true; onAdminOk(); } 
        else setErr(d.message || 'Password Admin salah.');
      } else {
        const fd = new FormData(); fd.append('username', f.user); fd.append('password', f.pass);
        const r = await fetch('../modules/member/login/member_login.php', { method: 'POST', body: fd });
        const d = await r.json();
        if (d.success) { success = true; onOk(d.member); } 
        else if (d.need_setup) {
          alert(d.message);
          window.location.href = '../guru-belajar/member/set-password.php';
        }
        else setErr(d.message || 'Login gagal.');
      }

      if (success && remember) {
        let newAccs = [...accounts];
        const idx = newAccs.findIndex(a => a.user.toLowerCase() === f.user.toLowerCase());
        if (idx === -1) {
          newAccs.push({ user: f.user });
          localStorage.setItem('gv_accounts', JSON.stringify(newAccs));
          setAccounts(newAccs);
        }
      }
    } catch (e) { 
      setErr('Gagal menghubungi server: ' + (e.message || 'Error tidak diketahui')); 
      console.error(e);
    } finally { setLd(false); }
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
