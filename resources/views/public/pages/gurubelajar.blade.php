@extends('layouts.public')

@section('content')

<style>
/* Theme adaptation for Guru Belajar page */
#pg-gurubelajar {
  --hero-bg: linear-gradient(135deg, var(--navy2) 0%, var(--navy) 100%);
  --accent-text: var(--primary-light);
  --cta-bg: linear-gradient(135deg, var(--purple-faint), var(--purple-dark));
  --cta-btn-bg: linear-gradient(135deg, var(--purple-dark), var(--purple-light));
}

[data-theme="light"] #pg-gurubelajar {
  --hero-bg: var(--bg);
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

#pg-gurubelajar .detail-hero {
  position: relative;
  overflow: hidden;
  padding: clamp(56px, 7vw, 92px) 24px;
}

#pg-gurubelajar .learning-hero-glow {
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 80% at 88% 18%, rgba(52, 211, 153, .14) 0%, transparent 62%),
    radial-gradient(ellipse 48% 60% at 10% 80%, rgba(124, 58, 237, .18) 0%, transparent 65%);
  z-index: 0;
}

#pg-gurubelajar .detail-hero-inner {
  position: relative;
  z-index: 1;
}

#pg-gurubelajar .detail-hero-text {
  max-width: 560px;
}

#pg-gurubelajar .detail-subtitle {
  max-width: 520px;
}

#pg-gurubelajar .detail-btns {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  align-items: center;
}

#pg-gurubelajar .hero-btn-primary,
#pg-gurubelajar .hero-btn-secondary {
  display: inline-flex !important;
  align-items: center;
  justify-content: center;
  min-height: 48px;
  min-width: 180px;
  text-align: center;
  text-decoration: none;
}

#pg-gurubelajar .hero-btn-secondary {
  background: rgba(255, 255, 255, .08) !important;
  color: #ffffff !important;
  border: 1.5px solid rgba(167, 139, 250, .55) !important;
}

[data-theme="light"] #pg-gurubelajar .hero-btn-secondary {
  background: #ffffff !important;
  color: var(--primary) !important;
  border-color: var(--border) !important;
}

#pg-gurubelajar .detail-img {
  width: min(48vw, 560px);
  min-width: 280px;
  display: flex;
  align-items: center;
  justify-content: center;
}

#pg-gurubelajar .detail-img img {
  width: 100%;
  max-width: 560px;
  height: auto;
  display: block;
  object-fit: contain;
  filter: drop-shadow(0 28px 60px rgba(0, 0, 0, .28));
}

#pg-gurubelajar .learning-feature-card {
  min-height: 100%;
}

#pg-gurubelajar .learning-step {
  min-height: 150px;
}

#pg-gurubelajar .cta-note {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 8px 14px;
  border-radius: 999px;
  background: rgba(255, 255, 255, .08);
  color: rgba(255, 255, 255, .78);
}

@media (max-width: 768px) {
  #pg-gurubelajar .detail-hero {
    padding: 44px 20px 36px;
  }

  #pg-gurubelajar .detail-img {
    width: 100%;
    max-width: 360px;
  }

  #pg-gurubelajar .detail-btns {
    width: 100%;
  }

  #pg-gurubelajar .hero-btn-primary,
  #pg-gurubelajar .hero-btn-secondary {
    width: 100%;
  }
}
</style>

<div id="pg-gurubelajar">
<div class="detail-breadcrumb">
  <button class="breadcrumb-back" onclick="window.location.href='{{ route('home') }}'"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 2L3 6l5 4" stroke="#c4bdf0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Kembali</button>
  <span class="breadcrumb-trail"><span>Beranda</span><span class="sep">/</span><span>Partner</span><span class="sep">/</span><span class="current">Guru Belajar</span></span>
</div>

<section class="detail-hero">
  <div class="learning-hero-glow" aria-hidden="true"></div>
  <div class="detail-hero-inner">
    <div class="detail-hero-text gv-reveal">
      <span class="detail-badge" style="background:rgba(52,211,153,.1); border-color:rgba(52,211,153,.3)">PROGRAM</span>
      <h1 class="detail-title">Guru <em>Belajar</em></h1>
      <p class="detail-subtitle">Program pembelajaran mandiri untuk peningkatan kompetensi berkelanjutan</p>
      <div class="detail-btns">
        <a href="{{ route('register') }}" class="btn-primary hero-btn-primary">Mulai Belajar</a>
        <a href="{{ route('learn-more.gurubelajar') }}" class="btn-secondary hero-btn-secondary">Pelajari Lebih Lanjut</a>
      </div>
    </div>
    <div class="detail-img gv-reveal">
      <div class="gv-parallax-wrap">
        <img src="{{ asset('asset/img/guru-wanita.png') }}" alt="Guru Belajar Hero" class="gv-parallax-img" style="transform-origin: center top;"/>
      </div>
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
    <div class="sec-title gv-reveal">Program Unggulan</div>
    <div class="sec-desc gv-reveal">Tingkatkan kompetensimu melalui kelas interaktif, webinar eksklusif, dan sertifikasi resmi dari ahli di bidang pendidikan.</div>
    <div class="feat-grid">
      <div class="feat-card gv-reveal learning-feature-card" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
        <div class="fc-head"><div class="fc-icon" style="background:var(--purple-faint)"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1l2 4.5 5 .5-3.6 3.5 1 4.5L8 12 3.6 14l1-4.5L1 6l5-.5z" stroke="var(--primary-light)" stroke-width="1.2" stroke-linejoin="round"/></svg></div><div><div class="fc-name">Belajar Mandiri Terstruktur</div></div></div>
        <div class="fc-sub">Self-paced learning tanpa batas waktu</div>
        <div class="fc-desc">Akses 200+ mata pelajaran dengan kurikulum yang dirancang bersama pakar pendidikan Indonesia.</div>
      </div>
      <div class="feat-card alt gv-reveal learning-feature-card" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
        <div class="fc-head"><div class="fc-icon" style="background:var(--purple-faint)"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="6" stroke="var(--primary-light)" stroke-width="1.2"/><path d="M6 8l2 2 4-4" stroke="var(--primary-light)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><div class="fc-name">Sertifikasi Terverifikasi</div></div></div>
        <div class="fc-sub">Diakui secara profesional</div>
        <div class="fc-desc">Selesaikan program dan dapatkan sertifikat digital yang dapat dibagikan ke profil LinkedIn.</div>
      </div>
      <div class="feat-card wide gv-reveal learning-feature-card">
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
      <div class="step learning-step"><div class="step-num">1</div><div class="step-title">Daftar Akun</div><div class="step-desc">Buat akun Guruverse.ID gratis &amp; lengkapi profil gurumu</div></div>
      <div class="step learning-step"><div class="step-num">2</div><div class="step-title">Pilih Program</div><div class="step-desc">Jelajahi 200+ mata pelajaran sesuai kebutuhan dan jenjangmu</div></div>
      <div class="step learning-step"><div class="step-num">3</div><div class="step-title">Belajar &amp; Sertifikat</div><div class="step-desc">Selesaikan program dan dapatkan sertifikat digital resmi</div></div>
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

</div>

@endsection
