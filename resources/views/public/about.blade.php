@extends('layouts.public')

@section('content')
<style>
/* ===== HERO ===== */
.about-hero{
  position:relative;
  min-height:450px;
  display:flex;align-items:center;justify-content:center;
  text-align:center;
  padding:80px 5% 60px;
  background:var(--navy);
  overflow:hidden;
  color:#fff;
}
.about-hero::before{
  content:'';
  position:absolute;
  inset:-20px; /* scale up slightly to hide blurred edges */
  background:url('{{ asset("asset/img/about-hero-bg.jpg") }}') center/cover no-repeat;
  filter:blur(3px) brightness(0.45); /* reduced blur, slightly brighter */
  z-index:0;
}
.hero-content{position:relative;z-index:1;max-width:720px;}
.hero-badge{
  display:inline-block;
  background:rgba(255,255,255,.25);border:1px solid rgba(255,255,255,.55);
  color:#fff;font-size:11px;font-weight:800;padding:6px 18px;
  border-radius:20px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:24px;
  text-shadow: 0 1px 4px rgba(0,0,0,.4);
}
.hero-title{font-size:clamp(28px, 4vw, 44px);font-weight:900;line-height:1.1;margin-bottom:20px;color:#fff;letter-spacing:-0.03em;
  text-shadow: 0 2px 16px rgba(0,0,0,.5);
}
.hero-title em{color:#a5f3fc;font-style:normal;}
.hero-quote{
  font-size:0.95rem;color:rgba(255,255,255,.92);line-height:1.8;max-width:560px;margin:0 auto;
  font-style:italic;
  text-shadow: 0 1px 8px rgba(0,0,0,.4);
}

/* ===== STORY SECTION ===== */
.story-container{
  background:var(--bg);
  border-radius:48px;
  padding:60px 5%;
  margin:24px 2% 20px;
  border:1px solid var(--border);
}
.story-inner{max-width:1100px;margin:0 auto;}
.section-badge{
  font-size:11px;color:#a78bfa;font-weight:800;
  letter-spacing:1.5px;text-transform:uppercase;margin-bottom:16px;
  display: block;
}
.about-section-title{
  font-size:clamp(22px, 3vw, 32px);font-weight:800;
  line-height:1.2;margin-bottom:20px;color:var(--text);
}
.about-section-title em{color:var(--purple);font-style:normal;}
.story-grid{
  display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;
}
.story-text p{
  color:var(--text-muted);font-size:0.9rem;line-height:1.8;margin-bottom:18px;
}
.story-text strong{
  color:var(--text);
}
.visual-card{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:24px;padding:32px;
  box-shadow:0 20px 40px -10px rgba(10,7,24,0.05);
}
.visual-title{font-size:1.1rem;font-weight:800;color:var(--text);margin-bottom:10px;}
.visual-desc{color:var(--text-muted);font-size:0.85rem;line-height:1.7;}

/* ===== PILLARS ===== */
.pillars-section{padding:32px 5% 60px;}
.pillars-grid{
  display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:24px;
  margin-top:40px;
}
.about-pillar-card{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:24px;padding:32px;
  position: relative; overflow: hidden;
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease, border-color 0.4s ease;
  z-index: 1;
}
.about-pillar-card::before {
  content: ''; position: absolute;
  top: 0; left: -100%; width: 50%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
  transform: skewX(-20deg);
  transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: -1;
}
.about-pillar-card:hover{
  transform: translateY(-10px) scale(1.02);
  border-color: var(--purple);
  box-shadow: 0 24px 48px -12px rgba(124, 58, 237, 0.15);
}
.about-pillar-card:hover::before {
  left: 200%;
}
.pillar-name{font-size:1.1rem;font-weight:800;color:var(--text);margin-bottom:12px;}
.about-pillar-card .pillar-desc{color:var(--text-muted);font-size:0.85rem;line-height:1.7;}

/* ===== CONTACT & MAP FOOTER — PREMIUM REDESIGN ===== */
.about-contact{
  padding: 80px 5% 0;
  background: linear-gradient(180deg, #0d0a28 0%, #0a0820 100%);
  border-top: 1px solid rgba(124,58,237,.25);
  position: relative; overflow: hidden;
}
.about-contact::before {
  content: '';
  position: absolute; top: -100px; left: 50%;
  transform: translateX(-50%);
  width: 700px; height: 400px;
  background: radial-gradient(ellipse, rgba(124,58,237,.2) 0%, transparent 70%);
  pointer-events: none;
}
.about-contact-inner{
  max-width: 1200px; margin: 0 auto;
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 56px; align-items: start;
  position: relative; z-index: 1;
}
.contact-logo{ margin-bottom: 20px; }
.contact-logo img{ height: 40px; object-fit: contain; }
.contact-tagline{
  font-size: .93rem; color: rgba(255,255,255,.6); line-height: 1.8;
  margin-bottom: 28px; max-width: 400px;
}
/* Contact items — glassmorphism cards */
.contact-items{ display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
.contact-item{
  display: flex; align-items: flex-start; gap: 14px;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.08);
  border-radius: 14px; padding: 14px 16px;
  transition: background .25s, border-color .25s;
}
.contact-item:hover {
  background: rgba(124,58,237,.12);
  border-color: rgba(124,58,237,.3);
}
.contact-icon{
  width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  background: rgba(124,58,237,.2); border: 1px solid rgba(124,58,237,.35);
}
.contact-item-text{}
.contact-item-label{
  font-size: 10px; font-weight: 700; color: rgba(255,255,255,.4);
  text-transform: uppercase; letter-spacing: .1em; margin-bottom: 3px;
}
.contact-item-value{ font-size: .88rem; color: rgba(255,255,255,.88); font-weight: 600; line-height: 1.5; }
.contact-item-value a{ color: rgba(255,255,255,.88); text-decoration: none; transition: color .2s; }
.contact-item-value a:hover{ color: #a78bfa; }
/* Sosmed */
.sosmed-title{ font-size: 10px; font-weight: 800; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .12em; margin-bottom: 12px; }
.sosmed-row{ display: flex; gap: 10px; flex-wrap: wrap; }
.sosmed-btn{
  display: inline-flex; align-items: center; gap: 8px;
  padding: 9px 18px; border-radius: 50px;
  font-size: 12px; font-weight: 700;
  border: 1px solid; text-decoration: none;
  transition: all .25s;
}
.sosmed-btn.instagram{ background: rgba(225,48,108,.1); border-color: rgba(225,48,108,.3); color: #f472b6; }
.sosmed-btn.instagram:hover{ background: rgba(225,48,108,.22); transform: translateY(-2px); }
.sosmed-btn.whatsapp{ background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.3); color: #4ade80; }
.sosmed-btn.whatsapp:hover{ background: rgba(34,197,94,.22); transform: translateY(-2px); }
/* Map */
.map-col{}
.map-label{ font-size: 10px; font-weight: 800; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .12em; margin-bottom: 14px; }
.map-wrapper{
  border-radius: 20px; overflow: hidden;
  border: 1px solid rgba(124,58,237,.3);
  box-shadow: 0 20px 60px rgba(0,0,0,.5);
  line-height: 0;
}
.map-wrapper iframe{ width: 100%; height: 280px; border: none; display: block; }
.map-open-link{
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 12px; font-size: 12px; font-weight: 700;
  color: #a78bfa; text-decoration: none; transition: color .2s;
}
.map-open-link:hover{ color: #fff; }
/* Quick contact card styling */
.quick-contact-card {
  margin-top: 24px;
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 18px; padding: 22px;
}
.quick-contact-label {
  font-size: 10px; font-weight: 800; color: #a78bfa;
  text-transform: uppercase; letter-spacing: .12em; margin-bottom: 14px;
}
.quick-contact-btn {
  display: flex; align-items: center; gap: 12px;
  padding: 13px 18px; border-radius: 12px;
  font-size: 13px; font-weight: 700; text-decoration: none;
  transition: all .2s; margin-bottom: 10px; border: 1px solid;
}
.quick-contact-btn:last-child { margin-bottom: 0; }
.quick-contact-btn.wa {
  background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.25); color: #4ade80;
}
.quick-contact-btn.wa:hover { background: rgba(34,197,94,.2); transform: translateX(4px); }
.quick-contact-btn.email {
  background: rgba(96,165,250,.1); border-color: rgba(96,165,250,.25); color: #60a5fa;
}
.quick-contact-btn.email:hover { background: rgba(96,165,250,.2); transform: translateX(4px); }

/* Footer bottom bar */
.about-footer-bar{
  max-width: 100%;
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 12px;
  padding: 22px 5%; margin-top: 72px;
  background: rgba(0,0,0,.4);
  border-top: 1px solid rgba(124,58,237,.2);
  font-size: 12px; font-weight: 500;
  color: rgba(255,255,255,.4);
  position: relative; z-index: 1;
}
.about-footer-links{ display: flex; gap: 24px; }
.about-footer-links a{ color: rgba(255,255,255,.4); text-decoration: none; transition: color .2s; }
.about-footer-links a:hover{ color: #a78bfa; }


@media(max-width:900px){
  .story-grid{grid-template-columns:1fr; gap:40px;}
  .story-container{border-radius:32px;}
  .about-contact-inner{grid-template-columns:1fr;gap:40px;}
  .map-wrapper iframe{height:260px;}
}
@media(max-width:640px){
  .about-contact{padding:48px 5% 0;}
  .about-footer-bar{flex-direction:column;align-items:flex-start;}
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
.gv-parallax-img { transform: scale(1.12); will-change: transform; display: block; width: 100%; }

/* ===== LIGHT MODE: PAKSA WARNA TEKS AGAR SELALU TERLIHAT ===== */
[data-theme="light"] .section-badge            { color: #093C5D !important; font-weight: 800 !important; }
[data-theme="light"] .about-section-title       { color: #092B40 !important; }
[data-theme="light"] .about-section-title em    { color: #093C5D !important; }
[data-theme="light"] .story-text p              { color: #1e3a4f !important; }
[data-theme="light"] .story-text strong         { color: #092B40 !important; }
[data-theme="light"] .story-inner               { color: #092B40 !important; }
[data-theme="light"] .story-container           { background: #ffffff !important; border-color: #D2E3EB !important; }
[data-theme="light"] .visual-card               { background: #EBF4FA !important; border-color: #D2E3EB !important; }
[data-theme="light"] .visual-title              { color: #092B40 !important; }
[data-theme="light"] .visual-desc               { color: #1e3a4f !important; }
[data-theme="light"] .pillars-section           { background: #F5F8FA !important; }

/* ===== PREMIUM LIGHT MODE CONTACT ===== */
[data-theme="light"] .about-contact {
  background: #F8FAFC !important;
  border-top: 1px solid #E2E8F0 !important;
}
[data-theme="light"] .about-contact::before {
  background: radial-gradient(ellipse, rgba(124,58,237,.06) 0%, transparent 70%);
}
[data-theme="light"] .contact-tagline { color: #64748B !important; }
[data-theme="light"] .contact-item {
  background: #FFFFFF !important;
  border: 1px solid #E2E8F0 !important;
  box-shadow: 0 4px 20px rgba(0,0,0,.02);
}
[data-theme="light"] .contact-item:hover {
  border-color: #a78bfa !important; box-shadow: 0 4px 20px rgba(124,58,237,.08);
}
[data-theme="light"] .contact-icon {
  background: #F1F5F9 !important; border-color: #E2E8F0 !important; color: #a78bfa;
}
[data-theme="light"] .contact-item-label { color: #94A3B8 !important; }
[data-theme="light"] .contact-item-value { color: #0F172A !important; }
[data-theme="light"] .contact-item-value a { color: #0F172A !important; }
[data-theme="light"] .contact-item-value a:hover { color: #a78bfa !important; }
[data-theme="light"] .sosmed-title, [data-theme="light"] .map-label { color: #94A3B8 !important; }
[data-theme="light"] .sosmed-btn { background: #FFFFFF !important; box-shadow: 0 2px 10px rgba(0,0,0,.03); }
[data-theme="light"] .map-wrapper { border-color: #E2E8F0 !important; box-shadow: 0 20px 40px rgba(0,0,0,.06); }
[data-theme="light"] .map-open-link { color: #a78bfa !important; }
[data-theme="light"] .map-open-link:hover { color: #7c3aed !important; }

[data-theme="light"] .quick-contact-card {
  background: #FFFFFF !important;
  border: 1px solid #E2E8F0 !important;
  box-shadow: 0 10px 30px rgba(0,0,0,.03);
}
[data-theme="light"] .quick-contact-label { color: #a78bfa !important; }
[data-theme="light"] .quick-contact-btn { background: #FFFFFF !important; }

[data-theme="light"] .about-footer-bar {
  background: #FFFFFF !important;
  border-top: 1px solid #E2E8F0 !important;
  color: #64748B !important;
}
[data-theme="light"] .about-footer-links a { color: #64748B !important; }
[data-theme="light"] .about-footer-links a:hover { color: #0F172A !important; }

[data-theme="light"] .about-pillar-card         { background: #ffffff !important; border-color: #D2E3EB; }
[data-theme="light"] .about-pillar-card:hover   { border-color: #a78bfa !important; box-shadow: 0 24px 48px -12px rgba(124, 58, 237, 0.1); }
[data-theme="light"] .about-pillar-card::before { background: linear-gradient(90deg, transparent, rgba(124,58,237,0.04), transparent); }
[data-theme="light"] .pillar-name               { color: #092B40 !important; }
[data-theme="light"] .about-pillar-card .pillar-desc { color: #1e3a4f !important; }
[data-theme="light"] .about-footer-bar          { color: #3D6175 !important; border-top-color: #D2E3EB !important; }
[data-theme="light"] .about-footer-links a      { color: #3D6175 !important; }
[data-theme="light"] .about-footer-links a:hover{ color: #093C5D !important; }

/* Contact section light mode overrides removed so premium dark design applies to both */
</style>

<section class="about-hero">
  <div class="hero-content">
    {{-- No gv-reveal on hero: these are above the fold, show immediately --}}
    <span class="hero-badge">Tentang Kami</span>
    <h1 class="hero-title">Ruang Semesta untuk<br/><em>Guru Indonesia</em></h1>
    <p class="hero-quote">
      "Di setiap peradaban besar, selalu ada peran guru yang bekerja dalam sunyi… Menanam harapan, membentuk masa depan."
    </p>
  </div>
</section>

<div class="story-container">
  <div class="story-inner">
    <span class="section-badge gv-reveal">Cerita Kami</span>
    <h2 class="about-section-title gv-reveal delay-1">Guruverse.ID bukan<br/>sekadar <em>nama</em></h2>
    <div class="story-grid">
      <div class="story-text gv-reveal delay-2">
        <p>
          Guruverse.ID adalah <strong>manifestasi dari ekosistem yang dibangun oleh ACF Eduhub</strong>.
          Sebuah ruang semesta peningkatan kompetensi guru.
        </p>
        <p>
          Kami menghadirkan <strong>Learning &amp; Teaching Management System (LTMS)</strong> untuk guru —
          modul, pelatihan, dan komunitas yang membantu guru Indonesia menjadi lebih kompeten.
        </p>
      </div>
      <div class="visual-card gv-reveal delay-3">
        <h3 class="visual-title">ACF Eduhub</h3>
        <p class="visual-desc">
          Ekosistem pendidikan yang telah melayani ribuan guru Indonesia dengan
          platform, konten, dan komunitas berkualitas tinggi.
        </p>
      </div>
    </div>
  </div>
</div>

<section class="pillars-section">
  <div style="text-align:center; max-width:600px; margin:0 auto;">
    <span class="section-badge gv-reveal" style="display:inline-block;">Tiga Pilar Utama</span>
    <h2 class="about-section-title gv-reveal delay-1">Ekosistem <em>Terpadu</em> untuk Guru</h2>
  </div>
  <div class="pillars-grid">
    <div class="about-pillar-card gv-reveal delay-1">
      <h3 class="pillar-name">Guru Belajar</h3>
      <p class="pillar-desc">Akses Kelas Online, Webinar eksklusif, dan raih Sertifikat Digital resmi untuk menunjang karier profesional.</p>
    </div>
    <div class="about-pillar-card gv-reveal delay-2">
      <h3 class="pillar-name">Guru Mengajar</h3>
      <p class="pillar-desc">Melalui Dashboard Personal, Gamifikasi, Impact Tracker, dan Pelatihan Offline yang berdampak.</p>
    </div>
    <div class="about-pillar-card gv-reveal delay-3">
      <h3 class="pillar-name">Guru Inspira</h3>
      <p class="pillar-desc">Wadah Forum Diskusi, Kolaborasi Proyek lintas sekolah, serta kumpulan Cerita Inspiratif.</p>
    </div>
  </div>
</section>

{{-- ===== CONTACT, SOSMED & MAP FOOTER ===== --}}
<footer class="about-contact">
  <div class="about-contact-inner">

    {{-- Kolom Kiri: Info Kontak & Sosmed --}}
    <div class="contact-info-col gv-reveal">
      <div class="contact-logo">
        <img src="{{ asset('asset/img/FA Logo Guruverse.ID - nrgative.png') }}" alt="Guruverse.ID">
      </div>
      <p class="contact-tagline">
        Satu platform ekosistem kompetensi guru Indonesia. Kami siap membantu perjalanan belajar dan mengajar Anda.
      </p>

      <div class="contact-items">
        {{-- Alamat --}}
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
          </div>
          <div class="contact-item-text">
            <div class="contact-item-label">Alamat</div>
            <div class="contact-item-value">Jl. Jati Mulya No.9, Gumuruh<br>Kec. Batununggal, Kota Bandung<br>Jawa Barat 40275</div>
          </div>
        </div>

        {{-- WhatsApp --}}
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <div class="contact-item-text">
            <div class="contact-item-label">WhatsApp</div>
            <div class="contact-item-value">
              <a href="https://wa.me/6283133531303" target="_blank">+62 831-3353-1303</a>
            </div>
          </div>
        </div>

        {{-- Email --}}
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
            </svg>
          </div>
          <div class="contact-item-text">
            <div class="contact-item-label">Email</div>
            <div class="contact-item-value">
              <a href="https://mail.google.com/mail/?view=cm&to=guruverse@acf.or.id" target="_blank">guruverse@acf.or.id</a>
            </div>
          </div>
        </div>

        {{-- Jam Operasional --}}
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <div class="contact-item-text">
            <div class="contact-item-label">Jam Operasional</div>
            <div class="contact-item-value">Senin – Jumat: 08.00 – 17.00 WIB</div>
          </div>
        </div>
      </div>

      {{-- Sosial Media --}}
      <div class="sosmed-title">Ikuti Kami di</div>
      <div class="sosmed-row">
        <a href="https://www.instagram.com/guruverse.id?igsh=MXF2dXlxZmF4MHR2bw==" target="_blank" class="sosmed-btn instagram">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          Instagram
        </a>
        <a href="https://wa.me/6283133531303" target="_blank" class="sosmed-btn whatsapp">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          WhatsApp
        </a>
      </div>
    </div>

    {{-- Kolom Kanan: Google Maps --}}
    <div class="map-col gv-reveal delay-2">
      <div class="map-label">Temukan Kami di Sini</div>
      <div class="map-wrapper">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.787073870498!2d107.62489527499254!3d-6.934978993056782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e8b64e1d0c6d%3A0x5a0a6f5a9a6f5a9a!2sJl.%20Jati%20Mulya%20No.9%2C%20Gumuruh%2C%20Kec.%20Batununggal%2C%20Kota%20Bandung%2C%20Jawa%20Barat%2040275!5e0!3m2!1sid!2sid!4v1686000000000!5m2!1sid!2sid"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Lokasi Guruverse.ID - ACF Eduhub, Bandung">
        </iframe>
      </div>
      <a href="https://maps.google.com/?q=Jl.+Jati+Mulya+No.9,+Gumuruh,+Kec.+Batununggal,+Kota+Bandung,+Jawa+Barat+40275" target="_blank" class="map-open-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        Buka di Google Maps
      </a>

      {{-- Quick Contact Card --}}
      <div class="quick-contact-card">
        <div class="quick-contact-label">HUBUNGI KAMI LANGSUNG</div>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <a href="https://wa.me/6283133531303" target="_blank" class="quick-contact-btn wa">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.004 0C5.373 0 0 5.373 0 12.004c0 2.117.553 4.1 1.517 5.823L.024 23.976l6.304-1.654A11.954 11.954 0 0 0 12.004 24C18.63 24 24 18.627 24 12.004 24 5.373 18.63 0 12.004 0zm0 21.818a9.814 9.814 0 0 1-5.003-1.374l-.359-.213-3.722.976.993-3.63-.234-.373a9.79 9.79 0 0 1-1.503-5.2c0-5.42 4.41-9.83 9.828-9.83 5.418 0 9.828 4.41 9.828 9.83 0 5.42-4.41 9.814-9.828 9.814z"/></svg>
            Chat WhatsApp Sekarang
          </a>
          <a href="https://mail.google.com/mail/?view=cm&to=guruverse@acf.or.id" target="_blank" class="quick-contact-btn email">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Kirim Email
          </a>
        </div>
      </div>
    </div>

  </div>

  {{-- Bottom Bar --}}
  <div class="about-footer-bar">
    <div>&copy; {{ date('Y') }} Guruverse.ID — ACF EDUHUB. All rights reserved.</div>
    <div class="about-footer-links">
      <a href="{{ route('home') }}">Beranda</a>
      <a href="{{ route('about') }}">Tentang Kami</a>
      <a href="{{ route('program') }}">Program</a>
      <a href="{{ route('register') }}">Daftar</a>
    </div>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
// ---- Intersection Observer: Zajno Fade Up ----
const revealObserverAbout = new IntersectionObserver(function(entries) {
  entries.forEach(function(entry) {
    if (entry.isIntersecting) {
      entry.target.classList.add('is-visible');
    } else {
      entry.target.classList.remove('is-visible');
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('.gv-reveal').forEach(function(el) {
  revealObserverAbout.observe(el);
});

// ---- GSAP Parallax ----
if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
  gsap.registerPlugin(ScrollTrigger);
  document.querySelectorAll('.gv-parallax-img').forEach(function(elem) {
    gsap.to(elem, {
      yPercent: 18, scale: 1, ease: 'none',
      scrollTrigger: {
        trigger: elem.closest('.gv-parallax-wrap') || elem.parentElement,
        start: 'top bottom', end: 'bottom top', scrub: 1.5
      }
    });
  });
}
</script>

@endsection
