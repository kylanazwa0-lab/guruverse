<!-- =====================
     GURU INSPIRA
===================== -->

<div id="pg-guruinspira" class="page">
<style>
/* Theme adaptation for Guru Inspira page */
#pg-guruinspira {
  --accent-text: #648db3;
  --icon-bg: #1e3a6e;
  --box-bg: #1a1060;
  --btn-primary-bg: #1d4ed8;
  --step-num-bg-1: linear-gradient(135deg,#2a5298,#648db3);
  --step-num-bg-2: linear-gradient(135deg,#1e7a50,#2ebd80);
  --step-num-bg-3: linear-gradient(135deg,#8a2be2,#648db3);
  --cta-bg: linear-gradient(135deg,#0f0c2e,#1e3a6e);
  --cta-btn-bg: linear-gradient(135deg,#2a5298,#648db3);
}

[data-theme="light"] #pg-guruinspira {
  --accent-text: var(--primary);
  --icon-bg: rgba(9, 60, 93, 0.08);
  --box-bg: rgba(9, 60, 93, 0.04);
  --btn-primary-bg: var(--primary);
  --step-num-bg-1: linear-gradient(135deg, var(--primary), var(--primary-light));
  --step-num-bg-2: linear-gradient(135deg, var(--secondary-dark), var(--primary-light));
  --step-num-bg-3: linear-gradient(135deg, var(--primary), var(--secondary));
  --cta-bg: linear-gradient(135deg, var(--primary), var(--primary-dark));
  --cta-btn-bg: linear-gradient(135deg, var(--secondary-dark), var(--primary));
}

#pg-guruinspira .detail-quote svg path {
  stroke: var(--accent-text) !important;
}
#pg-guruinspira .stat-num {
  color: var(--accent-text) !important;
}
#pg-guruinspira .feat-card .fc-icon {
  background: var(--icon-bg) !important;
}
#pg-guruinspira .feat-card .fc-icon svg {
  stroke: var(--accent-text) !important;
}
#pg-guruinspira .feat-card .fc-icon svg path {
  stroke: var(--accent-text) !important;
}
#pg-guruinspira .feature-img-box {
  background: var(--box-bg) !important;
}
#pg-guruinspira .step-num-1 {
  background: var(--step-num-bg-1) !important;
}
#pg-guruinspira .step-num-2 {
  background: var(--step-num-bg-2) !important;
}
#pg-guruinspira .step-num-3 {
  background: var(--step-num-bg-3) !important;
}
#pg-guruinspira .step-box {
  background: var(--box-bg) !important;
}
#pg-guruinspira .cta-banner {
  background: var(--cta-bg) !important;
}
#pg-guruinspira .cta-banner .btn-primary {
  background: var(--cta-btn-bg) !important;
}
#pg-guruinspira .hero-btn-primary {
  background: var(--btn-primary-bg) !important;
}

/* Guru Inspira step-arrow */
#pg-guruinspira .step-arrow {
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:1.8rem;
  color:#648db3;
  opacity:.6;
  padding:0 4px;
}
#pg-guruinspira .steps {
  display:grid;
  grid-template-columns: 1fr auto 1fr auto 1fr;
  gap:8px;
  align-items:start;
}
@media(max-width:768px){
  #pg-guruinspira .steps { grid-template-columns:1fr; gap:16px; }
  #pg-guruinspira .step-arrow { display:none; }
  #pg-guruinspira .feat-grid { grid-template-columns:1fr !important; }
  #pg-guruinspira [style*="grid-template-columns:repeat(3"] { grid-template-columns:1fr !important; }
}
</style>

