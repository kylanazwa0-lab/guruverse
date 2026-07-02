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
  background: #ffffff;
  border-color: #D2E3EB;
  box-shadow: 0 8px 32px rgba(9, 60, 93, 0.10);
}
[data-theme="light"] .belajar-slide {
  background: linear-gradient(135deg, #ffffff 60%, rgba(37, 99, 235, 0.06)) !important;
}
[data-theme="light"] .mengajar-slide {
  background: linear-gradient(135deg, #ffffff 60%, rgba(245, 158, 11, 0.06)) !important;
}
[data-theme="light"] .inspira-slide {
  background: linear-gradient(135deg, #ffffff 60%, rgba(236, 72, 153, 0.06)) !important;
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


/* ── CLOSING BANNER ── */
.closing-banner-custom {
  position: relative;
  background: linear-gradient(135deg, #1e3a8a 0%, #093C5D 100%);
  border-radius: 24px;
  padding: 40px 48px;
  overflow: hidden; /* Prevent rectangular image from sticking out */
  box-shadow: 0 12px 24px rgba(9, 60, 93, 0.15);
  margin-top: 60px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
.closing-avatar-left {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 45%;
  object-fit: cover;
  object-position: top center;
  z-index: 1;
  pointer-events: none;
  -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%);
  mask-image: linear-gradient(to right, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%);
  opacity: 0.8;
}
.closing-content {
  max-width: 55%;
  margin: 0;
  text-align: right;
  color: #fff;
  position: relative;
  z-index: 2;
}
.closing-title-text {
  font-size: clamp(20px, 3vw, 28px);
  font-weight: 800;
  margin-bottom: 12px;
  line-height: 1.2;
}
.closing-desc-text {
  font-size: 0.95rem;
  opacity: 0.9;
  line-height: 1.5;
  margin-bottom: 24px;
}
.closing-action-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 16px 36px;
  background: #ffffff;
  color: #093C5D;
  font-weight: 800;
  font-size: 1rem;
  border-radius: 16px;
  text-decoration: none;
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  transition: transform 0.2s, box-shadow 0.2s;
  border: none;
  cursor: pointer;
}
.closing-action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 30px rgba(0,0,0,0.2);
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
}
</style>

<div class="prog-wrapper">
  <div class="container-inner">

    <!-- HERO SECTION -->
    <section class="hero-section-custom">
      <div class="hero-content-prog">
        <div class="hero-badge-prog">
          <span>Our Programs</span>
        </div>
        <h1 class="hero-title-prog">
          Ekosistem Pemberdayaan <br>
          <span class="text-highlight">Guru Masa Depan</span>
        </h1>
        <p class="hero-desc-prog">
          Guruverse.ID menyediakan platform belajar, mengajar, dan berkolaborasi yang dirancang khusus untuk meningkatkan kompetensi, kreativitas, dan kesejahteraan guru di seluruh Indonesia.
        </p>
      </div>
      <div class="hero-image-area">
        <img src="{{ asset('asset/img/hero-teachers.png') }}" class="hero-main-img" alt="Guruverse Teachers">
      </div>
    </section>

    <!-- HORIZONTAL PILLS -->
    <div class="pills-grid">
      <div class="pill-card-custom">
        <div>
          <div class="pill-text-title">Guru Belajar</div>
          <div class="pill-text-sub">Tumbuh</div>
        </div>
      </div>
      <div class="pill-card-custom">
        <div>
          <div class="pill-text-title">Guru Mengajar</div>
          <div class="pill-text-sub">Berdampak</div>
        </div>
      </div>
      <div class="pill-card-custom">
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
        <div class="swiper-slide swiper-slide-custom">
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
        <div class="swiper-slide swiper-slide-custom">
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
        <div class="swiper-slide swiper-slide-custom">
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

    <!-- CLOSING BANNER -->
    <div class="closing-banner-custom">
      <img src="{{ asset('asset/img/modern_teacher_illustration.jfif') }}" class="closing-avatar-left" alt="Teacher Left" onerror="this.style.display='none'">
      <div class="closing-content">
        <h3 class="closing-title-text">Belajar. Mengajar. Menginspirasi.</h3>
        <p class="closing-desc-text">Dengan tiga pilar ini, Guruverse.ID membentuk ekosistem guru masa depan: guru yang kompeten, berdampak, dan menginspirasi generasi penerus bangsa.</p>
        <button class="closing-action-btn" onclick="window.location.href='{{ route('register') }}'">
          Gabung Sekarang — Gratis
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle;margin-left:6px"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
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
