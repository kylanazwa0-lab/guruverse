@extends('layouts.public')

@section('content')

{{-- ===== HERO ===== --}}
<section class="detail-hero" style="background:linear-gradient(135deg,var(--navy) 0%,var(--navy2) 55%,var(--navy4) 100%);">
  <div class="detail-hero-inner">
    <div class="detail-hero-text">
      <span class="detail-badge">TENTANG GURUVERSE.ID</span>
      <h1 class="detail-title">Semesta <em>Kompetensi</em><br>Guru Indonesia</h1>
      <p class="detail-subtitle">Guruverse.ID adalah ekosistem digital yang dirancang khusus untuk guru Indonesia — tempat belajar, berbagi, dan menginspirasi satu sama lain secara berkelanjutan.</p>
      <div class="detail-quote">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="flex-shrink:0;margin-top:2px">
          <path d="M3 10h4V6H3v4c0 2.2 1.8 4 4 4M12 10h4V6h-4v4c0 2.2 1.8 4 4 4" stroke="var(--purple-light)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>"Satu platform untuk semua perjalanan kompetensi guru Indonesia."</span>
      </div>
      <div class="detail-btns">
        <a href="{{ route('register') }}" class="btn-primary" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
          Bergabung Sekarang
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <a href="{{ route('about') }}" class="btn-secondary" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
          Tentang Kami
        </a>
      </div>
    </div>
    <div class="detail-img">
      <img src="{{ asset('asset/img/hero-teachers.png') }}" alt="Guru Indonesia Bersama">
    </div>
  </div>
</section>

{{-- ===== STATS ===== --}}
<div class="stats">
  <div class="stats-inner">
    <div class="stat">
      <div class="stat-num">15.000+</div>
      <div class="stat-lbl">Guru Terdaftar</div>
    </div>
    <div class="stat">
      <div class="stat-num">34</div>
      <div class="stat-lbl">Provinsi Indonesia</div>
    </div>
    <div class="stat">
      <div class="stat-num">200+</div>
      <div class="stat-lbl">Program & Pelatihan</div>
    </div>
    <div class="stat">
      <div class="stat-num">4.9/5</div>
      <div class="stat-lbl">Rating Kepuasan</div>
    </div>
  </div>
</div>

{{-- ===== CERITA GURUVERSE ===== --}}
<div class="content-section alt">
  <div class="content-inner" style="max-width:860px;text-align:center;">
    <div class="sec-title">Mengapa Guruverse.ID Hadir?</div>
    <div class="sec-desc" style="font-size:1rem;line-height:1.85;max-width:680px;margin:0 auto 2rem;">
      Guru adalah pilar utama kemajuan bangsa. Namun, banyak guru yang masih berjuang sendirian — tanpa komunitas yang mendukung, tanpa akses pelatihan berkualitas, dan tanpa wadah untuk berbagi karya. <strong style="color:var(--purple-light)">Guruverse.ID hadir untuk mengubah itu semua.</strong>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;text-align:left;margin-top:2rem;">
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:16px;padding:1.5rem;">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--purple-light)" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3 style="font-size:.95rem;font-weight:800;color:#fff;margin-bottom:.5rem;">Komunitas Suportif</h3>
        <p style="font-size:.82rem;color:var(--text-muted);line-height:1.7;">Terhubung dengan ribuan guru dari seluruh Indonesia yang saling mendukung dan berbagi inspirasi.</p>
      </div>
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:16px;padding:1.5rem;">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(56,189,248,.12);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <h3 style="font-size:.95rem;font-weight:800;color:#fff;margin-bottom:.5rem;">Pelatihan Berkualitas</h3>
        <p style="font-size:.82rem;color:var(--text-muted);line-height:1.7;">Akses ratusan pelatihan, webinar, dan kursus yang dirancang oleh para ahli pendidikan terbaik.</p>
      </div>
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:16px;padding:1.5rem;">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(74,222,128,.1);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <h3 style="font-size:.95rem;font-weight:800;color:#fff;margin-bottom:.5rem;">Pengakuan & Sertifikasi</h3>
        <p style="font-size:.82rem;color:var(--text-muted);line-height:1.7;">Dapatkan sertifikat resmi yang diakui dan badge pencapaian untuk setiap kompetensi yang dikuasai.</p>
      </div>
    </div>
  </div>
</div>

