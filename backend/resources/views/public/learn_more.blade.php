@extends('layouts.public')

@section('title', 'Pelajari Lebih Lanjut | Guruverse.ID')

@section('content')
<style>
/* ── LM PAGE STYLES ── */
.lm-page {
  min-height: 100vh;
  background: var(--bg);
  color: var(--text);
  overflow-x: hidden;
}

/* ── CUSTOM TOAST ── */
.custom-toast {
  position: fixed;
  top: 30px;
  right: -350px;
  background: #0f172a !important;
  border: 1px solid rgba(56,189,248,.3);
  box-shadow: 0 10px 30px rgba(0,0,0,.5);
  border-radius: 12px;
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  z-index: 9999;
  transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
  opacity: 0;
}
.custom-toast.show {
  right: 30px;
  opacity: 1;
}
.custom-toast-icon {
  width: 24px;
  height: 24px;
  background: rgba(56, 189, 248, 0.1);
  color: #38bdf8;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.custom-toast-text {
  font-size: 14px;
  font-weight: 600;
  color: #ffffff !important;
}

/* ── HERO ── */
.lm-hero {
  padding: 100px 5% 80px;
  position: relative;
  overflow: hidden;
}
.lm-hero-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
  z-index: 0;
}
.lm-hero-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  gap: 60px;
  align-items: center;
  position: relative;
  z-index: 1;
}
.lm-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 16px;
  background: rgba(124,58,237,0.1);
  color: var(--purple-light, #a78bfa);
  border: 1px solid rgba(124,58,237,0.25);
  border-radius: 50px;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .1em;
  margin-bottom: 20px;
}
.lm-hero-title {
  font-size: clamp(32px, 5vw, 56px);
  font-weight: 900;
  line-height: 1.1;
  letter-spacing: -0.03em;
  margin-bottom: 20px;
}
.lm-hero-title span {
  background: linear-gradient(135deg, #a78bfa, #38bdf8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.lm-hero-desc {
  font-size: 16px;
  line-height: 1.75;
  color: var(--text-muted, #6b7280);
  margin-bottom: 36px;
  max-width: 480px;
}
.lm-hero-actions {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}
.btn-lm-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 28px;
  background: linear-gradient(135deg, #6d28d9, #7c3aed);
  color: #fff;
  border-radius: 50px;
  font-weight: 800;
  font-size: 15px;
  text-decoration: none;
  box-shadow: 0 8px 24px rgba(124,58,237,.35);
  transition: all .3s cubic-bezier(.23,1,.32,1);
}
.btn-lm-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 16px 40px rgba(124,58,237,.45);
  color: #fff;
  text-decoration: none;
}
.btn-lm-outline {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 13px 28px;
  background: transparent;
  color: var(--purple-light, #a78bfa);
  border: 1.5px solid rgba(124,58,237,.35);
  border-radius: 50px;
  font-weight: 700;
  font-size: 15px;
  text-decoration: none;
  transition: all .3s;
}
.btn-lm-outline:hover {
  background: rgba(124,58,237,.08);
  border-color: rgba(124,58,237,.6);
  transform: translateY(-2px);
  color: var(--purple-light, #a78bfa);
  text-decoration: none;
}
.lm-hero-visual {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}
.lm-hero-img {
  width: 100%;
  max-width: 420px;
  height: auto;
  border-radius: 0;
  background: transparent;
  animation: lm-float 6s ease-in-out infinite;
  filter: drop-shadow(0 20px 40px rgba(124,58,237,.2));
  mix-blend-mode: multiply;
}
@keyframes lm-float {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-14px); }
}

/* ── STATS BAR ── */
.lm-stats {
  background: var(--card, #fff);
  border-top: 1px solid var(--border);
  border-bottom: 1px solid var(--border);
  padding: 40px 5%;
}
.lm-stats-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  text-align: center;
}
.stat-item {
  padding: 20px;
  border-right: 1px solid var(--border);
}
.stat-item:last-child { border-right: none; }
.stat-num {
  font-size: clamp(28px, 4vw, 40px);
  font-weight: 900;
  letter-spacing: -0.03em;
  background: linear-gradient(135deg, #a78bfa, #38bdf8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  display: block;
  line-height: 1.1;
  margin-bottom: 6px;
}
.stat-label {
  font-size: 13px;
  font-weight: 600;
  color: var(--text-muted, #6b7280);
}

/* ── STORY SECTION ── */
.lm-story {
  padding: 100px 5%;
  position: relative;
}
.lm-story-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1.1fr;
  gap: 80px;
  align-items: center;
}
.section-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .12em;
  color: var(--purple-light, #a78bfa);
  margin-bottom: 16px;
}
.section-title {
  font-size: clamp(26px, 3.5vw, 42px);
  font-weight: 900;
  line-height: 1.15;
  letter-spacing: -0.03em;
  margin-bottom: 20px;
  color: var(--text);
}
.section-title span {
  background: linear-gradient(135deg, #a78bfa, #38bdf8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.section-desc {
  font-size: 15px;
  line-height: 1.75;
  color: var(--text-muted, #6b7280);
}
.story-quote-card {
  background: var(--card, #fff);
  border: 1px solid var(--border);
  border-radius: 28px;
  padding: 40px;
  position: relative;
  overflow: hidden;
}
.story-quote-card::before {
  content: '"';
  position: absolute;
  top: -20px;
  left: 24px;
  font-size: 120px;
  font-family: Georgia, serif;
  color: var(--purple-light, #a78bfa);
  opacity: 0.12;
  line-height: 1;
  pointer-events: none;
}
.story-quote-text {
  font-size: 15px;
  line-height: 1.85;
  color: var(--text);
  font-style: italic;
  position: relative;
  z-index: 1;
}
.story-quote-text strong { font-style: normal; color: var(--purple-light, #a78bfa); }
.story-quote-author {
  margin-top: 24px;
  display: flex;
  align-items: center;
  gap: 12px;
}
.quote-author-line {
  width: 36px;
  height: 1px;
  background: var(--border);
}
.quote-author-name {
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .12em;
  color: var(--text-muted, #6b7280);
}

/* ── PILLARS ── */
.lm-pillars {
  padding: 80px 5%;
  background: var(--card, rgba(255,255,255,0.5));
  border-top: 1px solid var(--border);
  border-bottom: 1px solid var(--border);
}
.lm-section-header {
  text-align: center;
  max-width: 600px;
  margin: 0 auto 60px;
}
.pillars-grid {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.pillar-item {
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 28px;
  padding: 36px 30px;
  transition: all .4s cubic-bezier(.23,1,.32,1);
  position: relative;
  overflow: hidden;
}
.pillar-item::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: var(--pillar-color, #a78bfa);
  opacity: 0;
  transition: opacity .3s;
}
.pillar-item:hover {
  transform: translateY(-10px);
  box-shadow: 0 30px 60px rgba(0,0,0,.1);
  border-color: var(--pillar-color, #a78bfa);
}
.pillar-item:hover::before { opacity: 1; }
.pillar-icon {
  width: 52px;
  height: 52px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin-bottom: 24px;
  border: 1px solid var(--border);
}
.pillar-tag {
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .1em;
  margin-bottom: 10px;
  display: block;
}
.pillar-name {
  font-size: 20px;
  font-weight: 900;
  color: var(--text);
  margin-bottom: 14px;
}
.pillar-desc {
  font-size: 14px;
  line-height: 1.7;
  color: var(--text-muted, #6b7280);
}

/* ── FEATURES ── */
.lm-features {
  padding: 100px 5% 40px;
}
.lm-features-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.features-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.feature-item {
  display: flex;
  gap: 16px;
  padding: 20px 24px;
  background: var(--card, #fff);
  border: 1px solid var(--border);
  border-radius: 20px;
  transition: all .3s;
  align-items: flex-start;
}
.feature-item:hover {
  border-color: rgba(124,58,237,.35);
  background: rgba(124,58,237,.04);
  transform: translateX(6px);
}
.feature-icon {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: rgba(124,58,237,.1);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}
.feature-content h4 {
  font-size: 15px;
  font-weight: 800;
  color: var(--text);
  margin-bottom: 6px;
}
.feature-content p {
  font-size: 13px;
  line-height: 1.6;
  color: var(--text-muted, #6b7280);
}

/* ── PRODUCTS ── */
.lm-products {
  padding: 80px 5% 40px;
}
.lm-products-inner {
  max-width: 1200px;
  margin: 0 auto;
}
.lm-products-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 50px;
}
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 16px;
  max-width: 850px;
  margin: 0 auto;
}
.product-card {
  background: var(--card, #fff);
  border: 1px solid var(--border);
  border-radius: 14px;
  overflow: hidden;
  transition: all .3s;
  display: flex;
  flex-direction: column;
}
.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  border-color: rgba(124,58,237,.3);
}
.product-img-wrap {
  width: 100%;
  aspect-ratio: 4/5;
  overflow: hidden;
  background: #18181b;
  position: relative;
}
.product-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .5s;
}
.product-img-wrap img.default-img {
  object-fit: contain;
  padding: 2rem;
  background: linear-gradient(135deg, rgba(30,41,59,1), rgba(15,23,42,1));
}
.product-card:hover .product-img-wrap img {
  transform: scale(1.05);
}
.product-badge {
  position: absolute;
  top: 10px;
  left: 10px;
  background: rgba(124,58,237, 0.9);
  color: #fff;
  font-size: 9px;
  font-weight: 700;
  padding: 3px 6px;
  border-radius: 12px;
  backdrop-filter: blur(4px);
  z-index: 2;
}
.product-body {
  padding: 12px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.product-author {
  font-size: 9px;
  color: #94a3b8 !important;
  text-transform: uppercase;
  letter-spacing: .05em;
  font-weight: 700;
  margin-bottom: 4px;
}
.product-title {
  font-size: 13px;
  font-weight: 800;
  color: #f8fafc !important;
  margin-bottom: 8px;
  line-height: 1.3;
}
.product-price {
  font-size: 14px;
  font-weight: 900;
  color: #38bdf8;
  margin-bottom: 12px;
  margin-top: auto;
}
.btn-buy {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  width: 100%;
  padding: 8px;
  border-radius: 8px;
  background: rgba(56,189,248,0.1);
  color: #38bdf8;
  font-weight: 700;
  font-size: 12px;
  border: 1px solid rgba(56,189,248,0.2);
  cursor: pointer;
  transition: .2s;
  text-decoration: none;
}
.btn-buy:hover {
  background: #38bdf8;
  color: #0f172a;
}

/* ── CTA ── */
.lm-cta {
  padding: 40px 5% 80px;
}
.lm-cta-inner {
  max-width: 1200px;
  margin: 0 auto;
}
.lm-cta-card {
  background: linear-gradient(135deg, rgba(109,40,217,.15), rgba(56,189,248,.08));
  border: 1px solid rgba(124,58,237,.3);
  border-radius: 28px;
  padding: 32px;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 30px;
  align-items: center;
  position: relative;
  overflow: hidden;
}
.lm-cta-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
  pointer-events: none;
}
.lm-cta-title {
  font-size: clamp(18px, 2.5vw, 24px);
  font-weight: 900;
  letter-spacing: -.03em;
  margin-bottom: 12px;
  color: var(--text);
}
.lm-cta-title span {
  background: linear-gradient(135deg, #a78bfa, #38bdf8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.lm-cta-desc {
  font-size: 13px;
  line-height: 1.5;
  color: var(--text-muted, #6b7280);
  margin-bottom: 20px;
  max-width: 480px;
}
.lm-cta-actions { display: flex; gap: 14px; flex-wrap: wrap; }
.cta-rocket {
  width: 100px;
  height: 100px;
  border-radius: 20px;
  background: linear-gradient(135deg, rgba(124,58,237,.25), rgba(56,189,248,.1));
  border: 1px solid rgba(124,58,237,.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 40px;
  transform: rotate(12deg);
  box-shadow: 0 20px 40px rgba(0,0,0,.15);
  flex-shrink: 0;
}

/* ── SCROLL REVEAL ── */
.lm-reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity .7s cubic-bezier(.23,1,.32,1), transform .7s cubic-bezier(.23,1,.32,1);
}
.lm-reveal.is-visible {
  opacity: 1;
  transform: translateY(0);
}
.lm-reveal.delay-1 { transition-delay: .1s; }
.lm-reveal.delay-2 { transition-delay: .2s; }
.lm-reveal.delay-3 { transition-delay: .3s; }
.lm-reveal.delay-4 { transition-delay: .4s; }
.lm-reveal.delay-5 { transition-delay: .5s; }
.lm-reveal.delay-6 { transition-delay: .6s; }

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .lm-hero-inner { grid-template-columns: 1fr; text-align: center; }
  .lm-hero-desc { max-width: 100%; }
  .lm-hero-actions { justify-content: center; }
  .lm-hero-visual { display: none; }
  .lm-story-inner { grid-template-columns: 1fr; gap: 40px; }
  .pillars-grid { grid-template-columns: repeat(2, 1fr); }
  .lm-features-inner { grid-template-columns: 1fr; gap: 40px; }
  .lm-cta-card { grid-template-columns: 1fr; padding: 48px 40px; }
  .cta-rocket { display: none; }
}
@media (max-width: 768px) {
  .lm-hero { padding: 80px 5% 60px; }
  .lm-stats-inner { grid-template-columns: repeat(2, 1fr); }
  .stat-item { border-right: none; border-bottom: 1px solid var(--border); }
  .stat-item:nth-child(2n) { border-bottom: 1px solid var(--border); }
  .stat-item:nth-last-child(-n+2) { border-bottom: none; }
  .pillars-grid { grid-template-columns: 1fr; }
  .lm-cta-card { padding: 40px 24px; border-radius: 24px; }
  .lm-story { padding: 60px 5%; }
  .lm-features { padding: 60px 5%; }
}
@media (max-width: 480px) {
  .lm-stats-inner { grid-template-columns: 1fr 1fr; }
  .btn-lm-primary, .btn-lm-outline { width: 100%; justify-content: center; }
  .lm-cta-actions { flex-direction: column; }
}

/* ── LIGHT MODE OVERRIDES ── */
[data-theme="light"] .lm-page {
  background: #f8faff;
}

/* Badge */
[data-theme="light"] .lm-badge {
  background: linear-gradient(135deg, rgba(124,58,237,.1), rgba(56,189,248,.1));
  color: #7c3aed;
  border-color: rgba(124,58,237,.25);
}

/* Gradient text */
[data-theme="light"] .lm-hero-title span,
[data-theme="light"] .section-title span,
[data-theme="light"] .lm-cta-title span {
  background: linear-gradient(135deg, #7c3aed, #06b6d4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Stats numbers */
[data-theme="light"] .stat-num {
  background: linear-gradient(135deg, #7c3aed, #06b6d4);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Stats bar background */
[data-theme="light"] .lm-stats {
  background: #ffffff;
}

/* Buttons */
[data-theme="light"] .btn-lm-primary {
  background: linear-gradient(135deg, #7c3aed, #6d28d9);
  box-shadow: 0 8px 24px rgba(124,58,237,.3);
  color: #fff;
}
[data-theme="light"] .btn-lm-primary:hover {
  box-shadow: 0 16px 40px rgba(124,58,237,.4);
  color: #fff;
}
[data-theme="light"] .btn-lm-outline {
  color: #7c3aed;
  border-color: rgba(124,58,237,.35);
  background: rgba(124,58,237,.05);
}
[data-theme="light"] .btn-lm-outline:hover {
  background: rgba(124,58,237,.1);
  border-color: rgba(124,58,237,.5);
  color: #6d28d9;
}

/* Section badges */
[data-theme="light"] .section-badge { color: #7c3aed; }

/* Story section */
[data-theme="light"] .lm-story { background: #f8faff; }
[data-theme="light"] .story-quote-card {
  background: #ffffff;
  box-shadow: 0 12px 40px rgba(124,58,237,.08);
}
[data-theme="light"] .story-quote-card::before { color: #7c3aed; }
[data-theme="light"] .story-quote-text { color: #1e293b; }
[data-theme="light"] .story-quote-text strong { color: #7c3aed; }

/* Pillars section */
[data-theme="light"] .lm-pillars {
  background: #ffffff;
  border-color: #e8eaf6;
}
[data-theme="light"] .pillar-item {
  background: #f8faff;
  border-color: #e2e8f0;
}
[data-theme="light"] .pillar-item:hover {
  background: #ffffff;
  box-shadow: 0 20px 50px rgba(124,58,237,.12);
}
[data-theme="light"] .pillar-name { color: #1e293b; }
[data-theme="light"] .pillar-desc { color: #475569; }

/* Features section */
[data-theme="light"] .lm-features { background: #f8faff; }
[data-theme="light"] .feature-item {
  background: #ffffff;
  border-color: #e2e8f0;
  box-shadow: 0 4px 12px rgba(0,0,0,.04);
}
[data-theme="light"] .feature-item:hover {
  border-color: rgba(124,58,237,.3);
  background: #faf5ff;
  box-shadow: 0 8px 24px rgba(124,58,237,.1);
}
[data-theme="light"] .feature-icon {
  background: linear-gradient(135deg, rgba(124,58,237,.12), rgba(56,189,248,.08));
}
[data-theme="light"] .feature-content h4 { color: #1e293b; }
[data-theme="light"] .feature-content p { color: #475569; }

/* CTA section */
[data-theme="light"] .lm-cta-card {
  background: linear-gradient(135deg, #faf5ff, #eff6ff);
  border-color: rgba(124,58,237,.2);
  box-shadow: 0 20px 60px rgba(124,58,237,.1);
}
[data-theme="light"] .lm-cta-title { color: #1e293b; }
[data-theme="light"] .lm-cta-desc { color: #475569; }

/* Titles and text */
[data-theme="light"] .lm-hero-title { color: #0f172a; }
[data-theme="light"] .lm-hero-desc { color: #475569; }
[data-theme="light"] .section-title { color: #0f172a; }
[data-theme="light"] .section-desc { color: #475569; }
[data-theme="light"] .stat-label { color: #64748b; }

/* Blobs brighter for light mode */
[data-theme="light"] .lm-hero-blob:first-child {
  background: radial-gradient(circle, rgba(167,139,250,.2) 0%, transparent 70%);
}
[data-theme="light"] .lm-hero-blob:last-child {
  background: radial-gradient(circle, rgba(125,211,252,.2) 0%, transparent 70%);
}
</style>

<div class="lm-page">

  {{-- ──────────────────── HERO ──────────────────── --}}
  <section class="lm-hero">
    <div class="lm-hero-blob" style="width:600px;height:600px;top:-200px;right:-100px;background:radial-gradient(circle,rgba(124,58,237,.12) 0%,transparent 70%)"></div>
    <div class="lm-hero-blob" style="width:400px;height:400px;bottom:-100px;left:-80px;background:radial-gradient(circle,rgba(56,189,248,.1) 0%,transparent 70%)"></div>
    <div class="lm-hero-inner">
      <div class="lm-reveal">
        <div class="lm-badge">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Tentang Guruverse
        </div>
        <h1 class="lm-hero-title">
          Membuka Pintu<br>
          <span>Masa Depan Pendidikan</span>
        </h1>
        <p class="lm-hero-desc">
          Guruverse.id adalah ekosistem digital yang dirancang khusus untuk memberdayakan guru Indonesia melalui teknologi, kolaborasi, dan inovasi berkelanjutan.
        </p>
        <div class="lm-hero-actions">
          <a href="{{ route('register') }}" class="btn-lm-primary">
            Mulai Sekarang
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          <a href="{{ route('home') }}" class="btn-lm-outline">
            Kembali ke Beranda
          </a>
        </div>
      </div>
      <div class="lm-hero-visual lm-reveal delay-2">
        <img src="{{ asset('asset/img/hero_illustration.png') }}" alt="Guruverse Illustration" class="lm-hero-img"
             onerror="this.style.display='none'">
      </div>
    </div>
  </section>

  {{-- ──────────────────── STATS ──────────────────── --}}
  <div class="lm-stats">
    <div class="lm-stats-inner">
      <div class="stat-item lm-reveal">
        <span class="stat-num">15.000+</span>
        <span class="stat-label">Guru Aktif</span>
      </div>
      <div class="stat-item lm-reveal delay-1">
        <span class="stat-num">500+</span>
        <span class="stat-label">Modul Belajar</span>
      </div>
      <div class="stat-item lm-reveal delay-2">
        <span class="stat-num">98.4%</span>
        <span class="stat-label">Tingkat Kepuasan</span>
      </div>
      <div class="stat-item lm-reveal delay-3">
        <span class="stat-num">24/7</span>
        <span class="stat-label">Pendampingan Mentor</span>
      </div>
    </div>
  </div>

  {{-- ──────────────────── STORY ──────────────────── --}}
  <section class="lm-story">
    <div class="lm-story-inner">
      <div class="lm-reveal">
        <span class="section-badge">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          Cerita Kami
        </span>
        <h2 class="section-title">Lebih Dari Sekadar <span>Sebuah Nama</span></h2>
        <p class="section-desc">
          Guruverse.ID bukan sekadar nama. Ia adalah manifestasi dari ekosistem yang dibangun oleh <strong>ACF Eduhub</strong> — sebuah ruang semesta peningkatan kompetensi guru Indonesia.
        </p>
      </div>
      <div class="story-quote-card lm-reveal delay-1">
        <p class="story-quote-text">
          "Kami menghadirkan <strong>Learning & Teaching Management System (LTMS)</strong> untuk guru; modul, pelatihan, dan komunitas yang membantu guru Indonesia menjadi lebih kompeten secara pedagogik, profesional, personal, sosial, digital, dan inovatif — agar siap menjawab tantangan zaman dan menyalakan cahaya pendidikan bangsa."
        </p>
        <div class="story-quote-author">
          <div class="quote-author-line"></div>
          <span class="quote-author-name">Tim Guruverse.ID</span>
        </div>
      </div>
    </div>
  </section>

  {{-- ──────────────────── PILLARS ──────────────────── --}}
  <section class="lm-pillars">
    <div class="lm-section-header lm-reveal">
      <h2 class="section-title">Tiga Pilar <span>Utama</span></h2>
      <p class="section-desc">Fokus kami adalah memberikan solusi komprehensif bagi setiap kebutuhan guru Indonesia.</p>
    </div>
    <div class="pillars-grid">
      <div class="pillar-item lm-reveal delay-1" style="--pillar-color: #a78bfa;">

        <span class="pillar-tag" style="color:#a78bfa;">Pengembangan Diri & Kompetensi</span>
        <div class="pillar-name">Guru Belajar</div>
        <p class="pillar-desc">"Guru yang terus tumbuh dan memperdalam ilmunya." Meliputi Kelas Online, Webinar, dan Sertifikat Digital untuk menunjang karier profesional Anda.</p>
      </div>
      <div class="pillar-item lm-reveal delay-2" style="--pillar-color: #38bdf8;">

        <span class="pillar-tag" style="color:#38bdf8;">Aksi Nyata & Kontribusi</span>
        <div class="pillar-name">Guru Mengajar</div>
        <p class="pillar-desc">"Guru yang mengimplementasikan nilai dan berdampak bagi murid serta komunitas." Didukung Dashboard Personal, Gamifikasi, dan Pelatihan Offline.</p>
      </div>
      <div class="pillar-item lm-reveal delay-3" style="--pillar-color: #f472b6;">

        <span class="pillar-tag" style="color:#f472b6;">Jejaring, Kolaborasi & Inspirasi</span>
        <div class="pillar-name">Guru Inspira</div>
        <p class="pillar-desc">"Guru yang saling menguatkan dan berbagi semangat." Wadah Forum Diskusi, Kolaborasi Proyek, dan berbagi Cerita Inspiratif bersama rekan sejawat.</p>
      </div>
    </div>
  </section>

  {{-- ──────────────────── FEATURES ──────────────────── --}}
  <section class="lm-features">
    <div class="lm-features-inner">
      <div class="lm-reveal">
        <span class="section-badge">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          Keunggulan Ekosistem
        </span>
        <h2 class="section-title">Mengapa Memilih <span>Guruverse.id?</span></h2>
        <p class="section-desc">
          Kami menyatukan teknologi mutakhir dengan pemahaman mendalam tentang kebutuhan guru di lapangan untuk menciptakan pengalaman belajar yang relevan dan menyenangkan.
        </p>
      </div>
      <div class="features-list">
        <div class="feature-item lm-reveal delay-1">

          <div class="feature-content">
            <h4>Sertifikat Resmi Digital</h4>
            <p>Dapatkan e-Certificate resmi dari ACF Eduhub untuk menunjang nilai angka kredit dan portofolio profesional Anda.</p>
          </div>
        </div>
        <div class="feature-item lm-reveal delay-2">

          <div class="feature-content">
            <h4>Analisis Progres Pintar</h4>
            <p>Dashboard interaktif yang merekam pencapaian belajar dan mengajar Anda secara berkala dengan visualisasi modern.</p>
          </div>
        </div>
        <div class="feature-item lm-reveal delay-3">

          <div class="feature-content">
            <h4>Kolaborasi Tanpa Batas</h4>
            <p>Terhubung langsung dengan ribuan guru hebat di seluruh nusantara untuk berbagi program, modul, dan inspirasi.</p>
          </div>
        </div>
        <div class="feature-item lm-reveal delay-4">

          <div class="feature-content">
            <h4>Akses 24/7 dari Mana Saja</h4>
            <p>Platform berbasis cloud yang dapat diakses kapan saja dan di mana saja melalui perangkat apapun — smartphone, tablet, atau laptop.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ──────────────────── PRODUCTS ──────────────────── --}}
  <section class="lm-products" id="jendela-dunia">
    <div class="lm-products-inner">
      <div class="lm-products-header lm-reveal">
        <span class="section-badge">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
          Jendela Dunia & E-Book
        </span>
        <h2 class="section-title" style="text-align:center;">Produk Pilihan <span>Guruverse</span></h2>
        <p class="section-desc" style="margin:0 auto; text-align:center;">
          Tingkatkan kompetensi Anda dengan berbagai modul, buku panduan, dan materi eksklusif yang bisa Anda beli secara langsung.
        </p>
      </div>

      <div class="products-grid">
        @foreach($products as $index => $product)
        <div class="product-card lm-reveal delay-{{ ($index % 4) + 1 }}">
          <div class="product-img-wrap">
            <div class="product-badge" style="background: {{ $product->badge_color ?? 'rgba(124, 58, 237, 0.9)' }};">{{ $product->badge }}</div>
            <img src="{{ $product->image ?: asset('images/default-product.png') }}" alt="{{ $product->name }}" class="{{ $product->image ? '' : 'default-img' }}">
          </div>
          <div class="product-body">
            <div class="product-author">{{ $product->author }}</div>
            <h3 class="product-title">{{ $product->name }}</h3>
            
            <div style="margin-top: auto; margin-bottom: 12px;">
                @if($product->member_price !== null)
                    <div style="font-size: 11px; color: #94a3b8; text-decoration: line-through;">
                        Normal: Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 14px; font-weight: 700; color: {{ $product->member_price == 0 ? '#10b981' : '#a78bfa' }};">
                        Member: {{ $product->member_price == 0 ? 'Gratis' : 'Rp ' . number_format($product->member_price, 0, ',', '.') }}
                    </div>
                @else
                    <div class="product-price" style="color: {{ $product->price == 0 ? '#10b981' : '#f59e0b' }}; margin-bottom: 0;">
                        {{ $product->price == 0 ? 'Gratis' : 'Rp ' . number_format($product->price, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            
            <div style="display: flex; gap: 8px;">
                <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                  <button type="submit" class="btn-buy" style="color: #f8fafc; background: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);" title="Tambah ke Keranjang">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                  </button>
                </form>

                <form action="{{ route('cart.buy_now') }}" method="POST" style="flex: 3;">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                  @if($product->price == 0 || $product->member_price === 0)
                  <button type="submit" class="btn-buy" style="color: #10b981; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2);">
                    Unduh Sekarang
                  </button>
                  @else
                  <button type="submit" class="btn-buy" style="color: #f59e0b; background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                    Beli Langsung
                  </button>
                  @endif
                </form>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      
      <div style="text-align: center; margin-top: 40px;" class="lm-reveal delay-5">
        <a href="{{ route('public.products') }}" class="btn-lm-secondary" style="display: inline-flex; align-items: center; gap: 8px;">
          Lihat Semua Produk
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg>
        </a>
      </div>
    </div>
  </section>

  {{-- ──────────────────── CTA ──────────────────── --}}
  <section class="lm-cta">
    <div class="lm-cta-inner">
      <div class="lm-cta-card lm-reveal">
        <div class="lm-cta-blob" style="width:300px;height:300px;top:-50px;right:100px;background:radial-gradient(circle,rgba(124,58,237,.2) 0%,transparent 70%);"></div>
        <div class="lm-cta-blob" style="width:200px;height:200px;bottom:-30px;left:50px;background:radial-gradient(circle,rgba(56,189,248,.15) 0%,transparent 70%);"></div>
        <div style="position:relative;z-index:1;">
          <h2 class="lm-cta-title">Siap Menjadi Bagian dari <span>Revolusi Pendidikan?</span></h2>
          <p class="lm-cta-desc">Bergabunglah hari ini dan dapatkan akses penuh ke seluruh fitur Guruverse.id. Bersama-sama kita wujudkan pendidikan Indonesia yang lebih baik.</p>
          <div class="lm-cta-actions">
            <a href="{{ route('register') }}" class="btn-lm-primary">
              Daftar Sekarang — Gratis!
            </a>
            <a href="{{ route('home') }}" class="btn-lm-outline">Kembali ke Beranda</a>
          </div>
        </div>
        <div class="cta-rocket">🚀</div>
      </div>
    </div>
  </section>

</div>

<!-- Custom Toast -->
<div id="custom-toast" class="custom-toast">
  <div class="custom-toast-icon">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
  </div>
  <div class="custom-toast-text" id="custom-toast-text">Pesan di sini</div>
</div>

<script>
function showToast(message) {
  const toast = document.getElementById('custom-toast');
  const text = document.getElementById('custom-toast-text');
  if(toast && text) {
    text.innerText = message;
    toast.classList.add('show');
    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  }
}

// Scroll reveal animation
(function() {
  const els = document.querySelectorAll('.lm-reveal');
  if (!els.length) return;
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('is-visible');
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  els.forEach(el => obs.observe(el));
})();
</script>
@endsection
