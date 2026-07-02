@extends('layouts.public')

@section('content')

{{-- =====================
     HAL_HOME.PHP
     Halaman Beranda Utama
===================== --}}
<div id="pg-home" class="page on">

{{-- HERO --}}
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
        <a href="{{ route('register') }}" class="btn-primary">Register Now!</a>
        <a href="#learn-more" class="btn-secondary" onclick="event.preventDefault();document.getElementById('learn-more').scrollIntoView({behavior:'smooth'});">Pelajari Lebih Lanjut</a>
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
      <img src="{{ asset('asset/img/hero-teachers.png') }}" alt="Guru Indonesia Bersama" />
    </div>
  </div>
</section>

<section class="hero-features" id="learn-more">
  <div class="section-header">
    <div class="section-eyebrow">Fitur Unggulan</div>
    <h2 class="section-title">Fitur Utama Guruverse.ID</h2>
    <p class="section-subtitle">Bawa pengalaman pembelajaran guru ke tingkat lebih tinggi dengan fitur interaktif, komunitas kuat, dan tracking yang mudah dipahami.</p>
  </div>
  <div class="feature-grid">
    <article class="feature-card">
      <h3 class="feature-card-title">Kursus Interaktif</h3>
      <p class="feature-card-desc">Akses pembelajaran langsung dengan modul yang mudah diikuti, kuis ringkas, dan mentor pendamping.</p>
      <button class="feature-card-link" type="button" onclick="go('gurubelajar')">Pelajari Program</button>
    </article>
    <article class="feature-card">
      <h3 class="feature-card-title">Komunitas Pengajar</h3>
      <p class="feature-card-desc">Terhubung dengan guru lain, berbagi praktik terbaik, dan bangun jaringan profesional yang kolaboratif.</p>
      <button class="feature-card-link" type="button" onclick="go('guruinspira')">Gabung Komunitas</button>
    </article>
    <article class="feature-card">
      <h3 class="feature-card-title">Tracking Kemajuan</h3>
      <p class="feature-card-desc">Pantau perkembangan kompetensi guru dengan dashboard yang jelas, laporan mudah dibaca, dan rekomendasi lanjutan.</p>
      <button class="feature-card-link" type="button" onclick="go('gurumengajar')">Lihat Dashboard</button>
    </article>
  </div>
</section>

{{-- PILLARS --}}
<section class="pillars">
  <div class="section-header">
    <h2 class="section-title">Pilar Utama Guruverse.ID</h2>
    <p class="section-subtitle">Membangun ekosistem pendidikan yang mendukung peningkatan kompetensi guru secara pedagogik, profesional, personal, sosial, digital, dan inovatif.</p>
  </div>
  <div class="pillars-grid">

    {{-- Card 1 --}}
    <div class="pillar-card" onclick="go('gurubelajar')">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="{{ asset('asset/img/guru-wanita.png') }}" alt="Guru Belajar"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Belajar</div>
        <div class="pillar-desc">Belajar adalah perjalanan tanpa akhir. Melalui Guru Belajar, Anda dapat memperdalam kompetensi pedagogik dan profesional dengan kursus intensif, webinar interaktif, dan sertifikasi resmi. Fleksibel, terstruktur, dan relevan dengan kebutuhan zaman — jadilah guru yang terus tumbuh dan menjadi teladan bagi murid.</div>
        <button class="pillar-arrow" aria-label="Lihat Guru Belajar">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    {{-- Card 2 --}}
    <div class="pillar-card" onclick="go('gurumengajar')">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="{{ asset('asset/img/rapat-guru.png') }}" alt="Guru Mengajar"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Mengajar</div>
        <div class="pillar-desc">Ilmu yang dipelajari akan bermakna ketika diwujudkan dalam aksi nyata.
          Guru Mengajar adalah wadah untuk berbagi praktik baik, materi inovatif, dan strategi kreatif yang berdampak langsung bagi murid dan komunitas. Dengan dashboard personal, gamifikasi, dan pelatihan offline, Anda bisa mengukur kontribusi sekaligus merasakan dampak nyata</div>
        <button class="pillar-arrow" aria-label="Lihat Guru Mengajar">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    {{-- Card 3 --}}
    <div class="pillar-card" onclick="go('guruinspira')">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="{{ asset('asset/img/teachers-sertifikat.png') }}" alt="Guru Inspira"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Inspira</div>
        <div class="pillar-desc">Setiap guru punya cerita, dan setiap cerita bisa menyalakan semangat. Guru Inspira adalah ruang kolaborasi lintas daerah untuk saling mendukung, berbagi inspirasi, dan membangun jejaring profesional. Forum diskusi, proyek kolaborasi, dan kisah inspiratif akan membuat Anda merasa tidak berjalan sendiri dalam perjalanan pendidikan</div>
        <button class="pillar-arrow" aria-label="Lihat Guru Inspira">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

  </div>
