@extends('layouts.public')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
/* ── THEME SUPPORT ── */
:root {
  --prog-blue: #2563eb;
  --prog-blue-hover: #1d4ed8;
  --prog-blue-bg: rgba(37, 99, 235, 0.08);
  --prog-orange: #f59e0b;
  --prog-orange-hover: #d97706;
  --prog-orange-bg: rgba(245, 158, 11, 0.08);
  --prog-pink: #ec4899;
  --prog-pink-hover: #db2777;
  --prog-pink-bg: rgba(236, 72, 153, 0.08);
  
  --p-bg: var(--bg);
  --p-card-bg: var(--card);
  --p-border: var(--border);
  --p-text: var(--text);
  --p-text-muted: var(--text-muted);
  --p-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
}

[data-theme="dark"] {
  --p-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

/* ── LIGHT MODE OVERRIDES ── */
[data-theme="light"] {
  --p-card-bg: #ffffff;
  --p-border: #D2E3EB;
  --p-text: #092B40;
  --p-text-muted: #3D6175;
  --p-shadow: 0 4px 20px rgba(9, 60, 93, 0.08);
}

[data-theme="light"] .prog-wrapper {
  background: #F5F8FA;
}

/* Light mode: hero */
[data-theme="light"] .hero-title-prog  { color: #092B40; }
[data-theme="light"] .hero-desc-prog   { color: #3D6175; }
[data-theme="light"] .hero-badge-prog  {
  background: rgba(37, 99, 235, 0.10);
  color: #1d4ed8;
}

/* Light mode: pill cards */
[data-theme="light"] .pill-card-custom {
  background: #ffffff;
  border-color: #D2E3EB;
  box-shadow: 0 4px 16px rgba(9, 60, 93, 0.08);
}
[data-theme="light"] .pill-text-title { color: #092B40; }
[data-theme="light"] .pill-text-sub   { color: #3D6175; }
[data-theme="light"] .pill-icon-box.belajar-bg { background: rgba(37, 99, 235, 0.10); }
[data-theme="light"] .pill-icon-box.mengajar-bg { background: rgba(245, 158, 11, 0.10); }
[data-theme="light"] .pill-icon-box.inspira-bg  { background: rgba(236, 72, 153, 0.10); }

/* Light mode: swiper slide cards */
[data-theme="light"] .pslide-inner {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 1);
  box-shadow: 0 20px 40px rgba(9, 60, 93, 0.06), inset 0 0 0 1px rgba(255, 255, 255, 0.5);
}
[data-theme="light"] .belajar-slide {
  background: linear-gradient(135deg, rgba(255,255,255,0.95) 40%, rgba(219, 234, 254, 0.5)) !important;
}
[data-theme="light"] .mengajar-slide {
  background: linear-gradient(135deg, rgba(255,255,255,0.95) 40%, rgba(254, 243, 199, 0.5)) !important;
}
[data-theme="light"] .inspira-slide {
  background: linear-gradient(135deg, rgba(255,255,255,0.95) 40%, rgba(252, 231, 243, 0.5)) !important;
}

/* Light mode: slide text */
[data-theme="light"] .pslide-title { color: #092B40 !important; }
[data-theme="light"] .belajar-slide .pslide-title  { color: #1e3a8a !important; }
[data-theme="light"] .mengajar-slide .pslide-title { color: #78350f !important; }
[data-theme="light"] .inspira-slide .pslide-title  { color: #831843 !important; }
[data-theme="light"] .pslide-desc { color: #3D6175 !important; }
[data-theme="light"] .pslide-features span { color: #092B40 !important; }

/* Light mode: divider */
[data-theme="light"] .pslide-actions {
  border-left-color: rgba(9, 60, 93, 0.12);
}

/* Light mode: swiper nav buttons */
[data-theme="light"] .swiper-button-next,
[data-theme="light"] .swiper-button-prev {
  background: #ffffff;
  color: #2563eb;
  box-shadow: 0 4px 16px rgba(9, 60, 93, 0.18);
}
[data-theme="light"] .swiper-button-next:hover,
[data-theme="light"] .swiper-button-prev:hover {
  background: #2563eb;
  color: #ffffff;
}

/* Light mode: swiper pagination */
[data-theme="light"] .swiper-pagination-bullet {
  background: #3D6175;
  opacity: 0.4;
}
[data-theme="light"] .swiper-pagination-bullet-active {
  background: #2563eb;
  opacity: 1;
}

.prog-wrapper {
  background: var(--p-bg);
  color: var(--p-text);
  padding: 60px 0 100px;
  transition: all 0.3s ease;
}

.container-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
}

/* ── HERO ── */
.hero-section-custom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 48px;
  margin-bottom: 80px;
}
.hero-content-prog {
  flex: 1.2;
}
.hero-badge-prog {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--prog-blue-bg);
  color: var(--prog-blue);
  font-weight: 700;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 8px 16px;
  border-radius: 9999px;
  margin-bottom: 24px;
}
.hero-title-prog {
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 800;
  line-height: 1.2;
  color: var(--p-text);
  margin-bottom: 20px;
}
.hero-title-prog span.text-highlight {
  color: var(--prog-blue);
}
.hero-desc-prog {
  font-size: 1.05rem;
  color: var(--p-text-muted);
  line-height: 1.7;
}

.hero-image-area {
  flex: 0.9;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}
.hero-main-img {
  width: 100%;
  max-width: 480px;
  height: auto;
  position: relative;
  z-index: 1;
}

/* ── PILLS ── */
.pills-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-bottom: 64px;
}
.pill-card-custom {
  background: var(--p-card-bg);
  border: 1px solid var(--p-border);
  border-radius: 20px;
  padding: 16px 24px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: var(--p-shadow);
  transition: transform 0.3s, box-shadow 0.3s;
}
.pill-card-custom:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.06);
}

.pill-text-title {
  font-weight: 800;
  font-size: 1.05rem;
  color: var(--p-text);
  margin-bottom: 2px;
}
.pill-text-sub {
  font-size: 0.85rem;
  color: var(--p-text-muted);
  font-weight: 500;
}

/* ── SWIPER SLIDESHOW ── */
.pillarSwiper {
  width: 100%;
  padding-top: 40px;
  padding-bottom: 50px;
  margin-bottom: 20px;
  height: 430px; /* Force height so it doesn't stretch */
}
.swiper-pagination {
  bottom: 0px !important;
}
.swiper-slide-custom {
  width: 720px;
  height: 340px;
  transition: filter 0.3s;
}
.swiper-slide:not(.swiper-slide-active) {
  filter: blur(2px) brightness(0.9);
}

.pslide-inner {
  position: relative;
  width: 100%;
  height: 100%;
  border-radius: 24px;
  padding: 40px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  overflow: hidden;
  box-shadow: 0 12px 32px rgba(0,0,0,0.08);
  border: 1px solid var(--p-border);
  background: var(--p-card-bg);
}

.belajar-slide { background: linear-gradient(135deg, var(--p-card-bg), var(--prog-blue-bg)); }
.mengajar-slide { background: linear-gradient(135deg, var(--p-card-bg), var(--prog-orange-bg)); }
.inspira-slide { background: linear-gradient(135deg, var(--p-card-bg), var(--prog-pink-bg)); }

.pslide-title { color: var(--p-text) !important; }
.pslide-desc { color: var(--p-text-muted) !important; }

.pslide-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  z-index: 2;
}

.pslide-actions {
  flex: 0 0 240px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  z-index: 2;
  border-left: 1px solid rgba(0,0,0,0.08);
  padding-left: 40px;
}

.pslide-badge {
  display: inline-flex;
  align-items: center;
  padding: 6px 14px;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 20px;
  width: fit-content;
}

.pslide-title {
  font-size: 2.2rem;
  font-weight: 900;
  line-height: 1.1;
  margin-bottom: 16px;
}

.pslide-desc {
  font-size: 0.95rem;
  color: var(--p-text-muted);
  line-height: 1.6;
}

.pslide-features {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 28px;
}

.pslide-features span {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 0.88rem;
  font-weight: 700;
  color: var(--p-text);
}

.pslide-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 14px 24px;
  border-radius: 14px;
  font-size: 1rem;
  font-weight: 800;
  text-decoration: none;
  cursor: pointer;
  transition: transform 0.2s, opacity 0.2s;
  border: none;
}
.pslide-btn:hover {
  transform: translateY(-2px);
  opacity: 0.9;
}

/* Decorative Background Icon */
.pslide-icon-bg {
  position: absolute;
  left: -20px;
  bottom: -40px;
  width: 240px;
  height: 240px;
  opacity: 0.08;
  z-index: 1;
  pointer-events: none;
}
.pslide-icon-bg svg {
  width: 100%;
  height: 100%;
}


/* Swiper Controls Customization */
.swiper-pagination-bullet {
  background: var(--p-border);
  opacity: 1;
}
.swiper-pagination-bullet-active {
  background: #2563eb;
  width: 24px;
  border-radius: 10px;
}
.swiper-button-next, .swiper-button-prev {
  color: #2563eb;
  background: var(--p-card-bg);
  width: 48px;
  height: 48px;
  border-radius: 50%;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  margin-top: -24px;
}
.swiper-button-next::after, .swiper-button-prev::after {
  font-size: 20px;
  font-weight: bold;
}
.swiper-button-next:hover, .swiper-button-prev:hover {
  background: #2563eb;
  color: #fff;
}


/* ── EDITORIAL GRID (NO CARDS) ── */
.editorial-grid-section {
  max-width: 1200px;
  margin: 60px auto 140px;
  padding: 0 5%;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 80px;
  align-items: flex-start;
}
.eg-item {
  display: flex;
  flex-direction: column;
}
.eg-item:nth-child(2) {
  margin-top: 80px;
}
.eg-item:nth-child(3) {
  margin-top: 160px;
}
.eg-num {
  font-size: 6rem;
  font-weight: 900;
  line-height: 0.8;
  color: var(--p-text);
  opacity: 0.05;
  margin-bottom: -20px;
  z-index: 0;
}
.eg-title {
  font-size: 2rem;
  font-weight: 900;
  margin-bottom: 20px;
  position: relative;
  z-index: 1;
}
.eg-line {
  width: 60px;
  height: 4px;
  margin-bottom: 24px;
  border-radius: 4px;
}
.eg-desc {
  font-size: 1.1rem;
  line-height: 1.8;
  color: var(--p-text-muted);
}
@media (max-width: 992px) {
  .editorial-grid-section { grid-template-columns: 1fr; gap: 60px; margin-bottom: 60px; }
  .eg-item:nth-child(2), .eg-item:nth-child(3) { margin-top: 0; }
  .eg-num { font-size: 5rem; }
}

/* ── PREMIUM MESH CTA ── */
.premium-cta-section {
  position: relative;
  width: 100%;
  padding: 80px 20px;
  overflow: hidden;
  border-radius: 32px;
  text-align: center;
  background: var(--p-card-bg);
  border: 1px solid var(--p-border);
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
  margin-top: 40px;
  isolation: isolate;
}

/* Animated gradient blobs */
.cta-blob {
  position: absolute;
  filter: blur(80px);
  z-index: -1;
  border-radius: 50%;
  animation: floatCTA 10s infinite alternate ease-in-out;
}
.cta-blob-1 {
  width: 400px; height: 400px;
  background: rgba(37, 99, 235, 0.4);
  top: -100px; left: -100px;
}
.cta-blob-2 {
  width: 350px; height: 350px;
  background: rgba(236, 72, 153, 0.3);
  bottom: -100px; right: -50px;
  animation-delay: -5s;
}
.cta-blob-3 {
  width: 300px; height: 300px;
  background: rgba(245, 158, 11, 0.3);
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  animation: floatCTA 15s infinite alternate ease-in-out reverse;
}

@keyframes floatCTA {
  0% { transform: translate(0, 0) scale(1); }
  100% { transform: translate(50px, 50px) scale(1.2); }
}

[data-theme="light"] .cta-blob { opacity: 0.7; }
[data-theme="dark"] .cta-blob { opacity: 0.4; }

.pcta-title {
  font-size: clamp(28px, 4vw, 42px);
  font-weight: 900;
  line-height: 1.2;
  color: var(--p-text);
  margin-bottom: 16px;
  letter-spacing: -1px;
}
.pcta-desc {
  font-size: 1rem;
  color: var(--p-text-muted);
  max-width: 500px;
  margin: 0 auto 30px;
  line-height: 1.6;
}
.pcta-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 32px;
  font-size: 1rem;
  font-weight: 800;
  color: #fff;
  background: #0f172a;
  border-radius: 9999px;
  text-decoration: none;
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  border: 1px solid rgba(255,255,255,0.1);
  overflow: hidden;
  position: relative;
  cursor: pointer;
}
.pcta-btn::before {
  content: '';
  position: absolute;
  top: 0; left: -100%;
  width: 100%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: all 0.6s ease;
}
.pcta-btn:hover::before {
  left: 100%;
}
.pcta-btn:hover {
  transform: translateY(-4px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0,0,0,0.25);
  color: #fff;
}
[data-theme="dark"] .pcta-btn {
  background: #ffffff;
  color: #0f172a;
}
[data-theme="dark"] .pcta-btn::before {
  background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent);
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .hero-section-custom {
    flex-direction: column-reverse;
    text-align: center;
    gap: 32px;
  }
  .hero-image-area {
    width: 100%;
  }
  .pills-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .swiper-slide-custom {
    width: 100% !important; /* Full width on smaller screens */
    height: auto;
  }
  .pslide-inner {
    flex-direction: column;
    padding: 30px 20px;
  }
  .pslide-actions {
    border-left: none;
    border-top: 1px solid rgba(0,0,0,0.08);
    padding-left: 0;
    padding-top: 20px;
    width: 100%;
    flex: auto;
  }
  .closing-avatar-left {
    display: none;
  }
  .closing-content {
    max-width: 100%;
    text-align: center;
  }
  .closing-banner-custom {
    padding: 48px 24px;
    justify-content: center;
  }
/* ===== ANIMATION SYSTEM (Zajno-style) ===== */
.gv-reveal {
  opacity: 0;
  transform: translateY(60px) rotate(1.5deg);
  transform-origin: left center;
  transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1),
              transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
  will-change: opacity, transform;
}
.gv-reveal.is-visible { opacity: 1; transform: translateY(0) rotate(0deg); }
.gv-reveal.delay-1 { transition-delay: 0.1s; }
.gv-reveal.delay-2 { transition-delay: 0.2s; }
.gv-reveal.delay-3 { transition-delay: 0.3s; }
.gv-reveal.delay-4 { transition-delay: 0.4s; }
.gv-parallax-wrap { overflow: hidden; border-radius: inherit; }
.gv-parallax-img { transform: scale(1.12); will-change: transform; display: block; width: 100%; transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1); }
.gv-reveal.is-visible .gv-parallax-img { transform: scale(1); }
</style>

