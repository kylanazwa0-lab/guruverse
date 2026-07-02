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
    <div class="hero-text gv-reveal">
      <div class="hero-eyebrow">Ruang Semesta Guru Indonesia</div>
      <h1 class="hero-title">Semesta Kompetensi,<br/>Untuk Guru Indonesia</h1>
      <p class="hero-subtitle">Guruverse.ID adalah ruang semesta bagi guru Indonesia untuk terhubung, bertumbuh, dan menjadi lebih kompeten bersama.</p>
      <div class="hero-actions">
        <a href="{{ route('register') }}" class="btn-primary">Register Now!</a>
        <a href="{{ route('learn-more') }}" class="btn-secondary">Pelajari Lebih Lanjut</a>
      </div>
      <div class="hero-search">
        <div class="search-box">
          <input type="search" class="search-input" placeholder="Cari kelas, program, dan komunitas guru..." aria-label="Search Guruverse" />
          <button class="search-btn" type="button" data-search-button>Cari Sekarang</button>
        </div>
        <div class="hero-tags">
          <button class="tag-pill" type="button" data-search-term="Program Guru">Program Guru</button>
          <button class="tag-pill" type="button" data-search-term="Webinar">Webinar</button>
          <button class="tag-pill" type="button" data-search-term="Sertifikasi">Sertifikasi</button>
          <button class="tag-pill" type="button" data-search-term="Komunitas">Komunitas</button>
          <button class="tag-pill" type="button" data-search-term="Pelatihan">Pelatihan</button>
        </div>
      </div>
    </div>
    <div class="hero-image">
      <div class="gv-parallax-wrap">
        <img src="{{ asset('asset/img/hero-teachers.png') }}" alt="Guru Indonesia Bersama" class="gv-parallax-img" style="transform-origin: center top;" />
      </div>
    </div>
  </div>
</section>

<section class="hero-features" id="learn-more">
  <div class="section-header">
    <div class="section-eyebrow gv-reveal">Fitur Unggulan</div>
    <h2 class="section-title gv-reveal">Fitur Utama Guruverse.ID</h2>
    <p class="section-subtitle gv-reveal">Bawa pengalaman pembelajaran guru ke tingkat lebih tinggi dengan fitur interaktif, komunitas kuat, dan tracking yang mudah dipahami.</p>
  </div>
  <div class="feature-grid">
    <article class="feature-card gv-reveal">
      <h3 class="feature-card-title">Kursus Interaktif</h3>
      <p class="feature-card-desc">Akses pembelajaran langsung dengan modul yang mudah diikuti, kuis ringkas, dan mentor pendamping.</p>
      <button class="feature-card-link" type="button" onclick="window.location.href='{{ route('guru-belajar') }}'">Pelajari Program</button>
    </article>
    <article class="feature-card gv-reveal">
      <h3 class="feature-card-title">Komunitas Pengajar</h3>
      <p class="feature-card-desc">Terhubung dengan guru lain, berbagi praktik terbaik, dan bangun jaringan profesional yang kolaboratif.</p>
      <button class="feature-card-link" type="button" onclick="window.location.href='{{ route('guru-inspira') }}'">Gabung Komunitas</button>
    </article>
    <article class="feature-card gv-reveal">
      <h3 class="feature-card-title">Tracking Kemajuan</h3>
      <p class="feature-card-desc">Pantau perkembangan kompetensi guru dengan dashboard yang jelas, laporan mudah dibaca, dan rekomendasi lanjutan.</p>
      <button class="feature-card-link" type="button" onclick="window.location.href='{{ route('guru-mengajar') }}'">Lihat Dashboard</button>
    </article>
  </div>
</section>

