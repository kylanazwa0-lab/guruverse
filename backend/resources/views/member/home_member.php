<?php
session_start();

// Cek session — gunakan member_int_id ATAU member_id (konsisten dengan sistem login)
if (!isset($_SESSION['member_int_id']) && !isset($_SESSION['member_id'])) {
    header("Location: /guruverse/register/register.php");
    exit;
}

require_once '../../database/config.php';
$conn = getConnection();

// Query berdasarkan session yang tersedia
if (isset($_SESSION['member_int_id'])) {
    $stmt = $conn->prepare("SELECT member_id, full_name, username, email, institution, phone, photo_path, joined_at FROM members WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['member_int_id']);
} else {
    $stmt = $conn->prepare("SELECT member_id, full_name, username, email, institution, phone, photo_path, joined_at FROM members WHERE member_id = ?");
    $stmt->bind_param('s', $_SESSION['member_id']);
}
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if (!$member) {
    session_destroy();
    header("Location: /guruverse/register/register.php");
    exit;
}

$photoUrl = '../../asset/img/1.png'; // Menggunakan gambar dari folder asset/img sebagai default
$photoField = $member['photo_path'] ?? null;
if ($photoField) {
    $absPath = '../../' . $photoField;
    if (file_exists($absPath)) {
        $photoUrl = $absPath;
    }
}
$photoBase64 = $photoUrl;

$memberData = [
    'memberId'    => $member['member_id'] ?? '',
    'fullName'    => $member['full_name'] ?? '',
    'username'    => $member['username'] ?? '',
    'email'       => $member['email'] ?? '',
    'institution' => $member['institution'] ?? '',
    'phone'       => $member['phone'] ?? '',
    'photo'       => $photoBase64,
    'joinedAt'    => $member['joined_at'] ?? '',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="../../asset/img/logo guruverse FA.ai.png"/>
<title>Guruverse.id — Dashboard Anggota</title>

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

<!-- Menggunakan style yang sama -->
<link rel="stylesheet" href="../../asset/css/dashboard_style.css"> <!-- Kita butuh file css ini terpisah atau inline, saya gunakan inline dari asalnya sementara -->
<style>
/* ... Mengambil style dari register.php yang diperlukan ... */
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
<script>
    window.CURRENT_MEMBER = <?= json_encode($memberData) ?>;
</script>
<script type="text/babel" src="home_member.js?v=<?= time() ?>"></script>
</body>
</html>
