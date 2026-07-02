<?php
// ── Query Sertifikat (hanya dimuat dari halaman ini) ──────────────────────
$certificates = [];
    $stmt_cert = $conn->prepare("SELECT cert.id, cert.certificate_number, cert.issued_at, cert.is_verified, cert.pdf_path,
    c.title as course_title, c.duration_hours, c.total_modules,
    (SELECT ROUND(AVG(score)) FROM gb_quiz_results WHERE course_id = cert.course_id AND user_id = cert.user_id) as final_score
    FROM gb_certificates cert
    JOIN gb_courses c ON cert.course_id = c.id
    WHERE cert.user_id = ?
    ORDER BY cert.issued_at DESC");
$stmt_cert->bind_param("i", $user_id);
$stmt_cert->execute();
$res_cert = $stmt_cert->get_result();
if ($res_cert) {
    while ($row = $res_cert->fetch_assoc()) $certificates[] = $row;
}
$stmt_cert->close();
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
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:20px;">
      <?php foreach ($certificates as $cert): ?>
      <div class="card p-0 overflow-hidden" style="border:1px solid var(--c-border-light)">
        <div style="height:180px;background:var(--c-bg);display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--c-border-light);position:relative">
          <div style="width:120px;height:84px;background:linear-gradient(135deg,#f9ca24,#f39c12);border-radius:8px;box-shadow:0 8px 16px rgba(243,156,18,0.3);display:flex;align-items:center;justify-content:center;color:#fff;border:4px solid #fff;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
          </div>
          <div style="position:absolute;top:12px;right:12px;background:#fff;color:var(--c-text);font-size:10px;font-weight:800;padding:4px 8px;border-radius:6px;box-shadow:0 2px 4px rgba(0,0,0,0.05)">
            <?= !empty($cert['certificate_number']) ? 'ID: ' . htmlspecialchars($cert['certificate_number']) : 'Belum dicetak' ?>
          </div>
        </div>
        <div style="padding:20px;">
          <h3 style="font-size:15px;font-weight:800;margin-bottom:8px;line-height:1.4"><?= htmlspecialchars($cert['course_title']) ?></h3>
          <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:6px;">
            Diterbitkan: <?= date('d M Y', strtotime($cert['issued_at'])) ?>
          </div>
          <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:20px;">
            Nilai Akhir: <strong style="color:var(--c-text); font-size:13px;"><?= $cert['final_score'] !== null ? $cert['final_score'] : 'Belum Selesai' ?></strong>
          </div>
          <div style="display:flex;gap:10px;">
            <?php if (!empty($cert['pdf_path'])): ?>
            <button class="btn btn-primary btn-sm" style="flex:1" onclick="viewCertificate('<?= htmlspecialchars($cert['pdf_path']) ?>')">Lihat Sertifikat</button>
            <?php else: ?>
            <button class="btn btn-primary btn-sm" style="flex:1;opacity:0.5;cursor:not-allowed" disabled title="Sertifikat belum tersedia">Sertifikat Diproses</button>
            <?php endif; ?>
            <button class="btn btn-outline btn-sm" style="width:36px;padding:0;display:flex;align-items:center;justify-content:center;" title="Bagikan Sertifikat" onclick="shareCertificate('<?= htmlspecialchars($cert['course_title']) ?>', '<?= htmlspecialchars($cert['certificate_number']) ?>', '<?= !empty($cert['pdf_path']) ? '/uploads/certificates/' . htmlspecialchars($cert['pdf_path']) : '' ?>')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div><!-- /page-sertifikat -->

<script>
function shareCertificate(courseTitle, certNo, certUrl) {
  var shareText = 'Saya telah menyelesaikan kelas "' + courseTitle + '" di Guruverse.id! 🎓\nNo. Sertifikat: ' + certNo;
  var fullUrl = certUrl ? (window.location.origin + certUrl) : window.location.href;

  if (navigator.share) {
    navigator.share({
      title: 'Sertifikat Guruverse - ' + courseTitle,
      text: shareText,
      url: fullUrl
    }).catch(function() {});
  } else {
    // Fallback: copy to clipboard
    var copyText = shareText + '\n' + fullUrl;
    navigator.clipboard.writeText(copyText).then(function() {
      gbShowAlert('Disalin! 📋', 'Link sertifikat berhasil disalin ke clipboard. Anda bisa langsung paste dan bagikan!', 'success');
    }).catch(function() {
      prompt('Salin link sertifikat berikut:', fullUrl);
    });
  }
}
</script>
