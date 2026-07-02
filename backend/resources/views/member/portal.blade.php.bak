@php
  $member = Auth::guard('web')->user();
  
  $parts = explode(' ', $member->full_name ?? 'Member');
  $user_initials = strtoupper(substr($parts[0] ?? 'M', 0, 1));
  if (count($parts) > 1 && isset($parts[1][0])) {
      $user_initials .= strtoupper(substr($parts[1], 0, 1));
  } else {
      $user_initials .= strtoupper(substr($parts[0] ?? 'M', 1, 1));
  }

  $photo = '/asset/img/default-avatar.png';
  if (!empty($member->photo_base64)) {
      $photo = 'data:image/png;base64,' . $member->photo_base64;
  } elseif (!empty($member->photo_path)) {
      // Clean path if it starts with public or similar
      $path = str_replace('public/', '', $member->photo_path);
      $photo = asset($path);
  }

  $memberData = [
      'memberId'    => $member->member_id ?? '',
      'fullName'    => $member->full_name ?? '',
      'username'    => $member->username ?? '',
      'email'       => $member->email ?? '',
      'institution' => $member->institution ?? '',
      'phone'       => $member->phone ?? '',
      'photo'       => $photo,
      'joinedAt'    => $member->created_at ? $member->created_at->toISOString() : now()->toISOString(),
  ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="/asset/img/logo guruverse FA.ai.png"/>
<title>Guruverse.id &mdash; Dashboard Anggota</title>

<!-- 1. React -->
<script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

<!-- 2. Lucide Icons -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

<!-- 3. Babel Standalone -->
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

<!-- 4. Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;0,900;1,600&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet"/>

<style>
:root{
  --ink:#0f0c29;
  --deep:#1a1560;
  --purple:#6d28d9;
  --violet:#7c3aed;
  --accent:#a78bfa;
  --sky:#38bdf8;
  --nav-h:64px;
}

/* ── Light Mode Overrides ── */
[data-theme="dark"] .brand-logo-light { display: none !important; }
[data-theme="dark"] .brand-logo-dark { display: block !important; }
[data-theme="light"] .brand-logo-light { display: block !important; }
[data-theme="light"] .brand-logo-dark { display: none !important; }

[data-theme="light"] {
  --ink: #f5f8fa;
  --deep: #ffffff;
  --purple: #093c5d;
  --violet: #357a9e;
  --accent: #093c5d;
  --sky: #76d4e2;
}
[data-theme="light"] body {
  color: #092b40;
}
[data-theme="light"] .nav {
  background: rgba(255,255,255,0.9);
  border-bottom: 1px solid rgba(9,60,93,0.1);
}
[data-theme="light"] .nav-logo span {
  color: #093c5d;
}
[data-theme="light"] .cshell {
  background: var(--deep);
  box-shadow: 0 16px 40px rgba(9,60,93,0.1), 0 0 0 1px rgba(9,60,93,0.05);
}
[data-theme="light"] .kpage {
  background: var(--ink);
}
[data-theme="light"] .infobox {
  background: rgba(9,60,93,0.03);
  border: 1px solid rgba(9,60,93,0.08);
}
[data-theme="light"] .back-lbl {
  color: rgba(9,60,93,0.5);
}
[data-theme="light"] .back-val {
  color: #092b40;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html,body{min-height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:var(--ink);color:#fff;overflow-x:hidden;overflow-y:auto;}
body::-webkit-scrollbar{display:none;}
.mono{font-family:'JetBrains Mono',monospace;}

/* NAV */
.nav{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;padding:0 2.5rem;background:rgba(15,12,41,.82);backdrop-filter:blur(18px);border-bottom:1px solid rgba(255,255,255,.07);}
.nav-logo{display:flex;align-items:center;gap:9px;text-decoration:none;}
.nav-logo img{height:34px;object-fit:contain;}
.nav-logo span{font-weight:900;font-size:.95rem;color:#fff;letter-spacing:-.02em;}

/* ANIMATIONS */
@keyframes twinkle{0%,100%{opacity:var(--op,.5);transform:scale(1)}50%{opacity:.08;transform:scale(.4)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-9px)}}
@keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.2}}