</section>

{{-- FOOTER (dalam section home) --}}
<footer class="footer">
  <div class="footer-inner">
    <div>
      <div class="footer-logo"><img src="{{ asset('asset/img/FA Logo Guruverse.ID - nrgative.png') }}" alt="Guruverse" style="height:32px;"></div>
      <div class="footer-addr">Jl. Jati Mulya No.9, Gumuruh<br/>Kec. Batununggal, Kota Bandung, Jawa Barat 40275, Indonesia</div>
      <div class="footer-socials">
        <a href="https://www.instagram.com/guruverse.id" target="_blank" class="social-btn" aria-label="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="20" height="20" rx="5" stroke="#a78bfa" stroke-width="2"/><circle cx="12" cy="12" r="4" stroke="#a78bfa" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.5" fill="#a78bfa"/></svg></a>
        <a href="https://wa.me/6283133531303" target="_blank" class="social-btn" aria-label="WhatsApp"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
      </div>
    </div>
    <p style="font-size:11px;color:var(--text-dim);font-weight:600">@2024 Guruverse.ID. All rights reserved.</p>
  </div>
</footer>

</div>
{{-- end pg-home --}}


{{-- =====================
     HAL_GURUINSPIRA.PHP
===================== --}}

<div id="pg-guruinspira" class="page">
<style>
/* Theme adaptation for Guru Inspira page */
#pg-guruinspira {
  --accent-text: var(--primary-light);
  --icon-bg: var(--purple-faint);
  --box-bg: var(--navy3);
  --btn-primary-bg: var(--purple-dark);
  --step-num-bg-1: linear-gradient(135deg, var(--purple-faint), var(--purple-light));
  --step-num-bg-2: linear-gradient(135deg, #1e7a50, #2ebd80);
  --step-num-bg-3: linear-gradient(135deg, var(--purple-dark), var(--purple-light));
  --cta-bg: linear-gradient(135deg, var(--navy2), var(--navy3));
  --cta-btn-bg: linear-gradient(135deg, var(--purple-dark), var(--purple-light));
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

#pg-guruinspira .detail-quote svg path { stroke: var(--accent-text) !important; }
#pg-guruinspira .stat-num { color: var(--accent-text) !important; }
#pg-guruinspira .feat-card .fc-icon { background: var(--icon-bg) !important; }
#pg-guruinspira .feat-card .fc-icon svg { stroke: var(--accent-text) !important; }
#pg-guruinspira .feat-card .fc-icon svg path { stroke: var(--accent-text) !important; }
#pg-guruinspira .feature-img-box { background: var(--box-bg) !important; }
#pg-guruinspira .step-num-1 { background: var(--step-num-bg-1) !important; }
#pg-guruinspira .step-num-2 { background: var(--step-num-bg-2) !important; }
#pg-guruinspira .step-num-3 { background: var(--step-num-bg-3) !important; }
#pg-guruinspira .step-box { background: var(--box-bg) !important; }
#pg-guruinspira .cta-banner { background: var(--cta-bg) !important; }
#pg-guruinspira .cta-banner .btn-primary { background: var(--cta-btn-bg) !important; }
#pg-guruinspira .hero-btn-primary { background: var(--btn-primary-bg) !important; }

#pg-guruinspira .step-arrow {
  display:flex; align-items:center; justify-content:center;
  font-size:1.8rem; color:#648db3; opacity:.6; padding:0 4px;
}
@media(max-width:768px){
  #pg-guruinspira .steps { grid-template-columns:1fr; gap:16px; }
  #pg-guruinspira .feat-grid { grid-template-columns:1fr !important; }
  #pg-guruinspira [style*="grid-template-columns:repeat(3"] { grid-template-columns:1fr !important; }
}
</style>

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

