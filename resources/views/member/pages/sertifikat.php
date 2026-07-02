<?php
// ── Query Sertifikat (hanya dimuat dari halaman ini) ──────────────────────
$certificates = [];
$res = $conn->query("SELECT cert.*, c.title as course_title, c.duration_hours, c.total_modules
    FROM gb_certificates cert
    JOIN gb_courses c ON cert.course_id = c.id
    WHERE cert.user_id = $user_id
    ORDER BY cert.issued_at DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) $certificates[] = $row;
}
?>
<div class="page" id="page-sertifikat">
  <div class="hero-section mb-16" style="padding:14px 24px;min-height:auto">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:20%;left:10%;--d:4s;--delay:0s"></span>
      <span style="top:60%;left:70%;--d:3.5s;--delay:1s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge">
        <span class="hero-badge-dot" style="background:#f9ca24"></span> Pencapaian
      </div>
      <h1 style="font-size:20px;margin-bottom:4px">Sertifikat Saya</h1>
      <p style="font-size:13px">Kumpulan sertifikat resmi dari setiap kelas yang telah Anda selesaikan.</p>
    </div>
  </div>

  <?php if (empty($certificates)): ?>
    <div class="empty-state-card">
      <div class="empty-state-icon-wrap" style="background:rgba(249,202,36,0.1);color:#f9ca24">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
        </svg>
      </div>
      <h2 class="t-h2" style="margin-bottom:12px">Belum ada sertifikat</h2>
      <p class="t-body t-muted" style="max-width:480px;margin:0 auto 32px">
        Selesaikan seluruh materi kelas dan evaluasi akhir untuk mendapatkan sertifikat resmi.
      </p>
      <button class="btn btn-primary" onclick="showPage('kelas')">
        <i class="ti ti-arrow-right" style="margin-right:8px"></i> Lanjutkan Belajar
      </button>
    </div>
  <?php else: ?>
    <!-- Certificate list rendering will go here -->
  <?php endif; ?>

</div><!-- /page-sertifikat -->
