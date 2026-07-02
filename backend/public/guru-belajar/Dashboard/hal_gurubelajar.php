<!-- =====================
     GURU BELAJAR
===================== -->
<div id="pg-gurubelajar" class="page">
<style>
/* Theme adaptation for Guru Belajar page */
#pg-gurubelajar {
  --hero-bg: linear-gradient(135deg, var(--navy2) 0%, var(--navy) 100%);
  --accent-text: var(--primary-light);
  --cta-bg: linear-gradient(135deg, var(--purple-faint), var(--purple-dark));
  --cta-btn-bg: linear-gradient(135deg, var(--purple-dark), var(--purple-light));
}

[data-theme="light"] #pg-gurubelajar {
  --hero-bg: linear-gradient(135deg, #EEF2FF 0%, var(--bg) 100%);
  --accent-text: var(--primary);
  --cta-bg: linear-gradient(135deg, var(--primary), var(--primary-dark));
  --cta-btn-bg: linear-gradient(135deg, var(--secondary-dark), var(--primary));
}

#pg-gurubelajar .detail-hero {
  background: var(--hero-bg) !important;
}
#pg-gurubelajar .detail-title em {
  color: var(--accent-text) !important;
}
#pg-gurubelajar .detail-badge {
  color: var(--accent-text) !important;
  border-color: var(--accent-text) !important;
}
#pg-gurubelajar .btn-secondary {
  color: var(--accent-text) !important;
  border-color: var(--accent-text) !important;
}
#pg-gurubelajar .stat-num {
  color: var(--accent-text) !important;
}
#pg-gurubelajar .cta-banner {
  background: var(--cta-bg) !important;
}
#pg-gurubelajar .cta-banner .btn-primary {
  background: var(--cta-btn-bg) !important;
}
</style>

<nav class="detail-navbar">
  <div class="detail-nav-top">
    <div class="nav-logo" onclick="goH()" style="cursor:pointer"><img src="../../asset/img/logo guruverse FA.ai.png" alt="GV" style="height:30px;"><span>GURUVERSE<em>.ID</em></span></div>
    <div class="nav-links">
      <button class="nav-link" onclick="window.location.href='about.php'">Tentang Kami</button>
      <button class="nav-link" onclick="window.location.href='program.php'">Program</button>
      <button class="nav-link" onclick="window.location.href='testimoni.php'">Testimoni</button>
      <button class="nav-link" onclick="window.location.href='artikel.php'">Artikel</button>
      <!-- Dark/Light Mode Toggle -->
      <button class="theme-toggle-btn" onclick="toggleDarkMode()" title="Ganti Mode Tampilan" aria-label="Toggle Dark Mode" style="margin-right: 8px;">
        <span class="icon-moon">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </span>
        <span class="icon-sun">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </span>
      </button>
      <button class="nav-cta" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
    </div>
    <button class="nav-hamburger" onclick="toggleMenu4()" id="hamburger4"><span></span><span></span><span></span></button>
  </div>
  <div class="nav-mobile" id="navMobile4">
    <button class="nav-link" onclick="window.location.href='about.php'">Tentang Kami</button><button class="nav-link" onclick="window.location.href='program.php'">Program</button>
    <button class="nav-link" onclick="window.location.href='testimoni.php'">Testimoni</button><button class="nav-link" onclick="window.location.href='artikel.php'">Artikel</button>
    <button class="nav-cta" style="margin-top:8px;border-radius:10px" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
  </div>
  <div class="detail-breadcrumb">
    <button class="breadcrumb-back" onclick="goH()"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 2L3 6l5 4" stroke="#c4bdf0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Kembali</button>
    <span class="breadcrumb-trail"><span>Beranda</span><span class="sep">/</span><span>Partner</span><span class="sep">/</span><span class="current">Guru Belajar</span></span>
  </div>
</nav>

<section class="detail-hero">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 80% at 90% 20%,rgba(4,120,87,.1) 0%,transparent 60%);z-index:0"></div>
  <div class="detail-hero-inner">
    <div class="detail-hero-text">
      <span class="detail-badge" style="background:rgba(52,211,153,.1); border-color:rgba(52,211,153,.3)">PROGRAM</span>
      <h1 class="detail-title">Guru <em>Belajar</em></h1>
      <p class="detail-subtitle">Program pembelajaran mandiri untuk peningkatan kompetensi berkelanjutan</p>
      <div class="detail-btns">
        <button class="btn-secondary" style="border-color:rgba(5,150,105,.4)" onclick="window.location.href='../../register/learn-more-belajar.php'">Pelajari Lebih Lanjut</button>
      </div>
    </div>
    <div class="detail-img">
      <img src="../../asset/img/teachers-sertifikat.png" style="width:700px;"/>
    </div>
  </div>
