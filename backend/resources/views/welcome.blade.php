<!DOCTYPE html>
<html lang="id">
<head>
    <title>Guruverse.ID — Beranda</title>
    @include('partials.global_head')
    <style>
        /* =========================================
           UPGRADED AESTHETIC DESIGN - GURUVERSE
           ========================================= */
        
        /* 1. Hero Section - Vibrant, Dynamic, Deep */
        .hero {
            position: relative;
            overflow: hidden;
            padding: 100px 24px 80px;
            background: linear-gradient(135deg, var(--navy) 0%, #150B3A 50%, #0F172A 100%);
            min-height: 90vh;
            display: flex;
            align-items: center;
        }
        
        [data-theme="light"] .hero {
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 50%, #F8FAFC 100%);
        }

        /* Hero Animated Glowing Orbs */
        .hero::before, .hero::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: orbFloat 10s ease-in-out infinite alternate;
        }
        .hero::before {
            width: 400px; height: 400px;
            background: rgba(124, 58, 237, 0.25); /* Purple orb */
            top: -10%; left: -5%;
        }
        .hero::after {
            width: 300px; height: 300px;
            background: rgba(56, 189, 248, 0.2); /* Cyan orb */
            bottom: -5%; right: 10%;
            animation-delay: -5s;
        }
        [data-theme="light"] .hero::before { background: rgba(99, 102, 241, 0.2); }
        [data-theme="light"] .hero::after { background: rgba(56, 189, 248, 0.25); }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 40px) scale(1.1); }
        }

        .hero-stars { position: absolute; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .hero-star { position: absolute; border-radius: 50%; background: #A78BFA; box-shadow: 0 0 10px 2px rgba(167,139,250,0.5); animation: twinkle 3s infinite alternate; }
        @keyframes twinkle { 0% { opacity: 0.2; transform: scale(0.8); } 100% { opacity: 0.8; transform: scale(1.2); } }

        .hero-inner {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 48px; align-items: center; width: 100%;
        }

        .hero-text { display: flex; flex-direction: column; gap: 20px; }
        
        .hero-eyebrow {
            font-size: 13px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase;
            color: #38BDF8; display: inline-block;
            background: rgba(56,189,248,0.1); padding: 6px 16px; border-radius: 20px; align-self: flex-start;
            border: 1px solid rgba(56,189,248,0.2);
        }
        [data-theme="light"] .hero-eyebrow { color: #0284C7; background: rgba(2,132,199,0.1); border-color: rgba(2,132,199,0.2); }

        .hero-title {
            font-size: clamp(38px, 5vw, 64px); font-weight: 900; line-height: 1.1;
            color: #FFFFFF; letter-spacing: -1px;
        }
        [data-theme="light"] .hero-title { color: #0F172A; }

        .hero-title em {
            font-style: normal;
            background: linear-gradient(135deg, #A855F7, #EC4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0px 4px 20px rgba(168, 85, 247, 0.3);
        }

        .hero-subtitle { font-size: 17px; color: rgba(255,255,255,0.75); line-height: 1.7; max-width: 520px; }
        [data-theme="light"] .hero-subtitle { color: #475569; }

        .hero-actions { display: flex; gap: 16px; flex-wrap: wrap; margin-top: 8px; }
        
        .btn-primary {
            background: linear-gradient(135deg, #7C3AED, #4F46E5);
            border: none; border-radius: 30px;
            padding: 14px 32px; color: #fff; font-weight: 800; font-size: 15px;
            cursor: pointer; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.5);
            position: relative; overflow: hidden;
        }
        .btn-primary::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s;
        }
        .btn-primary:hover::after { left: 100%; }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(124, 58, 237, 0.6); }

        .btn-secondary {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px; padding: 14px 32px;
            color: #fff; font-weight: 700; font-size: 15px;
            backdrop-filter: blur(10px); cursor: pointer; transition: all 0.3s;
        }
        [data-theme="light"] .btn-secondary { background: rgba(255,255,255,0.7); color: #0F172A; border-color: rgba(15,23,42,0.1); }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); transform: translateY(-3px); border-color: #A78BFA; }
        [data-theme="light"] .btn-secondary:hover { background: #fff; border-color: #6366F1; }

        .hero-search { margin-top: 16px; width: 100%; max-width: 500px; }
        
        /* Glassmorphism Search Box */
        .search-box {
            display: flex; align-items: center; padding: 6px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50px; backdrop-filter: blur(16px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        [data-theme="light"] .search-box { background: rgba(255,255,255,0.9); box-shadow: 0 15px 35px rgba(15,23,42,0.08); border-color: rgba(15,23,42,0.05); }
        .search-box:focus-within { border-color: #A78BFA; background: rgba(255,255,255,0.12); box-shadow: 0 15px 40px rgba(167,139,250,0.2); }
        [data-theme="light"] .search-box:focus-within { border-color: #6366F1; background: #fff; box-shadow: 0 15px 40px rgba(99,102,241,0.15); }

        .search-input {
            flex: 1; border: none; background: transparent; color: #fff;
            padding: 12px 20px; font-size: 15px; outline: none; font-family: inherit;
        }
        [data-theme="light"] .search-input { color: #0F172A; }
        .search-input::placeholder { color: rgba(255,255,255,0.5); }
        [data-theme="light"] .search-input::placeholder { color: rgba(15,23,42,0.4); }
        
        .search-btn {
            background: #A855F7; border: none; border-radius: 50px;
            color: #fff; font-weight: 700; padding: 12px 24px; cursor: pointer; transition: all 0.3s;
        }
        .search-btn:hover { background: #9333EA; transform: scale(1.05); }

        .hero-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
        .tag-pill {
            padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            color: #C4B5FD; cursor: pointer; transition: all 0.2s; backdrop-filter: blur(5px);
        }
        [data-theme="light"] .tag-pill { background: rgba(15,23,42,0.04); color: #475569; border-color: rgba(15,23,42,0.05); }
        .tag-pill:hover { background: rgba(167,139,250,0.2); color: #fff; border-color: #A78BFA; }
        [data-theme="light"] .tag-pill:hover { background: rgba(99,102,241,0.1); color: #4F46E5; border-color: #6366F1; }

        .hero-image { display: flex; justify-content: center; align-items: center; position: relative; }
        .hero-image img {
            width: 100%; max-width: 600px; height: auto;
            filter: drop-shadow(0 30px 40px rgba(0,0,0,0.4));
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* 2. Hero Features (Glassmorphism Overlay) */
        .hero-features {
            position: relative; margin: -60px 24px 60px; max-width: 1152px; z-index: 10;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 32px; padding: 50px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            margin-left: auto; margin-right: auto;
        }
        [data-theme="light"] .hero-features { background: rgba(255,255,255,0.8); border-color: #fff; box-shadow: 0 20px 40px rgba(15,23,42,0.08); }

        .section-header { text-align: center; margin-bottom: 40px; }
        .section-eyebrow { font-size: 13px; font-weight: 800; color: #A78BFA; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; }
        [data-theme="light"] .section-eyebrow { color: #6366F1; }
        .section-title { font-size: clamp(28px, 3.5vw, 40px); font-weight: 900; color: #fff; margin-bottom: 16px; letter-spacing: -0.5px; }
        [data-theme="light"] .section-title { color: #0F172A; }
        .section-subtitle { font-size: 16px; color: rgba(255,255,255,0.7); max-width: 650px; margin: 0 auto; line-height: 1.6; }
        [data-theme="light"] .section-subtitle { color: #475569; }

        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; }
        
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px; padding: 32px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex; flex-direction: column; height: 100%;
        }
        [data-theme="light"] .feature-card { background: #fff; border-color: rgba(15,23,42,0.06); box-shadow: 0 10px 25px rgba(15,23,42,0.03); }
        .feature-card:hover { transform: translateY(-10px); background: rgba(255,255,255,0.06); border-color: rgba(167,139,250,0.4); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        [data-theme="light"] .feature-card:hover { background: #fff; border-color: #A78BFA; box-shadow: 0 20px 40px rgba(15,23,42,0.08); }

        .feature-card-title { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 12px; }
        [data-theme="light"] .feature-card-title { color: #0F172A; }
        .feature-card-desc { font-size: 14px; color: rgba(255,255,255,0.65); line-height: 1.7; flex-grow: 1; margin-bottom: 24px; }
        [data-theme="light"] .feature-card-desc { color: #475569; }
        
        .feature-card-link {
            background: rgba(167,139,250,0.15); color: #C4B5FD; border: none;
            padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 14px;
            cursor: pointer; transition: all 0.3s; align-self: flex-start;
        }
        [data-theme="light"] .feature-card-link { background: rgba(99,102,241,0.1); color: #4F46E5; }
        .feature-card:hover .feature-card-link { background: #A855F7; color: #fff; }
        [data-theme="light"] .feature-card:hover .feature-card-link { background: #4F46E5; color: #fff; }

        /* 3. Pillars Section - Immersive Grid */
        .pillars { padding: 80px 24px; background: var(--navy); }
        [data-theme="light"] .pillars { background: #F8FAFC; }

        .pillars-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px; max-width: 1200px; margin: 0 auto; }
        
        .pillar-card {
            background: var(--navy3); border: 1px solid rgba(255,255,255,0.05);
            border-radius: 28px; overflow: hidden; display: flex; flex-direction: column;
            cursor: pointer; transition: all 0.4s; box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        [data-theme="light"] .pillar-card { background: #fff; border-color: rgba(15,23,42,0.08); box-shadow: 0 15px 35px rgba(15,23,42,0.05); }
        .pillar-card:hover { transform: translateY(-12px); border-color: #A855F7; box-shadow: 0 30px 60px rgba(0,0,0,0.4); }
        [data-theme="light"] .pillar-card:hover { border-color: #6366F1; box-shadow: 0 30px 60px rgba(15,23,42,0.12); }

        .pillar-img { width: 100%; height: 220px; position: relative; overflow: hidden; background: linear-gradient(135deg, #F1F5F9, #E2E8F0); }
        .pillar-img::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, var(--navy3), transparent); }
        [data-theme="light"] .pillar-img::after { background: linear-gradient(to top, #fff, transparent); }
        .pillar-img img { width: 100%; height: 100%; object-fit: cover; object-position: center 20%; transition: transform 0.6s ease; }
        .pillar-card:hover .pillar-img img { transform: scale(1.08); }

        .pillar-body { padding: 30px; display: flex; flex-direction: column; flex-grow: 1; position: relative; z-index: 2; margin-top: -30px; }
        .pillar-title { font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 12px; }
        [data-theme="light"] .pillar-title { color: #0F172A; }
        .pillar-desc { font-size: 14px; color: rgba(255,255,255,0.65); line-height: 1.7; flex-grow: 1; margin-bottom: 20px; }
        [data-theme="light"] .pillar-desc { color: #475569; }
        
        .pillar-arrow {
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(167,139,250,0.15); color: #C4B5FD;
            border: none; display: flex; align-items: center; justify-content: center;
            margin-left: auto; transition: all 0.3s;
        }
        [data-theme="light"] .pillar-arrow { background: rgba(99,102,241,0.1); color: #4F46E5; }
        .pillar-card:hover .pillar-arrow { background: linear-gradient(135deg, #7C3AED, #4F46E5); color: #fff; transform: scale(1.1) rotate(-45deg); box-shadow: 0 10px 20px rgba(124,58,237,0.4); }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-inner { grid-template-columns: 1fr; text-align: center; }
            .hero-text { align-items: center; }
            .hero-subtitle { margin: 0 auto; }
            .hero-actions { justify-content: center; }
            .hero-tags { justify-content: center; }
            .hero-features { margin: -40px 20px 40px; padding: 40px 30px; }
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 36px; }
            .hero-image { display: none; /* Simplify on mobile */ }
            .hero { min-height: 70vh; padding: 80px 20px 60px; }
            .search-box { flex-direction: column; border-radius: 20px; padding: 12px; }
            .search-input { width: 100%; text-align: center; }
            .search-btn { width: 100%; border-radius: 12px; }
        }

    </style>
</head>
<body>
    @include('partials.global_header')

    <!-- =====================
         HOMEPAGE - UPGRADED
    ===================== -->
    <div id="pg-home" class="page on">

    <!-- HERO SECTION -->
    <section class="hero">
      <div class="hero-stars">
        <div class="hero-star" style="width:3px;height:3px;top:12%;left:8%;opacity:.7"></div>
        <div class="hero-star" style="width:4px;height:4px;top:28%;left:15%;opacity:.4"></div>
        <div class="hero-star" style="width:3px;height:3px;top:8%;left:55%;opacity:.5"></div>
        <div class="hero-star" style="width:6px;height:6px;top:70%;left:48%;opacity:.3"></div>
        <div class="hero-star" style="width:2px;height:2px;top:45%;left:92%;opacity:.6"></div>
        <div class="hero-star" style="width:4px;height:4px;top:18%;right:22%;opacity:.4"></div>
      </div>
      <div class="hero-inner">
        <div class="hero-text">
          <div class="hero-eyebrow">Ruang Semesta Guru Indonesia</div>
          <h1 class="hero-title">Semesta Kompetensi,<br/><em>Untuk Guru Indonesia</em></h1>
          <p class="hero-subtitle">Guruverse.ID adalah ekosistem digital cerdas bagi guru Indonesia untuk terhubung, bertumbuh, dan menjadi lebih inspiratif bersama.</p>
          <div class="hero-actions">
            <button class="btn-primary" onclick="window.location.href='{{ url('/register') }}'">Daftar Sekarang</button>
            <button class="btn-secondary" onclick="window.location.href='{{ url('/learn-more') }}'">Pelajari Lebih Lanjut</button>
          </div>
          <div class="hero-search">
            <div class="search-box">
              <input type="search" class="search-input" placeholder="Cari kelas, program, atau komunitas..." aria-label="Search Guruverse" />
              <button class="search-btn" type="button">Jelajahi</button>
            </div>
            <div class="hero-tags">
              <span class="tag-pill">Pendidikan Abad 21</span>
              <span class="tag-pill">Sertifikasi</span>
              <span class="tag-pill">Komunitas Interaktif</span>
              <span class="tag-pill">Webinar</span>
            </div>
          </div>
        </div>
        <div class="hero-image">
          <img src="{{ asset('asset/img/hero-teachers.png') }}" alt="Guru Indonesia Bersama" />
        </div>
      </div>
    </section>

    <!-- GLASSMORPHISM FEATURES OVERYLAY -->
    <section class="hero-features">
      <div class="section-header">
        <div class="section-eyebrow">Fitur Unggulan</div>
        <h2 class="section-title">Ekosistem Super App Guru</h2>
        <p class="section-subtitle">Bawa pengalaman belajar-mengajar Anda ke tingkat tertinggi dengan teknologi AI, komunitas suportif, dan analitik performa yang mendalam.</p>
      </div>
      <div class="feature-grid">
        <article class="feature-card">
          <h3 class="feature-card-title">Micro-Learning Interaktif</h3>
          <p class="feature-card-desc">Tingkatkan kompetensi Anda melalui modul belajar singkat, quiz cerdas, dan pendampingan mentor eksklusif kapan saja.</p>
          <button class="feature-card-link" type="button" onclick="window.location.href='{{ url('/belajar') }}'">Jelajahi Program</button>
        </article>
        <article class="feature-card">
          <h3 class="feature-card-title">Jejaring Guru Nasional</h3>
          <p class="feature-card-desc">Terhubung dengan ribuan guru dari seluruh Indonesia, berbagi RPP inovatif, dan berkolaborasi dalam proyek berdampak.</p>
          <button class="feature-card-link" type="button" onclick="window.location.href='{{ url('/inspira') }}'">Gabung Diskusi</button>
        </article>
        <article class="feature-card">
          <h3 class="feature-card-title">Impact Tracker Dashboard</h3>
          <p class="feature-card-desc">Pantau perkembangan kompetensi Anda, dapatkan laporan visual yang indah, dan raih sertifikat resmi terverifikasi.</p>
          <button class="feature-card-link" type="button" onclick="window.location.href='{{ url('/mengajar') }}'">Lihat Analitik</button>
        </article>
      </div>
    </section>

    <!-- PILLARS SECTION -->
    <section class="pillars">
      <div class="section-header">
        <div class="section-eyebrow">Tiga Pilar Kekuatan</div>
        <h2 class="section-title">Pilar Utama Guruverse.ID</h2>
        <p class="section-subtitle" style="margin-top: 10px;">Membangun ekosistem pendidikan berkelanjutan untuk mencetak guru inovatif, pedagogik, dan inspiratif di era digital.</p>
      </div>
      <div class="pillars-grid">

        <!-- Card 1 -->
        <div class="pillar-card" onclick="window.location.href='{{ url('/belajar') }}'">
          <div class="pillar-img">
            <img src="{{ asset('asset/img/guru-wanita.png') }}" alt="Guru Belajar"/>
          </div>
          <div class="pillar-body">
            <div class="pillar-title">Guru Belajar</div>
            <div class="pillar-desc">Perjalanan memperdalam kompetensi pedagogik. Akses kelas intensif, sertifikasi resmi, dan kurikulum yang dirancang khusus untuk memenuhi standar pendidikan masa depan.</div>
            <button class="pillar-arrow" aria-label="Lihat Detail">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
            </button>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="pillar-card" onclick="window.location.href='{{ url('/mengajar') }}'">
          <div class="pillar-img">
            <img src="{{ asset('asset/img/rapat-guru.png') }}" alt="Guru Mengajar"/>
          </div>
          <div class="pillar-body">
            <div class="pillar-title">Guru Mengajar</div>
            <div class="pillar-desc">Wujudkan ilmu dalam aksi nyata. Kelola kelas digital Anda, pantau statistik keterlibatan siswa, dan gunakan gamifikasi untuk menciptakan pengalaman belajar luar biasa.</div>
            <button class="pillar-arrow" aria-label="Lihat Detail">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
            </button>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="pillar-card" onclick="window.location.href='{{ url('/inspira') }}'">
          <div class="pillar-img">
            <img src="{{ asset('asset/img/teachers-sertifikat.png') }}" alt="Guru Inspira"/>
          </div>
          <div class="pillar-body">
            <div class="pillar-title">Guru Inspira</div>
            <div class="pillar-desc">Setiap kisah memiliki kekuatan. Bagikan inspirasi, dukung sesama pendidik dalam forum lintas pulau, dan temukan dukungan moral dari jaringan profesional eksklusif kami.</div>
            <button class="pillar-arrow" aria-label="Lihat Detail">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
            </button>
          </div>
        </div>

      </div>
    </section>

    </div>
    <!-- end pg-home -->

    @include('partials.global_footer')
</body>
</html>
