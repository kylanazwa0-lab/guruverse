<!DOCTYPE html>
<html lang="id">
<head>
<title>Artikel — Guruverse.ID</title>
<?php include 'global_head.php'; ?>
<style>
/* ===== HERO SECTION ===== */
.ts-hero {
  padding: 50px 5% 40px;
  text-align: left;
  max-width: 1400px;
  margin: 0 auto;
}

.ts-hero-badge {
  font-family: inherit;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--primary);
  margin-bottom: 24px;
  display: block;
}

.ts-hero-title {
  font-family: inherit;
  font-size: 32px;
  font-weight: 800;
  color: var(--text);
  line-height: 1.2;
  letter-spacing: -0.02em;
  margin-bottom: 20px;
  margin-top: 0;
}

.ts-hero-title em {
  font-style: normal;
  font-weight: 800;
  color: var(--primary);
}

.ts-hero-subtitle {
  font-family: inherit;
  font-size: 16px;
  font-weight: 400;
  color: var(--text-muted);
  line-height: 1.75;
  margin: 0;
}

/* ===== ARTICLES SECTION ===== */
.ts-articles-container {
  padding: 0 5% 120px;
  max-width: 1400px;
  margin: 0 auto;
}

.ts-art-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 24px;
}

/* ThoughtStream Card (Default) */
.ts-art-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 24px;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  text-decoration: none;
  box-sizing: border-box;
}

.ts-art-card:hover {
  border-color: var(--primary);
  transform: translateY(-5px);
}

.ts-art-meta {
  font-family: inherit;
  font-size: 11px;
  font-weight: 500;
  color: var(--text-muted);
  margin-bottom: 16px;
  display: flex;
  gap: 12px;
  align-items: center;
}

.ts-art-meta span.category {
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--primary);
}

.ts-art-title {
  font-family: inherit;
  font-size: 18px;
  font-weight: 700;
  color: var(--text);
  line-height: 1.4;
  letter-spacing: -0.01em;
  margin-top: 0;
  margin-bottom: 16px;
}

.ts-art-excerpt {
  font-family: inherit;
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.7;
  margin-bottom: 24px;
  margin-top: 0;
  flex-grow: 1;
}

.ts-read-more {
  font-family: inherit;
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-top: auto;
  padding: 10px 16px;
  border: none;
  background: transparent;
  align-self: flex-start;
  margin-left: -16px;
}

/* Icon style */
.ts-art-icon {
  width: 24px;
  height: 24px;
  color: var(--primary);
  margin-bottom: 24px;
}

@media(max-width:900px){
  .ts-hero { padding: 84px 5% 60px; }
  .ts-articles-container { padding: 0 5% 84px; }
}
@media(max-width:600px){
  .ts-hero { padding: 60px 5% 48px; }
  .ts-articles-container { padding: 0 5% 60px; }
}
</style>
</head>
<body>

<?php include 'global_header.php'; ?>

<section class="ts-hero">
  <span class="ts-hero-badge">Articles & Insights</span>
  <h1 class="ts-hero-title">Wawasan Seputar Dunia <em>Pendidikan Digital</em></h1>
  <p class="ts-hero-subtitle">Kumpulan artikel, tips mengajar, dan berita terbaru mengenai transformasi guru di Indonesia.</p>
</section>

<div class="ts-articles-container">
  <div class="ts-art-grid">
    <!-- Article 1 -->
    <a href="https://garuda.kemdiktisaintek.go.id/" target="_blank" class="ts-art-card art-card">
      <svg class="ts-art-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      <div class="ts-art-meta">
        <span class="category">Referensi</span>
        <span>22 Mei 2026</span>
      </div>
      <h3 class="ts-art-title">Garba Rujukan Digital (GARUDA) Kemdikbudristek</h3>
      <p class="ts-art-excerpt">Portal referensi ilmiah Indonesia untuk penelusuran publikasi akademik dan riset bagi para guru, peneliti, dan akademisi.</p>
      <span class="ts-read-more">Baca Selengkapnya →</span>
    </a>

    <!-- Article 2 -->
    <a href="https://dispendik.mojokertokab.go.id/artikel-pentingnya-pendidikan-bagi-masa-depan/" target="_blank" class="ts-art-card art-card">
      <svg class="ts-art-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      <div class="ts-art-meta">
        <span class="category">Wawasan</span>
        <span>20 Mei 2026</span>
      </div>
      <h3 class="ts-art-title">Pentingnya Pendidikan bagi Masa Depan</h3>
      <p class="ts-art-excerpt">Pendidikan adalah kunci utama yang membuka pintu peluang tanpa batas dan membangun fondasi kuat bagi masa depan generasi penerus bangsa.</p>
      <span class="ts-read-more">Baca Selengkapnya →</span>
    </a>

    <!-- Article 3 -->
    <a href="https://www.kompasiana.com/tag/pendidikan" target="_blank" class="ts-art-card art-card">
      <svg class="ts-art-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
      <div class="ts-art-meta">
        <span class="category">Opini & Berita</span>
        <span>21 Mei 2026</span>
      </div>
      <h3 class="ts-art-title">Kumpulan Artikel Pendidikan Kompasiana</h3>
      <p class="ts-art-excerpt">Temukan ragam perspektif, inovasi, pengalaman mengajar, dan opini dari para pendidik maupun masyarakat mengenai dunia pendidikan di Indonesia.</p>
      <span class="ts-read-more">Baca Selengkapnya →</span>
    </a>
  </div>
</div>

<?php include 'global_footer.php'; ?>

</body>
</html>
