@extends('layouts.public')

@section('content')

<!-- Upgraded Premium CSS -->
<style>
  /* Base & Typography */
  :root {
    --law-bg: #f8fafc;
    --law-text: #0f172a;
    --law-highlight: #2563eb;
    --law-highlight-gradient: linear-gradient(135deg, #2563eb, #8b5cf6);
    --law-card-bg: rgba(255, 255, 255, 0.7);
    --law-pill-bg: rgba(37, 99, 235, 0.1);
    --law-pill-text: #2563eb;
  }

  [data-theme="dark"] {
    --law-bg: #0f172a;
    --law-text: #f8fafc;
    --law-highlight: #60a5fa;
    --law-highlight-gradient: linear-gradient(135deg, #60a5fa, #c084fc);
    --law-card-bg: rgba(30, 41, 59, 0.5);
    --law-pill-bg: rgba(96, 165, 250, 0.15);
    --law-pill-text: #60a5fa;
  }

  .lm-page {
    background-color: var(--law-bg);
    color: var(--law-text);
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
    position: relative;
    min-height: 100vh;
  }

  /* Rich Animated Blob Backgrounds */
  .bg-blobs {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 0; pointer-events: none;
  }
  .blob-1 {
    position: absolute; top: -10%; right: -5%; width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);
    border-radius: 50%; filter: blur(40px); animation: float-blob 20s ease-in-out infinite alternate;
  }
  .blob-2 {
    position: absolute; top: 40%; left: -10%; width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
    border-radius: 50%; filter: blur(40px); animation: float-blob 25s ease-in-out infinite alternate-reverse;
  }
  [data-theme="dark"] .blob-1 { background: radial-gradient(circle, rgba(192,132,252,0.15) 0%, transparent 70%); }
  [data-theme="dark"] .blob-2 { background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%); }

  @keyframes float-blob {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(-30px, 50px) scale(1.1); }
  }

  .law-container {
    max-width: 1400px; margin: 0 auto; padding: 0 5%; position: relative; z-index: 1;
  }

  /* Back Button - Polished */
  .btn-back-modern {
    display: inline-flex; align-items: center; gap: 8px; color: var(--law-text);
    text-decoration: none; font-weight: 600; font-size: 0.9rem;
    margin-top: 30px; margin-bottom: 20px; padding: 10px 20px;
    background: var(--law-card-bg); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    border-radius: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .btn-back-modern:hover { 
    transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); 
    background: var(--law-text); color: var(--law-bg);
  }

  /* Hero Section */
  .hero-section {
    display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; align-items: center; padding: 40px 0 80px;
  }
  .hero-title { 
    font-size: clamp(3rem, 5vw, 4.5rem); font-weight: 800; line-height: 1.1; 
    letter-spacing: -0.04em; margin-bottom: 24px; color: var(--law-text); 
  }
  .hero-highlight { 
    background: var(--law-highlight-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .hero-subtitle {
    font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: var(--law-highlight);
    text-transform: uppercase; letter-spacing: 1px;
  }
  .hero-desc { 
    font-size: 1.15rem; line-height: 1.7; color: var(--law-text); opacity: 0.75; 
    max-width: 500px; margin-bottom: 40px;
  }
  
  .fc-pill { 
    display: inline-flex; align-items: center; padding: 6px 14px; border-radius: 30px; 
    background: var(--law-pill-bg); color: var(--law-pill-text); font-size: 0.8rem; 
    font-weight: 700; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 1px;
  }

  /* Hero Buttons */
  .hero-actions { display: flex; gap: 16px; align-items: center; }
  .btn-primary-glow {
    padding: 14px 28px; border-radius: 40px; background: var(--law-highlight-gradient);
    color: #ffffff !important; font-weight: 700; font-size: 1rem; text-decoration: none;
    box-shadow: 0 10px 30px rgba(37,99,235,0.3); transition: all 0.3s;
  }
  .btn-primary-glow:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(37,99,235,0.4); }
  .btn-secondary {
    padding: 14px 28px; border-radius: 40px; font-weight: 700; font-size: 1rem;
    color: var(--law-text); text-decoration: none; transition: all 0.3s;
  }
  .btn-secondary:hover { opacity: 0.7; }

  /* Hero Right (Floating Visuals NO CARDS) */
  .hero-visuals { position: relative; height: 400px; display: flex; justify-content: center; align-items: center; }
  .floating-glass {
    position: absolute; background: var(--law-card-bg); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-radius: 24px; padding: 24px; box-shadow: 0 30px 60px rgba(0,0,0,0.06);
    display: flex; flex-direction: column; gap: 12px; z-index: 2;
  }
  [data-theme="dark"] .floating-glass { box-shadow: 0 30px 60px rgba(0,0,0,0.4); }
  .fc-title { font-weight: 700; font-size: 1rem; color: var(--law-text); }
  
  .img-float { animation: float-img 8s ease-in-out infinite; z-index: 3; position: relative; width: 100%; max-width: 320px; }

  /* Main Sections */
  .section-block { padding: 80px 0; position: relative; }
  
  .section-header { margin-bottom: 50px; }
  .section-title { font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 800; margin-bottom: 16px; letter-spacing: -0.03em; color: var(--law-text); }
  .section-subtitle { font-size: 1.1rem; opacity: 0.7; max-width: 600px; line-height: 1.7; color: var(--law-text); }

  /* Grid Layouts - NO BORDERS */
  .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; margin-top: 40px; }
  .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-top: 40px; }
  
  /* The "Card" is now just a soft glassy background, no border */
  .modern-glass-item {
    background: var(--law-card-bg); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    border-radius: 24px; padding: 40px 32px; color: var(--law-text);
    box-shadow: 0 20px 40px rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }
  [data-theme="dark"] .modern-glass-item { box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
  .modern-glass-item:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 30px 60px rgba(0,0,0,0.06); 
    background: var(--law-bg); /* Slight shift on hover */
  }
  [data-theme="dark"] .modern-glass-item:hover { box-shadow: 0 30px 60px rgba(0,0,0,0.4); }

  .glass-num { font-size: 1.25rem; font-weight: 800; margin-bottom: 16px; color: var(--law-highlight); opacity: 0.8; }
  .glass-head { font-size: 1.4rem; font-weight: 700; margin-bottom: 12px; }
  .glass-desc { font-size: 1rem; opacity: 0.7; line-height: 1.7; }

  /* Modules List - Clean Flow */
  .module-list { display: flex; flex-direction: column; gap: 24px; margin-top: 40px; max-width: 800px; }
  .module-item { 
    display: flex; gap: 24px; align-items: flex-start; padding: 32px;
    background: var(--law-card-bg); border-radius: 24px; backdrop-filter: blur(10px);
    transition: transform 0.3s;
  }
  .module-item:hover { transform: scale(1.01); }
  .mod-icon { 
    font-size: 2.5rem; font-weight: 900; background: var(--law-highlight-gradient); 
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; 
    line-height: 1; width: 60px; flex-shrink: 0;
  }
  .mod-title { font-weight: 800; color: var(--law-text); font-size: 1.25rem; margin-bottom: 8px; }
  .mod-desc { font-size: 1.05rem; opacity: 0.7; line-height: 1.6; color: var(--law-text); }

  @media(max-width: 992px) {
    .hero-section { grid-template-columns: 1fr; text-align: center; }
    .hero-desc { margin: 0 auto 40px; }
    .hero-actions { justify-content: center; }
    .hero-visuals { display: none; }
  }

  @keyframes float-img {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
  }
