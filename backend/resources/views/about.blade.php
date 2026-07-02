@include('partials.global_head')
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tentang Kami — Guruverse.ID</title>
    <meta name="description" content="Guruverse.ID adalah manifestasi dari ekosistem yang dibangun oleh ACF Eduhub. Ruang semesta peningkatan kompetensi guru Indonesia."/>
    @include('partials.global_head')
</head>
<body>
    @include('partials.global_header')
    <?php // Legacy about.php content start ?>
    <section class="about-hero">
        <div class="hero-content">
            <span class="hero-badge">Tentang Kami</span>
            <h1 class="hero-title">Guruverse.ID<br/><em>Platform Pendidikan</em></h1>
            <p class="hero-quote">
                "Misi kami adalah memberdayakan guru Indonesia dengan alat dan komunitas untuk meningkatkan kompetensi dan inovasi dalam pembelajaran."
            </p>
        </div>
    </section>
    <div class="story-container">
        <div class="story-inner">
            <span class="section-badge">Visi &amp; Misi</span>
            <h2 class="section-title">Menciptakan <em>Ekosistem</em> Belajar yang Terintegrasi</h2>
            <div class="story-grid">
                <div class="story-text">
                    <p>Guruverse.ID menyediakan platform lengkap untuk pelatihan, materi, dan kolaborasi guru di seluruh Indonesia.</p>
                </div>
                <div class="visual-card">
                    <h3 class="visual-title">Akses Mudah</h3>
                    <p class="visual-desc">Belajar kapan saja, di mana saja, dengan dukungan teknologi modern.</p>
                </div>
            </div>
        </div>
    </div>
    <?php // Legacy about.php content end ?>
    @include('partials.global_footer')
</body>
</html>
