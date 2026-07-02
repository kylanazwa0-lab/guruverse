<!-- =====================
     GURU MENGAJAR
===================== -->
<div id="pg-gurumengajar" class="page">
<style>
/* Theme adaptation for Guru Mengajar page */
#pg-gurumengajar {
  --page-primary: var(--primary);
  --page-primary-light: var(--primary-light);
  --card-bg: var(--card);
  --card-text: var(--text);
  --card-text-muted: var(--text-muted);
  --card-text-dim: var(--text-muted);
  --step-text: var(--text);
  --icon-bg: rgba(124, 58, 237, 0.1);
  --icon-stroke: var(--purple-light);
  --glow-color: rgba(124, 58, 237, 0.15);
}

[data-theme="light"] #pg-gurumengajar {
  --page-primary: var(--primary);
  --page-primary-light: var(--primary-light);
  --card-bg: #ffffff;
  --card-text: var(--text);
  --card-text-muted: var(--text-muted);
  --card-text-dim: var(--text-muted);
  --step-text: var(--text);
  --icon-bg: rgba(9, 60, 93, 0.08);
  --icon-stroke: var(--primary);
  --glow-color: rgba(9, 60, 93, 0.12);
}

/* Apply variables locally */
#pg-gurumengajar .custom-badge-classroom {
  background: var(--icon-bg) !important;
  color: var(--page-primary-light) !important;
}
#pg-gurumengajar .custom-quote-svg {
  color: var(--page-primary-light) !important;
}
#pg-gurumengajar .custom-glow-effect {
  background: radial-gradient(circle, var(--glow-color) 0%, transparent 70%) !important;
}
#pg-gurumengajar .custom-stat-icon-box {
  background: var(--icon-bg) !important;
  width: 40px; 
  height: 40px; 
  border-radius: 10px; 
  display: flex; 
  align-items: center; 
  justify-content: center;
}
#pg-gurumengajar .custom-stat-icon-box svg {
  stroke: var(--icon-stroke) !important;
}
#pg-gurumengajar .custom-feat-card {
  background: var(--card-bg) !important;
  border: 1px solid var(--border) !important;
  padding: 24px;
  border-radius: 16px;
}
#pg-gurumengajar .custom-feat-card .fc-name {
  color: var(--card-text) !important;
}
#pg-gurumengajar .custom-feat-card .fc-desc {
  color: var(--card-text-muted) !important;
}
#pg-gurumengajar .custom-feat-card ul li {
  color: var(--card-text-dim) !important;
}
#pg-gurumengajar .custom-feat-card ul li svg {
  stroke: var(--icon-stroke) !important;
}
#pg-gurumengajar .custom-step-icon {
  background: var(--page-primary) !important;
  width: 56px; 
  height: 56px; 
  border-radius: 50%; 
  color: white; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  margin: 0 auto 16px; 
  box-shadow: 0 10px 15px -3px var(--glow-color) !important;
}
#pg-gurumengajar .custom-step-icon-alt {
  background: var(--page-primary-light) !important;
  width: 56px; 
  height: 56px; 
  border-radius: 50%; 
  color: white; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  margin: 0 auto 16px; 
  box-shadow: 0 10px 15px -3px var(--glow-color) !important;
}
#pg-gurumengajar .custom-step-title {
  color: var(--step-text) !important;
}
#pg-gurumengajar .custom-testi-title-main {
  color: var(--step-text) !important;
}
#pg-gurumengajar .custom-testi-card {
  background: var(--card-bg) !important;
  border: 1px solid var(--border) !important;
  padding: 32px;
  border-radius: 16px;
}
#pg-gurumengajar .custom-testi-card .quote-text {
  color: var(--card-text-muted) !important;
}
#pg-gurumengajar .custom-testi-card .author-name {
  color: var(--card-text) !important;
}
#pg-gurumengajar .custom-testi-card .author-school {
  color: var(--card-text-dim) !important;
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
    <button class="nav-hamburger" onclick="toggleMenu3()" id="hamburger3"><span></span><span></span><span></span></button>
  </div>
  <div class="nav-mobile" id="navMobile3">
    <button class="nav-link" onclick="window.location.href='about.php'">Tentang Kami</button><button class="nav-link" onclick="window.location.href='program.php'">Program</button>
    <button class="nav-link" onclick="window.location.href='testimoni.php'">Testimoni</button><button class="nav-link" onclick="window.location.href='artikel.php'">Artikel</button>
    <button class="nav-cta" style="margin-top:8px;border-radius:10px" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
  </div>
  <div class="detail-breadcrumb">
    <button class="breadcrumb-back" onclick="goH()"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 2L3 6l5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Kembali</button>
    <span class="breadcrumb-trail"><span>Beranda</span><span class="sep">/</span><span>Partner</span><span class="sep">/</span><span class="current">Guru Mengajar</span></span>
  </div>
