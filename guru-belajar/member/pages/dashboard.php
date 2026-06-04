  <div class="page active" id="page-dashboard">

    <!-- Hero -->
    <style>
    .hero-section{position:relative;overflow:hidden;border-radius:24px;background:linear-gradient(135deg,#1e1b4b 0%,#312e81 40%,#4338ca 70%,#6d28d9 100%);padding:48px 40px 0 40px;display:flex;align-items:flex-end;gap:32px;min-height:260px}
    .hero-section::after{content:'';position:absolute;top:-60px;right:280px;width:320px;height:320px;background:radial-gradient(circle,rgba(167,139,250,0.35) 0%,transparent 70%);border-radius:50%;pointer-events:none;z-index:1;animation:orbFloat 6s ease-in-out infinite alternate}
    @keyframes orbFloat{from{transform:translateY(0) scale(1)}to{transform:translateY(-20px) scale(1.08)}}
    .hero-stars{position:absolute;inset:0;z-index:1;pointer-events:none}
    .hero-stars span{position:absolute;width:3px;height:3px;background:#fff;border-radius:50%;opacity:0;animation:twinkle var(--d,3s) ease-in-out var(--delay,0s) infinite}
    @keyframes twinkle{0%,100%{opacity:0;transform:scale(.5)}50%{opacity:.8;transform:scale(1.2)}}
    .hero-section .hero-text{position:relative;z-index:2;flex:1;padding-bottom:44px}
    .hero-section .hero-text h1{font-size:2rem;font-weight:800;color:#fff;margin-bottom:10px;line-height:1.2;letter-spacing:-.5px}
    .hero-section .hero-text p{font-size:14px;color:rgba(255,255,255,.78);line-height:1.65;max-width:380px}
    .hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);border-radius:20px;padding:5px 14px;font-size:11px;font-weight:700;color:#fff;margin-bottom:16px;letter-spacing:.5px}
    .hero-badge-dot{width:6px;height:6px;background:#34d399;border-radius:50%;animation:pulse-dot 2s ease-in-out infinite}
    @keyframes pulse-dot{0%,100%{box-shadow:0 0 0 0 rgba(52,211,153,.5)}50%{box-shadow:0 0 0 5px rgba(52,211,153,0)}}
    .hero-cta{display:inline-flex;align-items:center;gap:8px;margin-top:20px;background:linear-gradient(135deg,#f59e0b,#ef4444);color:#fff;font-weight:700;font-size:13px;padding:10px 22px;border-radius:24px;border:none;cursor:pointer;box-shadow:0 4px 20px rgba(245,158,11,.4);transition:transform .2s,box-shadow .2s;text-decoration:none}
    .hero-cta:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(245,158,11,.5)}
    .hero-section .hero-illustration{position:relative;z-index:2;flex-shrink:0;width:300px;align-self:flex-end}
    .hero-img-3d-wrap{position:relative;width:100%;transform-style:preserve-3d;animation:heroImgFloat 5s ease-in-out infinite alternate}
    @keyframes heroImgFloat{from{transform:translateY(0) rotateX(2deg) rotateY(-4deg)}to{transform:translateY(-14px) rotateX(-1deg) rotateY(2deg)}}
    .hero-img-3d-wrap img.hero-main-img{width:100%;height:240px;object-fit:cover;object-position:top center;display:block;border-radius:20px 20px 0 0;filter:drop-shadow(0 -8px 32px rgba(99,102,241,.5)) drop-shadow(0 24px 40px rgba(0,0,0,.5))}
    .hero-img-3d-wrap::after{content:'';position:absolute;bottom:-10px;left:50%;transform:translateX(-50%);width:70%;height:20px;background:radial-gradient(ellipse,rgba(0,0,0,.45) 0%,transparent 75%);border-radius:50%;filter:blur(6px);animation:heroShadow 5s ease-in-out infinite alternate}
    @keyframes heroShadow{from{transform:translateX(-50%) scaleX(1);opacity:.45}to{transform:translateX(-50%) scaleX(.85);opacity:.25}}
    .hero-card-float{position:absolute;background:rgba(255,255,255,.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.25);border-radius:12px;padding:8px 14px;font-size:11px;font-weight:700;color:#fff;white-space:nowrap;box-shadow:0 4px 20px rgba(0,0,0,.2);z-index:3;animation:cardFloat 4s ease-in-out infinite alternate}
    @keyframes cardFloat{from{transform:translateY(0)}to{transform:translateY(-8px)}}
    .hero-card-float.card-1{top:20px;left:-30px;animation-delay:-1s}
    .hero-card-float.card-2{top:90px;right:-24px;animation-delay:-2.5s}
    .hero-card-float.card-3{bottom:60px;left:-24px;animation-delay:-.5s}
    .hero-card-float .hcf-val{font-size:14px;font-weight:800;color:#fbbf24}
    .hero-glow-ring{position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(139,92,246,.4) 0%,rgba(99,102,241,.2) 40%,transparent 70%);filter:blur(20px);z-index:1;pointer-events:none}
    @media(max-width:768px){.hero-section{flex-direction:column;align-items:flex-start;padding:32px 24px 0;min-height:auto}.hero-section .hero-illustration{width:200px;align-self:flex-end;margin-top:-20px}.hero-img-3d-wrap img.hero-main-img{height:170px}.hero-card-float{display:none}}
    </style>
    <div class="hero-section mb-24">
      <div class="hero-stars" aria-hidden="true">
        <span style="top:12%;left:8%;--d:2.5s;--delay:0s"></span>
        <span style="top:28%;left:18%;--d:3.2s;--delay:0.8s"></span>
        <span style="top:55%;left:12%;--d:2s;--delay:0.3s"></span>
        <span style="top:20%;left:55%;--d:4s;--delay:1.2s"></span>
        <span style="top:70%;left:45%;--d:3s;--delay:0.6s"></span>
        <span style="top:10%;left:72%;--d:2.8s;--delay:1.8s"></span>
      </div>
      <div class="hero-text">
        <div class="hero-badge"><span class="hero-badge-dot"></span> Platform Belajar Guru #1</div>
        <h1>Halo, <?= htmlspecialchars($user_name) ?>! </h1>
        <p>Semangat belajar hari ini! Terus tingkatkan kompetensimu<br>untuk pendidikan Indonesia yang lebih baik.</p>
        <a href="#" onclick="showPage('modul'); return false;" class="hero-cta">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
          Mulai Belajar Sekarang
        </a>
      </div>
      <div class="hero-illustration">
        <div class="hero-glow-ring"></div>
        <div class="hero-img-3d-wrap">
          <div class="hero-card-float card-1"> <span class="hcf-val"><?= $total_kelas ?></span> Kelas</div>
          <div class="hero-card-float card-2"> <span class="hcf-val"><?= $total_sertifikat ?></span> Sertifikat</div>
          <div class="hero-card-float card-3"> <span class="hcf-val"><?= $total_kelas > 0 ? round(($kelas_selesai / max($total_kelas, 1)) * 100) : 0 ?>%</span> Progress</div>
          <img class="hero-main-img" src="/guruverse/asset/img/hero-teachers.png" alt="Guru-guru GuruVerse" loading="eager">
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="icon-box icon-box-md icon-box-primary"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
        <div>
          <div class="stat-value"><?= $total_kelas > 0 ? round(($kelas_selesai / max($total_kelas, 1)) * 100) : 0 ?>%</div>
          <div class="stat-label">Progress Belajar</div>
          <div class="stat-sub">Total <?= $kelas_selesai ?> dari <?= $total_kelas ?> kelas</div>
          <div class="progress" style="width:140px;margin-top:6px"><div class="progress-bar" style="width:<?= $total_kelas > 0 ? round(($kelas_selesai / max($total_kelas, 1)) * 100) : 0 ?>%"></div></div>
        </div>
      </div>
      <div class="stat-card">
        <div class="icon-box icon-box-md icon-box-blue"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
        <div>
          <div class="stat-value"><?= $total_kelas ?></div>
          <div class="stat-label">Kelas Aktif</div>
          <div class="stat-sub">Sedang berlangsung</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="icon-box icon-box-md icon-box-warning"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
        <div>
          <div class="stat-value"><?= $total_sertifikat ?></div>
          <div class="stat-label">Sertifikat</div>
          <div class="stat-sub">Sertifikat diperoleh</div>
        </div>
      </div>
      <div class="stat-card" >
        <div class="icon-box icon-box-md" style="background:rgba(232,67,147,0.1)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E84393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
        <div>
          <div class="stat-value" style="color:#E84393">&mdash; Hari</div>
          <div class="stat-label">Streak Belajar</div>
          <div class="stat-sub" >Mulai belajar untuk membangun streak</div>
        </div>
      </div>
      <div class="stat-card" style="cursor:pointer" onclick="showPage('cart')">
        <div class="icon-box icon-box-md" style="background:rgba(109, 40, 217, 0.1)"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#6d28d9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg></div>
        <div>
          <div class="stat-value" style="color:#6d28d9" id="gvDashboardCartCount">0</div>
          <div class="stat-label">Keranjang Saya</div>
          <div class="stat-sub">Buku & e-book siap checkout</div>
        </div>
      </div>
    </div>

    <!-- Continue + Calendar -->
    <div class="layout-two-col mb-24">
      <div>
        <div class="section-head">
          <h2>Lanjutkan Belajar</h2>
        </div>

        <div style="text-align:center;padding:28px 20px;background:var(--c-bg-card);border-radius:14px;border:2px dashed var(--c-border)">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:10px;opacity:0.4"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
          <div style="font-weight:600;color:var(--c-text-muted);margin-bottom:4px">Belum ada kelas aktif</div>
          <div style="font-size:12px;color:var(--c-text-muted);opacity:0.7">Progress belajar akan muncul di sini setelah Anda mendaftar kelas.</div>
        </div>

      </div>


      <!-- Calendar -->
      <div class="card card-body">
        <div class="cal-header">
          <button class="cal-nav">&lsaquo;</button>
          <span class="cal-month">Mei 2026</span>
          <button class="cal-nav">&rsaquo;</button>
        </div>
        <div class="cal-days">
          <div class="cal-day-label">Sen</div><div class="cal-day-label">Sel</div>
          <div class="cal-day-label">Rab</div><div class="cal-day-label">Kam</div>
          <div class="cal-day-label">Jum</div><div class="cal-day-label">Sab</div>
          <div class="cal-day-label">Min</div>
          <div class="cal-day cal-empty"></div><div class="cal-day cal-empty"></div>
          <div class="cal-day cal-empty"></div><div class="cal-day cal-empty"></div>
          <div class="cal-day has-event" title="Hari Buruh">1</div><div class="cal-day">2</div><div class="cal-day">3</div>
          <div class="cal-day">4</div><div class="cal-day">5</div><div class="cal-day today">6</div>
          <div class="cal-day">7</div><div class="cal-day">8</div><div class="cal-day">9</div><div class="cal-day">10</div>
          <div class="cal-day">11</div><div class="cal-day">12</div><div class="cal-day">13</div>
          <div class="cal-day has-event" title="Kenaikan Yesus Kristus">14</div><div class="cal-day">15</div><div class="cal-day">16</div><div class="cal-day">17</div>
          <div class="cal-day">18</div><div class="cal-day">19</div><div class="cal-day">20</div>
          <div class="cal-day">21</div><div class="cal-day">22</div><div class="cal-day">23</div><div class="cal-day">24</div>
          <div class="cal-day">25</div><div class="cal-day">26</div>
          <div class="cal-day has-event" title="Hari Raya Idul Adha">27</div>
          <div class="cal-day">28</div><div class="cal-day">29</div><div class="cal-day">30</div>
          <div class="cal-day has-event" title="Hari Raya Waisak">31</div>
        </div>
        <div class="flex items-center gap-12 mt-8" style="font-size:10px;color:var(--c-text-muted)">
          <div class="flex items-center gap-4"><div style="width:8px;height:8px;border-radius:50%;background:var(--c-primary)"></div> Hari libur nasional</div>
          <div class="flex items-center gap-4"><div style="width:8px;height:8px;border-radius:50%;background:var(--c-success)"></div> Hari ini</div>
          <span class="link-action" style="margin-left:auto">Lihat Jadwal Lengkap</span>
        </div>
      </div>

    </div>

    <!-- Rekomendasi untuk Anda -->
    <div class="section-head">
      <h2>Rekomendasi untuk Anda</h2>
    </div>
    <div style="text-align:center;padding:32px 20px;background:var(--c-bg-card);border-radius:14px;border:2px dashed var(--c-border);margin-bottom:24px">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px;opacity:0.4"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      <div style="font-weight:600;color:var(--c-text-muted);margin-bottom:4px">Kelas akan segera hadir</div>
      <div style="font-size:12px;color:var(--c-text-muted);opacity:0.7">Rekomendasi kelas akan muncul di sini berdasarkan minat dan progress belajar Anda.</div>
    </div>

    <!-- Program Populer untuk Guru (Darkened Background for better contrast) -->
    <div style="background: rgba(108, 92, 231, 0.04); border-radius: 24px; padding: 32px 24px; margin-bottom: 32px; border: 1px solid rgba(108, 92, 231, 0.08);">
      <div style="text-align:center;margin-bottom:24px">
        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--c-primary);margin-bottom:8px">PROGRAM PILIHAN</div>
        <h2 class="t-h2">Program Populer untuk Guru</h2>
        <p class="t-body t-muted mt-4">Pilih program terbaik sesuai kebutuhan pengembangan dirimu</p>
      </div>
      
      <div style="text-align:center;padding:40px 20px;background:#fff;border-radius:18px;border:2px dashed var(--c-border);box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px;opacity:0.4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        <div style="font-weight:600;color:var(--c-text-muted);margin-bottom:4px">Kelas akan segera hadir</div>
        <div style="font-size:12px;color:var(--c-text-muted);opacity:0.7">Program populer akan ditampilkan di sini ketika sudah tersedia.</div>
      </div>
    </div>



    <!-- Community -->
    <div class="community-banner mb-24">
      <div class="community-text">
        <h2>Belajar Bersama, Berkembang Bersama</h2>
        <p>Diskusi, kolaborasi, dan berbagi pengalaman bersama guru lain dalam komunitas positif.</p>
        <div class="community-feats">
          <div class="community-feat"><span class="community-feat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Forum diskusi aktif</div>
          <div class="community-feat"><span class="community-feat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Kolaborasi proyek kelas</div>
          <div class="community-feat"><span class="community-feat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span> Berbagi tersembunyi</div>
        </div>
      </div>
      <div style="flex-shrink:0"><img src="/guruverse/asset/img/community_teachers_muslim (2).png" alt="Komunitas Guru" loading="lazy" style="width:280px;height:190px;object-fit:cover;border-radius:16px;display:block;box-shadow:0 4px 20px rgba(0,0,0,0.3)"></div>
    </div>

    <!-- Features -->
    <div style="text-align:center;margin-bottom:20px">
      <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--c-primary);margin-bottom:8px">FITUR UTAMA</div>
      <h2 class="t-h2 mb-4">Semua yang Kamu Butuhkan untuk Berkembang</h2>
      <p class="t-body t-muted">Fitur lengkap untuk mendukung perjalanan belajarmu.</p>
    </div>

    <div class="features-grid mb-24">
      <div class="feature-card">
        <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="/guruverse/asset/img/feature_kelas_online.png" alt="Kelas Online" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block"></div>
        <div class="feature-title">Kelas Online &amp; Webinar</div>
        <div class="feature-desc">Belajar langsung bersama mentor profesional melalui kelas online interaktif.</div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Live session interaktif</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Tanya jawab langsung</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Rekaman dapat diputar ulang</span></div>
      </div>
      <div class="feature-card">
        <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="/guruverse/asset/img/feature_modul_belajar.png" alt="Modul Belajar" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block"></div>
        <div class="feature-title">Modul Pembelajaran Terstruktur</div>
        <div class="feature-desc">Belajar mandiri dengan materi yang disusun sistematis dan mudah dipahami.</div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Materi ringkas &amp; fokus</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Video, infografis &amp; latihan</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Progress belajar otomatis</span></div>
      </div>
      <div class="feature-card">
        <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="/guruverse/asset/img/feature_sertifikat.png" alt="Sertifikat" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top center;display:block"></div>
        <div class="feature-title">Sertifikat Digital</div>
        <div class="feature-desc">Dapatkan sertifikat resmi sebagai bukti pengembangan diri dan kompetensi.</div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Sertifikat resmi &amp; terverifikasi</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Bagikan ke LinkedIn</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Mendukung portofolio &amp; karier</span></div>
      </div>
    </div>

  <script>
    (function() {
      function updateDashboardCartCount() {
        const cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
        const el = document.getElementById('gvDashboardCartCount');
        if (el) el.textContent = cart.length;
      }
      // Run once when loaded
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateDashboardCartCount);
      } else {
        updateDashboardCartCount();
      }
      // Run on storage changes
      window.addEventListener('storage', updateDashboardCartCount);
      
      // Override or extend showPage to update count when user transitions back to dashboard
      const origShowPage = window.showPage;
      window.showPage = function(name) {
        if (typeof origShowPage === 'function') origShowPage(name);
        updateDashboardCartCount();
        if (name === 'cart' && typeof renderFullCart === 'function') {
          renderFullCart();
        }
      };
    })();
  </script>
  </div><!-- /page-dashboard -->