<nav class="detail-navbar">
  <div class="detail-nav-top">
    <div class="nav-logo" onclick="goH()" style="cursor:pointer"><img src="../../asset/img/FA Logo Guruverse.ID - main.png" alt="GV" style="height:32px;"></div>
    <div class="nav-links">
      <button class="nav-link" onclick="window.location.href='about.php'">Tentang Kami</button>
      <button class="nav-link">Program</button>
      <button class="nav-link">Testimoni</button>
      <button class="nav-link">Artikel</button>
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
    <button class="nav-hamburger" onclick="toggleMenu2()" id="hamburger2">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="nav-mobile" id="navMobile2">
    <button class="nav-link" onclick="window.location.href='about.php'">Tentang Kami</button>
    <button class="nav-link">Program</button>
    <button class="nav-link">Testimoni</button>
    <button class="nav-link">Artikel</button>
    <button class="nav-cta" style="margin-top:8px;border-radius:10px" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
  </div>
  <div class="detail-breadcrumb">
    <button class="breadcrumb-back" onclick="goH()">
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 2L3 6l5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Kembali
    </button>
    <span class="breadcrumb-trail">
      <span>Beranda</span><span class="sep">/</span>
      <span>Partner</span><span class="sep">/</span>
      <span class="current">Guru Inspira</span>
    </span>
  </div>
</nav>

<!-- HERO -->
<section class="detail-hero">
  <div class="detail-hero-inner">
    <div class="detail-hero-text">
      <span class="detail-badge">PROGRAM</span>
      <h1 class="detail-title">Guru <em>Inspira</em></h1>
      <p class="detail-subtitle">Jejaring inspirasi dan komunitas guru untuk saling menguatkan, berbagi semangat, dan berkontribusi nyata.</p>
      <div class="detail-quote">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="flex-shrink:0;margin-top:2px"><path d="M3 10h4V6H3v4c0 2.2 1.8 4 4 4M12 10h4V6h-4v4c0 2.2 1.8 4 4 4" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span>"Guru yang saling menguatkan dan berbagi semangat untuk pendidikan Indonesia."</span>
      </div>
      <div class="detail-btns">
        <button class="btn-primary hero-btn-primary" onclick="window.location.href='../../register.php'" style="border:none;border-radius:12px;padding:13px 28px;color:#fff;font-weight:700;font-size:14px;cursor:pointer;font-family:inherit;">Bergabung Sekarang</button>
        <button class="btn-secondary" style="border-radius:12px;padding:12px 24px;" onclick="window.location.href='../../register/learn-more.php'">Pelajari Lebih Lanjut</button>
      </div>
    </div>
    <div class="detail-img">
      <img src="../../asset/img/hero-teachers.png" alt="Guru Inspira">
    </div>
  </div>
</section>


<!-- STATS -->
<div class="stats">
  <div class="stats-inner">
    <div class="stat">
      <div style="display:flex;align-items:center;gap:8px;justify-content:center;margin-bottom:4px">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><circle cx="8" cy="7" r="3" stroke="#648db3" stroke-width="1.5"/><circle cx="14" cy="7" r="3" stroke="#648db3" stroke-width="1.5"/><path d="M2 19c0-3.3 2.7-6 6-6h6c3.3 0 6 2.7 6 6" stroke="#648db3" stroke-width="1.5" stroke-linecap="round"/></svg>
        <div class="stat-num">2M+</div>
      </div>
      <div class="stat-lbl">Peserta Terdaftar</div>
    </div>
    <div class="stat">
      <div style="display:flex;align-items:center;gap:8px;justify-content:center;margin-bottom:4px">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect x="3" y="3" width="16" height="16" rx="2" stroke="#648db3" stroke-width="1.5"/><path d="M7 8h8M7 12h6M7 16h4" stroke="#648db3" stroke-width="1.4" stroke-linecap="round"/></svg>
        <div class="stat-num">200+</div>
      </div>
      <div class="stat-lbl">Mata Pelajaran</div>
    </div>
    <div class="stat">
      <div style="display:flex;align-items:center;gap:8px;justify-content:center;margin-bottom:4px">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><circle cx="11" cy="11" r="8" stroke="#648db3" stroke-width="1.5"/><path d="M11 3v8l5 3" stroke="#648db3" stroke-width="1.4" stroke-linecap="round"/></svg>
        <div class="stat-num">95%</div>
      </div>
      <div class="stat-lbl">Tingkat Penyelesaian</div>
    </div>
    <div class="stat">
      <div style="display:flex;align-items:center;gap:8px;justify-content:center;margin-bottom:4px">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><path d="M11 2l2.5 5.5L19 8.5l-4 3.9 1 5.5L11 15l-5 2.9 1-5.5-4-3.9 5.5-.9z" stroke="#648db3" stroke-width="1.5" stroke-linejoin="round"/></svg>
        <div class="stat-num">4.9/5</div>
      </div>
      <div class="stat-lbl">Rating Program</div>
    </div>
  </div>