</nav>

<!-- HERO -->
<section class="detail-hero">
  <div class="detail-hero-inner">
    <div class="detail-hero-text">
      <div style="margin-bottom: 16px;">
        <span class="detail-badge">PARTNER</span>
        <span class="detail-badge custom-badge-classroom" style="margin-left:10px;">CLASSROOM HUB</span>
      </div>
      <h1 class="detail-title">Guru <em>Mengajar</em></h1>
      <p class="detail-subtitle">Satu ekosistem cerdas untuk mengelola, melacak, dan menginspirasi pembelajaran yang bermakna.</p>
      
      <div class="detail-quote">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="custom-quote-svg" style="flex-shrink: 0; margin-top: 2px;"><path d="M3 21c3 0 7-1 7-8V5H3v8h4c0 5-4 8-4 8zM14 21c3 0 7-1 7-8V5h-7v8h4c0 5-4 8-4 8z" fill="currentColor"/></svg>
        <span>"Menghubungkan guru, data, dan inspirasi dalam satu dashboard masa depan."</span>
      </div>

      <div class="detail-btns">
        <button class="btn-primary" style="padding:14px 32px;" onclick="window.location.href='../../register.php'">
          Mulai Daftar
        </button>
        <button class="btn-secondary" style="display: flex; align-items: center; gap: 8px;" onclick="document.getElementById('fitur-utama').scrollIntoView({behavior: 'smooth'})">
          Pelajari Fitur
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3.5 5.25L7 8.75L10.5 5.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>
    <div class="detail-img">
      <div style="position: relative; padding: 20px;">
        <div class="custom-glow-effect" style="position: absolute; top: 10%; right: 10%; width: 300px; height: 300px; z-index: 0; filter: blur(40px);"></div>
        <img src="../../asset/img/hero_classroom_hub.png" alt="Classroom Hub" style="width: 100%; max-width: 550px; border-radius: 24px; position: relative; z-index: 1;">
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats">
  <div class="stats-inner">
    <div class="stat">
      <div style="display:flex;align-items:center;gap:12px;justify-content:center;">
        <div class="custom-stat-icon-box">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div style="text-align: left;">
          <div class="stat-num">500K+</div>
          <div class="stat-lbl">Komunitas Aktif</div>
        </div>
      </div>
    </div>
    <div class="stat">
      <div style="display:flex;align-items:center;gap:12px;justify-content:center;">
        <div class="custom-stat-icon-box">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div style="text-align: left;">
          <div class="stat-num">25K+</div>
          <div class="stat-lbl">Diskusi Terbentuk</div>
        </div>
      </div>
    </div>
    <div class="stat">
      <div style="display:flex;align-items:center;gap:12px;justify-content:center;">
        <div class="custom-stat-icon-box">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div style="text-align: left;">
          <div class="stat-num">1.2M+</div>
          <div class="stat-lbl">Materi Belajar</div>
        </div>
      </div>
    </div>
    <div class="stat">
      <div style="display:flex;align-items:center;gap:12px;justify-content:center;">
        <div class="custom-stat-icon-box">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div style="text-align: left;">
          <div class="stat-num">100%</div>
          <div class="stat-lbl">Partisipasi Aktif</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FITUR UTAMA -->