{{-- HERO --}}
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
        <a href="{{ route('register') }}" class="btn-primary hero-btn-primary" style="border:none;border-radius:12px;padding:13px 28px;color:#fff;font-weight:700;font-size:14px;cursor:pointer;font-family:inherit;text-decoration:none;display:inline-block;">Bergabung Sekarang</a>
        <a href="{{ route('learn-more') }}" class="btn-secondary" style="border-radius:12px;padding:12px 24px;text-decoration:none;display:inline-block;">Pelajari Lebih Lanjut</a>
      </div>
    </div>
    <div class="detail-img">
      <img src="{{ asset('asset/img/hero-teachers.png') }}" alt="Guru Inspira">
    </div>
  </div>
</section>


{{-- STATS --}}
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

{{-- FOKUS UTAMA --}}
<div class="content-section alt">
  <div class="content-inner">
    <div class="sec-title">Fokus Utama Guru Inspira</div>
    <div class="sec-desc">Jejaring, kolaborasi, dan inspirasi untuk guru Indonesia</div>

    <div class="feat-grid" style="grid-template-columns:repeat(3,1fr); gap:24px;">

      {{-- Forum Diskusi --}}
      <div class="feat-card" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
        <div style="height:200px; background:linear-gradient(135deg, #f8fafc, #e2e8f0); position:relative; overflow:hidden;">
          <img src="{{ asset('asset/img/rapat-guru.png') }}" alt="Forum Diskusi" style="width:100%; height:100%; object-fit:cover; mix-blend-mode:multiply; transition:transform 0.5s ease; cursor:pointer;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <div style="padding:24px; flex-grow:1; display:flex; flex-direction:column;">
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
      </div>

      {{-- Kolaborasi Proyek --}}
      <div class="feat-card alt" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
        <div style="height:200px; background:linear-gradient(135deg, #f1f5f9, #cbd5e1); position:relative; overflow:hidden;">
          <img src="{{ asset('asset/img/community_teachers_muslim (2).png') }}" alt="Kolaborasi Proyek" style="width:100%; height:100%; object-fit:cover; mix-blend-mode:multiply; transition:transform 0.5s ease; cursor:pointer;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <div style="padding:24px; flex-grow:1; display:flex; flex-direction:column;">
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
      </div>

      {{-- Cerita Inspiratif --}}
      <div class="feat-card" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
        <div style="height:200px; background:linear-gradient(135deg, #f8fafc, #e2e8f0); position:relative; overflow:hidden;">
          <img src="{{ asset('asset/img/teachers-sertifikat.png') }}" alt="Cerita Inspiratif" style="width:100%; height:100%; object-fit:cover; mix-blend-mode:multiply; transition:transform 0.5s ease; cursor:pointer;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <div style="padding:24px; flex-grow:1; display:flex; flex-direction:column;">
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
</div>

{{-- CARA BERGABUNG --}}
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
      </div>
      <div class="step">
        <div class="step-num step-num-2">2</div>
        <div class="step-title">Jelajahi Komunitas</div>
        <div class="step-desc">Temukan forum diskusi, proyek kolaborasi, dan cerita inspiratif dari guru lainnya.</div>
      </div>
      <div class="step">
        <div class="step-num step-num-3">3</div>
        <div class="step-title">Berbagi &amp; Berkontribusi</div>
        <div class="step-desc">Bagikan ide, ikut proyek, dan inspirasikan guru lainnya.</div>
      </div>
    </div>
  </div>
