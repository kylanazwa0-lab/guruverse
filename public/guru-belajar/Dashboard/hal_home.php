<!-- =====================
     HOMEPAGE
===================== -->
<div id="pg-home" class="page on">

<nav class="navbar">
  <div class="navbar-inner">
    <div class="nav-logo" onclick="goH()"><img src="../../asset/img/logo guruverse FA.ai.png" alt="GV" style="height:30px;"><span>GURUVERSE<em>.ID</em></span></div>
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
    <button class="nav-hamburger" onclick="toggleMenu()" id="hamburger">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="nav-mobile" id="navMobile">
    <button class="nav-link" onclick="window.location.href='about.php'">Tentang Kami</button>
    <button class="nav-link" onclick="window.location.href='program.php'">Program</button>
    <button class="nav-link" onclick="window.location.href='testimoni.php'">Testimoni</button>
    <button class="nav-link" onclick="window.location.href='artikel.php'">Artikel</button>
    <button class="nav-cta" style="margin-top:8px;border-radius:10px" onclick="window.open('https://wa.me/6283133531303','_blank')">Contact Us</button>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-stars">
    <div class="hero-star" style="width:3px;height:3px;top:12%;left:8%;opacity:.7"></div>
    <div class="hero-star" style="width:4px;height:4px;top:28%;left:15%;opacity:.4"></div>
    <div class="hero-star" style="width:3px;height:3px;top:8%;left:55%;opacity:.5"></div>
    <div class="hero-star" style="width:5px;height:5px;top:70%;left:48%;opacity:.3"></div>
    <div class="hero-star" style="width:2px;height:2px;top:45%;left:92%;opacity:.6"></div>
    <div class="hero-star" style="width:4px;height:4px;top:18%;right:22%;opacity:.4"></div>
  </div>
  <div class="hero-inner">
    <div class="hero-text">
      <div class="hero-eyebrow">Ruang Semesta Guru Indonesia</div>
      <h1 class="hero-title">Semesta Kompetensi,<br/>Untuk Guru Indonesia</h1>
      <p class="hero-subtitle">Guruverse.ID adalah ruang semesta bagi guru Indonesia untuk terhubung, bertumbuh, dan menjadi lebih kompeten bersama.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="window.location.href='../../register/register.php'">Register Now!</button>
        <button class="btn-secondary" onclick="window.location.href='../../register/learn-more.php'">Pelajari Lebih Lanjut</button>
      </div>
      <div class="hero-search">
        <div class="search-box">
          <input type="search" class="search-input" placeholder="Cari kelas, program, dan komunitas guru..." aria-label="Search Guruverse" />
          <button class="search-btn" type="button">Cari Sekarang</button>
        </div>
        <div class="hero-tags">
          <span class="tag-pill">Program Guru</span>
          <span class="tag-pill">Webinar</span>
          <span class="tag-pill">Sertifikasi</span>
          <span class="tag-pill">Komunitas</span>
          <span class="tag-pill">Pelatihan</span>
        </div>
      </div>
    </div>
    <div class="hero-image">
      <img src="../../asset/img/hero-teachers.png" alt="Guru Indonesia Bersama" />
    </div>
  </div>
</section>