<div class="content-section" id="fitur-utama">
  <div class="content-inner">
    <div class="sec-title">Fitur Utama Guru Mengajar</div>
    <div class="sec-desc">Semua yang kamu butuhkan untuk mengajar lebih efektif dan berdampak</div>

    <div class="feat-grid" style="grid-template-columns: repeat(4, 1fr); margin-top: 48px;">
      <!-- Dashboard Personal -->
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Dashboard Personal</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Kelola semua aktivitas mengajar dalam satu dashboard terintegrasi.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Kelas & jadwal mengajar</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Rencana pembelajaran</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Penilaian & refleksi</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Analitik perkembangan kelas</li>
        </ul>
      </div>

      <!-- Gamifikasi -->
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary-light); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M6 9a6 6 0 1 0 12 0"/><path d="M12 15v6"/><path d="M7 21h10"/><path d="M12 3v3"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Gamifikasi</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Belajar & berkontribusi jadi lebih seru dengan sistem gamifikasi.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Poin & level pencapaian</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Badge & achievement</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Leaderboard guru inspiratif</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Reward menarik</li>
        </ul>
      </div>

      <!-- Impact Tracker -->
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Impact Tracker</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Pantau dampak pembelajaran terhadap murid & komunitas.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Tracking keterlibatan murid</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Capaian kompetensi</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Dampak ke komunitas</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Laporan otomatis</li>
        </ul>
      </div>

      <!-- Pelatihan Offline -->
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary-light); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Pelatihan Offline</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Tingkatkan kompetensimu melalui pelatihan tatap muka berkualitas.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Workshop praktik mengajar</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Pendampingan langsung</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Sertifikat resmi</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Jaringan & kolaborasi</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- ALUR -->
<div class="content-section alt" style="padding-bottom: 80px;">
  <div class="content-inner">
    <div class="sec-title">Alur Guru Mengajar</div>
    <div class="sec-desc">Dari perencanaan hingga berdampak nyata</div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 60px; max-width: 1000px; margin-left: auto; margin-right: auto; position: relative;">
      <!-- Steps -->
      <div style="flex: 1; text-align: center; position: relative;">
        <div class="custom-step-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        </div>
        <div class="custom-step-title" style="font-weight: 700; font-size: 0.95rem;">1. Rencanakan</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Buat rencana pembelajaran yang efektif</div>
      </div>

      <div style="color: var(--border); font-size: 1.5rem;">→</div>

      <div style="flex: 1; text-align: center;">
        <div class="custom-step-icon-alt">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div class="custom-step-title" style="font-weight: 700; font-size: 0.95rem;">2. Laksanakan</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Implementasikan dengan metode kreatif</div>
      </div>

      <div style="color: var(--border); font-size: 1.5rem;">→</div>

      <div style="flex: 1; text-align: center;">
        <div class="custom-step-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div class="custom-step-title" style="font-weight: 700; font-size: 0.95rem;">3. Libatkan</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Libatkan murid secara aktif</div>
      </div>

      <div style="color: var(--border); font-size: 1.5rem;">→</div>

      <div style="flex: 1; text-align: center;">
        <div class="custom-step-icon-alt">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M12 4v16"/><path d="M12 4L8 8"/><path d="M12 4L16 8"/></svg>
        </div>
        <div class="custom-step-title" style="font-weight: 700; font-size: 0.95rem;">4. Evaluasi</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Evaluasi & refleksi berkelanjutan</div>
      </div>

      <div style="color: var(--border); font-size: 1.5rem;">→</div>

      <div style="flex: 1; text-align: center;">
        <div class="custom-step-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <div class="custom-step-title" style="font-weight: 700; font-size: 0.95rem;">5. Berdampak</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Ciptakan dampak positif nyata</div>
      </div>
    </div>
  </div>