</div>

{{-- CTA BANNER --}}
<div class="cta-banner" style="position:relative;overflow:hidden">
  <div style="position:absolute;left:0;top:0;height:100%;width:35%;background:url('{{ asset("asset/img/community_teachers_muslim (2).png") }}') center/cover no-repeat;opacity:.35"></div>
  <div class="cta-inner" style="position:relative;z-index:1">
    <div class="cta-title" style="font-size:clamp(1.5rem,3vw,2.2rem)">Bersama, Kita Lebih Kuat!</div>
    <div class="cta-sub">Bergabung bersama ribuan guru di seluruh Indonesia dan jadilah bagian dari perubahan pendidikan.</div>
    <a href="{{ route('register') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;font-size:1rem;padding:13px 28px;text-decoration:none;">
      Gabung Komunitas Gratis
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
    <div class="cta-note" style="margin-top:20px;display:flex;gap:24px;justify-content:center;flex-wrap:wrap;font-size:.82rem;color:rgba(255,255,255,.55)">
      <span>✓ Komunitas aktif</span>
      <span>✓ Aman &amp; Positif</span>
      <span>✓ Dari Sabang sampai Merauke</span>
    </div>
  </div>
</div>
</div>{{-- end pg-guruinspira --}}


{{-- =====================
     HAL_GURUMENGAJAR.PHP
===================== --}}
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

#pg-gurumengajar .custom-badge-classroom { background: var(--icon-bg) !important; color: var(--page-primary-light) !important; }
#pg-gurumengajar .custom-quote-svg { color: var(--page-primary-light) !important; }
#pg-gurumengajar .custom-glow-effect { background: radial-gradient(circle, var(--glow-color) 0%, transparent 70%) !important; }
#pg-gurumengajar .custom-stat-icon-box { background: var(--icon-bg) !important; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
#pg-gurumengajar .custom-stat-icon-box svg { stroke: var(--icon-stroke) !important; }
#pg-gurumengajar .custom-feat-card { background: var(--card-bg) !important; border: 1px solid var(--border) !important; padding: 24px; border-radius: 16px; }
#pg-gurumengajar .custom-feat-card .fc-name { color: var(--card-text) !important; }
#pg-gurumengajar .custom-feat-card .fc-desc { color: var(--card-text-muted) !important; }
#pg-gurumengajar .custom-feat-card ul li { color: var(--card-text-dim) !important; }
#pg-gurumengajar .custom-feat-card ul li svg { stroke: var(--icon-stroke) !important; }
#pg-gurumengajar .custom-step-icon { background: var(--page-primary) !important; width: 56px; height: 56px; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 10px 15px -3px var(--glow-color) !important; }
#pg-gurumengajar .custom-step-icon-alt { background: var(--page-primary-light) !important; width: 56px; height: 56px; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 10px 15px -3px var(--glow-color) !important; }
#pg-gurumengajar .custom-step-title { color: var(--step-text) !important; }
#pg-gurumengajar .custom-testi-title-main { color: var(--step-text) !important; }
#pg-gurumengajar .custom-testi-card { background: var(--card-bg) !important; border: 1px solid var(--border) !important; padding: 32px; border-radius: 16px; }
#pg-gurumengajar .custom-testi-card .quote-text { color: var(--card-text-muted) !important; }
#pg-gurumengajar .custom-testi-card .author-name { color: var(--card-text) !important; }
#pg-gurumengajar .custom-testi-card .author-school { color: var(--card-text-dim) !important; }
</style>

<div class="detail-breadcrumb">
  <button class="breadcrumb-back" onclick="goH()"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 2L3 6l5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Kembali</button>
  <span class="breadcrumb-trail"><span>Beranda</span><span class="sep">/</span><span>Partner</span><span class="sep">/</span><span class="current">Guru Mengajar</span></span>
</div>