{{-- PILLARS --}}
<section class="pillars">
  <div class="section-header">
    <h2 class="section-title gv-reveal">Pilar Utama Guruverse.ID</h2>
    <p class="section-subtitle gv-reveal">Membangun ekosistem pendidikan yang mendukung peningkatan kompetensi guru secara pedagogik, profesional, personal, sosial, digital, dan inovatif.</p>
  </div>
  <div class="pillars-grid">

    {{-- Card 1 --}}
    <div class="pillar-card gv-reveal" role="button" tabindex="0" onclick="window.location.href='{{ route('guru-belajar') }}'" onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location.href='{{ route('guru-belajar') }}'; }">
      <div class="pillar-img" style="background:linear-gradient(160deg,#f1f5f9,#b2d8ce)">
        <img src="{{ asset('asset/img/guru-wanita.png') }}" alt="Guru Belajar"/>
      </div>
      <div class="pillar-body">
        <div class="pillar-title">Guru Belajar</div>
        <div class="pillar-desc">Belajar adalah perjalanan tanpa akhir. Melalui Guru Belajar, Anda dapat memperdalam kompetensi pedagogik dan profesional dengan kursus intensif, webinar interaktif, dan sertifikasi resmi. Fleksibel, terstruktur, dan relevan dengan kebutuhan zaman - jadilah guru yang terus tumbuh dan menjadi teladan bagi murid.</div>
        <button class="pillar-arrow" aria-label="Lihat Guru Belajar">
          <svg width="14" height="11" viewBox="0 0 16 12" fill="none"><path d="M1 6h14M9 1l6 5-6 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    {{-- Card 2 --}}
    <div class="pillar-card gv-reveal" role="button" tabindex="0" onclick="window.location.href='{{ route('guru-mengajar') }}'" onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location.href='{{ route('guru-mengajar') }}'; }">
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
    <div class="pillar-card gv-reveal" role="button" tabindex="0" onclick="window.location.href='{{ route('guru-inspira') }}'" onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location.href='{{ route('guru-inspira') }}'; }">
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

{{-- TESTIMONI SECTION --}}
<style>
.testimonial-wrapper{
  background: radial-gradient(at 0% 100%, rgba(255, 241, 242, 0.05) 0%, transparent 50%), 
              radial-gradient(at 100% 0%, rgba(240, 253, 244, 0.05) 0%, transparent 50%),
              radial-gradient(at 50% 50%, rgba(245, 243, 255, 0.05) 0%, transparent 100%);
  background-color: var(--bg);
  border-radius:64px;
  padding:100px 5% 80px;
  margin:20px 2% 80px;
  border: 1px solid var(--border);
  position:relative;
  overflow:hidden;
}

@keyframes float-blob {
  0% { transform: translate(0, 0) scale(1); }
  100% { transform: translate(-30px, 40px) scale(1.1); }
}

.testimonial-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap:32px;
  max-width:1200px;
  margin:0 auto;
}

.testi-card {
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid var(--border);
  border-radius: 32px;
  padding: 40px;
  transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
  box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: relative;
  overflow: hidden;
}
[data-theme="dark"] .testi-card {
  background: rgba(30, 41, 59, 0.5);
  border-color: rgba(255, 255, 255, 0.1);
}
.testi-card::before {
  content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
  background: linear-gradient(90deg, transparent, var(--purple), transparent);
  opacity: 0; transition: opacity 0.4s ease;
}
.testi-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 40px 80px -15px rgba(124, 58, 237, 0.2);
  border-color: var(--purple);
}
.testi-card:hover::before { opacity: 1; }