</div>

<!-- TESTIMONI -->
<div class="content-section">
  <div class="content-inner">
    <div style="text-align: center; margin-bottom: 48px;">
      <div class="custom-testi-title-main" style="font-size: 2rem; font-weight: 800; margin-bottom: 8px;">Guru Hebat, Dampak Nyata</div>
      <div style="color: var(--text-muted);">Kisah inspiratif dari guru yang sudah berdampak</div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
      <div class="custom-testi-card">
        <div class="quote-text" style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;">"Dashboard Guru Mengajar sangat membantu saya mengelola kelas dengan lebih terstruktur dan efisien."</div>
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #4361ee, #7b2ff7); display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; font-size:1rem; flex-shrink:0;">RS</div>
          <div>
            <div class="author-name" style="font-weight: 700; font-size: 0.9rem;">Rini Susanti</div>
            <div class="author-school" style="font-size: 0.8rem;">SDN 2 Bandung</div>
          </div>
        </div>
      </div>

      <div class="custom-testi-card">
        <div class="quote-text" style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;">"Pelatihan offline-nya sangat aplikatif, langsung bisa saya terapkan di kelas dan murid jadi lebih aktif."</div>
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #06d6a0, #00b4d8); display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; font-size:1rem; flex-shrink:0;">HW</div>
          <div>
            <div class="author-name" style="font-weight: 700; font-size: 0.9rem;">Hendra Wijaya</div>
            <div class="author-school" style="font-size: 0.8rem;">SMPN 3 Jakarta</div>
          </div>
        </div>
      </div>

      <div class="custom-testi-card">
        <div class="quote-text" style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;">"Melalui Impact Tracker, saya bisa melihat perkembangan murid saya secara nyata dan terukur."</div>
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #f8961e, #f3722c); display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; font-size:1rem; flex-shrink:0;">DN</div>
          <div>
            <div class="author-name" style="font-weight: 700; font-size: 0.9rem;">Dewi Nurhaliza</div>
            <div class="author-school" style="font-size: 0.8rem;">SMAN 1 Surabaya</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA BANNER -->
<div class="cta-banner cta-banner-gm" style="margin-top: 0; position: relative; overflow: hidden; padding: 48px 24px;">
  <!-- Background Image Overlay -->
  <div style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; opacity: 0.08; z-index: 0;">
    <img src="../../asset/img/community_teachers_muslim.png" alt="Community" style="width: 100%; height: 100%; object-fit: cover;">
  </div>
  <div class="cta-inner" style="position: relative; z-index: 1; max-width: 560px;">
    <div class="cta-title" style="font-size: clamp(20px, 3vw, 28px); margin-bottom: 8px;">Bergabung bersama 5.200+ guru</div>
    <div class="cta-sub" style="max-width: 600px; margin: 0 auto 20px; font-size: clamp(12px, 1.4vw, 14px);">Bersama kita bisa — saling menguatkan, berbagi ilmu, dan membangun pendidikan Indonesia</div>
    <button class="btn-primary" onclick="window.location.href='../../register.php'" style="background: #fff; color: var(--navy); font-weight: 700; padding: 10px 24px; border-radius: 12px; font-size: 0.9rem;">
      Gabung Komunitas Gratis 
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left: 6px; vertical-align: middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"/></svg>
    </button>
    <div style="display: flex; justify-content: center; gap: 20px; margin-top: 24px; color: var(--text-dim); font-size: 0.8rem; flex-wrap: wrap;">
      <span style="display: flex; align-items: center; gap: 6px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Gratis untuk semua guru</span>
      <span style="display: flex; align-items: center; gap: 6px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Komunitas aktif</span>
      <span style="display: flex; align-items: center; gap: 6px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Dari Sabang sampai Merauke</span>
    </div>
  </div>
</div>
</div><!-- end pg-gurumengajar -->