{{-- HERO --}}
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
        <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;text-decoration:none;display:inline-block;">Mulai Daftar</a>
        <button class="btn-secondary" style="display: flex; align-items: center; gap: 8px;" onclick="document.getElementById('fitur-utama').scrollIntoView({behavior: 'smooth'})">
          Pelajari Fitur
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3.5 5.25L7 8.75L10.5 5.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>
    <div class="detail-img">
      <div style="position: relative; padding: 20px;">
        <div class="custom-glow-effect" style="position: absolute; top: 10%; right: 10%; width: 300px; height: 300px; z-index: 0; filter: blur(40px);"></div>
        <img src="{{ asset('asset/img/hero_classroom_hub.png') }}" alt="Classroom Hub" style="width: 100%; max-width: 550px; border-radius: 24px; position: relative; z-index: 1;">
      </div>
    </div>
  </div>
</section>

{{-- STATS --}}
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

{{-- FITUR UTAMA --}}
<div class="content-section" id="fitur-utama">
  <div class="content-inner">
    <div class="sec-title">Fitur Utama Guru Mengajar</div>
    <div class="sec-desc">Semua yang kamu butuhkan untuk mengajar lebih efektif dan berdampak</div>

    <div class="feat-grid" style="grid-template-columns: repeat(4, 1fr); margin-top: 48px;">
      {{-- Dashboard Personal --}}
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Dashboard Personal</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Kelola semua aktivitas mengajar dalam satu dashboard terintegrasi.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Kelas &amp; jadwal mengajar</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Rencana pembelajaran</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Penilaian &amp; refleksi</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Analitik perkembangan kelas</li>
        </ul>
      </div>

      {{-- Gamifikasi --}}
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary-light); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M6 9a6 6 0 1 0 12 0"/><path d="M12 15v6"/><path d="M7 21h10"/><path d="M12 3v3"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Gamifikasi</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Belajar &amp; berkontribusi jadi lebih seru dengan sistem gamifikasi.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Poin &amp; level pencapaian</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Badge &amp; achievement</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Leaderboard guru inspiratif</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Reward menarik</li>
        </ul>
      </div>

      {{-- Impact Tracker --}}
      <div class="custom-feat-card">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--page-primary); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div class="fc-name" style="font-size: 1.1rem; font-weight:700;">Impact Tracker</div>
        <div class="fc-desc" style="font-size: 0.85rem; margin-top: 8px;">Pantau dampak pembelajaran terhadap murid &amp; komunitas.</div>
        <ul style="list-style: none; padding: 0; margin-top: 16px;">
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Tracking keterlibatan murid</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Capaian kompetensi</li>
          <li style="font-size: 0.8rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Dampak ke komunitas</li>
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Laporan otomatis</li>
        </ul>
      </div>

      {{-- Pelatihan Offline --}}
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
          <li style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Jaringan &amp; kolaborasi</li>
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- ALUR --}}
<div class="content-section alt" style="padding-bottom: 80px;">
  <div class="content-inner">
    <div class="sec-title">Alur Guru Mengajar</div>
    <div class="sec-desc">Dari perencanaan hingga berdampak nyata</div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 60px; max-width: 1000px; margin-left: auto; margin-right: auto; position: relative;">
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
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Evaluasi &amp; refleksi berkelanjutan</div>
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

{{-- TESTIMONI --}}
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

