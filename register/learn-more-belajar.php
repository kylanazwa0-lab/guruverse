<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<link rel="icon" type="image/png" href="../asset/img/logo guruverse FA.ai.png"/>
<title>Guru Belajar — Guruverse.id</title>
<?php
ob_start();
include '../guru-belajar/Dashboard/global_head.php';
$head = ob_get_clean();
$head = str_replace('../../asset/', '../asset/', $head);
echo $head;
?>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

<!-- Lawtrades CSS adapted -->
<style>
  /* Base & Typography */
  :root {
    --law-bg: #F5F8FA;
    --law-text: #092B40;
    --law-highlight: #093C5D;
    --law-card-bg: #ffffff;
    --law-border: #D2E3EB;
    --law-pill-bg: rgba(9, 60, 93, 0.08);
    --law-pill-border: rgba(9, 60, 93, 0.15);
    --law-pill-text: #093C5D;
  }

  [data-theme="dark"] {
    --law-bg: #0d0f1a;
    --law-text: #e2e8f0;
    --law-highlight: #38bdf8;
    --law-card-bg: #151828;
    --law-border: rgba(124, 58, 237, 0.2);
    --law-pill-bg: rgba(56, 189, 248, 0.1);
    --law-pill-border: rgba(56, 189, 248, 0.2);
    --law-pill-text: #38bdf8;
  }

  body {
    background-color: var(--law-bg) !important;
    color: var(--law-text) !important;
    font-family: 'Inter', sans-serif !important;
    overflow-x: hidden;
    margin: 0;
    padding: 0;
  }

  * { box-sizing: border-box; }

  /* Blob Gradient Background */
  .bg-blob {
    position: absolute; top: 0; right: 0; width: 800px; height: 800px;
    background: radial-gradient(circle, rgba(60,141,141,0.15) 0%, rgba(250,248,243,0) 70%);
    z-index: 0; pointer-events: none;
  }
  [data-theme="dark"] .bg-blob { background: radial-gradient(circle, rgba(79,209,197,0.15) 0%, rgba(15,17,26,0) 70%); }

  .law-container {
    max-width: 1400px; margin: 0 auto; padding: 0 5%; position: relative; z-index: 1;
  }

  /* Back Button */
  .btn-back-modern {
    display: inline-flex; align-items: center; gap: 8px; color: var(--law-text);
    text-decoration: none; font-weight: 500; font-size: 0.85rem;
    margin-top: 20px; margin-bottom: 20px; padding: 6px 14px;
    border: 1px solid var(--law-pill-border); border-radius: 30px; transition: all 0.2s;
  }
  .btn-back-modern:hover { background: var(--law-text); color: var(--law-bg); }

  /* Hero Section */
  .hero-section {
    display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: center; padding: 10px 0 40px;
  }
  .hero-title { font-size: clamp(2.2rem, 4vw, 3.5rem); font-weight: 500; line-height: 1.1; letter-spacing: -0.03em; margin-bottom: 24px; color: var(--law-text); }
  .hero-highlight { color: var(--law-highlight); position: relative; display: inline-block; }
  .hero-highlight::after { content: ''; position: absolute; bottom: 8px; left: 0; width: 100%; height: 4px; background-color: var(--law-highlight); border-radius: 4px; opacity: 0.4; }
  .hero-desc { font-size: 1rem; line-height: 1.6; color: var(--law-text); opacity: 0.8; max-width: 450px; margin-bottom: 24px;}
  
  .fc-pill { display: inline-block; padding: 4px 10px; border-radius: 20px; background: #e0e7ff; color: #3730a3; font-size: 0.75rem; font-weight: 600; margin-bottom: 12px; }
  [data-theme="dark"] .fc-pill { background: #3730a3; color: #e0e7ff; }

  /* Hero Right (Floating Cards) */
  .hero-visuals { position: relative; height: 350px; }
  .floating-card {
    position: absolute; background: var(--law-bg); border: 1px solid var(--law-border);
    border-radius: 16px; padding: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    display: flex; flex-direction: column; gap: 12px;
  }
  [data-theme="dark"] .floating-card { box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
  .fc-title { font-weight: 600; font-size: 0.9rem; }
  .dashed-lines { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none; }

  /* Main Sections */
  .section-block { padding: 32px 0; position: relative; }
  .section-block::before {
    content: ''; position: absolute; top: 0; left: 10%; width: 80%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--law-border), transparent); opacity: 0.1;
  }
  [data-theme="dark"] .section-block::before { background: linear-gradient(90deg, transparent, #ffffff, transparent); opacity: 0.05; }
  
  .section-header { margin-bottom: 30px; }
  .section-title { font-size: clamp(1.6rem, 2.5vw, 2.4rem); font-weight: 500; margin-bottom: 12px; letter-spacing: -0.02em; }
  .section-subtitle { font-size: 0.95rem; opacity: 0.8; max-width: 600px; line-height: 1.6; }

  /* Grid Layouts */
  .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 24px; }
  .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 24px; }
  
  .modern-card {
    background: var(--law-card-bg); border: 1px solid var(--law-border); border-radius: 16px; padding: 24px;
  }
  
  @media(max-width: 900px) {
    .hero-section { grid-template-columns: 1fr; text-align: center; }
    .hero-desc { margin: 0 auto; }
    .hero-visuals { display: none; }
  }

  @keyframes float-img {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
  }
</style>
</head>
<body>

<?php
ob_start();
include '../guru-belajar/Dashboard/global_header.php';
$header = ob_get_clean();
$header = str_replace('../../asset/', '../asset/', $header);
$header = str_replace('href="index.php"', 'href="../guru-belajar/Dashboard/index.php"', $header);
$header = str_replace("location.href='index.php'",     "location.href='../guru-belajar/Dashboard/index.php'",     $header);
$header = str_replace("location.href='about.php'",     "location.href='learn-more.php'",                          $header);
$header = str_replace("location.href='program.php'",   "location.href='../guru-belajar/Dashboard/program.php'",   $header);
$header = str_replace("location.href='testimoni.php'", "location.href='../guru-belajar/Dashboard/testimoni.php'", $header);
$header = str_replace("location.href='artikel.php'",   "location.href='../guru-belajar/Dashboard/artikel.php'",   $header);
echo $header;
?>

<div class="bg-blob"></div>

<main class="law-container">
  
  <a href="../guru-belajar/Dashboard/index.php" class="btn-back-modern">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Kembali
  </a>

  <!-- HERO SECTION -->
  <section class="hero-section">
    <div>
      <span class="fc-pill" style="background:#dbeafe; color:#1e40af;">Pilar Pertama</span>
      <h1 class="hero-title">
        Guru <br>
        <span class="hero-highlight">Belajar</span>
      </h1>
      <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px;">Mengapa Guru Belajar Penting?</h3>
      <p class="hero-desc">
        Guru Belajar adalah fondasi dari perjalanan seorang pendidik. Di sini, guru Indonesia diajak untuk terus bertumbuh, memperdalam kompetensi, dan menyesuaikan diri dengan perubahan zaman. Belajar bukan sekadar kewajiban, melainkan identitas seorang guru profesional.
      </p>
      <div style="display: flex; gap: 12px;">
        <a href="register.php" class="btn-back-modern" style="margin: 0; background: var(--law-text); color: var(--law-bg); border: none;">Daftar Sekarang</a>
        <a href="#program" class="btn-back-modern" style="margin: 0;">Lihat Program</a>
      </div>
    </div>
    
    <div class="hero-visuals">
      <svg class="dashed-lines" viewBox="0 0 500 500">
        <path d="M50,150 Q200,50 350,250 T450,450" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6,6" opacity="0.2"/>
        <path d="M100,400 Q250,300 400,100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6,6" opacity="0.2"/>
        <circle cx="50" cy="150" r="4" fill="currentColor" opacity="0.5"/>
        <circle cx="450" cy="450" r="4" fill="currentColor" opacity="0.5"/>
        <circle cx="400" cy="100" r="4" fill="currentColor" opacity="0.5"/>
      </svg>

      <div class="floating-card" style="top: 20px; right: 20px; width: 240px; z-index: 2;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
          <div class="fc-title">Sertifikat Resmi</div>
          <span class="fc-pill" style="background:#dcfce7; color:#166534; margin:0;">Valid</span>
        </div>
        <p style="font-size:0.85rem; opacity:0.8; margin:0;">Bukti pencapaian yang bisa meningkatkan portofolio dan angka kredit.</p>
      </div>

      <div style="position: absolute; bottom: 20px; left: 0px; width: 300px; z-index: 3; animation: float-img 6s ease-in-out infinite;">
        <img src="../asset/img/premium-teacher-certificate.png" alt="Sertifikat" style="width: 100%; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));">
      </div>
    </div>
  </section>

  <!-- PROGRAM SECTION -->
  <section id="program" class="section-block">
    <div class="section-header">
      <span class="fc-pill" style="background:#fce7f3; color:#9d174d;">Program Guru Belajar</span>
      <h2 class="section-title">Pembelajaran <span class="hero-highlight">Fleksibel & Terstruktur</span></h2>
      <p class="section-subtitle">
        Program ini dirancang sedemikian rupa sehingga guru bisa belajar kapan saja dan di mana saja sesuai dengan ritme masing-masing.
      </p>
    </div>

    <div class="feature-grid">
      <div class="modern-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: var(--law-highlight);">01. Kelas Online & Webinar</h3>
        <p style="font-size: 0.9rem; opacity: 0.8; line-height: 1.5;">Akses langsung ke materi terbaru dari pakar pendidikan, memfasilitasi interaksi real-time.</p>
      </div>
      <div class="modern-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: var(--law-highlight);">02. Modul Terstruktur</h3>
        <p style="font-size: 0.9rem; opacity: 0.8; line-height: 1.5;">Kurikulum berkualitas tinggi yang relevan dengan kebutuhan pengajaran masa kini.</p>
      </div>
      <div class="modern-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: var(--law-highlight);">03. Sertifikat Digital Resmi</h3>
        <p style="font-size: 0.9rem; opacity: 0.8; line-height: 1.5;">Tingkatkan portofolio Anda dengan kredensial yang divalidasi dan diakui secara nasional.</p>
      </div>
    </div>
  </section>

  <!-- STATS SECTION -->
  <section class="section-block">
    <div class="section-header" style="text-align: right;">
      <span class="fc-pill" style="background:#fef08a; color:#854d0e;">Dampak Nyata</span>
      <h2 class="section-title">Bukti Kualitas Pembelajaran <span class="hero-highlight">Guruverse</span></h2>
    </div>

    <div class="stat-grid">
      <div class="modern-card" style="text-align: center;">
        <div style="font-size: 2rem; font-weight: 800; color: var(--law-highlight);">2M+</div>
        <div style="font-weight: 600; margin: 4px 0;">Peserta Terdaftar</div>
        <div style="font-size: 0.8rem; opacity: 0.7;">Komunitas besar guru</div>
      </div>
      <div class="modern-card" style="text-align: center;">
        <div style="font-size: 2rem; font-weight: 800; color: var(--law-highlight);">200+</div>
        <div style="font-weight: 600; margin: 4px 0;">Mata Pelajaran</div>
        <div style="font-size: 0.8rem; opacity: 0.7;">Pilihan sesuai kebutuhan</div>
      </div>
      <div class="modern-card" style="text-align: center;">
        <div style="font-size: 2rem; font-weight: 800; color: var(--law-highlight);">95%</div>
        <div style="font-weight: 600; margin: 4px 0;">Penyelesaian</div>
        <div style="font-size: 0.8rem; opacity: 0.7;">Tuntas 100% modul</div>
      </div>
      <div class="modern-card" style="text-align: center;">
        <div style="font-size: 2rem; font-weight: 800; color: var(--law-highlight);">4.9/5</div>
        <div style="font-weight: 600; margin: 4px 0;">Rating Kepuasan</div>
        <div style="font-size: 0.8rem; opacity: 0.7;">Terbukti berkualitas</div>
      </div>
    </div>
  </section>

  <!-- MODULES SECTION -->
  <section class="section-block">
    <div class="section-header">
      <span class="fc-pill" style="background:#e0e7ff; color:#3730a3;">Modul Unggulan</span>
      <h2 class="section-title">Kurikulum <span class="hero-highlight">Dirancang Khusus</span></h2>
      <p class="section-subtitle">
        Pilihlah spesialisasi belajar Anda untuk mengakselerasi karir dan kemampuan mengajar di kelas.
      </p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px; margin-top: 24px;">
      <div style="display: flex; gap: 16px; align-items: center;">
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--law-highlight); opacity: 0.4; line-height: 1; width: 50px;">KM</div>
        <div>
          <div style="font-weight: 600; color: var(--law-text); font-size: 1rem; margin-bottom: 4px;">Kurikulum Merdeka</div>
          <div style="font-size: 0.85rem; opacity: 0.8; line-height: 1.4;">Pemahaman mendalam dan pedoman aplikasi yang siap dipraktekkan di kelas.</div>
        </div>
      </div>
      <div style="display: flex; gap: 16px; align-items: center;">
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--law-highlight); opacity: 0.4; line-height: 1; width: 50px;">TP</div>
        <div>
          <div style="font-weight: 600; color: var(--law-text); font-size: 1rem; margin-bottom: 4px;">Teknologi Pedagogi</div>
          <div style="font-size: 0.85rem; opacity: 0.8; line-height: 1.4;">Integrasi AI, metode flipped classroom, dan merancang pembelajaran interaktif.</div>
        </div>
      </div>
      <div style="display: flex; gap: 16px; align-items: center;">
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--law-highlight); opacity: 0.4; line-height: 1; width: 50px;">SK</div>
        <div>
          <div style="font-weight: 600; color: var(--law-text); font-size: 1rem; margin-bottom: 4px;">Sertifikasi Kompetensi</div>
          <div style="font-size: 0.85rem; opacity: 0.8; line-height: 1.4;">Bimbingan intensif tahap demi tahap untuk meraih sertifikasi nasional.</div>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include '../guru-belajar/Dashboard/global_footer.php'; ?>

<script>
  // Active state for navbar
  (function() {
    document.getElementById("nav-program").classList.add("active");
  })();
</script>
</body>
</html>
