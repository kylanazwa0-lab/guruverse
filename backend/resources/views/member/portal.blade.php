@php
  $member = Auth::guard('web')->user();
  $firstName = explode(' ', $member->full_name ?? 'Member')[0];
  
  $photo = '/asset/img/default_avatar.svg';
  if (!empty($member->photo_base64)) {
      $photo = 'data:image/png;base64,' . $member->photo_base64;
  } elseif (!empty($member->photo_path)) {
      $path = str_replace('public/', '', $member->photo_path);
      $photo = asset($path);
  }

  $unread_notif_count = \App\Models\Notification::where('user_id', $member->id)->where('is_read', 0)->count();
  $notifications = \App\Models\Notification::where('user_id', $member->id)->orderBy('created_at', 'desc')->limit(10)->get();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Guruverse.id &mdash; Panel Member</title>
<link rel="icon" type="image/png" href="/asset/img/logo guruverse FA.ai.png"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root {
    --bg-main: #f4f7f9;
    --card-bg: #ffffff;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --border: #e2e8f0;
    --primary: #6366f1;
    --primary-dark: #4f46e5;
  }
  [data-theme="dark"] {
    --bg-main: #0f172a;
    --card-bg: #1e293b;
    --text-dark: #f8fafc;
    --text-muted: #94a3b8;
    --border: #334155;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
  body { background: var(--bg-main); color: var(--text-dark); min-height: 100vh; overflow-x: hidden; transition: background-color 0.3s ease, color 0.3s ease; }
  
  .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
  
  /* Header */
  .header { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; background: var(--card-bg); border-bottom: 1px solid var(--border); margin-bottom: 32px; transition: background-color 0.3s ease, border-color 0.3s ease;}
  .header .logo { display: flex; align-items: center; gap: 12px; margin-left: 24px;}
  .header .logo img { height: 32px; }
  .header .logo-text h1 { font-size: 1.1rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }
  .header .logo-text p { font-size: 0.75rem; color: var(--text-muted); font-weight: 500;}
  .header-actions { display: flex; align-items: center; gap: 20px; margin-right: 24px;}
  .notif-btn { position: relative; width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; background: none; cursor: pointer; color: var(--text-muted);}
  .notif-badge { position: absolute; top: -2px; right: -2px; background: #ef4444; color: #fff; font-size: 10px; font-weight: 700; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }
  .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; }
  .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
  .user-info h4 { font-size: 0.9rem; font-weight: 700; color: var(--text-dark); }
  .user-info p { font-size: 0.75rem; color: var(--text-muted); }

  /* Hero */
  .hero { background: linear-gradient(135deg, #3b82f6, #6366f1, #8b5cf6); border-radius: 24px; padding: 48px; position: relative; overflow: hidden; color: #fff; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; box-shadow: 0 12px 32px rgba(99,102,241,0.15);}
  .hero-content { position: relative; z-index: 2; max-width: 60%; }
  .hero-pill { background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.3);}
  .hero h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 12px; }
  .hero p { font-size: 1rem; color: rgba(255,255,255,0.9); line-height: 1.6; margin-bottom: 32px;}
  .hero-actions { display: flex; gap: 12px; }
  .btn-hero { width: 48px; height: 48px; border-radius: 50%; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;}
  .btn-hero.white { background: #fff; color: var(--primary); }
  .btn-hero.glass { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(4px);}
  
  .hero-level { position: absolute; right: 280px; bottom: 48px; background: var(--card-bg); padding: 8px 16px; border-radius: 12px; display: flex; align-items: center; gap: 12px; color: var(--text-dark); font-weight: 700; box-shadow: 0 8px 24px rgba(0,0,0,0.1); z-index: 3; transition: background-color 0.3s ease, color 0.3s ease;}
  .hero-level-icon { background: #fef08a; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #ca8a04;}
  
  .hero-character { position: absolute; right: 48px; top: -20px; width: 280px; height: 280px; background: #1e293b; border-radius: 50%; border: 4px solid rgba(255,255,255,0.2); overflow: hidden; z-index: 2;}
  .hero-character img { width: 100%; height: 100%; object-fit: cover; opacity: 0.8;}
  .circle-dec { position: absolute; border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; }

  /* Stats */
  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;}
  .stat-card { background: #fff; padding: 24px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 16px; position: relative;}
  .stat-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
  .stat-title { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; }
  .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--text-dark); }
  .stat-menu { position: absolute; right: 20px; top: 20px; color: var(--border); cursor: pointer;}

  /* Portals */
  .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;}
  .section-title h3 { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 700; margin-bottom: 4px;}
  .section-title h2 { font-size: 1.5rem; font-weight: 800; color: var(--text-dark); }
  .section-link { color: var(--primary); font-size: 0.9rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 4px;}
  
  .portal-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px;}
  .portal-card { background: var(--card-bg); border-radius: 24px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; text-decoration: none; transition: transform 0.2s, background-color 0.3s ease, color 0.3s ease;}
  .portal-card:hover { transform: translateY(-4px); }
  .portal-img { aspect-ratio: 16/9; width: 100%; object-fit: cover; }
  .portal-body { padding: 24px; display: flex; flex-direction: column; flex: 1;}
  .portal-head { display: flex; align-items: center; gap: 12px; margin-bottom: 16px;}
  .portal-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;}
  .portal-title { font-size: 1.1rem; font-weight: 800; color: var(--text-dark); margin-bottom: 2px;}
  .portal-meta { font-size: 0.75rem; font-weight: 700; }
  .portal-desc { font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 24px; flex: 1;}
  .portal-btn { width: 100%; padding: 12px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: 0.2s;}

  /* Belajar */
  .p-belajar .portal-icon { background: #eff6ff; color: #3b82f6; }
  .p-belajar .portal-meta { color: #3b82f6; }
  .p-belajar .portal-btn { background: #eff6ff; color: #3b82f6; }
  .p-belajar:hover .portal-btn { background: #3b82f6; color: #fff; }

  /* Mengajar */
  .p-mengajar .portal-icon { background: #ecfdf5; color: #10b981; }
  .p-mengajar .portal-meta { color: #10b981; }
  .p-mengajar .portal-btn { background: #ecfdf5; color: #10b981; }
  .p-mengajar:hover .portal-btn { background: #10b981; color: #fff; }

  /* Inspira */
  .p-inspira .portal-icon { background: #faf5ff; color: #a855f7; }
  .p-inspira .portal-meta { color: #a855f7; }
  .p-inspira .portal-btn { background: #faf5ff; color: #a855f7; }
  .p-inspira:hover .portal-btn { background: #a855f7; color: #fff; }

  /* 2 Cols */
  .bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px;}
  .list-card { background: var(--card-bg); border-radius: 24px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); transition: background-color 0.3s ease;}
  .list-item { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 24px; transition: border-color 0.3s ease;}
  .list-item:last-child { margin-bottom: 0; border-bottom: none; padding-bottom: 0;}
  .item-icon { width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;}
  .item-content { flex: 1; }
  .item-title { font-weight: 700; color: var(--text-dark); margin-bottom: 4px; font-size: 0.95rem;}
  .item-time { font-size: 0.8rem; color: var(--text-muted); }
  .item-action { flex-shrink: 0; }
  .btn-sm { padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer; border: none;}
  .btn-blue { background: #eff6ff; color: #3b82f6; }
  .btn-purple { background: #faf5ff; color: #a855f7; }

  .progress-bar { width: 100%; height: 6px; background: #f1f5f9; border-radius: 3px; margin-top: 12px; overflow: hidden; position: relative;}
  .progress-fill { height: 100%; border-radius: 3px; }

  /* Dev Progress */
  .summary-card { background: var(--card-bg); border-radius: 24px; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); margin-bottom: 60px; transition: background-color 0.3s ease;}
  .sum-bars { display: flex; gap: 40px; margin-top: 24px;}
  .sum-col { flex: 1; }
  .sum-head { display: flex; justify-content: space-between; margin-bottom: 12px; font-weight: 700; font-size: 0.9rem;}
  .sum-head span:first-child { color: var(--text-dark); }
  
  .footer { border-top: 1px solid var(--border); padding: 32px 0; display: flex; justify-content: space-between; color: var(--text-muted); font-size: 0.85rem;}
  .footer-links { display: flex; gap: 24px; }
  .footer-links a { color: var(--text-muted); text-decoration: none; }
</style>
</head>
<body>

<script>
  // Apply theme early to prevent flash
  const currentTheme = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', currentTheme);
</script>

<header class="header">
  <div class="logo">
    <img src="/asset/img/logo guruverse FA.ai.png" alt="Guruverse">
    <div class="logo-text">
      <h1>Guruverse</h1>
      <p>Belajar • Mengajar • Menginspirasi</p>
    </div>
  </div>
  <div class="header-actions">
    <button class="notif-btn" onclick="toggleTheme()" title="Mode Gelap/Terang">
      <i id="theme-icon" data-lucide="moon"></i>
    </button>
    <button class="notif-btn" onclick="toggleNotif()" style="position:relative;">
      <i data-lucide="bell"></i>
      @if($unread_notif_count > 0)
        <span class="notif-badge">{{ $unread_notif_count }}</span>
      @endif
    </button>
    <div class="user-profile" onclick="toggleUserMenu()" style="position:relative;">
      <img src="{{ $photo }}" alt="{{ $firstName }}">
      <div class="user-info">
        <h4>{{ $firstName }}</h4>
        <p>Panel Member</p>
      </div>
      <i data-lucide="chevron-down" style="color:var(--text-muted); width:16px;"></i>
    </div>
  </div>
</header>

<!-- Notification Dropdown -->
<div class="notif-dropdown" id="notifDropdown" style="display:none;position:absolute;top:72px;right:80px;z-index:9999;background:var(--card-bg);border:1px solid var(--border);border-radius:14px;width:320px;box-shadow:0 10px 40px rgba(0,0,0,0.18);">
  <div style="padding:12px 16px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
    <h3 style="font-size:14px; font-weight:700;">Notifikasi</h3>
  </div>
  <div style="max-height: 350px; overflow-y: auto;">
    @if ($notifications->isEmpty())
      <div style="padding: 40px 20px; text-align: center; color: var(--text-muted);">Belum ada notifikasi baru.</div>
    @else
      @foreach ($notifications as $n)
        <div style="padding:12px 16px; border-bottom:1px solid var(--border); display:flex; gap:12px; cursor:pointer;">
           <div style="width:32px; height:32px; border-radius:8px; background:rgba(99,102,241,0.1); color:var(--primary); display:flex; align-items:center; justify-content:center; flex-shrink:0;">🔔</div>
           <div style="flex:1;">
             <h4 style="font-size:12px; font-weight:700; margin-bottom:2px;">{{ $n->title }}</h4>
             <p style="font-size:11px; color:var(--text-muted); line-height:1.4;">{{ $n->message }}</p>
             <div style="font-size:10px; color:var(--text-muted); margin-top:4px;">{{ date('d M, H:i', strtotime($n->created_at)) }}</div>
           </div>
           @if (!$n->is_read)
             <div style="width:8px; height:8px; border-radius:50%; background:var(--primary); margin-top:4px;"></div>
           @endif
        </div>
      @endforeach
    @endif
  </div>
  <div style="padding:10px; text-align:center; border-top:1px solid var(--border); font-size:12px; font-weight:600; color:var(--primary); cursor:pointer;">
    Lihat Semua
  </div>
</div>

<!-- User Dropdown Menu -->
<div id="userDropdown" style="
  display:none;position:absolute;top:72px;right:24px;z-index:9999;
  background:var(--card-bg);border:1px solid var(--border);
  border-radius:14px;padding:6px;min-width:200px;
  box-shadow:0 10px 40px rgba(0,0,0,0.18);
">
  <div style="padding:10px 12px;border-bottom:1px solid var(--border);margin-bottom:4px">
    <div style="font-weight:700;font-size:13px;">{{ $member->full_name }}</div>
    <div style="font-size:11px;color:var(--text-muted);margin-top:2px">{{ $member->institution ?? 'Member' }}</div>
  </div>
  <a href="{{ route('member.profil_portal') }}"
     style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;color:var(--text-dark);text-decoration:none;">
     <i data-lucide="user" style="width:16px;"></i> Profil Saya
  </a>
  <div style="height:1px;background:var(--border);margin:4px 0"></div>
  <form action="{{ route('logout') }}" method="POST" id="logout-form-portal" style="display:none;">
    @csrf
  </form>
  <a onclick="event.preventDefault(); document.getElementById('logout-form-portal').submit();"
     style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;color:#ef4444;text-decoration:none;">
     <i data-lucide="log-out" style="width:16px;"></i> Keluar
  </a>
</div>

<div class="container">

  <!-- Hero -->
  <div class="hero">
    <div class="circle-dec" style="width:300px; height:300px; left:-50px; top:-100px;"></div>
    <div class="circle-dec" style="width:150px; height:150px; right:350px; top:40px;"></div>
    <div class="circle-dec" style="width:80px; height:80px; right:400px; bottom:60px;"></div>
    
    <div class="hero-content">
      <div class="hero-pill">Ruang tumbuh untuk pendidik hebat</div>
      <h2>Halo, {{ $firstName }}! </h2>
      <p>Selamat datang di Panel Member GuruVerse. Pilih portal yang ingin Anda<br>akses untuk memulai perjalanan pendidikan Anda.</p>

    </div>
    

    
    <!-- 3D Character Image -->
    <div class="hero-character">
      <img src="/asset/img/3d_avatar_blender.png" alt="Avatar">
    </div>
  </div>



  <!-- Portals -->
  <div class="section-header">
    <div class="section-title">
      <h3>Portal Utama</h3>
      <h2>Pilih Portal yang Ingin Anda Akses</h2>
    </div>
  </div>

  <div class="portal-grid">
    <a href="/dashboard" class="portal-card p-belajar">
      <img src="/asset/img/pilar_belajar_3d.png" class="portal-img">
      <div class="portal-body">
        <div class="portal-head">
          <div class="portal-icon">📘</div>
          <div>
            <div class="portal-title">Guru Belajar</div>
            <div class="portal-meta">6 Kelas Aktif</div>
          </div>
        </div>
        <div class="portal-desc">Platform peningkatan kompetensi pendidik melalui pelatihan dan kelas terstruktur.</div>
        <div class="portal-btn">Mulai Belajar</div>
      </div>
    </a>
    
    <a href="/member/mengajar" class="portal-card p-mengajar">
      <img src="/asset/img/pilar_mengajar_3d.png" class="portal-img">
      <div class="portal-body">
        <div class="portal-head">
          <div class="portal-icon">🏫</div>
          <div>
            <div class="portal-title">Guru Mengajar</div>
            <div class="portal-meta">24 Materi Tersedia</div>
          </div>
        </div>
        <div class="portal-desc">Wadah berbagi praktik baik, perangkat ajar, dan metode inovatif bagi murid.</div>
        <div class="portal-btn">Mulai Mengajar</div>
      </div>
    </a>
    
    <a href="/member/inspira" class="portal-card p-inspira">
      <img src="/asset/img/pilar_inspira_3d.png" class="portal-img">
      <div class="portal-body">
        <div class="portal-head">
          <div class="portal-icon">✨</div>
          <div>
            <div class="portal-title">Guru Inspira</div>
            <div class="portal-meta">158 Artikel Terbit</div>
          </div>
        </div>
        <div class="portal-desc">Ruang publikasi karya, tulisan, dan pengalaman inspiratif bersama rekan sejawat.</div>
        <div class="portal-btn">Mulai Menginspirasi</div>
      </div>
    </a>
  </div>

  <!-- Bottom 2 Cols -->
  <div class="bottom-grid">
    <!-- Aktivitas -->
    <div class="list-card">
      <div class="section-header" style="margin-bottom:32px;">
        <div class="section-title">
          <h3>Jejak Terbaru</h3>
          <h2>Aktivitas Terakhir</h2>
        </div>
        <div class="stat-menu" style="position:static;"><i data-lucide="more-horizontal"></i></div>
      </div>
      
      <div class="list-item">
        <div class="item-icon" style="background:#eff6ff; color:#3b82f6;"><i data-lucide="book-open"></i></div>
        <div class="item-content">
          <div class="item-title">Menyelesaikan Modul "Manajemen Kelas Digital"</div>
          <div class="item-time">2 jam lalu</div>
        </div>
      </div>
      
      <div class="list-item">
        <div class="item-icon" style="background:#f0fdf4; color:#10b981;"><i data-lucide="folder-up"></i></div>
        <div class="item-content">
          <div class="item-title">Mengunggah Perangkat Ajar</div>
          <div class="item-time">Kemarin</div>
        </div>
      </div>
      
      <div class="list-item">
        <div class="item-icon" style="background:#faf5ff; color:#a855f7;"><i data-lucide="sparkles"></i></div>
        <div class="item-content">
          <div class="item-title">Menerbitkan Artikel Inspiratif</div>
          <div class="item-time">3 hari lalu</div>
        </div>
      </div>
    </div>
    
    <!-- Rekomendasi -->
    <div class="list-card">
      <div class="section-header" style="margin-bottom:32px;">
        <div class="section-title">
          <h3>Untuk Anda</h3>
          <h2>Rekomendasi Untuk Anda</h2>
        </div>
        <div class="stat-menu" style="position:static; width:36px; height:36px; border:1px solid var(--border); border-radius:50%; display:flex; align-items:center; justify-content:center;"><i data-lucide="sliders-horizontal" style="width:16px;"></i></div>
      </div>
      
      <div class="list-item">
        <div class="item-icon" style="overflow:hidden;"><img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=200&auto=format&fit=crop" style="width:100%;height:100%;object-fit:cover;"></div>
        <div class="item-content">
          <div class="item-title">Manajemen Kelas Digital</div>
          <div style="display:flex; align-items:center; gap:12px;">
            <div class="progress-bar" style="flex:1;"><div class="progress-fill" style="width:50%; background:#3b82f6;"></div></div>
            <div style="font-size:0.75rem; font-weight:700; color:var(--text-muted); margin-top:12px;">50%</div>
          </div>
        </div>
        <div class="item-action">
          <button class="btn-sm btn-blue">Lanjutkan</button>
        </div>
      </div>
      
      <div class="list-item">
        <div class="item-icon" style="overflow:hidden;"><img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=200&auto=format&fit=crop" style="width:100%;height:100%;object-fit:cover;"></div>
        <div class="item-content">
          <div class="item-title">Webinar AI dalam Pembelajaran</div>
          <div class="item-time" style="margin-top:6px;">20 Juli 2026</div>
        </div>
        <div class="item-action">
          <button class="btn-sm btn-purple">Daftar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Progress -->
  <div class="summary-card">
    <div class="section-header" style="margin-bottom:0;">
      <div class="section-title">
        <h3>Ringkasan Perjalanan</h3>
        <h2>Progress Pengembangan Anda</h2>
      </div>
      <div class="item-time">Terus melangkah, dampak Anda semakin terasa.</div>
    </div>
    
    <div class="sum-bars">
      <div class="sum-col">
        <div class="sum-head"><span>Guru Belajar</span> <span style="color:#3b82f6;">60%</span></div>
        <div class="progress-bar" style="height:8px;"><div class="progress-fill" style="width:60%; background:#3b82f6;"></div></div>
      </div>
      <div class="sum-col">
        <div class="sum-head"><span>Guru Mengajar</span> <span style="color:#10b981;">40%</span></div>
        <div class="progress-bar" style="height:8px;"><div class="progress-fill" style="width:40%; background:#10b981;"></div></div>
      </div>
      <div class="sum-col">
        <div class="sum-head"><span>Guru Inspira</span> <span style="color:#a855f7;">75%</span></div>
        <div class="progress-bar" style="height:8px;"><div class="progress-fill" style="width:75%; background:#a855f7;"></div></div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div>&copy; 2026 GuruVerse<br><span style="font-size:0.7rem;">Belajar • Mengajar • Menginspirasi</span></div>
    <div class="footer-links">
      <a href="#">Tentang Kami</a>
      <a href="#">Bantuan</a>
      <a href="#">Kebijakan Privasi</a>
      <a href="#">Kontak</a>
    </div>
  </footer>

</div>

<script>
  lucide.createIcons();

  function updateToggleIcon(theme) {
    const icon = document.getElementById('theme-icon');
    if(icon) {
      icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
      lucide.createIcons({
        nameAttr: 'data-lucide'
      });
    }
  }

  function toggleTheme() {
    const html = document.documentElement;
    const isDark = html.getAttribute('data-theme') === 'dark';
    const newTheme = isDark ? 'light' : 'dark';
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateToggleIcon(newTheme);
  }

  // Set initial icon
  updateToggleIcon(currentTheme);

  function toggleNotif() {
    const nd = document.getElementById('notifDropdown');
    const ud = document.getElementById('userDropdown');
    if(nd.style.display === 'none') {
      nd.style.display = 'block';
      ud.style.display = 'none';
    } else {
      nd.style.display = 'none';
    }
  }

  function toggleUserMenu() {
    const nd = document.getElementById('notifDropdown');
    const ud = document.getElementById('userDropdown');
    if(ud.style.display === 'none') {
      ud.style.display = 'block';
      nd.style.display = 'none';
    } else {
      ud.style.display = 'none';
    }
  }

  document.addEventListener('click', function(e) {
    const nd = document.getElementById('notifDropdown');
    const ud = document.getElementById('userDropdown');
    if (!e.target.closest('.notif-btn') && !e.target.closest('#notifDropdown')) {
      if(nd) nd.style.display = 'none';
    }
    if (!e.target.closest('.user-profile') && !e.target.closest('#userDropdown')) {
      if(ud) ud.style.display = 'none';
    }
  });
</script>
</body>
</html>