{{-- CTA BANNER --}}
<div class="cta-banner cta-banner-gm" style="margin-top: 0; position: relative; overflow: hidden; padding: 48px 24px;">
  <div style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; opacity: 0.08; z-index: 0;">
    <img src="{{ asset('asset/img/community_teachers_muslim.png') }}" alt="Community" style="width: 100%; height: 100%; object-fit: cover;">
  </div>
  <div class="cta-inner" style="position: relative; z-index: 1; max-width: 560px;">
    <div class="cta-title" style="font-size: clamp(20px, 3vw, 28px); margin-bottom: 8px;">Bergabung bersama 5.200+ guru</div>
    <div class="cta-sub" style="max-width: 600px; margin: 0 auto 20px; font-size: clamp(12px, 1.4vw, 14px);">Bersama kita bisa — saling menguatkan, berbagi ilmu, dan membangun pendidikan Indonesia</div>
    <a href="{{ route('register') }}" class="btn-primary" style="background: #fff; color: var(--navy); font-weight: 700; padding: 10px 24px; border-radius: 12px; font-size: 0.9rem; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
      Gabung Komunitas Gratis
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"/></svg>
    </a>
    <div style="display: flex; justify-content: center; gap: 20px; margin-top: 24px; color: var(--text-dim); font-size: 0.8rem; flex-wrap: wrap;">
      <span style="display: flex; align-items: center; gap: 6px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Gratis untuk semua guru</span>
      <span style="display: flex; align-items: center; gap: 6px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Komunitas aktif</span>
      <span style="display: flex; align-items: center; gap: 6px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg> Dari Sabang sampai Merauke</span>
    </div>
  </div>
</div>
</div>{{-- end pg-gurumengajar --}}


{{-- =====================
     HAL_GURUBELAJAR.PHP
===================== --}}
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

#pg-gurubelajar .detail-hero { background: var(--hero-bg) !important; }
#pg-gurubelajar .detail-title em { color: var(--accent-text) !important; }
#pg-gurubelajar .detail-badge { color: var(--accent-text) !important; border-color: var(--accent-text) !important; }
#pg-gurubelajar .btn-secondary { color: var(--accent-text) !important; border-color: var(--accent-text) !important; }
#pg-gurubelajar .stat-num { color: var(--accent-text) !important; }
#pg-gurubelajar .cta-banner { background: var(--cta-bg) !important; }
#pg-gurubelajar .cta-banner .btn-primary { background: var(--cta-btn-bg) !important; }
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
        <a href="{{ route('learn-more') }}" class="btn-secondary" style="border-color:rgba(5,150,105,.4);text-decoration:none;display:inline-block;">Pelajari Lebih Lanjut</a>
      </div>
    </div>
    <div class="detail-img">
      <img src="{{ asset('asset/img/teachers-sertifikat.png') }}" alt="Guru Belajar" style="width:700px;"/>
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
        <div class="fc-sub">Dikurasi tim ahli &amp; praktisi pendidikan</div>
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
      <div class="step"><div class="step-num">1</div><div class="step-title">Daftar Akun</div><div class="step-desc">Buat akun Guruverse.ID gratis &amp; lengkapi profil gurumu</div></div>
      <div class="step"><div class="step-num">2</div><div class="step-title">Pilih Program</div><div class="step-desc">Jelajahi 200+ mata pelajaran sesuai kebutuhan dan jenjangmu</div></div>
      <div class="step"><div class="step-num">3</div><div class="step-title">Belajar &amp; Sertifikat</div><div class="step-desc">Selesaikan program dan dapatkan sertifikat digital resmi</div></div>
    </div>
  </div>
</div>

<div class="cta-banner">
  <div class="cta-inner">
    <div class="cta-title">Mulai belajar, tingkatkan kompetensi</div>
    <div class="cta-sub">Bergabung bersama 2 juta+ guru yang sudah merasakan manfaat Guru Belajar</div>
    <a href="{{ route('register') }}" class="btn-primary" style="text-decoration:none;display:inline-block;">Mulai Program Gratis</a>
    <div class="cta-note">Akses gratis untuk 30 hari pertama</div>
  </div>
</div>
</div>{{-- end pg-gurubelajar --}}


{{-- ===== JAVASCRIPT SPA NAVIGATION ===== --}}
<script>
function goH(){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('on'));
  document.getElementById('pg-home').classList.add('on');
  window.scrollTo({top:0,behavior:'smooth'});
}
function go(id){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('on'));
  document.getElementById('pg-'+id).classList.add('on');
  window.scrollTo({top:0,behavior:'smooth'});
}
</script>

@endsection
