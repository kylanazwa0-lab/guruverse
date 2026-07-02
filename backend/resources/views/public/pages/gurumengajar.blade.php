@extends('layouts.public')
@section('content')
<div id="pg-gurumengajar">
<style>
/* Theme adaptation for Guru Mengajar page */
#pg-gurumengajar {
  --page-primary: #2563eb;
  --page-primary-light: #60a5fa;
  --page-primary-dark: #1e40af;
  --page-primary-rgb: 37, 99, 235;
  --card-bg: var(--card, #1e1e2d);
  --card-text: var(--text, #f8fafc);
  --card-text-muted: var(--text-muted, #94a3b8);
  --card-text-dim: var(--text-muted, #64748b);
  --step-text: var(--text, #f8fafc);
  --icon-bg: rgba(var(--page-primary-rgb), 0.1);
  --icon-stroke: var(--page-primary-light, #60a5fa);
  --glow-color: rgba(var(--page-primary-rgb), 0.15);
  --border-color: var(--border, rgba(255, 255, 255, 0.1));
  font-family: 'Inter', 'Roboto', sans-serif;
}

[data-theme="dark"] #pg-gurumengajar {
  --text-main: #f8fafc;
  --text-muted: #94a3b8;
  --bg-main: #0f172a;
  --card-bg: #1e293b;
  --card-border: #334155;
  --page-primary: #3b82f6; /* Bright Blue for dark mode */
  --page-primary-dark: #1e3a8a; /* Deep Navy Blue */
  --page-primary-rgb: 59, 130, 246;
}

[data-theme="light"] #pg-gurumengajar {
  --page-primary: #093c5d;
  --page-primary-light: #1a5c8a;
  --page-primary-dark: #062a42;
  --page-primary-rgb: 9, 60, 93;
  --card-bg: #ffffff;
  --card-text: var(--text, #1e293b);
  --card-text-muted: var(--text-muted, #475569);
  --card-text-dim: var(--text-muted, #64748b);
  --step-text: var(--text, #1e293b);
  --icon-bg: rgba(var(--page-primary-rgb), 0.08);
  --icon-stroke: var(--page-primary, #093c5d);
  --glow-color: rgba(var(--page-primary-rgb), 0.12);
  --border-color: var(--border, #e2e8f0);
}

/* Base Styles & Typography */
#pg-gurumengajar .sec-title {
  font-size: clamp(1.75rem, 4vw, 2.5rem);
  font-weight: 800;
  text-align: center;
  margin-bottom: 0.5rem;
  color: var(--card-text);
  letter-spacing: -0.02em;
}
#pg-gurumengajar .sec-desc {
  text-align: center;
  color: var(--card-text-muted);
  font-size: clamp(1rem, 2vw, 1.125rem);
  max-width: 600px;
  margin: 0 auto 3rem;
  line-height: 1.6;
}

/* Animations */

@keyframes pulseGlow {
  0% { box-shadow: 0 0 0 0 var(--glow-color); }
  70% { box-shadow: 0 0 0 15px transparent; }
  100% { box-shadow: 0 0 0 0 transparent; }
}
@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
  100% { transform: translateY(0px); }
}



/* Custom Components */
#pg-gurumengajar .custom-badge-classroom { 
  background: var(--icon-bg); 
  color: var(--page-primary); 
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  border: 1px solid rgba(var(--page-primary-rgb), 0.2);
}

/* Hero Section */
.detail-hero {
  background: transparent; /* Menghilangkan gradasi agar warnanya menyatu dengan halaman */
  padding: 0 2rem 4rem 2rem; /* padding atas di-nol-kan agar mepet dengan header */
  position: relative;
  overflow: hidden;
}
.detail-hero-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 4rem;
}
.detail-hero-text {
  flex: 1;
}
.detail-title {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-weight: 800;
  line-height: 1.1;
  margin-bottom: 1.5rem;
  color: var(--card-text);
  letter-spacing: -0.03em;
}
.detail-title em {
  font-style: normal;
  color: var(--page-primary);
  background: linear-gradient(120deg, var(--page-primary), var(--page-primary-light));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  position: relative;
}
.detail-title em::after {
  content: '';
  position: absolute;
  bottom: 8px;
  left: 0;
  width: 100%;
  height: 8px;
  background: var(--glow-color);
  z-index: -1;
  border-radius: 4px;
}
.detail-subtitle {
  font-size: clamp(1rem, 2vw, 1.25rem);
  color: var(--card-text-muted);
  line-height: 1.6;
  margin-bottom: 2rem;
  max-width: 500px;
}
.detail-quote {
  display: inline-flex;
  align-items: flex-start;
  gap: 12px;
  padding: 1rem 1.5rem;
  background: var(--icon-bg);
  border-radius: 12px;
  border-left: 4px solid var(--page-primary);
  margin-bottom: 2.5rem;
  font-style: italic;
  color: var(--card-text);
  font-size: 0.95rem;
}
.detail-btns {
  display: flex;
  gap: 1rem;
  align-items: center;
  flex-wrap: wrap;
}
.btn-primary-custom {
  background: var(--page-primary);
  color: white;
  padding: 14px 32px;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 15px var(--glow-color);
}
.btn-primary-custom:hover {
  background: var(--page-primary-dark);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px var(--glow-color);
}
.btn-secondary-custom {
  background: transparent;
  color: var(--card-text);
  padding: 14px 24px;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  border: 1px solid var(--border-color);
  cursor: pointer;
}
.btn-secondary-custom:hover {
  background: var(--icon-bg);
  border-color: var(--page-primary);
  color: var(--page-primary);
}

.detail-img {
  flex: 1;
  position: relative;
  display: flex;
  justify-content: center;
}
.img-wrapper {
  position: relative;
  animation: float 6s ease-in-out infinite;
}
.custom-glow-effect { 
  background: radial-gradient(circle, var(--glow-color) 0%, transparent 60%); 
  position: absolute; 
  top: 50%; 
  left: 50%;
  transform: translate(-50%, -50%);
  width: 120%; 
  height: 120%; 
  z-index: 0; 
  filter: blur(60px);
  opacity: 0.3;
  pointer-events: none; /* Cegah efek cahaya menghalangi klik pada tombol */
}
.hero-image {
  width: 100%; 
  max-width: 550px; 
  position: relative; 
  z-index: 1;
  mix-blend-mode: darken; /* Makes the white background transparent against the light background */
}

/* Stats Section */
.stats-wrapper {
  padding: 3rem 2rem;
  background: linear-gradient(to right, transparent, var(--icon-bg), transparent);
  border-top: 1px solid var(--border-color);
  border-bottom: 1px solid var(--border-color);
}
.stats-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 2rem;
}
.stat-card {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 1rem;
  border-radius: 16px;
  transition: transform 0.3s ease;
}
.stat-card:hover {
  transform: translateY(-5px);
}
.custom-stat-icon-box { 
  background: var(--card-bg); 
  width: 56px; 
  height: 56px; 
  border-radius: 14px; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  box-shadow: 0 8px 16px var(--glow-color);
  border: 1px solid var(--border-color);
  flex-shrink: 0;
}
.custom-stat-icon-box svg { 
  stroke: var(--page-primary); 
  width: 28px;
  height: 28px;
}
.stat-num {
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--card-text);
  line-height: 1.2;
}
.stat-lbl {
  font-size: 0.85rem;
  color: var(--card-text-muted);
  font-weight: 500;
}

/* Features Section */
.content-section {
  padding: 6rem 2rem;
}
.content-inner {
  max-width: 1200px;
  margin: 0 auto;
}
.feat-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 24px;
  margin-top: 3rem;
}
.custom-feat-card { 
  background: var(--card-bg); 
  border: 1px solid var(--border-color); 
  padding: 2rem; 
  border-radius: 20px; 
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}
.custom-feat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, var(--page-primary), var(--page-primary-light));
  opacity: 0;
  transition: opacity 0.3s ease;
}
.custom-feat-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  border-color: var(--page-primary-light);
}
.custom-feat-card:hover::before {
  opacity: 1;
}
.fc-icon-wrap {
  width: 48px; 
  height: 48px; 
  border-radius: 12px; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  margin-bottom: 24px;
}
.fc-icon-wrap.primary { background: var(--page-primary); box-shadow: 0 8px 16px var(--glow-color); }
.fc-icon-wrap.secondary { background: var(--page-primary-light); box-shadow: 0 8px 16px rgba(167, 139, 250, 0.2); }
.fc-name { 
  color: var(--card-text); 
  font-size: 1.25rem; 
  font-weight: 700;
  margin-bottom: 12px;
}
.fc-desc { 
  color: var(--card-text-muted); 
  font-size: 0.95rem; 
  line-height: 1.5;
  margin-bottom: 24px;
}
.fc-list {
  list-style: none; 
  padding: 0; 
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.fc-list li { 
  color: var(--card-text-dim); 
  font-size: 0.85rem; 
  display: flex; 
  align-items: flex-start; 
  gap: 10px; 
  line-height: 1.4;
}
.fc-list li svg { 
  stroke: var(--page-primary); 
  flex-shrink: 0;
  margin-top: 2px;
}

/* Flow Section */
.alt-section {
  background: var(--icon-bg);
  border-top: 1px solid var(--border-color);
  border-bottom: 1px solid var(--border-color);
}
.program-flow {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
  margin-top: 4rem;
  position: relative;
}
.program-flow::before {
  content: '';
  position: absolute;
  top: 32px;
  left: 5%;
  right: 5%;
  height: 2px;
  background: var(--border-color);
  z-index: 0;
}
.program-flow-step {
  flex: 1;
  text-align: center;
  position: relative;
  z-index: 1;
}
.custom-step-icon, .custom-step-icon-alt { 
  width: 64px; 
  height: 64px; 
  border-radius: 50%; 
  color: white; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  margin: 0 auto 20px; 
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
}
.custom-step-icon {
  background: var(--page-primary); 
  box-shadow: 0 0 0 8px var(--card-bg), 0 10px 20px var(--glow-color);
}
.custom-step-icon-alt {
  background: var(--page-primary-light); 
  box-shadow: 0 0 0 8px var(--card-bg), 0 10px 20px rgba(167, 139, 250, 0.2);
}
.program-flow-step:hover .custom-step-icon,
.program-flow-step:hover .custom-step-icon-alt {
  transform: scale(1.1);
  animation: pulseGlow 2s infinite;
}
.custom-step-title { 
  color: var(--step-text); 
  font-weight: 700; 
  font-size: 1.05rem; 
  margin-bottom: 8px;
}
.step-desc {
  font-size: 0.85rem; 
  color: var(--card-text-muted);
  line-height: 1.4;
  padding: 0 10px;
}

/* Testimonial Section */
.testi-grid {
  display: grid; 
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
  gap: 32px;
  margin-top: 4rem;
}
.custom-testi-card { 
  background: var(--card-bg); 
  border: 1px solid var(--border-color); 
  padding: 2.5rem 2rem; 
  border-radius: 24px; 
  position: relative;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.custom-testi-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.05);
  border-color: var(--page-primary-light);
}
.quote-mark {
  position: absolute;
  top: 1.5rem;
  right: 2rem;
  font-size: 4rem;
  line-height: 1;
  color: var(--icon-bg);
  font-family: serif;
  font-weight: bold;
}
.quote-text { 
  color: var(--card-text); 
  font-size: 1.05rem; 
  line-height: 1.7; 
  margin-bottom: 2rem;
  position: relative;
  z-index: 1;
  font-style: italic;
}
.author-info {
  display: flex; 
  align-items: center; 
  gap: 16px;
  border-top: 1px solid var(--border-color);
  padding-top: 1.5rem;
}
.author-avatar {
  width: 50px; 
  height: 50px; 
  border-radius: 50%; 
  display:flex; 
  align-items:center; 
  justify-content:center; 
  font-weight:700; 
  color:#fff; 
  font-size:1.1rem; 
  flex-shrink:0;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.author-name { 
  color: var(--card-text);
  font-weight: 700; 
  font-size: 1rem;
  margin-bottom: 4px;
}
.author-school { 
  color: var(--page-primary); 
  font-size: 0.85rem;
  font-weight: 500;
}

/* CTA Banner */
.cta-banner-gm {
  background: #0a0a0a;
  border-radius: 24px;
  padding: 1px;
  margin: 0 2rem 4rem;
  overflow: hidden;
  position: relative;
  box-shadow: 0 30px 60px rgba(0,0,0,0.15);
}
.cta-bg-img {
  position: absolute; 
  left: -2%; 
  top: -2%; 
  width: 104%; 
  height: 104%; 
  opacity: 0.5; 
  z-index: 0;
  object-fit: cover;
  object-position: center 40%;
  filter: blur(4px);
  mix-blend-mode: normal;
}
.cta-inner {
  position: relative; 
  z-index: 1; 
  max-width: 700px;
  margin: 0 auto;
  padding: 1.5rem 2rem;
  text-align: center;
}
.cta-title { 
  font-size: clamp(1.25rem, 2.5vw, 1.5rem); 
  font-weight: 800;
  margin-bottom: 0.25rem;
  color: #ffffff;
}
.cta-sub { 
  font-size: clamp(0.8rem, 1.2vw, 0.9rem);
  color: rgba(255,255,255,0.9);
  margin-bottom: 1rem;
  line-height: 1.4;
}
.btn-cta {
  background: #ffffff; 
  color: var(--page-primary-dark); 
  font-weight: 700; 
  padding: 12px 24px; 
  border-radius: 10px; 
  font-size: 0.9rem; 
  text-decoration:none; 
  display:inline-flex; 
  align-items:center; 
  gap:10px;
  transition: all 0.3s ease;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.btn-cta:hover {
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}
.cta-features {
  display: flex; 
  justify-content: center; 
  gap: 16px; 
  margin-top: 1.25rem; 
  color: rgba(255,255,255,0.9); 
  font-size: 0.75rem; 
  flex-wrap: wrap;
  font-weight: 500;
}
.cta-feat-item {
  display: flex; 
  align-items: center; 
  gap: 6px;
  background: rgba(255,255,255,0.1);
  padding: 6px 12px;
  border-radius: 20px;
  backdrop-filter: blur(4px);
}

/* Breadcrumb */
.detail-breadcrumb {
  padding: 1.5rem 0 3rem 0; /* Jarak kecil agar tidak terlalu berdempetan dengan garis header */
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
  z-index: 20; /* Pastikan selalu bisa diklik */
}
.breadcrumb-back {
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  color: var(--card-text);
  padding: 8px 16px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  font-size: 0.85rem;
  font-weight: 600;
  transition: all 0.2s ease;
}
.breadcrumb-back:hover {
  background: var(--icon-bg);
  border-color: var(--page-primary);
  color: var(--page-primary);
}
.breadcrumb-trail {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.85rem;
  color: var(--card-text-muted);
}
.breadcrumb-trail .current {
  color: var(--page-primary);
  font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .detail-hero-inner {
    flex-direction: column;
    text-align: center;
    gap: 3rem;
  }
  .detail-quote {
    text-align: left;
    margin: 0 auto 2.5rem;
    display: inline-flex;
  }
  .detail-btns {
    justify-content: center;
  }
  .program-flow {
    flex-direction: column;
    gap: 2rem;
  }
  .program-flow::before {
    top: 0;
    bottom: 0;
    left: 32px;
    width: 2px;
    height: auto;
  }
  .program-flow-step {
    display: flex;
    align-items: center;
    text-align: left;
    gap: 1.5rem;
    width: 100%;
  }
  .custom-step-icon, .custom-step-icon-alt {
    margin: 0;
    flex-shrink: 0;
  }
  .step-text-content {
    flex: 1;
  }
  .step-desc {
    padding: 0;
  }
}

@media (max-width: 768px) {
  .detail-hero { padding: 2rem 1rem; }
  .content-section { padding: 4rem 1rem; }
  .cta-banner-gm { margin: 0 1rem 3rem; }
  .stats-wrapper { padding: 2rem 1rem; }
  .cta-inner { padding: 3rem 1.5rem; }
  .program-flow-step { gap: 1rem; }
}
</style>

{{-- HERO --}}
<section class="detail-hero">
  <div class="detail-breadcrumb">
    <button class="breadcrumb-back" onclick="window.location.href='{{ route('home') }}'">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      Kembali
    </button>
    <span class="breadcrumb-trail">
      <span>Beranda</span>
      <span class="sep">/</span>
      <span>Partner</span>
      <span class="sep">/</span>
      <span class="current">Guru Mengajar</span>
    </span>
  </div>

  <div class="detail-hero-inner gv-reveal">
    <div class="detail-hero-text">
      <div style="margin-bottom: 1.25rem; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <span class="custom-badge-classroom">PARTNER</span>
        <span class="custom-badge-classroom">CLASSROOM HUB</span>
      </div>
      <h1 class="detail-title">Guru <em>Mengajar</em></h1>
      <p class="detail-subtitle">Satu ekosistem cerdas untuk mengelola, melacak, dan menginspirasi pembelajaran yang bermakna.</p>

      <div class="detail-quote gv-reveal delay-1">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="custom-quote-svg" style="flex-shrink: 0; stroke: var(--page-primary);"><path d="M3 21c3 0 7-1 7-8V5H3v8h4c0 5-4 8-4 8zM14 21c3 0 7-1 7-8V5h-7v8h4c0 5-4 8-4 8z" fill="currentColor"/></svg>
        <span>"Menghubungkan guru, data, dan inspirasi dalam satu dashboard masa depan."</span>
      </div>

      <div class="detail-btns gv-reveal delay-2">
        <a href="{{ route('register') }}" class="btn-primary-custom">
          Mulai Daftar
        
        </a>
        <button class="btn-secondary-custom" onclick="document.getElementById('fitur-utama').scrollIntoView({behavior: 'smooth'})">
          Pelajari Fitur
        </button>
      </div>
    </div>
    <div class="detail-img gv-reveal delay-3">
      <div class="img-wrapper">
        <div class="custom-glow-effect"></div>
        <img src="{{ asset('asset/img/hero_classroom_hub.png') }}" alt="Classroom Hub" class="hero-image">
      </div>
    </div>
  </div>
</section>

{{-- STATS --}}
<div class="stats-wrapper">
  <div class="stats-inner">
    <div class="stat-card">
      <div class="custom-stat-icon-box">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div>
        <div class="stat-num">500K+</div>
        <div class="stat-lbl">Komunitas Aktif</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="custom-stat-icon-box">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      </div>
      <div>
        <div class="stat-num">25K+</div>
        <div class="stat-lbl">Diskusi Terbentuk</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="custom-stat-icon-box">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      </div>
      <div>
        <div class="stat-num">1.2M+</div>
        <div class="stat-lbl">Materi Belajar</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="custom-stat-icon-box">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="stat-num">100%</div>
        <div class="stat-lbl">Partisipasi Aktif</div>
      </div>
    </div>
  </div>
</div>

{{-- FITUR UTAMA --}}
<div class="content-section" id="fitur-utama">
  <div class="content-inner">
    <div class="sec-title gv-reveal">Fitur Utama Guru Mengajar</div>
    <div class="sec-desc gv-reveal delay-1">Semua yang kamu butuhkan untuk mengajar lebih efektif, terorganisir, dan berdampak bagi murid.</div>

    <div class="feat-grid">
      {{-- Dashboard Personal --}}
      <div class="custom-feat-card gv-reveal delay-1">
        <div class="fc-icon-wrap primary">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
        </div>
        <div class="fc-name">Dashboard Personal</div>
        <div class="fc-desc">Kelola semua aktivitas mengajar dalam satu dashboard terintegrasi yang mudah digunakan.</div>
        <ul class="fc-list">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Kelas &amp; jadwal mengajar</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Rencana pembelajaran</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Penilaian &amp; refleksi</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Analitik perkembangan kelas</li>
        </ul>
      </div>

      {{-- Gamifikasi --}}
      <div class="custom-feat-card gv-reveal delay-2">
        <div class="fc-icon-wrap secondary">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9a6 6 0 1 0 12 0"/><path d="M12 15v6"/><path d="M7 21h10"/><path d="M12 3v3"/></svg>
        </div>
        <div class="fc-name">Gamifikasi</div>
        <div class="fc-desc">Belajar &amp; berkontribusi jadi lebih seru dengan sistem gamifikasi yang interaktif.</div>
        <ul class="fc-list">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Poin &amp; level pencapaian</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Badge &amp; achievement</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Leaderboard guru inspiratif</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Reward menarik</li>
        </ul>
      </div>

      {{-- Impact Tracker --}}
      <div class="custom-feat-card gv-reveal delay-3">
        <div class="fc-icon-wrap primary">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div class="fc-name">Impact Tracker</div>
        <div class="fc-desc">Pantau dampak pembelajaran terhadap murid &amp; komunitas secara terukur dan presisi.</div>
        <ul class="fc-list">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Tracking keterlibatan murid</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Capaian kompetensi</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Dampak ke komunitas</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Laporan otomatis</li>
        </ul>
      </div>

      {{-- Pelatihan Offline --}}
      <div class="custom-feat-card gv-reveal delay-4">
        <div class="fc-icon-wrap secondary">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="fc-name">Pelatihan Offline</div>
        <div class="fc-desc">Tingkatkan kompetensimu melalui pelatihan tatap muka berkualitas bersama ahli.</div>
        <ul class="fc-list">
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Workshop praktik mengajar</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Pendampingan langsung</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Sertifikat resmi</li>
          <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Jaringan &amp; kolaborasi</li>
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- ALUR --}}
<div class="content-section alt-section">
  <div class="content-inner">
    <div class="sec-title gv-reveal">Alur Guru Mengajar</div>
    <div class="sec-desc gv-reveal delay-1">Perjalanan sistematis dari perencanaan hingga menciptakan dampak nyata</div>

    <div class="program-flow gv-reveal delay-2">
      <div class="program-flow-step">
        <div class="custom-step-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
        </div>
        <div class="step-text-content">
          <div class="custom-step-title">1. Rencanakan</div>
          <div class="step-desc">Buat rencana pembelajaran yang terstruktur dan efektif untuk mencapai tujuan.</div>
        </div>
      </div>
      
      <div class="program-flow-step">
        <div class="custom-step-icon-alt">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
        </div>
        <div class="step-text-content">
          <div class="custom-step-title">2. Laksanakan</div>
          <div class="step-desc">Implementasikan kurikulum dengan metode kreatif dan alat bantu mengajar.</div>
        </div>
      </div>
      
      <div class="program-flow-step">
        <div class="custom-step-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </div>
        <div class="step-text-content">
          <div class="custom-step-title">3. Libatkan</div>
          <div class="step-desc">Libatkan murid secara aktif dalam proses pembelajaran interaktif.</div>
        </div>
      </div>
      
      <div class="program-flow-step">
        <div class="custom-step-icon-alt">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
        </div>
        <div class="step-text-content">
          <div class="custom-step-title">4. Evaluasi</div>
          <div class="step-desc">Lakukan evaluasi berkelanjutan dan refleksi untuk peningkatan kualitas.</div>
        </div>
      </div>
      
      <div class="program-flow-step">
        <div class="custom-step-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <div class="step-text-content">
          <div class="custom-step-title">5. Berdampak</div>
          <div class="step-desc">Ciptakan dampak positif nyata bagi masa depan generasi bangsa.</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- TESTIMONI --}}
