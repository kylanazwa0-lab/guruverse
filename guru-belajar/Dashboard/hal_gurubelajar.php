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

<div class="detail-breadcrumb">
  <button class="breadcrumb-back" onclick="goH()"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 2L3 6l5 4" stroke="#c4bdf0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Kembali</button>
  <span class="breadcrumb-trail"><span>Beranda</span><span class="sep">/</span><span>Partner</span><span class="sep">/</span><span class="current">Guru Belajar</span></span>
</div>

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

