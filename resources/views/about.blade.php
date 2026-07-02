@include('partials.global_head')
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tentang Kami — Guruverse.ID</title>
    <meta name="description" content="Guruverse.ID adalah manifestasi dari ekosistem yang dibangun oleh ACF Eduhub. Ruang semesta peningkatan kompetensi guru Indonesia."/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
      (function(){
        var saved = localStorage.getItem('guruverse_theme');
        var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        var theme = saved || (prefersDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
      })();
    </script>
    <style>
    /* ===== CSS VARIABLES (mirrors public layout) ===== */
    *{box-sizing:border-box;margin:0;padding:0}
    html{scroll-behavior:smooth}
    body{font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:#0a0820;color:#fff;min-height:100vh}
    a{text-decoration:none;}

    :root{
      --purple:#7c3aed;
      --purple-dark:#6d28d9;
      --purple-light:#a78bfa;
      --purple-faint:#1e1560;
      --navy:#0a0820;
      --navy2:#0f0c2e;
      --navy3:#13103a;
      --navy4:#1a1242;
      --primary-dark:#5b21b6;
      --secondary:#a78bfa;
      --secondary-dark:#7c3aed;
      --border:rgba(124,58,237,.18);
      --text-muted:#9b93d4;
      --text-dim:#6b63a8;
      --bg: var(--navy);
      --card: var(--navy3);
      --text: #ffffff;
      --primary: var(--purple);
    }
    [data-theme="light"] {
      --primary: #093C5D;
      --primary-dark: #062c45;
      --primary-light: #357A9E;
      --secondary: #76D4E2;
      --secondary-dark: #2d93a4;
      --bg: #F5F8FA;
      --border: #D2E3EB;
      --text: #092B40;
      --text-muted: #3D6175;
    }
    [data-theme="light"] body { background: var(--bg); color: var(--text); }

    /* ===== ANIMATION SYSTEM (mirrors public layout) ===== */
    .gv-reveal {
      opacity: 0;
      transform: translateY(60px) rotate(1.5deg);
      transform-origin: left center;
      transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                  transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
      will-change: opacity, transform;
    }
    .gv-reveal.is-visible { opacity: 1; transform: translateY(0) rotate(0deg); }
    .gv-reveal.delay-1 { transition-delay: 0.1s; }
    .gv-reveal.delay-2 { transition-delay: 0.2s; }
    .gv-reveal.delay-3 { transition-delay: 0.3s; }
    .gv-reveal.delay-4 { transition-delay: 0.4s; }
    .gv-parallax-wrap { overflow: hidden; }
    .gv-parallax-img { transform: scale(1.15); will-change: transform; }

    /* ===== ABOUT HERO ===== */
    .about-hero {
      min-height: 92vh;
      background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(124,58,237,.45) 0%, transparent 70%), var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: clamp(80px,12vw,160px) 24px clamp(60px,8vw,100px);
      position: relative;
      overflow: hidden;
    }
    [data-theme="light"] .about-hero {
      background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(9,60,93,.12) 0%, transparent 70%), var(--bg);
    }
    .about-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237c3aed' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
    }
    .about-hero-inner { position: relative; z-index: 1; max-width: 820px; }
    .about-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(124,58,237,.15);
      border: 1px solid rgba(124,58,237,.35);
      color: var(--purple-light);
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .12em;
      text-transform: uppercase;
      padding: 8px 20px;
      border-radius: 100px;
      margin-bottom: 28px;
    }
    [data-theme="light"] .about-badge {
      background: rgba(9,60,93,.08);
      border-color: rgba(9,60,93,.25);
      color: var(--primary);
    }
    .about-hero-title {
      font-size: clamp(2.8rem, 7vw, 5.5rem);
      font-weight: 900;
      line-height: 1.08;
      letter-spacing: -.03em;
      color: #fff;
      margin-bottom: 28px;
    }
    [data-theme="light"] .about-hero-title { color: var(--primary); }
    .about-hero-title em {
      font-style: normal;
      background: linear-gradient(135deg, var(--purple-light), #c4b5fd);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    [data-theme="light"] .about-hero-title em {
      background: linear-gradient(135deg, var(--primary), var(--secondary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .about-hero-quote {
      font-size: clamp(1rem, 1.8vw, 1.25rem);
      color: var(--text-muted);
      line-height: 1.75;
      max-width: 640px;
      margin: 0 auto 40px;
    }
    [data-theme="light"] .about-hero-quote { color: var(--text-muted); }
    .about-hero-stats {
      display: flex;
      justify-content: center;
      gap: 48px;
      flex-wrap: wrap;
      margin-top: 48px;
      padding-top: 48px;
      border-top: 1px solid rgba(124,58,237,.2);
    }
    [data-theme="light"] .about-hero-stats { border-top-color: var(--border); }
    .about-stat-item { text-align: center; }
    .about-stat-num {
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 900;
      background: linear-gradient(135deg, #fff, var(--purple-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      display: block;
    }
    [data-theme="light"] .about-stat-num {
      background: linear-gradient(135deg, var(--primary), var(--secondary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .about-stat-lbl { font-size: 13px; color: var(--text-muted); font-weight: 500; margin-top: 4px; }

    /* ===== SECTION BASE ===== */
    .about-section {
      padding: clamp(64px, 8vw, 112px) clamp(20px, 5vw, 80px);
    }
    .about-section-inner { max-width: 1200px; margin: 0 auto; }
    .about-section.alt { background: var(--navy2); }
    [data-theme="light"] .about-section.alt { background: #ffffff; }
    .about-section.dark { background: linear-gradient(135deg, #1a0a3a, #0f0c2e); }
    [data-theme="light"] .about-section.dark { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); }

    .section-eyebrow {
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .14em;
      text-transform: uppercase;
      color: var(--purple-light);
      margin-bottom: 16px;
    }
    [data-theme="light"] .section-eyebrow { color: var(--secondary-dark); }
    .section-heading {
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 900;
      line-height: 1.15;
      letter-spacing: -.025em;
      color: #fff;
      margin-bottom: 20px;
    }
    [data-theme="light"] .section-heading { color: var(--primary); }
    .section-heading em {
      font-style: normal;
      background: linear-gradient(135deg, var(--purple-light), #c4b5fd);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    [data-theme="light"] .section-heading em {
      background: linear-gradient(135deg, var(--primary), var(--secondary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .section-lead {
      font-size: clamp(1rem, 1.6vw, 1.15rem);
      color: var(--text-muted);
      line-height: 1.8;
      max-width: 600px;
    }
    [data-theme="light"] .section-lead { color: var(--text-muted); }

    /* ===== VISI MISI ===== */
    .vm-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 32px;
      margin-top: 56px;
    }
    @media(max-width:768px){ .vm-grid { grid-template-columns: 1fr; } }
    .vm-card {
      background: var(--navy3);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 40px;
    }
    [data-theme="light"] .vm-card { background: #ffffff; border-color: var(--border); box-shadow: 0 4px 32px rgba(9,60,93,.07); }
    .vm-icon {
      width: 56px; height: 56px;
      background: rgba(124,58,237,.15);
      border-radius: 16px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 24px;
      color: var(--purple-light);
    }
    [data-theme="light"] .vm-icon { background: rgba(9,60,93,.08); color: var(--primary); }
    .vm-label {
      font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
      color: var(--purple-light); margin-bottom: 12px;
    }
    [data-theme="light"] .vm-label { color: var(--secondary-dark); }
    .vm-title { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 14px; line-height: 1.3; }
    [data-theme="light"] .vm-title { color: var(--primary); }
    .vm-text { color: var(--text-muted); line-height: 1.8; font-size: 15px; }
    [data-theme="light"] .vm-text { color: var(--text-muted); }

    /* ===== VALUES ===== */
    .values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 56px;
    }
    @media(max-width:900px){ .values-grid { grid-template-columns: 1fr 1fr; } }
    @media(max-width:540px){ .values-grid { grid-template-columns: 1fr; } }
    .value-card {
      background: rgba(124,58,237,.06);
      border: 1px solid rgba(124,58,237,.15);
      border-radius: 20px;
      padding: 32px 28px;
      transition: border-color .3s, transform .3s;
    }
    .value-card:hover { border-color: rgba(124,58,237,.4); transform: translateY(-4px); }
    [data-theme="light"] .value-card { background: #ffffff; border-color: var(--border); box-shadow: 0 4px 24px rgba(9,60,93,.06); }
    [data-theme="light"] .value-card:hover { border-color: var(--primary); }
    .value-num {
      font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
      color: var(--purple-light); margin-bottom: 16px; opacity: .7;
    }
    [data-theme="light"] .value-num { color: var(--secondary-dark); }
    .value-title { font-size: 1.15rem; font-weight: 800; color: #fff; margin-bottom: 10px; }
    [data-theme="light"] .value-title { color: var(--primary); }
    .value-desc { font-size: 14px; color: var(--text-muted); line-height: 1.7; }
    [data-theme="light"] .value-desc { color: var(--text-muted); }

    /* ===== HERO IMG (About Photo) ===== */
    .about-photo-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
    }
    @media(max-width:860px){ .about-photo-section { grid-template-columns: 1fr; } }
    .about-photo-wrap {
      border-radius: 28px;
      overflow: hidden;
      position: relative;
      aspect-ratio: 4/3;
    }
    .about-photo-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .about-photo-wrap::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(124,58,237,.3) 0%, transparent 60%);
    }

    /* ===== TEAM ===== */
    .team-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
      margin-top: 56px;
    }
    @media(max-width:860px){ .team-grid { grid-template-columns: 1fr 1fr; } }
    @media(max-width:540px){ .team-grid { grid-template-columns: 1fr; } }
    .team-card {
      background: var(--navy3);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 32px 24px;
      text-align: center;
      transition: border-color .3s, transform .3s;
    }
    .team-card:hover { border-color: rgba(124,58,237,.4); transform: translateY(-4px); }
    [data-theme="light"] .team-card { background: #ffffff; border-color: var(--border); box-shadow: 0 4px 24px rgba(9,60,93,.06); }
    .team-avatar {
      width: 80px; height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--purple-faint), var(--purple-dark));
      margin: 0 auto 20px;
      display: flex; align-items: center; justify-content: center;
      font-size: 2rem; font-weight: 800; color: var(--purple-light);
      border: 2px solid rgba(124,58,237,.3);
    }
    [data-theme="light"] .team-avatar {
      background: linear-gradient(135deg, rgba(9,60,93,.1), rgba(9,60,93,.2));
      color: var(--primary);
      border-color: rgba(9,60,93,.2);
    }
    .team-name { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
    [data-theme="light"] .team-name { color: var(--primary); }
    .team-role { font-size: 13px; color: var(--purple-light); font-weight: 600; }
    [data-theme="light"] .team-role { color: var(--secondary-dark); }
    .team-bio { font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-top: 12px; }

    /* ===== CTA ===== */
    .about-cta {
      text-align: center;
      padding: clamp(64px, 8vw, 100px) clamp(20px, 5vw, 80px);
      background: radial-gradient(ellipse 80% 80% at 50% 50%, rgba(124,58,237,.25) 0%, transparent 70%);
    }
    [data-theme="light"] .about-cta {
      background: radial-gradient(ellipse 80% 80% at 50% 50%, rgba(9,60,93,.08) 0%, transparent 70%);
    }
    .about-cta-title {
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 900;
      color: #fff;
      margin-bottom: 20px;
      line-height: 1.2;
    }
    [data-theme="light"] .about-cta-title { color: var(--primary); }
    .about-cta-sub { font-size: 1.1rem; color: var(--text-muted); margin-bottom: 40px; }
    .btn-primary-about {
      display: inline-flex; align-items: center; gap: 10px;
      background: linear-gradient(135deg, var(--purple), var(--purple-dark));
      color: #fff; font-weight: 700; font-size: 15px;
      padding: 16px 40px; border-radius: 14px;
      transition: transform .25s, box-shadow .25s;
      box-shadow: 0 8px 32px rgba(124,58,237,.35);
      text-decoration: none;
    }
    .btn-primary-about:hover { transform: translateY(-3px); box-shadow: 0 16px 48px rgba(124,58,237,.45); }
    [data-theme="light"] .btn-primary-about {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      box-shadow: 0 8px 32px rgba(9,60,93,.25);
    }

    /* ===== FOOTER ===== */
    .about-footer {
      text-align: center;
      padding: 32px 24px;
      border-top: 1px solid var(--border);
      font-size: 13px;
      color: var(--text-dim);
    }
    </style>
</head>
<body>
    @include('partials.global_header')

    {{-- HERO --}}
    <section class="about-hero">
        <div class="about-hero-inner">
            <span class="about-badge gv-reveal">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Tentang Kami
            </span>
            <h1 class="about-hero-title gv-reveal delay-1">
                Membangun <em>Semesta</em><br/>Guru Indonesia
            </h1>
            <p class="about-hero-quote gv-reveal delay-2">
                "Misi kami adalah memberdayakan guru Indonesia dengan alat, komunitas, dan ekosistem untuk meningkatkan kompetensi dan inovasi dalam pembelajaran."
            </p>
            <div class="about-hero-stats gv-reveal delay-3">
                <div class="about-stat-item">
                    <span class="about-stat-num">2M+</span>
                    <div class="about-stat-lbl">Guru Terdaftar</div>
                </div>
                <div class="about-stat-item">
                    <span class="about-stat-num">34</span>
                    <div class="about-stat-lbl">Provinsi</div>
                </div>
                <div class="about-stat-item">
                    <span class="about-stat-num">200+</span>
                    <div class="about-stat-lbl">Program</div>
                </div>
                <div class="about-stat-item">
                    <span class="about-stat-num">4.9★</span>
                    <div class="about-stat-lbl">Rating Platform</div>
                </div>
            </div>
        </div>
    </section>

    {{-- VISI MISI --}}
    <div class="about-section">
        <div class="about-section-inner">
            <div class="gv-reveal">
                <div class="section-eyebrow">Visi &amp; Misi</div>
                <h2 class="section-heading">Menciptakan <em>Ekosistem</em><br/>Belajar yang Terintegrasi</h2>
                <p class="section-lead">Guruverse.ID menyediakan platform lengkap untuk pelatihan, materi, dan kolaborasi guru di seluruh Indonesia — membangun generasi pendidik yang berdampak.</p>
            </div>
            <div class="vm-grid">
                <div class="vm-card gv-reveal delay-1">
                    <div class="vm-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <div class="vm-label">Visi</div>
                    <div class="vm-title">Menjadi Ekosistem Guru Terdepan di Asia Tenggara</div>
                    <div class="vm-text">Kami memimpikan dunia di mana setiap guru Indonesia memiliki akses penuh terhadap sumber daya, komunitas, dan teknologi terbaik untuk tumbuh sebagai pendidik yang berdampak nyata.</div>
                </div>
                <div class="vm-card gv-reveal delay-2">
                    <div class="vm-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="vm-label">Misi</div>
                    <div class="vm-title">Memberdayakan Setiap Guru dengan Alat & Komunitas</div>
                    <div class="vm-text">Memberikan platform pembelajaran yang inklusif, terstruktur, dan terkoneksi — memungkinkan guru untuk belajar, mengajar, dan menginspirasi satu sama lain tanpa batas geografis.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- FOTO + CERITA --}}
    <div class="about-section alt">
        <div class="about-section-inner">
            <div class="about-photo-section">
                <div class="gv-reveal">
                    <div class="section-eyebrow">Cerita Kami</div>
                    <h2 class="section-heading">Lahir dari <em>Kepedulian</em><br/>Terhadap Guru Indonesia</h2>
                    <p class="section-lead" style="margin-bottom:24px;">Guruverse.ID adalah manifestasi nyata dari ekosistem yang dibangun oleh <strong>ACF Eduhub</strong>. Bermula dari keresahan bahwa guru di Indonesia masih kesulitan mengakses sumber daya berkualitas dan komunitas yang suportif.</p>
                    <p class="section-lead">Sejak 2020, kami telah mendampingi lebih dari 2 juta guru dari Sabang sampai Merauke — melalui program pelatihan, webinar interaktif, dan komunitas kolaborasi yang terus bertumbuh.</p>
                </div>
                <div class="gv-reveal delay-2">
                    <div class="gv-parallax-wrap" style="border-radius:28px;">
                        <img src="{{ asset('asset/img/community_teachers_muslim (2).png') }}" alt="Komunitas Guru Guruverse" class="gv-parallax-img" style="width:100%;height:420px;object-fit:cover;display:block;"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NILAI-NILAI --}}
    <div class="about-section">
        <div class="about-section-inner">
            <div class="gv-reveal" style="text-align:center;max-width:640px;margin:0 auto 0;">
                <div class="section-eyebrow">Nilai-Nilai Kami</div>
                <h2 class="section-heading">Prinsip yang <em>Memandu</em> Kami</h2>
                <p class="section-lead" style="margin:0 auto;">Nilai-nilai ini bukan sekadar kata-kata — melainkan fondasi dari setiap keputusan dan inovasi yang kami bangun.</p>
            </div>
            <div class="values-grid">
                <div class="value-card gv-reveal delay-1">
                    <div class="value-num">01</div>
                    <div class="value-title">Inklusivitas</div>
                    <div class="value-desc">Setiap guru, dari kota besar hingga pelosok desa, berhak mendapat akses yang sama terhadap pendidikan berkualitas.</div>
                </div>
                <div class="value-card gv-reveal delay-2">
                    <div class="value-num">02</div>
                    <div class="value-title">Kolaborasi</div>
                    <div class="value-desc">Percaya bahwa guru-guru yang terhubung dan saling mendukung akan menciptakan dampak yang jauh lebih besar.</div>
                </div>
                <div class="value-card gv-reveal delay-3">
                    <div class="value-num">03</div>
                    <div class="value-title">Inovasi</div>
                    <div class="value-desc">Teknologi dan kreativitas adalah kunci untuk mentransformasi cara guru belajar, mengajar, dan berkolaborasi.</div>
                </div>
                <div class="value-card gv-reveal delay-1">
                    <div class="value-num">04</div>
                    <div class="value-title">Integritas</div>
                    <div class="value-desc">Transparansi dan kejujuran dalam setiap langkah adalah fondasi kepercayaan komunitas guru Indonesia.</div>
                </div>
                <div class="value-card gv-reveal delay-2">
                    <div class="value-num">05</div>
                    <div class="value-title">Dampak Nyata</div>
                    <div class="value-desc">Setiap program, fitur, dan komunitas dirancang dengan satu tujuan: perubahan positif yang terukur di dunia nyata.</div>
                </div>
                <div class="value-card gv-reveal delay-3">
                    <div class="value-num">06</div>
                    <div class="value-title">Pertumbuhan Berkelanjutan</div>
                    <div class="value-desc">Kami percaya bahwa belajar tidak pernah berhenti — baik untuk guru, maupun untuk kami sebagai platform.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TIM --}}
    <div class="about-section alt">
        <div class="about-section-inner">
            <div class="gv-reveal" style="text-align:center;max-width:640px;margin:0 auto 0;">
                <div class="section-eyebrow">Tim Kami</div>
                <h2 class="section-heading">Orang-Orang di <em>Balik</em> Guruverse</h2>
                <p class="section-lead" style="margin:0 auto;">Digerakkan oleh semangat untuk memajukan pendidikan Indonesia, tim kami terdiri dari para profesional yang berdedikasi.</p>
            </div>
            <div class="team-grid">
                <div class="team-card gv-reveal delay-1">
                    <div class="team-avatar">A</div>
                    <div class="team-name">Ahmad Fauzi</div>
                    <div class="team-role">Chief Executive Officer</div>
                    <div class="team-bio">Pendiri ACF Eduhub dengan lebih dari 12 tahun pengalaman di bidang teknologi pendidikan.</div>
                </div>
                <div class="team-card gv-reveal delay-2">
                    <div class="team-avatar">S</div>
                    <div class="team-name">Sari Dewi</div>
                    <div class="team-role">Chief Product Officer</div>
                    <div class="team-bio">Mantan guru SMA dengan passion membangun produk digital yang benar-benar membantu pendidik.</div>
                </div>
                <div class="team-card gv-reveal delay-3">
                    <div class="team-avatar">R</div>
                    <div class="team-name">Reza Pratama</div>
                    <div class="team-role">Head of Community</div>
                    <div class="team-bio">Mengelola jaringan komunitas guru di 34 provinsi Indonesia dengan program mentorship aktif.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="about-cta">
        <div style="max-width:640px;margin:0 auto;">
            <h2 class="about-cta-title gv-reveal">Bergabunglah dengan<br/><em style="background:linear-gradient(135deg,var(--purple-light),#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-style:normal;">2 Juta+ Guru Indonesia</em></h2>
            <p class="about-cta-sub gv-reveal delay-1">Mulai perjalanan belajar Anda hari ini. Gratis untuk 30 hari pertama.</p>
            <div class="gv-reveal delay-2">
                <a href="{{ route('register') }}" class="btn-primary-about">
                    Mulai Bergabung Gratis
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="about-footer">@2024 Guruverse.ID — All rights reserved.</div>

    @include('partials.global_footer')

    {{-- Animation Engine (same as public pages) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
    gsap.registerPlugin(ScrollTrigger);

    // ---- Intersection Observer: Fade Up ----
    const revealObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
        } else {
          entry.target.classList.remove('is-visible');
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('.gv-reveal').forEach(function(el) {
      revealObserver.observe(el);
    });

    // ---- GSAP Parallax ----
    document.querySelectorAll('.gv-parallax-img').forEach(function(elem) {
      gsap.to(elem, {
        yPercent: 18,
        scale: 1,
        ease: 'none',
        scrollTrigger: {
          trigger: elem.closest('.gv-parallax-wrap') || elem.parentElement,
          start: 'top bottom',
          end: 'bottom top',
          scrub: 1.5
        }
      });
    });
    </script>
</body>
</html>
