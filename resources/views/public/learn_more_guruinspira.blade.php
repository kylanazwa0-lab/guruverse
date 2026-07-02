@extends('layouts.public')

@section('title', 'Apa itu Guru Inspira? | Guruverse.id')

@section('content')
<style>
  /* Base & Typography */
  :root {
    --law-bg: var(--bg);
    --law-text: var(--text);
    --law-highlight: var(--primary);
    --law-highlight-gradient: linear-gradient(135deg, var(--primary), var(--secondary));
    --law-card-bg: rgba(255, 255, 255, 0.7);
    --law-border: rgba(9, 60, 93, 0.1);
    --law-pill-bg: rgba(9, 60, 93, 0.08);
    --law-pill-border: rgba(9, 60, 93, 0.15);
    --law-pill-text: var(--primary);
  }

  [data-theme="dark"] {
    --law-card-bg: rgba(30, 41, 59, 0.5);
    --law-border: rgba(255, 255, 255, 0.1);
    --law-pill-bg: rgba(124, 58, 237, 0.1);
    --law-pill-border: rgba(124, 58, 237, 0.2);
    --law-highlight-gradient: linear-gradient(135deg, #a78bfa, #c084fc);
  }

  body {
    background-color: var(--law-bg) !important;
    color: var(--law-text) !important;
    font-family: 'Inter', sans-serif !important;
    overflow-x: hidden;
  }

  /* Animated Blob Gradient Backgrounds */
  .bg-blobs {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 0; pointer-events: none;
  }
  .blob-1 {
    position: absolute; top: -10%; right: -5%; width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(60,141,141,0.2) 0%, transparent 70%);
    border-radius: 50%; filter: blur(40px); animation: float-blob 20s ease-in-out infinite alternate;
  }
  .blob-2 {
    position: absolute; top: 40%; left: -10%; width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%);
    border-radius: 50%; filter: blur(40px); animation: float-blob 25s ease-in-out infinite alternate-reverse;
  }
  [data-theme="dark"] .blob-1 { background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%); }
  [data-theme="dark"] .blob-2 { background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%); }

  @keyframes float-blob {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(-30px, 50px) scale(1.1); }
  }

  .law-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 5%;
    position: relative;
    z-index: 1;
  }

  /* Back Button */
  .btn-back-modern {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--law-text);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.85rem;
    margin-top: 20px;
    margin-bottom: 20px;
    padding: 6px 14px;
    border: 1px solid var(--law-pill-border);
    border-radius: 30px;
    transition: all 0.2s;
  }
  .btn-back-modern:hover {
    background: var(--law-text);
    color: var(--law-bg);
  }

  /* Hero Section */
  .hero-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: center;
    padding: 10px 0 40px;
  }

  .hero-title {
    font-size: clamp(2.2rem, 4vw, 3.5rem);
    font-weight: 500;
    line-height: 1.1;
    letter-spacing: -0.03em;
    margin-bottom: 24px;
    color: var(--law-text);
  }

  .hero-highlight {
    background: var(--law-highlight-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    display: inline-block;
  }
  .hero-highlight::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--law-highlight-gradient);
    border-radius: 4px;
    opacity: 0.3;
  }

  .hero-desc {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--law-text);
    opacity: 0.8;
    max-width: 450px;
  }

  /* Hero Right (Floating Cards) */
  .hero-visuals {
    position: relative;
    height: 350px;
  }
  .floating-card {
    position: absolute;
    background: var(--law-card-bg);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid var(--law-border);
    border-radius: 20px;
    padding: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .floating-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.08);
    border-color: var(--law-highlight);
  }
  [data-theme="dark"] .floating-card {
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
  }
  [data-theme="dark"] .floating-card:hover {
    box-shadow: 0 30px 60px rgba(0,0,0,0.5);
  }
  
  .fc-1 {
    top: 20px;
    right: 20px;
    width: 220px;
    z-index: 2;
  }
  .fc-2 {
    bottom: 20px;
    left: 20px;
    width: 260px;
    z-index: 3;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 12px;
  }

  .fc-title { font-weight: 600; font-size: 0.9rem; }
  .fc-subtitle { font-size: 0.75rem; opacity: 0.6; }
  .fc-pill { 
    display: inline-block; 
    padding: 4px 10px; 
    border-radius: 20px; 
    background: #e0e7ff; 
    color: #3730a3; 
    font-size: 0.75rem; 
    font-weight: 600; 
  }
  [data-theme="dark"] .fc-pill { background: rgba(124,58,237,0.15); color: var(--text); }

  .fc-img-wrapper {
    width: 45px; height: 45px;
    border-radius: 50%;
    overflow: hidden;
    border: 1px solid var(--law-border);
    flex-shrink: 0;
  }
  .fc-img-wrapper img {
    width: 100%; height: 100%;
    object-fit: cover;
  }

  /* Dashed lines SVG */
  .dashed-lines {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    z-index: 1;
    pointer-events: none;
  }

  /* Main Sections */
  .section-block {
    padding: 32px 0;
    position: relative;
  }
  /* Faint elegant separator */
  .section-block::before {
    content: '';
    position: absolute;
    top: 0;
    left: 10%;
    width: 80%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--law-border), transparent);
    opacity: 0.1;
  }
  [data-theme="dark"] .section-block::before {
    background: linear-gradient(90deg, transparent, var(--border), transparent);
    opacity: 0.5;
  }

  .section-header {
    margin-bottom: 30px;
  }
  .section-title {
    font-size: clamp(1.6rem, 2.5vw, 2.4rem);
    font-weight: 500;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
  }
  .section-subtitle {
    font-size: 0.95rem;
    opacity: 0.8;
    max-width: 600px;
    line-height: 1.6;
  }

  /* Pills Row */
  .pills-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
  }
  .pill-item {
    padding: 8px 16px;
    border: 1px solid var(--law-pill-border);
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--law-pill-text);
  }

  /* Glass Card */
  .modern-glass-item {
    background: var(--law-card-bg); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
    border-radius: 24px; padding: 40px 32px; color: var(--law-text);
    box-shadow: 0 20px 40px rgba(0,0,0,0.02); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid var(--law-border);
  }
  [data-theme="dark"] .modern-glass-item { box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
  .modern-glass-item:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 30px 60px rgba(0,0,0,0.06); 
    border-color: var(--law-highlight);
  }
  [data-theme="dark"] .modern-glass-item:hover { box-shadow: 0 30px 60px rgba(0,0,0,0.4); }

  /* Big Card */
  .big-card {
    padding: 32px 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    position: relative;
    overflow: hidden;
  }
  
  .big-card-title {
    font-size: 1.8rem;
    font-weight: 500;
    margin-bottom: 16px;
    letter-spacing: -0.02em;
  }
  
  .big-card-text {
    font-size: 0.95rem;
    line-height: 1.6;
    opacity: 0.85;
    margin-bottom: 20px;
    text-align: justify;
  }

  .big-card-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .big-card-list li {
    margin-bottom: 12px;
    display: flex;
    gap: 10px;
    font-size: 0.95rem;
    line-height: 1.5;
    opacity: 0.85;
  }
  .big-card-list li::before {
    content: '→';
    color: var(--law-highlight);
    font-weight: bold;
  }

  .big-card-img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 2;
  }
  .big-card-img-container img {
    width: 100%;
    max-width: 250px;
    border-radius: 20px;
    border: 1px solid var(--law-border);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  /* Story Section */
  .story-card {
    padding: 32px 0;
    margin: 20px 0 0;
  }

  .story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
  }
  .filosofi-card {
    background: var(--law-card-bg);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid var(--law-border);
    padding: 20px 24px;
    border-radius: 16px;
    margin-bottom: 12px;
    transition: all 0.3s;
  }
  .filosofi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.05);
  }
  .filosofi-title {
    font-weight: 600;
    color: var(--law-highlight);
    font-size: 0.9rem;
    margin-bottom: 4px;
  }
  .filosofi-desc {
    font-size: 0.8rem;
    opacity: 0.8;
    line-height: 1.4;
  }

  @media(max-width: 900px) {
    .hero-section { grid-template-columns: 1fr; text-align: center; }
    .hero-desc { margin: 0 auto; }
    .hero-visuals { display: none; } /* Hide complex visuals on mobile for simplicity */
    .big-card { grid-template-columns: 1fr; padding: 24px; gap: 24px; }
    .story-card { padding: 24px; }
    .story-grid { grid-template-columns: 1fr; gap: 24px; }
  }