.testi-content {
  font-size: 16px;
  line-height: 1.6;
  color: var(--text-muted);
  margin-bottom: 30px;
  font-style: italic;
  position: relative;
  z-index: 1;
}
.testi-content::before {
  content: '“';
  position: absolute;
  top: -20px; left: -10px;
  font-size: 64px;
  color: var(--purple);
  opacity: 0.15;
  font-family: serif;
  z-index: -1;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 16px;
}
.user-avatar {
  width: 56px;
  height: 56px;
  border-radius: 18px;
  object-fit: cover;
  border: 2px solid var(--border);
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
.user-details h4 {
  font-size: 16px;
  font-weight: 800;
  color: var(--text);
  margin-bottom: 2px;
}
.user-details p {
  font-size: 13px;
  color: var(--text-dim);
  font-weight: 500;
}

.stars {
  color: #fbbf24;
  margin-bottom: 12px;
  font-size: 14px;
  display: flex;
  gap: 2px;
}

.badge-premium {
  display:inline-block;font-size:10px;font-weight:800;
  letter-spacing:.14em;text-transform:uppercase;
  padding:5px 14px;border-radius:50px;border:1px solid;
  margin-bottom:16px;
  background:rgba(167,139,250,.15);color:var(--purple-light);border-color:rgba(167,139,250,.35);
}
.title-premium {
  font-size:clamp(32px,4.5vw,52px);font-weight:900;color:var(--text);line-height:1.1;margin-bottom:14px;letter-spacing:-.04em;
}
.title-premium em {
  font-style:normal;color:var(--purple);
}
.desc-premium {
  font-size:clamp(14px,1.5vw,16px);color:var(--text-muted);line-height:1.75;margin-bottom:48px; max-width: 600px;
}

@media (max-width: 768px) {
  .testimonial-wrapper { padding: 60px 20px; border-radius: 32px; margin: 20px 0; }
  .testimonial-grid { grid-template-columns: 1fr; }
}
</style>

<div class="testimonial-wrapper">
  <div class="floating-blob" style="position:absolute; top:5%; right:10%; width:300px; height:300px; background:linear-gradient(135deg, rgba(254,243,199,0.3), rgba(251,191,36,0.3)); border-radius:50%; filter:blur(60px); animation: float-blob 20s ease-in-out infinite alternate;"></div>
  <div class="floating-blob" style="position:absolute; bottom:10%; left:5%; width:250px; height:250px; background:linear-gradient(135deg, rgba(221,214,254,0.3), rgba(124,58,237,0.3)); border-radius:50%; filter:blur(60px); animation: float-blob 25s ease-in-out infinite alternate-reverse;"></div>

  <header class="header-wrapper gv-reveal" style="text-align: center; display: flex; flex-direction: column; align-items: center; position:relative; z-index:2;">
    <span class="badge-premium">Success Stories</span>
    <h1 class="title-premium">Apa Kata <em>Para Guru?</em></h1>
    <p class="desc-premium">Kisah inspiratif dari rekan-rekan pendidik yang telah bertransformasi bersama ekosistem Guruverse.ID.</p>
  </header>

  <div class="testimonial-grid" style="position:relative; z-index:2;">
    <!-- Testimonial 1 -->
    <div class="testi-card gv-reveal delay-1">
      <div>
        <div class="stars">★★★★★</div>
        <p class="testi-content">"Materi yang diajarkan sangat relevan dengan tantangan mengajar di era digital. Sekarang saya lebih percaya diri menggunakan teknologi di kelas."</p>
      </div>
      <div class="user-info">
        <img src="https://i.pravatar.cc/150?u=1" alt="User" class="user-avatar">
        <div class="user-details">
          <h4>Budi Santoso, S.Pd.</h4>
          <p>Guru Matematika, Bandung</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 2 -->
    <div class="testi-card gv-reveal delay-2">
      <div>
        <div class="stars">★★★★★</div>
        <p class="testi-content">"Jejaring yang saya dapatkan di sini luar biasa. Kami saling berbagi modul ajar dan strategi kreatif setiap minggunya."</p>
      </div>
      <div class="user-info">
        <img src="https://i.pravatar.cc/150?u=2" alt="User" class="user-avatar">
        <div class="user-details">
          <h4>Siti Aminah</h4>
          <p>Guru SD, Surabaya</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 3 -->
    <div class="testi-card gv-reveal delay-3">
      <div>
        <div class="stars">★★★★★</div>
        <p class="testi-content">"Transformasi cara mengajar saya benar-benar terjadi setelah mengikuti sertifikasi intensif di Guruverse. Siswa jadi lebih antusias!"</p>
      </div>
      <div class="user-info">
        <img src="https://i.pravatar.cc/150?u=3" alt="User" class="user-avatar">
        <div class="user-details">
          <h4>Rizky Pratama</h4>
          <p>Guru Fisika, Jakarta</p>
        </div>
      </div>
    </div>
  </div>
</div>

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

