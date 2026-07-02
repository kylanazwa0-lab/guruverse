<!DOCTYPE html>
<html lang="id">
<head>
<title>Tentang Kami — Guruverse.ID</title>
<meta name="description" content="Guruverse.ID adalah manifestasi dari ekosistem yang dibangun oleh ACF Eduhub. Ruang semesta peningkatan kompetensi guru Indonesia."/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<?php include 'global_head.php'; ?>
<style>
html,body{font-family:'Inter',sans-serif;}

/* ===== HERO ===== */
.about-hero{
  position:relative;
  min-height:400px;
  display:flex;align-items:center;justify-content:center;
  text-align:center;
  padding:80px 5% 60px;
  background:linear-gradient(135deg,var(--navy) 0%,#161245 100%);
  overflow:hidden;
  color:#fff;
}
.hero-content{position:relative;z-index:1;max-width:720px;}
.hero-badge{
  display:inline-block;
  background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.4);
  color:#fff;font-size:11px;font-weight:700;padding:5px 16px;
  border-radius:20px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:24px;
}
.hero-title{font-size:clamp(28px, 4vw, 44px);font-weight:900;line-height:1.1;margin-bottom:20px;color:#fff;letter-spacing:-0.03em;}
.hero-title em{color:var(--purple-light);font-style:normal;}
.hero-quote{
  font-size:0.95rem;color:rgba(255,255,255,.85);line-height:1.8;max-width:560px;margin:0 auto;
  font-style:italic;
}

/* ===== STORY SECTION ===== */
.story-container{
  background:var(--bg-slate);
  border-radius:48px;
  padding:80px 5%;
  margin:40px 2% 80px;
  border:1px solid var(--border);
}
.story-inner{max-width:1100px;margin:0 auto;}
.section-badge{
  font-size:11px;color:var(--purple);font-weight:700;
  letter-spacing:1.5px;text-transform:uppercase;margin-bottom:16px;
}
.section-title{
  font-size:clamp(22px, 3vw, 32px);font-weight:800;
  line-height:1.2;margin-bottom:20px;color:var(--navy);
}
.section-title em{color:var(--purple);font-style:normal;}
.story-grid{
  display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;
}
.story-text p{
  color:#475569;font-size:0.9rem;line-height:1.8;margin-bottom:18px;
}
.visual-card{
  background:#fff;
  border:1px solid var(--border);
  border-radius:24px;padding:32px;
  box-shadow:0 20px 40px -10px rgba(10,7,24,0.05);
}
.visual-title{font-size:1.1rem;font-weight:800;color:var(--navy);margin-bottom:10px;}
.visual-desc{color:#64748b;font-size:0.85rem;line-height:1.7;}

/* ===== PILLARS ===== */
.pillars-section{padding:80px 5%;}
.pillars-grid{
  display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:24px;
  margin-top:40px;
}
.pillar-card{
  background:#fff;
  border:1px solid var(--border);
  border-radius:24px;padding:32px;
  transition:all .3s ease;
}
.pillar-card:hover{
  transform:translateY(-8px);
  border-color:var(--purple);
  box-shadow:0 20px 40px -10px rgba(10,7,24,0.08);
}
.pillar-name{font-size:1.1rem;font-weight:800;color:var(--navy);margin-bottom:12px;}
.pillar-desc{color:#64748b;font-size:0.85rem;line-height:1.7;}

@media(max-width:900px){
  .story-grid{grid-template-columns:1fr; gap:40px;}
  .story-container{border-radius:32px;}
}
</style>
</head>
<body>

<?php include 'global_header.php'; ?>

<section class="about-hero">
  <div class="hero-content">
    <span class="hero-badge">Tentang Kami</span>
    <h1 class="hero-title">Ruang Semesta untuk<br/><em>Guru Indonesia</em></h1>
    <p class="hero-quote">
      "Di setiap peradaban besar, selalu ada peran guru yang bekerja dalam sunyi… Menanam harapan, membentuk masa depan."
    </p>
  </div>
</section>

<div class="story-container">
  <div class="story-inner">
    <span class="section-badge">Cerita Kami</span>
    <h2 class="section-title">Guruverse.ID bukan<br/>sekadar <em>nama</em></h2>
    <div class="story-grid">
      <div class="story-text">
        <p>
          Guruverse.ID adalah <strong>manifestasi dari ekosistem yang dibangun oleh ACF Eduhub</strong>.
          Sebuah ruang semesta peningkatan kompetensi guru.
        </p>
        <p>
          Kami menghadirkan <strong>Learning & Teaching Management System (LTMS)</strong> untuk guru —
          modul, pelatihan, dan komunitas yang membantu guru Indonesia menjadi lebih kompeten.
        </p>
      </div>
      <div class="visual-card">
        <h3 class="visual-title">ACF Eduhub</h3>
        <p class="visual-desc">
          Ekosistem pendidikan yang telah melayani ribuan guru Indonesia dengan
          platform, konten, dan komunitas berkualitas tinggi.
        </p>
      </div>
    </div>
  </div>
</div>

<section class="pillars-section">
  <div style="text-align:center; max-width:600px; margin:0 auto;">
    <span class="section-badge">Tiga Pilar Utama</span>
    <h2 class="section-title">Ekosistem <em>Terpadu</em> untuk Guru</h2>
  </div>
  <div class="pillars-grid">
    <div class="pillar-card">
      <h3 class="pillar-name">Guru Belajar</h3>
      <p class="pillar-desc">Akses Kelas Online, Webinar eksklusif, dan raih Sertifikat Digital resmi untuk menunjang karier profesional.</p>
    </div>
    <div class="pillar-card">
      <h3 class="pillar-name">Guru Mengajar</h3>
      <p class="pillar-desc">Melalui Dashboard Personal, Gamifikasi, Impact Tracker, dan Pelatihan Offline yang berdampak.</p>
    </div>
    <div class="pillar-card">
      <h3 class="pillar-name">Guru Inspira</h3>
      <p class="pillar-desc">Wadah Forum Diskusi, Kolaborasi Proyek lintas sekolah, serta kumpulan Cerita Inspiratif.</p>
    </div>
  </div>
</section>

<?php include 'global_footer.php'; ?>

</body>
</html>