</style>

<div class="bg-blobs">
  <div class="blob-1"></div>
  <div class="blob-2"></div>
</div>

<main class="law-container">
  
  <a href="{{ route('guru-inspira') }}" class="btn-back-modern gv-reveal">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Kembali
  </a>

  <!-- HERO SECTION -->
  <section class="hero-section">
    <div class="gv-reveal">
      <h1 class="hero-title">
        Apa itu <br>
        <span class="hero-highlight">Guru Inspira?</span>
      </h1>
      <p class="hero-desc">
        Guru Inspira adalah pilar yang menekankan peran guru sebagai sumber inspirasi bagi murid, rekan sejawat, dan lingkungan sekitarnya. Seorang Guru Inspira tidak hanya mengajar, tetapi juga menyalakan semangat belajar, membangun karakter, dan menumbuhkan rasa percaya diri pada setiap individu.
      </p>
    </div>
    
    <div class="hero-visuals">
      <!-- Abstract decorative dashed lines -->
      <svg class="dashed-lines" viewBox="0 0 500 500">
        <path d="M50,150 Q200,50 350,250 T450,450" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6,6" opacity="0.2"/>
        <path d="M100,400 Q250,300 400,100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6,6" opacity="0.2"/>
        <circle cx="50" cy="150" r="4" fill="currentColor" opacity="0.5"/>
        <circle cx="450" cy="450" r="4" fill="currentColor" opacity="0.5"/>
        <circle cx="400" cy="100" r="4" fill="currentColor" opacity="0.5"/>
      </svg>

      <!-- Floating Card 1 -->
      <div class="floating-card fc-1">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
          <div>
            <div class="fc-title">Membangun Karakter</div>
            <div class="fc-subtitle">Guru Inspira</div>
          </div>
          <span class="fc-pill" style="background:#dcfce7; color:#166534;">Teladan</span>
        </div>
        <p style="font-size:0.85rem; opacity:0.8; margin:0;">Mendorong guru menjadi teladan yang menginspirasi melalui sikap, tindakan, dan karya.</p>
      </div>

      <!-- Floating Card 2 -->
      <div class="floating-card fc-2">
        <div class="fc-img-wrapper">
          <img src="{{ asset('asset/img/ki_hajar_dewantara.png') }}" alt="Ki Hajar">
        </div>
        <div>
          <div class="fc-title">Ki Hajar Dewantara</div>
          <div class="fc-subtitle">Tokoh Pendidikan</div>
          <span class="fc-pill" style="margin-top:6px; background:#fef3c7; color:#92400e;">Inspirasi</span>
        </div>
      </div>
    </div>
  </section>

  <!-- KARAKTERISTIK SECTION -->
  <section class="section-block">
    <div class="section-header gv-reveal" style="text-align: right;">
      <h2 class="section-title">
        Karakteristik <span class="hero-highlight">Utama</span>
      </h2>
      <p class="section-subtitle" style="margin-left: auto;">
        Pilar-pilar sifat yang membangun sosok Guru Inspira dalam kesehariannya mengajar dan berinteraksi.
      </p>
    </div>

    <div class="pills-row gv-reveal delay-1" style="justify-content: flex-end;">
      <div class="pill-item">Visioner</div>
      <div class="pill-item">Motivator</div>
      <div class="pill-item">Teladan</div>
      <div class="pill-item">Kolaboratif</div>
      <div class="pill-item">Kreatif</div>
    </div>
  </section>

  <!-- DAMPAK & TUJUAN SECTION -->
  <section class="section-block">
    <!-- Big Card: Dampak & Tujuan -->
    <div class="big-card gv-reveal">
      <div style="position:relative; z-index:1;">
        <h3 class="big-card-title">Tujuan & Dampak</h3>
        <p class="big-card-text">
          Karena pendidikan bukan hanya soal transfer ilmu, tetapi juga tentang membentuk manusia yang berkarakter, berdaya juang, dan siap menghadapi tantangan masa depan. Guru Inspira menjadi katalisator perubahan yang membawa energi positif ke dalam proses belajar mengajar.
        </p>
      </div>

      <div style="position: relative; height: 100%; min-height: 350px;">
        <!-- Dashed lines -->
        <svg class="dashed-lines" viewBox="0 0 500 400">
          <path d="M-50,200 Q150,50 300,150 T450,300" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6,6" opacity="0.2"/>
          <path d="M50,350 Q250,250 400,100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6,6" opacity="0.2"/>
          <circle cx="300" cy="150" r="4" fill="currentColor" opacity="0.5"/>
          <circle cx="450" cy="300" r="4" fill="currentColor" opacity="0.5"/>
          <circle cx="400" cy="100" r="4" fill="currentColor" opacity="0.5"/>
        </svg>

        <!-- Floating Card 1 -->
        <div class="floating-card" style="top: 0; right: 10px; width: 220px; z-index: 2;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div class="fc-title">Potensi Murid</div>
            <span class="fc-pill" style="background:#dbeafe; color:#1e40af;">Fokus</span>
          </div>
          <p style="font-size:0.8rem; opacity:0.8; margin:8px 0 0; line-height: 1.4;">Membantu murid menemukan potensi diri dan berani bermimpi besar.</p>
        </div>

        <!-- Floating Card 2 -->
        <div class="floating-card" style="top: 130px; left: -20px; width: 220px; z-index: 3;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div class="fc-title">Lingkungan Positif</div>
            <span class="fc-pill" style="background:#fef08a; color:#854d0e;">Suasana</span>
          </div>
          <p style="font-size:0.8rem; opacity:0.8; margin:8px 0 0; line-height: 1.4;">Menciptakan area belajar yang penuh motivasi dan berdaya guna.</p>
        </div>

        <!-- Floating Card 3 -->
        <div class="floating-card" style="bottom: 20px; right: 20px; width: 240px; z-index: 4; display:flex; gap:12px; align-items:center;">
          <div class="fc-img-wrapper" style="width: 40px; height: 40px;">
            <img src="{{ asset('asset/img/community_teachers_muslim (2).png') }}" alt="Komunitas">
          </div>
          <div>
            <div class="fc-title">Sinergi & Komunitas</div>
            <p style="font-size:0.75rem; opacity:0.8; margin:4px 0 0; line-height: 1.3;">Budaya berbagi yang saling menguatkan antar guru.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- STORY SECTION -->
  <section class="section-block">
    <div class="story-card modern-glass-item gv-reveal">
      <div class="section-header" style="text-align: left; border-bottom: 1px solid var(--law-border); padding-bottom: 20px; margin-bottom: 30px;">
        <div style="font-size: 1.1rem; font-weight: 600; color: var(--law-highlight); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Kisah Guru Inspira</div>
        <h2 class="section-title" style="margin: 0; font-size: clamp(2rem, 3vw, 2.8rem);"><span class="hero-highlight">Ki Hajar Dewantara</span></h2>
      </div>

      <div class="story-grid">
        <!-- Left Column: Narrative -->
        <div class="gv-reveal delay-1">
          <div style="display:flex; align-items:center; gap: 16px; margin-bottom: 24px;">
            <img src="{{ asset('asset/img/ki_hajar_dewantara.png') }}" alt="Ki Hajar Dewantara" style="width: 80px; height: 80px; border-radius: 50%; border: 1px solid var(--law-border); box-shadow: 0 10px 20px rgba(0,0,0,0.1); object-fit: cover;">
            <div>
              <h3 style="font-size: 1.1rem; font-weight: 600; margin:0 0 6px;">Tokoh Pendidikan</h3>
              <span class="fc-pill" style="background:#fef08a; color:#854d0e;">Taman Siswa, 1922</span>
            </div>
          </div>
          
          <p class="big-card-text" style="margin-bottom: 12px;">
            Bayangkan seorang anak muda bernama Ki Hajar Dewantara. Di masa penjajahan, ketika akses pendidikan hanya terbatas untuk kalangan tertentu, beliau berani bermimpi besar: pendidikan harus bisa dinikmati oleh semua anak bangsa.
          </p>
          <p class="big-card-text">
            Dengan semangat itu, Ki Hajar mendirikan Taman Siswa. Sekolah ini bukan sekadar tempat belajar, tetapi wadah untuk menumbuhkan rasa percaya diri, keberanian, dan cinta tanah air. Murid-murid Taman Siswa akhirnya tumbuh menjadi generasi yang berani bersuara dan berjuang untuk bangsa.
          </p>
        </div>

        <!-- Right Column: Philosophy -->
        <div class="gv-reveal delay-2">
          <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0 0 24px;">Tiga Filosofi Pendidikan</h3>
          
          <div style="display: flex; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
            <div style="font-size: 2.2rem; font-weight: 800; color: var(--law-highlight); opacity: 0.4; line-height: 1;">01</div>
            <div>
              <div style="font-weight: 600; color: var(--law-text); font-size: 0.95rem; margin-bottom: 4px;">Ing ngarso sung tulodo</div>
              <div style="font-size: 0.8rem; opacity: 0.8; line-height: 1.4;">Di depan memberi teladan dan inspirasi positif.</div>
            </div>
          </div>

          <div style="display: flex; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
            <div style="font-size: 2.2rem; font-weight: 800; color: var(--law-highlight); opacity: 0.4; line-height: 1;">02</div>
            <div>
              <div style="font-weight: 600; color: var(--law-text); font-size: 0.95rem; margin-bottom: 4px;">Ing madyo mangun karso</div>
              <div style="font-size: 0.8rem; opacity: 0.8; line-height: 1.4;">Di tengah membangun semangat dan kemauan.</div>
            </div>
          </div>

          <div style="display: flex; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
            <div style="font-size: 2.2rem; font-weight: 800; color: var(--law-highlight); opacity: 0.4; line-height: 1;">03</div>
            <div>
              <div style="font-weight: 600; color: var(--law-text); font-size: 0.95rem; margin-bottom: 4px;">Tut wuri handayani</div>
              <div style="font-size: 0.8rem; opacity: 0.8; line-height: 1.4;">Di belakang memberi dorongan dan arahan.</div>
            </div>
          </div>

          <p style="font-size:0.85rem; opacity:0.8; margin-top:16px; padding-left: 12px; border-left: 2px solid var(--law-highlight); line-height: 1.5;">
            Ketiga semboyan ini mencerminkan esensi seorang Guru Inspira: mengajar dengan hati. Dampaknya, guru lain terinspirasi dan pendidikan menjadi gerakan sosial yang mengubah wajah Indonesia.
          </p>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