</section>

<div class="stats">
  <div class="stats-inner">
    <div class="stat"><div class="stat-num">2M+</div><div class="stat-lbl">Peserta Terdaftar</div></div>
    <div class="stat"><div class="stat-num">200+</div><div class="stat-lbl">Mata Pelajaran</div></div>
    <div class="stat"><div class="stat-num">95%</div><div class="stat-lbl">Tingkat Penyelesaian</div></div>
    <div class="stat"><div class="stat-num">4.9/5</div><div class="stat-lbl">Rating Program</div></div>
  </div>
</div>

<div class="content-section alt">
  <div class="content-inner">
    <div class="sec-title">Program Unggulan</div>
    <div class="sec-desc">Rancangan pembelajaran terstruktur untuk guru yang terus bertumbuh</div>
    <div class="feat-grid">
      <div class="feat-card">
        <div class="fc-head"><div class="fc-icon" style="background:var(--purple-faint)"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1l2 4.5 5 .5-3.6 3.5 1 4.5L8 12 3.6 14l1-4.5L1 6l5-.5z" stroke="var(--primary-light)" stroke-width="1.2" stroke-linejoin="round"/></svg></div><div><div class="fc-name">Belajar Mandiri Terstruktur</div></div></div>
        <div class="fc-sub">Self-paced learning tanpa batas waktu</div>
        <div class="fc-desc">Akses 200+ mata pelajaran dengan kurikulum yang dirancang bersama pakar pendidikan Indonesia.</div>
      </div>
      <div class="feat-card alt">
        <div class="fc-head"><div class="fc-icon" style="background:var(--purple-faint)"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="6" stroke="var(--primary-light)" stroke-width="1.2"/><path d="M6 8l2 2 4-4" stroke="var(--primary-light)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><div class="fc-name">Sertifikasi Terverifikasi</div></div></div>
        <div class="fc-sub">Diakui secara profesional</div>
        <div class="fc-desc">Selesaikan program dan dapatkan sertifikat digital yang dapat dibagikan ke profil LinkedIn.</div>
      </div>
      <div class="feat-card wide">
        <div class="fc-head"><div class="fc-icon" style="background:var(--purple-faint)"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="3" width="14" height="10" rx="1.5" stroke="var(--primary-light)" stroke-width="1.2"/><path d="M5 7h6M5 9.5h4" stroke="var(--primary-light)" stroke-width="1.2" stroke-linecap="round"/></svg></div><div><div class="fc-name">Konten Berkualitas Tinggi</div></div></div>
        <div class="fc-sub">Dikurasi tim ahli & praktisi pendidikan</div>
        <div class="fc-desc">Materi video, infografis, dan latihan interaktif yang dirancang untuk pembelajaran maksimal guru Indonesia modern.</div>
        <div class="fc-tags"><span class="tag green">SD</span><span class="tag green">SMP</span><span class="tag green">SMA</span><span class="tag green">SMK</span><span class="tag">Semua Mapel</span></div>
      </div>
    </div>
  </div>
</div>

<div class="content-section alt">
  <div class="content-inner" style="max-width:1200px">
    <div style="text-align:center;margin-bottom:36px">
      <div class="sec-title">Cara Bergabung</div>
      <div class="sec-desc">3 langkah mudah untuk mulai belajar</div>
    </div>
    <div class="steps">
      <div class="step"><div class="step-num">1</div><div class="step-title">Daftar Akun</div><div class="step-desc">Buat akun Guruverse.ID gratis & lengkapi profil gurumu</div></div>
      <div class="step"><div class="step-num">2</div><div class="step-title">Pilih Program</div><div class="step-desc">Jelajahi 200+ mata pelajaran sesuai kebutuhan dan jenjangmu</div></div>
      <div class="step"><div class="step-num">3</div><div class="step-title">Belajar & Sertifikat</div><div class="step-desc">Selesaikan program dan dapatkan sertifikat digital resmi</div></div>
    </div>
  </div>
</div>

<div class="cta-banner">
  <div class="cta-inner">
    <div class="cta-title">Mulai belajar, tingkatkan kompetensi</div>
    <div class="cta-sub">Bergabung bersama 2 juta+ guru yang sudah merasakan manfaat Guru Belajar</div>
    <button class="btn-primary" onclick="window.location.href='../../register.php'">Mulai Program Gratis</button>
    <div class="cta-note">Akses gratis untuk 30 hari pertama</div>
  </div>
</div>
</div><!-- end pg-gurubelajar -->

