<!DOCTYPE html>
<html lang="id">
<head>
<title>Testimoni Guru — Guruverse.ID</title>
<?php include 'global_head.php'; ?>
<style>
.testimonial-wrapper{
  background: radial-gradient(at 0% 100%, #fff1f2 0%, transparent 50%), 
              radial-gradient(at 100% 0%, #f0fdf4 0%, transparent 50%),
              radial-gradient(at 50% 50%, #f5f3ff 0%, transparent 100%);
  background-color: #f1f5f9;
  border-radius:64px;
  padding:100px 5% 80px;
  margin:20px 2% 80px;
  border: 1px solid rgba(255,255,255,0.5);
  position:relative;
  overflow:visible;
}

.testimonial-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap:32px;
  max-width:1200px;
  margin:0 auto;
}

.testi-card {
  background: var(--glass);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid var(--glass-border);
  border-radius: 32px;
  padding: 40px;
  transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
  box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.testi-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 40px 80px -15px rgba(124, 58, 237, 0.15);
  background: rgba(255, 255, 255, 0.9);
}

.testi-content {
  font-size: 16px;
  line-height: 1.6;
  color: #475569;
  margin-bottom: 30px;
  font-style: italic;
  position: relative;
}
.testi-content::before {
  content: '“';
  position: absolute;
  top: -20px; left: -10px;
  font-size: 64px;
  color: var(--purple);
  opacity: 0.1;
  font-family: serif;
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
  border: 2px solid #fff;
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
.user-details h4 {
  font-size: 16px;
  font-weight: 800;
  color: var(--navy);
  margin-bottom: 2px;
}
.user-details p {
  font-size: 13px;
  color: #94a3b8;
  font-weight: 500;
}

.stars {
  color: #fbbf24;
  margin-bottom: 12px;
  font-size: 14px;
  display: flex;
  gap: 2px;
}

@media (max-width: 768px) {
  .testimonial-wrapper { padding: 60px 20px; border-radius: 32px; }
  .testimonial-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<?php include 'global_header.php'; ?>

<div class="testimonial-wrapper">
  <div class="floating-blob" style="top:5%; right:10%; width:180px; height:180px; background:linear-gradient(135deg, #fef3c7, #fbbf24); opacity:0.4;"></div>
  <div class="floating-blob" style="bottom:10%; left:5%; width:150px; height:150px; background:linear-gradient(135deg, #ddd6fe, #7c3aed); opacity:0.3; animation-delay: -3s;"></div>

  <header class="header-wrapper">
    <span class="badge-premium">Success Stories</span>
    <h1 class="title-premium">Apa Kata <em>Para Guru?</em></h1>
    <p class="desc-premium">Kisah inspiratif dari rekan-rekan pendidik yang telah bertransformasi bersama ekosistem Guruverse.ID.</p>
  </header>

  <div class="testimonial-grid">
    <!-- Testimonial 1 -->
    <div class="testi-card">
      <div class="stars">★★★★★</div>
      <p class="testi-content">"Materi yang diajarkan sangat relevan dengan tantangan mengajar di era digital. Sekarang saya lebih percaya diri menggunakan teknologi di kelas."</p>
      <div class="user-info">
        <img src="https://i.pravatar.cc/150?u=1" alt="User" class="user-avatar">
        <div class="user-details">
          <h4>Budi Santoso, S.Pd.</h4>
          <p>Guru Matematika, Bandung</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 2 -->
    <div class="testi-card">
      <div class="stars">★★★★★</div>
      <p class="testi-content">"Jejaring yang saya dapatkan di sini luar biasa. Kami saling berbagi modul ajar dan strategi kreatif setiap minggunya."</p>
      <div class="user-info">
        <img src="https://i.pravatar.cc/150?u=2" alt="User" class="user-avatar">
        <div class="user-details">
          <h4>Siti Aminah</h4>
          <p>Guru SD, Surabaya</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 3 -->
    <div class="testi-card">
      <div class="stars">★★★★★</div>
      <p class="testi-content">"Transformasi cara mengajar saya benar-benar terjadi setelah mengikuti sertifikasi intensif di Guruverse. Siswa jadi lebih antusias!"</p>
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

<?php include 'global_footer.php'; ?>

</body>
</html>