</style>

<div class="lm-page">
  <div class="bg-blobs">
    <div class="blob-1"></div>
    <div class="blob-2"></div>
  </div>

  <main class="law-container">
    
    <a href="{{ url('/#gurubelajar') }}" onclick="event.preventDefault(); window.history.length > 1 && document.referrer !== '' ? window.history.back() : window.location.href = this.href;" class="btn-back-modern gv-reveal">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      Kembali
    </a>

    <!-- HERO SECTION -->
    <section class="hero-section">
      <div class="gv-reveal">
        <span class="fc-pill">Pilar Pertama</span>
        <h1 class="hero-title">
          Guru <br>
          <span class="hero-highlight">Belajar</span>
        </h1>
        <h3 class="hero-subtitle">Mengapa Guru Belajar Penting?</h3>
        <p class="hero-desc">
          Guru Belajar adalah fondasi dari perjalanan seorang pendidik. Di sini, guru Indonesia diajak untuk terus bertumbuh, memperdalam kompetensi, dan menyesuaikan diri dengan perubahan zaman. Belajar bukan sekadar kewajiban, melainkan identitas seorang guru profesional.
        </p>
        <div class="hero-actions">
          <a href="{{ route('register') }}" class="btn-primary-glow">Daftar Sekarang</a>
          <a href="#program" class="btn-secondary">Lihat Program</a>
        </div>
      </div>
      
      <div class="hero-visuals gv-reveal delay-2">
        <div class="floating-glass" style="bottom: 40px; left: -40px; width: 260px; animation: float-img 6s ease-in-out infinite reverse; z-index: 4;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div class="fc-title">Sertifikat Resmi</div>
            <span class="fc-pill" style="background:#dcfce7; color:#166534; margin:0; font-size:0.7rem;">Valid</span>
          </div>
          <p style="font-size:0.9rem; opacity:0.7; margin:0; color: var(--law-text); line-height:1.5;">Bukti pencapaian yang bisa meningkatkan portofolio dan angka kredit.</p>
        </div>

        <img src="{{ asset('asset/img/premium-teacher-certificate-transparent.png') }}" alt="Sertifikat" class="img-float" style="filter: drop-shadow(0 30px 40px rgba(0,0,0,0.15));">
      </div>
    </section>

    <!-- PROGRAM SECTION -->
    <section id="program" class="section-block">
      <div class="section-header gv-reveal">
        <span class="fc-pill">Program Guru Belajar</span>
        <h2 class="section-title">Pembelajaran <span class="hero-highlight">Fleksibel & Terstruktur</span></h2>
        <p class="section-subtitle">
          Program ini dirancang sedemikian rupa sehingga guru bisa belajar kapan saja dan di mana saja sesuai dengan ritme masing-masing.
        </p>
      </div>

      <div class="feature-grid">
        <div class="modern-glass-item gv-reveal delay-1">
          <div class="glass-num">01.</div>
          <h3 class="glass-head">Kelas Online & Webinar</h3>
          <p class="glass-desc">Akses langsung ke materi terbaru dari pakar pendidikan, memfasilitasi interaksi real-time untuk diskusi mendalam.</p>
        </div>
        <div class="modern-glass-item gv-reveal delay-2">
          <div class="glass-num">02.</div>
          <h3 class="glass-head">Modul Terstruktur</h3>
          <p class="glass-desc">Kurikulum berkualitas tinggi yang secara konsisten di-update agar relevan dengan kebutuhan pengajaran masa kini.</p>
        </div>
        <div class="modern-glass-item gv-reveal delay-3">
          <div class="glass-num">03.</div>
          <h3 class="glass-head">Sertifikat Digital Resmi</h3>
          <p class="glass-desc">Tingkatkan portofolio Anda dengan kredensial yang divalidasi dan diakui secara nasional oleh kementerian terkait.</p>
        </div>
      </div>
    </section>

    <!-- STATS SECTION -->
    <section class="section-block">
      <div class="section-header gv-reveal" style="text-align: right;">
        <span class="fc-pill" style="background:rgba(234,179,8,0.15); color:#ca8a04;">Dampak Nyata</span>
        <h2 class="section-title">Bukti Kualitas <span class="hero-highlight">Guruverse</span></h2>
      </div>

      <div class="stat-grid">
        <div class="modern-glass-item gv-reveal delay-1" style="text-align: center; padding: 40px 20px;">
          <div style="font-size: 3rem; font-weight: 900; background: var(--law-highlight-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">2M+</div>
          <div style="font-weight: 700; font-size: 1.1rem; margin: 12px 0 8px;">Peserta Terdaftar</div>
          <div style="font-size: 0.95rem; opacity: 0.6;">Komunitas besar guru</div>
        </div>
        <div class="modern-glass-item gv-reveal delay-2" style="text-align: center; padding: 40px 20px;">
          <div style="font-size: 3rem; font-weight: 900; background: var(--law-highlight-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">200+</div>
          <div style="font-weight: 700; font-size: 1.1rem; margin: 12px 0 8px;">Mata Pelajaran</div>
          <div style="font-size: 0.95rem; opacity: 0.6;">Pilihan sesuai kebutuhan</div>
        </div>
        <div class="modern-glass-item gv-reveal delay-3" style="text-align: center; padding: 40px 20px;">
          <div style="font-size: 3rem; font-weight: 900; background: var(--law-highlight-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">95%</div>
          <div style="font-weight: 700; font-size: 1.1rem; margin: 12px 0 8px;">Penyelesaian</div>
          <div style="font-size: 0.95rem; opacity: 0.6;">Tuntas 100% modul</div>
        </div>
        <div class="modern-glass-item gv-reveal delay-4" style="text-align: center; padding: 40px 20px;">
          <div style="font-size: 3rem; font-weight: 900; background: var(--law-highlight-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">4.9/5</div>
          <div style="font-weight: 700; font-size: 1.1rem; margin: 12px 0 8px;">Rating Kepuasan</div>
          <div style="font-size: 0.95rem; opacity: 0.6;">Terbukti berkualitas</div>
        </div>
      </div>
    </section>

    <!-- MODULES SECTION -->
    <section class="section-block" style="padding-bottom: 120px;">
      <div class="section-header gv-reveal">
        <span class="fc-pill">Modul Unggulan</span>
        <h2 class="section-title">Kurikulum <span class="hero-highlight">Eksklusif</span></h2>
        <p class="section-subtitle">
          Pilihlah spesialisasi belajar Anda untuk mengakselerasi karir dan kemampuan mengajar di kelas dengan metode paling mutakhir.
        </p>
      </div>

      <div class="module-list">
        <div class="module-item gv-reveal delay-1">
          <div class="mod-icon">KM</div>
          <div>
            <div class="mod-title">Kurikulum Merdeka</div>
            <div class="mod-desc">Pemahaman mendalam mengenai filosofi dan pedoman aplikasi asesmen yang siap dipraktekkan langsung di kelas Anda.</div>
          </div>
        </div>
        <div class="module-item gv-reveal delay-2">
          <div class="mod-icon">TP</div>
          <div>
            <div class="mod-title">Teknologi Pedagogi</div>
            <div class="mod-desc">Belajar cara jitu mengintegrasikan AI dasar, metode <em>flipped classroom</em>, dan cara merancang materi pembelajaran super interaktif.</div>
          </div>
        </div>
        <div class="module-item gv-reveal delay-3">
          <div class="mod-icon">SK</div>
          <div>
            <div class="mod-title">Sertifikasi Kompetensi</div>
            <div class="mod-desc">Dapatkan bimbingan intensif tahap demi tahap (step-by-step) dan <em>try-out</em> lengkap untuk berhasil meraih sertifikasi nasional.</div>
          </div>
        </div>
      </div>
    </section>

  </main>
</div>

@endsection
