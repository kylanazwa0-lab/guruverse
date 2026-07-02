@extends('layouts.public')
@section('content')

<div id="pg-guruinspira">
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
  <button class="breadcrumb-back" onclick="window.location.href='{{ route('home') }}'">
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
    <div class="detail-hero-text gv-reveal">
      <span class="detail-badge">PROGRAM</span>
      <h1 class="detail-title">Guru <em>Inspira</em></h1>
      <p class="detail-subtitle">Jejaring inspirasi dan komunitas guru untuk saling menguatkan, berbagi semangat, dan berkontribusi nyata.</p>
      <div class="detail-quote">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="flex-shrink:0;margin-top:2px"><path d="M3 10h4V6H3v4c0 2.2 1.8 4 4 4M12 10h4V6h-4v4c0 2.2 1.8 4 4 4" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span>"Guru yang saling menguatkan dan berbagi semangat untuk pendidikan Indonesia."</span>
      </div>
      <div class="detail-btns">
        <a href="{{ route('register') }}" class="btn-primary hero-btn-primary" style="border:none;border-radius:12px;padding:13px 28px;color:#fff;font-weight:700;font-size:14px;cursor:pointer;font-family:inherit;text-decoration:none;display:inline-block;">Bergabung Sekarang</a>
        <a href="{{ route('learn-more.guruinspira') }}" class="btn-secondary" style="border-radius:12px;padding:12px 24px;text-decoration:none;display:inline-block;">Pelajari Lebih Lanjut</a>
      </div>
    </div>
    <div class="detail-img gv-reveal">
      <div class="gv-parallax-wrap">
        <img src="{{ asset('asset/img/teachers-sertifikat.png') }}" alt="Guru Inspira" class="gv-parallax-img" style="transform-origin: center top;" />
      </div>
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
    <div class="sec-title gv-reveal">Bagaimana Kami Terhubung</div>
    <div class="sec-desc gv-reveal">Berbagai wadah kolaborasi dan interaksi untuk memperkaya pengalaman dan inspirasi Anda sebagai pendidik.</div>

    <div class="feat-grid" style="grid-template-columns:repeat(3,1fr); gap:24px;">

      {{-- Forum Diskusi --}}
      <div class="stat-card gv-reveal" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
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
      <div class="feat-card alt gv-reveal" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
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
      <div class="feat-card gv-reveal" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
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


{{-- CTA BANNER --}}
<div class="cta-banner gv-reveal" style="position:relative;overflow:hidden">
  <div style="position:absolute;left:0;top:0;height:100%;width:35%;background:url('{{ asset("asset/img/community_teachers_muslim (2).png") }}') center/cover no-repeat;opacity:.35"></div>
  <div class="cta-inner" style="position:relative;z-index:1">
    <div class="cta-title" style="font-size:clamp(1.5rem,3vw,2.2rem)">Bersama, Kita Lebih Kuat!</div>
    <div class="cta-sub">Bergabung bersama ribuan guru di seluruh Indonesia dan jadilah bagian dari perubahan pendidikan.</div>
    <a href="{{ route('register') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;font-size:1rem;padding:13px 28px;text-decoration:none;">
      Gabung Komunitas Gratis
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
    <div class="cta-note" style="margin-top:20px;display:flex;gap:24px;justify-content:center;flex-wrap:wrap;font-size:.82rem;color:rgba(255,255,255,.55)">
      <span>Komunitas aktif</span>
      <span>Aman &amp; Positif</span>
      <span>Dari Sabang sampai Merauke</span>
    </div>
  </div>
</div>
</div>
@endsection