.sp{display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.25);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
.bl{animation:blink 1.3s ease-in-out infinite;}

/* KARTU PAGE */
.kpage{position:relative;z-index:1;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:calc(var(--nav-h) + 1rem) 1rem 1.5rem;gap:.75rem;overflow-y:auto;}
.kpage::-webkit-scrollbar{display:none;}
.ktopbar{display:flex;align-items:center;justify-content:space-between;width:100%;max-width:460px;}

/* CARD SHELL */
.cshell{position:relative;width:100%;aspect-ratio:1.586/1;border-radius:1.5rem;overflow:hidden;background:var(--deep);box-shadow:0 24px 60px rgba(0,0,0,.65),0 0 0 1px rgba(255,255,255,.07);}
.cin{position:relative;z-index:10;height:100%;display:flex;flex-direction:column;padding:1.3rem 1.5rem;}

/* FLIP CARD */
.flip-scene{width:100%;max-width:460px;perspective:1200px;}
.flip-card{position:relative;width:100%;aspect-ratio:1.586/1;transform-style:preserve-3d;transition:transform .7s cubic-bezier(.4,0,.2,1);}
.flip-card.flipped{transform:rotateY(180deg);}
.face{position:absolute;inset:0;backface-visibility:hidden;-webkit-backface-visibility:hidden;border-radius:1.5rem;overflow:hidden;}
.face-back{transform:rotateY(180deg);}

/* INFO BOX */
.infobox{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:1.1rem;padding:.85rem 1.1rem;display:grid;grid-template-columns:1fr 1fr;gap:.75rem;font-size:.7rem;width:100%;max-width:460px;}