</div>

<!-- FOKUS UTAMA -->
<div class="content-section alt">
  <div class="content-inner">
    <div class="sec-title">Fokus Utama Guru Inspira</div>
    <div class="sec-desc">Jejaring, kolaborasi, dan inspirasi untuk guru Indonesia</div>

    <!-- Feature image grid -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:40px">
      <div class="feature-img-box" style="border-radius:14px;overflow:hidden;height:200px;">
        <img src="../../asset/img/feature_kelas_online.png" alt="Forum Diskusi" style="width:100%;height:100%;object-fit:cover;opacity:.9">
      </div>
      <div class="feature-img-box" style="border-radius:14px;overflow:hidden;height:200px;">
        <img src="../../asset/img/community_teachers_muslim.png" alt="Kolaborasi Proyek" style="width:100%;height:100%;object-fit:cover;opacity:.9">
      </div>
      <div class="feature-img-box" style="border-radius:14px;overflow:hidden;height:200px;">
        <img src="../../asset/img/feature_sertifikat.png" alt="Cerita Inspiratif" style="width:100%;height:100%;object-fit:cover;opacity:.9">
      </div>
    </div>

    <!-- Feature cards -->
    <div class="feat-grid" style="grid-template-columns:repeat(3,1fr)">
      <!-- Forum Diskusi -->
      <div class="feat-card">
        <div class="fc-head">
          <div class="fc-icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="2" width="10" height="8" rx="1.5" stroke-width="1.2"/><path d="M3 13l2-3" stroke-width="1.2" stroke-linecap="round"/><rect x="7" y="6" width="8" height="6" rx="1.5" stroke-width="1.2"/></svg>
          </div>
          <div><div class="fc-name">Forum Diskusi</div></div>
        </div>
        <div class="fc-desc">Ruang diskusi aktif untuk bertanya, berbagi, dan menemukan solusi pembelajaran nyata.</div>
        <ul class="fc-list">
          <li>Diskusi ribuan topik setiap hari</li>
          <li>Tanya jawab dengan guru ahli</li>
          <li>Berbagi praktik baik pembelajaran</li>
        </ul>
      </div>

      <!-- Kolaborasi Proyek -->
      <div class="feat-card alt">
        <div class="fc-head">
          <div class="fc-icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="5" cy="6" r="2.5" stroke-width="1.2"/><circle cx="11" cy="6" r="2.5" stroke-width="1.2"/><path d="M2 13c0-2.2 1.8-4 4-4M9 13c0-2.2 1.8-4 4-4" stroke-width="1.2" stroke-linecap="round"/></svg>
          </div>
          <div><div class="fc-name">Kolaborasi Proyek</div></div>
        </div>
        <div class="fc-desc">Berkolaborasi dalam proyek pembelajaran yang inovatif dan berdampak nyata.</div>
        <ul class="fc-list">
          <li>Bangun proyek bersama guru lain</li>
          <li>Bagikan ide dan sumber belajar</li>
          <li>Hasil proyek bermanfaat untuk murid</li>
        </ul>
      </div>

      <!-- Cerita Inspiratif -->
      <div class="feat-card">
        <div class="fc-head">
          <div class="fc-icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1l2 4.5 5 .5-3.6 3.5 1 4.5L8 12 3.6 14l1-4.5L1 6l5-.5z" stroke-width="1.2" stroke-linejoin="round"/></svg>
          </div>
          <div><div class="fc-name">Cerita Inspiratif</div></div>
        </div>
        <div class="fc-desc">Baca dan bagikan kisah inspiratif dari guru yang penuh semangat dan dedikasi.</div>
        <ul class="fc-list">
          <li>Kisah nyata dari lapangan</li>
          <li>Motivasi dan refleksi mengajar</li>
          <li>Inspirasi untuk terus berkembang</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- CARA BERGABUNG -->