<div class="prog-wrapper">
  <div class="container-inner">

    <!-- HERO SECTION -->
    <section class="hero-section-custom">
      <div class="hero-content-prog">
        <div class="hero-badge-prog gv-reveal">
          <span>Our Programs</span>
        </div>
        <h1 class="hero-title-prog gv-reveal delay-1">
          Ekosistem Pemberdayaan <br>
          <span class="text-highlight">Guru Masa Depan</span>
        </h1>
        <p class="hero-desc-prog gv-reveal delay-2">
          Guruverse.ID menyediakan platform belajar, mengajar, dan berkolaborasi yang dirancang khusus untuk meningkatkan kompetensi, kreativitas, dan kesejahteraan guru di seluruh Indonesia.
        </p>
      </div>
      <div class="hero-image-area gv-parallax-wrap gv-reveal delay-3" style="border-radius:32px;">
        <img src="{{ asset('asset/img/hero-teachers.png') }}" class="hero-main-img gv-parallax-img" alt="Guruverse Teachers">
      </div>
    </section>

    <!-- HORIZONTAL PILLS -->
    <div class="pills-grid">
      <div class="pill-card-custom gv-reveal delay-1">
        <div>
          <div class="pill-text-title">Guru Belajar</div>
          <div class="pill-text-sub">Tumbuh</div>
        </div>
      </div>
      <div class="pill-card-custom gv-reveal delay-2">
        <div>
          <div class="pill-text-title">Guru Mengajar</div>
          <div class="pill-text-sub">Berdampak</div>
        </div>
      </div>
      <div class="pill-card-custom gv-reveal delay-3">
        <div>
          <div class="pill-text-title">Guru Inspira</div>
          <div class="pill-text-sub">Menginspirasi</div>
        </div>
      </div>
    </div>

    <!-- SWIPER SLIDESHOW -->
    <div class="swiper pillarSwiper">
      <div class="swiper-wrapper">
        
        <!-- SLIDE 1: GURU BELAJAR -->
        <div class="swiper-slide swiper-slide-custom gv-reveal delay-1">
          <div class="pslide-inner belajar-slide">
            <div class="pslide-content">
              <div class="pslide-badge" style="background: rgba(37,99,235,.1); color: #2563eb;">Pilar 1 — Learn</div>
              <h3 class="pslide-title" style="color:#1e3a8a;">Guru Belajar</h3>
              <p class="pslide-desc">Program peningkatan kompetensi pedagogik dan profesional melalui kursus intensif, webinar, dan sertifikasi resmi.</p>
            </div>
            <div class="pslide-actions">
              <div class="pslide-features">
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Belajar Fleksibel</span>
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg> Materi Terstruktur</span>
              </div>
              <a href="{{ route('register') }}" class="pslide-btn" style="background:#2563eb; color:#fff;">Mulai Belajar</a>
            </div>
            <div class="pslide-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#bfdbfe" stroke-width="1"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div>
          </div>
        </div>

        <!-- SLIDE 2: GURU MENGAJAR -->
        <div class="swiper-slide swiper-slide-custom gv-reveal delay-2">
          <div class="pslide-inner mengajar-slide">
            <div class="pslide-content">
              <div class="pslide-badge" style="background: rgba(245,158,11,.1); color: #f59e0b;">Pilar 2 — Teach</div>
              <h3 class="pslide-title" style="color:#78350f;">Guru Mengajar</h3>
              <p class="pslide-desc">Wadah berbagi praktik baik dan strategi mengajar kreatif antarsesama rekan pendidik. Setiap murid adalah masa depan bangsa.</p>
            </div>
            <div class="pslide-actions">
              <div class="pslide-features">
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg> Dashboard Personal</span>
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> Pelatihan Offline</span>
              </div>
              <a href="{{ route('register') }}" class="pslide-btn" style="background:#f59e0b; color:#fff;">Mulai Mengajar</a>
            </div>
            <div class="pslide-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#fde68a" stroke-width="1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
          </div>
        </div>

        <!-- SLIDE 3: GURU INSPIRA -->
        <div class="swiper-slide swiper-slide-custom gv-reveal delay-3">
          <div class="pslide-inner inspira-slide">
            <div class="pslide-content">
              <div class="pslide-badge" style="background: rgba(236,72,153,.1); color: #ec4899;">Pilar 3 — Inspire</div>
              <h3 class="pslide-title" style="color:#831843;">Guru Inspira</h3>
              <p class="pslide-desc">Ruang kolaborasi lintas daerah untuk membangun jejaring profesional dan saling mendukung dalam transformasi pendidikan.</p>
            </div>
            <div class="pslide-actions">
              <div class="pslide-features">
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> Forum Diskusi</span>
                <span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="2.5"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg> Kolaborasi Proyek</span>
              </div>
              <button class="pslide-btn" style="background:#ec4899; color:#fff; border:none;" onclick="window.open('https://wa.me/6283133531303','_blank')">Bergabung Komunitas</button>
            </div>
            <div class="pslide-icon-bg"><svg viewBox="0 0 24 24" fill="none" stroke="#fbcfe8" stroke-width="1"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
          </div>
        </div>

      </div>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
      <!-- Add Navigation -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>

    <!-- EDITORIAL GRID DESCRIPTIONS -->
    <div class="editorial-grid-section">
      <div class="eg-item gv-reveal delay-1">
        <div class="eg-num">01</div>
        <h4 class="eg-title" style="color:#2563eb;">Guru Belajar</h4>
        <div class="eg-line" style="background:#2563eb;"></div>
        <p class="eg-desc">Guru Belajar adalah program komprehensif yang didesain khusus untuk meningkatkan kompetensi pedagogik, profesional, dan kepribadian Anda. Melalui rangkaian kursus intensif interaktif, seri webinar eksklusif dengan pakar pendidikan, hingga program sertifikasi resmi, kami siap menemani perjalanan Anda menjadi pendidik abad 21 yang adaptif, inovatif, dan diakui secara nasional.</p>
      </div>

      <div class="eg-item gv-reveal delay-2">
        <div class="eg-num">02</div>
        <h4 class="eg-title" style="color:#d97706;">Guru Mengajar</h4>
        <div class="eg-line" style="background:#d97706;"></div>
        <p class="eg-desc">Lebih dari sekadar mengajar, ini adalah ruang aktualisasi diri. Guru Mengajar memfasilitasi Anda untuk berbagi modul ajar, praktik baik (best practice), dan strategi pembelajaran kreatif. Dengan dukungan Dashboard Personal terintegrasi, fitur Gamifikasi untuk memotivasi siswa, dan Impact Tracker, wujudkan pengalaman belajar yang bermakna.</p>
      </div>

      <div class="eg-item gv-reveal delay-3">
        <div class="eg-num">03</div>
        <h4 class="eg-title" style="color:#db2777;">Guru Inspira</h4>
        <div class="eg-line" style="background:#db2777;"></div>
        <p class="eg-desc">Sinergi adalah kunci transformasi. Guru Inspira menghadirkan ruang kolaborasi tanpa batas wilayah, di mana Anda dapat membangun jejaring profesional yang solid, merintis kolaborasi proyek lintas daerah, serta menemukan dukungan moral dari sesama pejuang pendidikan. Melalui diskusi interaktif di forum komunitas dan kurasi cerita inspiratif, temukan kembali energi dan semangat mengabdi Anda setiap harinya.</p>
      </div>
    </div>

    <!-- PREMIUM MESH CTA -->
    <div class="premium-cta-section gv-reveal delay-1">
      <div class="cta-blob cta-blob-1"></div>
      <div class="cta-blob cta-blob-2"></div>
      <div class="cta-blob cta-blob-3"></div>
      
      <div style="position:relative; z-index:2;">
        <h3 class="pcta-title">Satu Langkah Kecil,<br>Dampak Tanpa Batas.</h3>
        <p class="pcta-desc">Waktunya beralih dari rutinitas ke transformasi. Bergabunglah dengan ribuan pendidik lainnya untuk memajukan pendidikan Indonesia.</p>
        <button class="pcta-btn" onclick="window.location.href='{{ route('register') }}'">
          Mulai Perjalanan Anda
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:4px"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper('.pillarSwiper', {
    slidesPerView: 'auto',
    centeredSlides: true,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 1500,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      768: {
        slidesPerView: 'auto',
        spaceBetween: 30
      }
    }
  });
</script>
@endsection