{{-- ===== 3 PILAR ===== --}}
<div class="content-section">
  <div class="content-inner">
    <div class="sec-title">3 Pilar Ekosistem Guruverse</div>
    <div class="sec-desc">Tiga program utama yang saling melengkapi untuk membentuk guru yang kompeten, berdampak, dan inspiratif</div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;margin-top:2.5rem;">

      {{-- Guru Belajar --}}
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:24px;overflow:hidden;transition:transform .3s,box-shadow .3s;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 48px rgba(0,0,0,.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
        <div style="height:180px;background:linear-gradient(135deg,#1a3a6e,#2563eb,#1e40af);position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <img src="{{ asset('asset/img/guru-wanita.png') }}" alt="Guru Belajar" style="height:100%;object-fit:contain;filter:drop-shadow(0 8px 24px rgba(0,0,0,.3));">
          <div style="position:absolute;inset:0;background:linear-gradient(to bottom,transparent 50%,rgba(26,58,110,.7));"></div>
        </div>
        <div style="padding:1.5rem;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(59,130,246,.15);display:flex;align-items:center;justify-content:center;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <h3 style="font-size:1.1rem;font-weight:900;color:#fff;">Guru Belajar</h3>
          </div>
          <p style="font-size:.85rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.2rem;">"Guru yang terus tumbuh dan memperdalam ilmunya." Platform peningkatan kompetensi melalui kursus intensif, webinar, dan sertifikasi resmi yang fleksibel.</p>
          <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:6px;margin-bottom:1.2rem;">
            @foreach(['Kursus online bersertifikat','Webinar interaktif dengan pakar','Modul belajar mandiri','Tracking progress kompetensi'] as $item)
            <li style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:var(--text-muted);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              {{ $item }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:.6rem 1.2rem;border-radius:50px;font-weight:700;font-size:.82rem;text-decoration:none;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            Pelajari Program <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
      </div>

      {{-- Guru Mengajar --}}
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:24px;overflow:hidden;transition:transform .3s,box-shadow .3s;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 48px rgba(0,0,0,.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
        <div style="height:180px;background:linear-gradient(135deg,#064e3b,#10b981,#047857);position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <img src="{{ asset('asset/img/rapat-guru.png') }}" alt="Guru Mengajar" style="height:100%;object-fit:contain;filter:drop-shadow(0 8px 24px rgba(0,0,0,.3));">
          <div style="position:absolute;inset:0;background:linear-gradient(to bottom,transparent 50%,rgba(6,78,59,.7));"></div>
        </div>
        <div style="padding:1.5rem;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(16,185,129,.15);display:flex;align-items:center;justify-content:center;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 style="font-size:1.1rem;font-weight:900;color:#fff;">Guru Mengajar</h3>
          </div>
          <p style="font-size:.85rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.2rem;">"Guru yang berdampak nyata bagi murid dan komunitas." Wadah berbagi praktik terbaik, dashboard personal, gamifikasi, dan pelatihan offline.</p>
          <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:6px;margin-bottom:1.2rem;">
            @foreach(['Dashboard kelas personal','Gamifikasi & sistem poin','Impact tracker murid','Pelatihan offline & sertifikat'] as $item)
            <li style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:var(--text-muted);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              {{ $item }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;background:#10b981;color:#fff;padding:.6rem 1.2rem;border-radius:50px;font-weight:700;font-size:.82rem;text-decoration:none;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            Pelajari Program <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
      </div>

      {{-- Guru Inspira --}}
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:24px;overflow:hidden;transition:transform .3s,box-shadow .3s;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 48px rgba(0,0,0,.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
        <div style="height:180px;background:linear-gradient(135deg,#3b0764,#7c3aed,#6d28d9);position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <img src="{{ asset('asset/img/teachers-sertifikat.png') }}" alt="Guru Inspira" style="height:100%;object-fit:contain;filter:drop-shadow(0 8px 24px rgba(0,0,0,.3));">
          <div style="position:absolute;inset:0;background:linear-gradient(to bottom,transparent 50%,rgba(59,7,100,.7));"></div>
        </div>
        <div style="padding:1.5rem;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <h3 style="font-size:1.1rem;font-weight:900;color:#fff;">Guru Inspira</h3>
          </div>
          <p style="font-size:.85rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.2rem;">"Guru yang saling menguatkan dan berbagi semangat." Ruang komunitas, forum diskusi, kolaborasi proyek, dan cerita inspiratif lintas daerah.</p>
          <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:6px;margin-bottom:1.2rem;">
            @foreach(['Forum diskusi aktif','Kolaborasi proyek lintas daerah','Cerita & pengalaman inspiratif','Agenda & event komunitas'] as $item)
            <li style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:var(--text-muted);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              {{ $item }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;background:#7c3aed;color:#fff;padding:.6rem 1.2rem;border-radius:50px;font-weight:700;font-size:.82rem;text-decoration:none;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            Pelajari Program <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ===== CARA BERGABUNG ===== --}}
<div class="content-section alt">
  <div class="content-inner">
    <div class="sec-title">Cara Bergabung di Guruverse</div>
    <div class="sec-desc">3 langkah mudah untuk memulai perjalanan kompetensimu</div>
    <div class="steps" style="margin-top:2.5rem;max-width:800px;margin-left:auto;margin-right:auto;">
      <div class="step">
        <div class="step-num">1</div>
        <div class="step-title">Daftar Akun Gratis</div>
        <div class="step-desc">Buat akun Guruverse.ID dalam 2 menit. Gratis selamanya untuk fitur dasar.</div>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <div class="step-title">Lengkapi Profil</div>
        <div class="step-desc">Isi data diri, institusi, dan bidang pengajaran untuk rekomendasi yang personal.</div>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <div class="step-title">Mulai Bertumbuh</div>
        <div class="step-desc">Akses program, bergabung komunitas, dan mulai perjalanan kompetensimu bersama kami.</div>
      </div>
    </div>
  </div>
</div>

{{-- ===== TESTIMONI ===== --}}
<div class="content-section">
  <div class="content-inner">
    <div class="sec-title">Apa Kata Mereka?</div>
    <div class="sec-desc">Ribuan guru telah merasakan manfaatnya</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;margin-top:2.5rem;">
      @foreach([
        ['RS','Rini Susanti','SDN 2 Bandung','Guruverse benar-benar mengubah cara saya mengajar. Kursusnya aplikatif dan komunitas di dalamnya sangat mendukung!','#3b82f6'],
        ['HW','Hendra Wijaya','SMPN 3 Jakarta','Saya sudah ikut 5 program di Guru Belajar. Sertifikatnya diakui dan materinya selalu relevan dengan kebutuhan lapangan.','#10b981'],
        ['DN','Dewi Nurhaliza','SMAN 1 Surabaya','Forum Guru Inspira membantu saya terhubung dengan guru dari Sabang sampai Merauke. Luar biasa rasanya tidak berjuang sendirian.','#7c3aed'],
      ] as [$initials,$name,$school,$quote,$color])
      <div style="background:var(--navy3);border:1px solid var(--border);border-radius:20px;padding:1.5rem;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(124,58,237,.4)'" onmouseout="this.style.borderColor='var(--border)'">
        <div style="display:flex;gap:4px;margin-bottom:1rem;">
          @for($i=0;$i<5;$i++)<svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor
        </div>
        <p style="font-size:.85rem;color:var(--text-muted);line-height:1.75;margin-bottom:1.2rem;font-style:italic;">"{{ $quote }}"</p>
        <div style="display:flex;align-items:center;gap:10px;border-top:1px solid var(--border);padding-top:1rem;">
          <div style="width:38px;height:38px;border-radius:50%;background:{{ $color }};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.82rem;color:#fff;flex-shrink:0;">{{ $initials }}</div>
          <div>
            <div style="font-size:.85rem;font-weight:800;color:#fff;">{{ $name }}</div>
            <div style="font-size:.75rem;color:var(--text-dim);">{{ $school }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- ===== CTA ===== --}}
<div class="cta-banner">
  <div class="cta-inner">
    <h2 class="cta-title">Siap Menjadi Guru yang Lebih Berdampak?</h2>
    <p class="cta-sub">Bergabunglah bersama 15.000+ guru Indonesia yang sudah memulai perjalanan kompetensi mereka di Guruverse.ID. Gratis untuk memulai.</p>
    <a href="{{ route('register') }}" class="cta-btn-main" style="text-decoration:none;margin:0 auto;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
      Daftar Gratis Sekarang
    </a>
    <div class="cta-note">
      <span>✓ Gratis selamanya</span>
      <span>✓ Tanpa kartu kredit</span>
      <span>✓ Untuk semua guru Indonesia</span>
    </div>
  </div>
</div>

{{-- ===== FOOTER ===== --}}
<footer class="footer">
  <div class="footer-inner">
    <div>
      <div class="footer-logo">
        <img src="{{ asset('asset/img/FA Logo Guruverse.ID - nrgative.png') }}" alt="Guruverse" style="height:32px;">
      </div>
      <div class="footer-addr">Jl. Jati Mulya No.9, Gumuruh<br>Kec. Batununggal, Kota Bandung, Jawa Barat 40275</div>
      <div class="footer-socials">
        <a href="https://www.instagram.com/guruverse.id" target="_blank" class="social-btn" aria-label="Instagram">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="20" height="20" rx="5" stroke="#a78bfa" stroke-width="2"/><circle cx="12" cy="12" r="4" stroke="#a78bfa" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.5" fill="#a78bfa"/></svg>
        </a>
        <a href="https://wa.me/6283133531303" target="_blank" class="social-btn" aria-label="WhatsApp">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
    </div>
    <div style="display:flex;gap:3rem;flex-wrap:wrap;">
      <div>
        <div style="font-size:.75rem;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.85rem;">Program</div>
        <div style="display:flex;flex-direction:column;gap:.5rem;">
          <a href="{{ route('home') }}" style="font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">Guru Belajar</a>
          <a href="{{ route('home') }}" style="font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">Guru Mengajar</a>
          <a href="{{ route('home') }}" style="font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">Guru Inspira</a>
        </div>
      </div>
      <div>
        <div style="font-size:.75rem;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.85rem;">Tautan</div>
        <div style="display:flex;flex-direction:column;gap:.5rem;">
          <a href="{{ route('about') }}" style="font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">Tentang Kami</a>
          <a href="{{ route('register') }}" style="font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">Daftar</a>
          <a href="{{ route('login') }}" style="font-size:.82rem;color:var(--text-muted);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">Masuk</a>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-copy">&copy; {{ date('Y') }} Guruverse.ID — ACF EDUHUB. All rights reserved.</div>
</footer>

@endsection