<div class="content-section">
  <div class="content-inner">
    <div class="sec-title gv-reveal">Guru Hebat, Dampak Nyata</div>
    <div class="sec-desc gv-reveal delay-1">Kisah inspiratif dari para pendidik yang telah menggunakan Guru Mengajar</div>

    <div class="testi-grid">
      <div class="custom-testi-card gv-reveal delay-1">
        <div class="quote-mark">"</div>
        <div class="quote-text">Dashboard Guru Mengajar sangat membantu saya mengelola kelas dengan lebih terstruktur dan efisien. Waktu administrasi berkurang drastis sehingga saya bisa fokus mengajar.</div>
        <div class="author-info">
          <div class="author-avatar" style="background: linear-gradient(135deg, #4361ee, #7b2ff7);">RS</div>
          <div>
            <div class="author-name">Rini Susanti</div>
            <div class="author-school">SDN 2 Bandung</div>
          </div>
        </div>
      </div>

      <div class="custom-testi-card gv-reveal delay-2">
        <div class="quote-mark">"</div>
        <div class="quote-text">Pelatihan offline-nya sangat aplikatif, langsung bisa saya terapkan di kelas. Murid-murid jadi jauh lebih antusias dan aktif berkat metode gamifikasi yang diajarkan.</div>
        <div class="author-info">
          <div class="author-avatar" style="background: linear-gradient(135deg, #06d6a0, #00b4d8);">HW</div>
          <div>
            <div class="author-name">Hendra Wijaya</div>
            <div class="author-school">SMPN 3 Jakarta</div>
          </div>
        </div>
      </div>

      <div class="custom-testi-card gv-reveal delay-3">
        <div class="quote-mark">"</div>
        <div class="quote-text">Melalui Impact Tracker, saya bisa melihat perkembangan setiap murid secara nyata dan terukur. Laporan otomatisnya sangat memudahkan komunikasi dengan orang tua.</div>
        <div class="author-info">
          <div class="author-avatar" style="background: linear-gradient(135deg, #f8961e, #f3722c);">DN</div>
          <div>
            <div class="author-name">Dewi Nurhaliza</div>
            <div class="author-school">SMAN 1 Surabaya</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- CTA BANNER --}}
<div class="cta-banner-gm gv-reveal">
  <img src="{{ asset('asset/img/bg-cta.png') }}" alt="Community" class="cta-bg-img">
  <div class="cta-inner">
    <h2 class="cta-title">Bergabung bersama 5.200+ Guru</h2>
    <p class="cta-sub">Bersama kita bisa - saling menguatkan, berbagi ilmu, berkolaborasi dan membangun masa depan pendidikan Indonesia yang lebih cemerlang.</p>
    
    <a href="{{ route('register') }}" class="btn-cta">
      Gabung Komunitas Sekarang
    </a>
    
    <div class="cta-features">
      <span class="cta-feat-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> 
        Akses Gratis
      </span>
      <span class="cta-feat-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> 
        Komunitas Aktif
      </span>
      <span class="cta-feat-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> 
        Skala Nasional
      </span>
    </div>
  </div>
</div>
</div>
@endsection