<div class="content-section alt">
  <div class="content-inner" style="max-width:1200px">
    <div style="text-align:center;margin-bottom:36px">
      <div class="sec-title">Cara Bergabung</div>
      <div class="sec-desc">3 langkah mudah untuk terhubung dan berbagi inspirasi</div>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-num step-num-1">1</div>
        <div class="step-title">Daftar Akun</div>
        <div class="step-desc">Buat akun Guruverse.ID gratis dan lengkapi profil gurumu.</div>
        <div class="step-box" style="margin-top:16px;border-radius:12px;overflow:hidden;height:80px;display:flex;align-items:center;justify-content:center">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="18" r="8" stroke="#648db3" stroke-width="2"/><path d="M10 42c0-7.7 6.3-14 14-14s14 6.3 14 14" stroke="#648db3" stroke-width="2" stroke-linecap="round"/><path d="M32 12l2 2 5-5" stroke="#648db3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
      </div>
      <div class="step-arrow">→</div>
      <div class="step">
        <div class="step-num step-num-2">2</div>
        <div class="step-title">Jelajahi Komunitas</div>
        <div class="step-desc">Temukan forum diskusi, proyek kolaborasi, dan cerita inspiratif dari guru lainnya.</div>
        <div class="step-box" style="margin-top:16px;border-radius:12px;overflow:hidden;height:80px;display:flex;align-items:center;justify-content:center">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="18" cy="20" r="7" stroke="#648db3" stroke-width="2"/><circle cx="30" cy="20" r="7" stroke="#648db3" stroke-width="2"/><circle cx="24" cy="30" r="7" stroke="#648db3" stroke-width="2"/></svg>
        </div>
      </div>
      <div class="step-arrow">→</div>
      <div class="step">
        <div class="step-num step-num-3">3</div>
        <div class="step-title">Berbagi & Berkontribusi</div>
        <div class="step-desc">Bagikan ide, ikut proyek, dan inspirasikan guru lainnya.</div>
        <div class="step-box" style="margin-top:16px;border-radius:12px;overflow:hidden;height:80px;display:flex;align-items:center;justify-content:center">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="10" stroke="#648db3" stroke-width="2"/><path d="M24 16v8l5 4" stroke="#648db3" stroke-width="2" stroke-linecap="round"/><path d="M16 36c-2-3-3-6-3-9" stroke="#648db3" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA BANNER -->
<div class="cta-banner" style="position:relative;overflow:hidden">
  <div style="position:absolute;left:0;top:0;height:100%;width:35%;background:url('../../asset/img/community_teachers_muslim.png') center/cover no-repeat;opacity:.35"></div>
  <div class="cta-inner" style="position:relative;z-index:1">
    <div class="cta-title" style="font-size:clamp(1.5rem,3vw,2.2rem)">Bersama, Kita Lebih Kuat!</div>
    <div class="cta-sub">Bergabung bersama ribuan guru di seluruh Indonesia dan jadilah bagian dari perubahan pendidikan.</div>
    <button class="btn-primary" onclick="window.location.href='../../register.php'" style="display:inline-flex;align-items:center;gap:8px;font-size:1rem;padding:13px 28px">
      Gabung Komunitas Gratis
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
    <div class="cta-note" style="margin-top:20px;display:flex;gap:24px;justify-content:center;flex-wrap:wrap;font-size:.82rem;color:rgba(255,255,255,.55)">
      <span>✓ Komunitas aktif</span>
      <span>✓ Aman &amp; Positif</span>
      <span>✓ Dari Sabang sampai Merauke</span>
    </div>
  </div>
</div>
</div><!-- end pg-guruinspira -->