<section class="hero-features">
  <div class="section-header">
    <div class="section-eyebrow">Fitur Unggulan</div>
    <h2 class="section-title">Fitur Utama Guruverse.ID</h2>
    <p class="section-subtitle">Bawa pengalaman pembelajaran guru ke tingkat lebih tinggi dengan fitur interaktif, komunitas kuat, dan tracking yang mudah dipahami.</p>
  </div>
  <div class="feature-grid">
    <article class="feature-card">
      <h3 class="feature-card-title">Kursus Interaktif</h3>
      <p class="feature-card-desc">Akses pembelajaran langsung dengan modul yang mudah diikuti, kuis ringkas, dan mentor pendamping.</p>
      <button class="feature-card-link" type="button">Pelajari Program</button>
    </article>
    <article class="feature-card">
      <h3 class="feature-card-title">Komunitas Pengajar</h3>
      <p class="feature-card-desc">Terhubung dengan guru lain, berbagi praktik terbaik, dan bangun jaringan profesional yang kolaboratif.</p>
      <button class="feature-card-link" type="button">Gabung Komunitas</button>
    </article>
    <article class="feature-card">
      <h3 class="feature-card-title">Tracking Kemajuan</h3>
      <p class="feature-card-desc">Pantau perkembangan kompetensi guru dengan dashboard yang jelas, laporan mudah dibaca, dan rekomendasi lanjutan.</p>
      <button class="feature-card-link" type="button">Lihat Dashboard</button>
    </article>
  </div>
</section>

<!-- PILLARS -->
<section class="pillars">
  <div class="section-header">
    <h2 class="section-title">Pilar Utama Guruverse.ID</h2>
    <p class="section-subtitle">Membangun ekosistem pendidikan yang mendukung peningkatan kompetensi guru secara pedagogik, profesional, personal, sosial, digital, dan inovatif.</p>
  </div>
  <div class="pillars-grid">

    <!-- Card 1 -->
    <div class="pillar-card" onclick="go('gurubelajar')">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="../../asset/img/guru-wanita.png"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Belajar</div>
        <div class="pillar-desc">Belajar adalah perjalanan tanpa akhir. Melalui Guru Belajar, Anda dapat memperdalam kompetensi pedagogik dan profesional dengan kursus intensif, webinar interaktif, dan sertifikasi resmi. Fleksibel, terstruktur, dan relevan dengan kebutuhan zaman — jadilah guru yang terus tumbuh dan menjadi teladan bagi murid.</div>
        <button class="pillar-arrow">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="pillar-card" onclick="go('gurumengajar')">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="../../asset/img/rapat-guru.png"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Mengajar</div>
        <div class="pillar-desc">Ilmu yang dipelajari akan bermakna ketika diwujudkan dalam aksi nyata. 
          Guru Mengajar adalah wadah untuk berbagi praktik baik, materi inovatif, dan strategi kreatif yang berdampak langsung bagi murid dan komunitas. Dengan dashboard personal, gamifikasi, dan pelatihan offline, Anda bisa mengukur kontribusi sekaligus merasakan dampak nyata</div>
        <button class="pillar-arrow">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="pillar-card" onclick="go('guruinspira')">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="../../asset/img/teachers-sertifikat.png"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Inspira</div>
        <div class="pillar-desc">Setiap guru punya cerita, dan setiap cerita bisa menyalakan semangat. Guru Inspira adalah ruang kolaborasi lintas daerah untuk saling mendukung, berbagi inspirasi, dan membangun jejaring profesional. Forum diskusi, proyek kolaborasi, dan kisah inspiratif akan membuat Anda merasa tidak berjalan sendiri dalam perjalanan pendidikan</div>
        <button class="pillar-arrow">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <div>
      <div class="footer-logo"><img src="../../asset/img/FA Logo Guruverse.ID - nrgative.png" alt="GV" style="height:32px;"></div>
      <div class="footer-addr">Jl. Jati Mulya No.9, Gumuruh<br/>Kec. Batununggal, Kota Bandung, Jawa Barat 40275, Indonesia</div>
      <div class="footer-socials">
        <a href="https://www.instagram.com/guruverse.id?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="20" height="20" rx="5" stroke="#a78bfa" stroke-width="2"/><circle cx="12" cy="12" r="4" stroke="#a78bfa" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.5" fill="#a78bfa"/></svg></a>
        <a href="https://wa.me/6283133531303" target="_blank" class="social-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
      </div>
    </div>
    <p style="font-size:11px;color:var(--text-dim);font-weight:600">@2024 Guruverse.ID. All rights reserved.</p>
  </div>
</footer>

</div>
<!-- end pg-home -->