/* BACK CARD details */
.back-row{display:flex;flex-direction:column;gap:2px;margin-bottom:8px;}
.back-lbl{font-size:5.5px;text-transform:uppercase;letter-spacing:.22em;color:rgba(255,255,255,.38);font-weight:700;}
.back-val{font-size:.72rem;font-weight:700;color:#fff;line-height:1.25;}

/* DASHBOARD STYLES */
.dash-container{background:#f8fafc;color:#1e293b;min-height:100vh;position:relative;z-index:200;display:flex;flex-direction:column;animation:fadeUp .5s ease-out;}
.dash-header{height:64px;padding:0 5%;display:flex;align-items:center;justify-content:space-between;background:#fff;border-bottom:1px solid #f1f5f9;position:sticky;top:0;z-index:10;}
.dash-logo{display:flex;align-items:center;gap:10px;}
.dash-logo img{height:32px;}
.dash-logo span{font-weight:800;font-size:1rem;color:#0f172a;}
.dash-actions{display:flex;gap:12px;}
.dash-btn-card{display:flex;align-items:center;gap:8px;background:#fff;border:1px solid #3b82f6;color:#3b82f6;padding:.5rem 1.1rem;border-radius:10px;font-weight:700;font-size:.85rem;cursor:pointer;transition:all .2s;}
.dash-btn-card:hover{background:#3b82f6;color:#fff;}
.dash-btn-out{display:flex;align-items:center;gap:8px;background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;padding:.5rem 1.1rem;border-radius:10px;font-weight:700;font-size:.85rem;cursor:pointer;transition:all .2s;}
.dash-btn-out:hover{background:#f1f5f9;color:#0f172a;}

.dash-main{flex:1;max-width:1200px;margin:0 auto;width:100%;padding:2rem 5% 4rem;display:flex;flex-direction:column;gap:2.5rem;}

.dash-hero{display:grid;grid-template-columns:1fr 380px;gap:2rem;align-items:center;background:linear-gradient(to right,#eff6ff,#fff);border-radius:2rem;padding:2.2rem 3rem;position:relative;overflow:hidden;}
.dash-greeting{font-size:2.2rem;font-weight:900;color:#0f172a;line-height:1.1;margin-bottom:0.8rem;}
.dash-greeting-line{width:50px;height:4px;background:#3b82f6;border-radius:2px;margin-bottom:1.2rem;}
.dash-sub{font-size:.9rem;color:#64748b;line-height:1.6;max-width:380px;}
.dash-hero-img{position:relative;display:flex;justify-content:center;}
.dash-hero-img img{width:100%;max-width:280px;z-index:2;filter:drop-shadow(0 20px 40px rgba(0,0,0,.1));}
.dash-floating-icon{position:absolute;background:#fff;width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 24px rgba(0,0,0,.08);z-index:3;animation:float 4s ease-in-out infinite;}
.fi-1{top:10%;left:-5%;color:#3b82f6;animation-delay:0s;}
.fi-2{bottom:15%;right:-5%;color:#f59e0b;animation-delay:1s;}

.dash-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;}
.dash-p-card{background:#fff;border-radius:2rem;padding:1.2rem;display:flex;flex-direction:column;gap:1.2rem;border:1px solid #f1f5f9;transition:all .3s cubic-bezier(0.4, 0, 0.2, 1);cursor:pointer;}
.dash-p-card:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,.05);border-color:#e2e8f0;}
.dash-p-visual{height:160px;border-radius:1.5rem;overflow:hidden;display:flex;align-items:center;justify-content:center;}
.dash-p-visual img{height:85%;object-fit:contain;transition:transform .5s;}
.dash-p-card:hover .dash-p-visual img{transform:scale(1.1) translateY(-5px);}
.dash-p-content{padding:0 .5rem;}
.dash-p-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;}
.dash-p-title{font-size:1.4rem;font-weight:800;color:#0f172a;}
.dash-p-desc{font-size:.9rem;color:#64748b;line-height:1.6;margin-bottom:1.8rem;min-height:3em;}
.dash-p-btn{display:inline-flex;align-items:center;gap:8px;color:#fff;text-decoration:none;font-weight:800;font-size:.9rem;padding:.8rem 1.8rem;border-radius:12px;transition:opacity .2s;box-shadow:0 8px 20px rgba(0,0,0,.1);}
.dash-p-btn:hover{opacity:.9;}

.dash-help{background:#ecfdf5;border-radius:2rem;padding:1.5rem 3rem;display:flex;justify-content:space-between;align-items:center;overflow:hidden;position:relative;border:1px solid #d1fae5;}
.dash-help-left{display:flex;align-items:center;gap:1.5rem;}
.dash-wa-icon{width:64px;height:64px;background:#10b981;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 24px rgba(16,185,129,.3);}
.dash-help-title{font-size:1.3rem;font-weight:900;color:#064e3b;margin-bottom:1px;}
.dash-help-sub{font-size:.85rem;color:#059669;font-weight:600;}
.dash-wa-num{font-size:1.5rem;font-weight:900;color:#10b981;margin-top:2px;}

@media(max-width:1000px){
  .dash-hero{grid-template-columns:1fr;padding:2rem;}
  .dash-hero-img{display:none;}
  .dash-greeting{font-size:2rem;}
  .dash-help{flex-direction:column;text-align:center;gap:2rem;padding:2rem;}
  .dash-help-left{flex-direction:column;gap:1rem;}
  .dash-help-right{display:none;}
}

/* PRINT */
@media print{
  .noprint{display:none!important;}
  body{background:#fff!important;overflow:auto!important;}
  .sf,.nav{display:none!important;}
  .kpage{padding:0!important;justify-content:flex-start!important;height:auto!important;min-height:auto!important;}
  .ktopbar,.infobox,.flip-btns{display:none!important;}
  .flip-scene{max-width:100%!important;}
  .flip-card{transform:none!important;aspect-ratio:1.586/1!important;position:relative!important;}
  .face-back{display:none!important;}
  .face{position:relative!important;-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;}
}
</style>
</head>
<body>

<div id="root"></div>

<form action="{{ route('logout') }}" method="POST" id="logout-form-member" style="display:none">
  @csrf
</form>

<script>
  window.CURRENT_MEMBER = {!! json_encode($memberData) !!};
  window.ROUTES = {
    memberDashboard: "{{ route('member.dashboard') }}",
    login: "{{ route('login') }}"
  };
</script>

<script type="text/babel">
@verbatim
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
    // Sync dark mode setting
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

@endverbatim
ReactDOM.createRoot(document.getElementById('root')).render(<App/>);
</script>
</body>
</html>
