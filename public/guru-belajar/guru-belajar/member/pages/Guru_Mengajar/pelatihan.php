<?php /* Pelatihan Offline — Guru Mengajar */ 
$has_pelatihan_db = false;
$check_pelatihan = $conn->query("SHOW TABLES LIKE 'gb_mengajar_pelatihan'");
if ($check_pelatihan && $check_pelatihan->num_rows > 0) {
    $has_pelatihan_db = true;
    
    $uid = (int)($_SESSION['member_int_id'] ?? 3);
    
    // Ambil pelatihan yang sudah didaftar user (via batch)
    $registered_pelatihan_ids = [];
    $res_reg = $conn->query("
        SELECT b.pelatihan_id 
        FROM gb_mengajar_peserta_pelatihan pt
        JOIN gb_mengajar_pelatihan_batch b ON pt.batch_id = b.id
        WHERE pt.member_id = $uid
    ");
    if($res_reg) while($row = $res_reg->fetch_assoc()){
        $registered_pelatihan_ids[] = (int)$row['pelatihan_id'];
    }

    $upcoming = [];
    $res = $conn->query("
        SELECT p.*, 
        (SELECT COUNT(id) FROM gb_mengajar_pelatihan_batch WHERE pelatihan_id = p.id) as total_batch
        FROM gb_mengajar_pelatihan p 
        ORDER BY p.created_at DESC
    ");
    if($res) while($r = $res->fetch_assoc()) {
        $r['tags'] = explode(',', $r['tags']);
        $r['sertifikat'] = (bool)$r['ada_sertifikat'];
        $r['fasilitas_arr'] = json_decode($r['fasilitas'] ?? '[]', true) ?: [];
        $r['color'] = $r['warna'];
        $r['status'] = in_array((int)$r['id'], $registered_pelatihan_ids) ? 'Terdaftar' : 'Akan Datang';
        $upcoming[] = $r;
    }

    $history = [];
    $certs = [];
    // Jika punya tabel riwayat asli, di-query di sini (masih mockup)
    $res2 = $conn->query("SHOW TABLES LIKE 'gb_mengajar_riwayat_pelatihan'");
    if($res2 && $res2->num_rows > 0) {
        $res3 = $conn->query("SELECT * FROM gb_mengajar_riwayat_pelatihan WHERE member_id = $uid");
        if($res3) while($r = $res3->fetch_assoc()) {
            $history[] = [
                'emoji' => $r['emoji'] ?? '🎓',
                'title' => $r['title'],
                'date' => $r['tanggal'],
                'hours' => $r['jam'] ?? 8,
                'cert' => (bool)$r['ada_sertifikat']
            ];
            if ($r['ada_sertifikat'] && !empty($r['cert_id'])) {
                $certs[] = [
                    'title' => $r['title'],
                    'issuer' => $r['cert_issuer'] ?? 'GuruVerse',
                    'date' => $r['tanggal'],
                    'id' => $r['cert_id']
                ];
            }
        }
    }
}

if (!$has_pelatihan_db): 
?>
<div class="page" id="page-pelatihan">
  <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:60vh;text-align:center;">
    <div style="font-size:64px;margin-bottom:16px;"></div>
    <h2 style="font-size:24px;font-weight:800;color:#1e1b4b;margin-bottom:8px;">Akan Segera Hadir</h2>
    <p style="color:#64748b;max-width:400px;line-height:1.6;">Fitur Pelatihan Offline sedang dipersiapkan dan akan segera terhubung dengan database.</p>
  </div>
</div>
<?php else: ?>

<div class="page" id="page-pelatihan">

  <div class="section-head mb-24">
    <h2>Pelatihan Offline: Tingkatkan Kompetensimu</h2>
    <span class="badge badge-amber">Workshop & Seminar</span>
  </div>

  <!-- STATS ROW (Guru Belajar Style) -->
  <div class="stats-grid mb-24">
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
      </div>
      <div>
        <div class="stat-value" style="color:var(--c-primary)">2</div>
        <div class="stat-label">Terdaftar</div>
        <div class="stat-sub">Pelatihan aktif</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
      </div>
      <div>
        <div class="stat-value t-success">5</div>
        <div class="stat-label">Selesai Diikuti</div>
        <div class="stat-sub">Riwayat pelatihan</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"></circle><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"></path></svg>
      </div>
      <div>
        <div class="stat-value" style="color:var(--c-warning)">3</div>
        <div class="stat-label">Sertifikat</div>
        <div class="stat-sub">Diperoleh</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon-box icon-box-md icon-box-blue">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
      </div>
      <div>
        <div class="stat-value" style="color:var(--c-blue)">48 Jam</div>
        <div class="stat-label">Total Belajar</div>
        <div class="stat-sub">Akumulasi waktu</div>
      </div>
    </div>
  </div>

  <!-- FILTER TABS -->
  <div style="display:flex; gap:8px; margin-bottom:24px; flex-wrap:wrap" id="pelatihan-tabs">
    <?php $tabs = ['Semua'=>'all', 'Akan Datang'=>'upcoming', 'Terdaftar'=>'registered', 'Selesai'=>'history', 'Sertifikat'=>'cert']; 
    $first = true;
    foreach($tabs as $t => $val): ?>
    <button onclick="gmFilterTraining(this, '<?= $val ?>')" class="btn <?= $first?'btn-primary':'btn-outline' ?> btn-sm" style="border-radius:99px;"><?= $t ?></button>
    <?php $first = false; endforeach; ?>
    <div style="margin-left:auto; display:flex; align-items:center; background:var(--c-bg); border:1px solid var(--c-border); border-radius:99px; padding:2px 12px; height:32px;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      <input type="text" onkeyup="searchPelatihanOffline(this.value)" placeholder="Cari pelatihan..." style="border:none; background:transparent; outline:none; font-size:12px; width:150px; color:var(--c-text);">
    </div>
  </div>

  <div style="display:flex; flex-direction:column; gap:24px; margin-bottom:24px;">
    <!-- UPCOMING TRAININGS -->
    <div class="card card-body filter-section" id="sec-upcoming">
      <div class="section-head">
        <h2>Akan Datang</h2>
      </div>
      <div style="display:flex; flex-direction:column; gap:16px;">
        <?php foreach($upcoming as $tr): ?>
        <div class="upcoming-item" data-status="<?= $tr['status']==='Terdaftar' ? 'registered' : 'upcoming' ?>" style="border-radius:12px; border:1px solid var(--c-border-light); background:var(--c-bg); position:relative; overflow:hidden;">
          <div style="position:absolute; top:0; left:0; width:4px; height:100%; background:<?= $tr['color'] ?>;"></div>
          <div style="padding:16px 16px 16px 20px;">
            
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
              <div>
                <div class="card-title-text" style="font-size:14px; font-weight:800; color:var(--c-text); margin-bottom:6px;"><?= $tr['title'] ?></div>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                  <?php foreach($tr['tags'] as $tag): ?>
                  <span style="font-size:10px; font-weight:700; padding:2px 8px; border-radius:99px; background:<?= $tr['color'] ?>15; color:<?= $tr['color'] ?>;"><?= $tag ?></span>
                  <?php endforeach; ?>
                  <?php if($tr['sertifikat']): ?><span class="badge badge-green">Sertifikat</span><?php endif; ?>
                </div>
              </div>
              <?php if($tr['status']==='Terdaftar'): ?>
              <div style="display:flex; flex-direction:column; align-items:flex-end; gap:6px;">
                <span class="badge badge-green">Terdaftar</span>
                <button onclick="lihatTiket(<?= $tr['id'] ?>)" class="btn btn-sm" style="background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; font-size:11px; padding:4px 10px;">Lihat Tiket</button>
              </div>
              <?php else: ?>
              <button onclick="daftarPelatihan(<?= $tr['id'] ?>, '<?= htmlspecialchars(addslashes($tr['title'])) ?>')" class="btn btn-primary btn-sm" style="padding:4px 10px; font-size:11px;">Daftar</button>
              <?php endif; ?>
            </div>

            <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--c-border-light);">
              <div style="font-size:11px; font-weight:700; color:var(--c-text); margin-bottom:8px;">Tersedia <?= $tr['total_batch'] ?> Pilihan Batch / Angkatan</div>
              <div style="display:flex; flex-wrap:wrap; gap:8px;">
                <?php foreach($tr['fasilitas_arr'] as $fas): ?>
                <span style="font-size:10px; color:var(--c-text-muted); background:var(--c-bg); border:1px solid var(--c-border-light); padding:4px 8px; border-radius:6px; display:flex; align-items:center; gap:4px;">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="<?= $tr['color'] ?>" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> <?= $fas ?>
                </span>
                <?php endforeach; ?>
              </div>
            </div>
            
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap:24px;">
      <!-- RIWAYAT PELATIHAN -->
      <div class="card card-body filter-section" id="sec-history">
        <div class="section-head">
          <h2>Riwayat Pelatihan</h2>
        </div>
        <div style="display:flex; flex-direction:column; gap:12px;">
          <?php if(empty($history)): ?>
          <div style="text-align:center; padding:32px 16px; color:var(--c-text-muted); font-size:13px; background:var(--c-bg); border-radius:12px; border:1px dashed var(--c-border);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 12px auto; opacity:0.4; display:block;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Anda belum menyelesaikan pelatihan apa pun.
          </div>
          <?php else: ?>
          <?php foreach($history as $h): ?>
          <div style="display:flex; align-items:center; gap:12px; padding:12px; border-radius:12px; border:1px solid var(--c-border-light); background:var(--c-bg);">
            <div class="icon-box icon-box-sm icon-box-primary" style="flex-shrink:0;">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div style="flex:1;">
              <div style="font-size:12px; font-weight:700; color:var(--c-text); margin-bottom:2px;"><?= $h['title'] ?></div>
              <div style="font-size:10px; color:var(--c-text-muted);"><?= $h['date'] ?> &nbsp;&middot;&nbsp; <?= $h['hours'] ?> jam</div>
            </div>
            <?php if($h['cert']): ?>
            <span class="badge badge-green">Sertifikat</span>
            <?php else: ?>
            <span class="badge" style="background:var(--c-bg-card); color:var(--c-text-muted); border:1px solid var(--c-border-light);">Tidak Ada</span>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- SERTIFIKAT -->
      <div class="card card-body filter-section" id="sec-cert">
        <div class="section-head">
          <h2>Sertifikat Resmi</h2>
        </div>
        <div style="display:flex; flex-direction:column; gap:12px;">
          <?php if(empty($certs)): ?>
          <div style="text-align:center; padding:32px 16px; color:var(--c-text-muted); font-size:13px; background:var(--c-bg); border-radius:12px; border:1px dashed var(--c-border);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 12px auto; opacity:0.4; display:block;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            Anda belum memperoleh sertifikat pelatihan offline.
          </div>
          <?php else: ?>
          <?php foreach($certs as $c): ?>
          <div style="border-radius:12px; border:1px solid var(--c-border-light); background:linear-gradient(135deg, rgba(109,40,217,.02), rgba(139,92,246,.05)); padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
              <div>
                <div style="font-size:13px; font-weight:800; color:var(--c-text); margin-bottom:4px; line-height:1.3;"><?= $c['title'] ?></div>
                <div style="font-size:11px; color:var(--c-text-muted);"><?= $c['issuer'] ?></div>
                <div style="font-size:10px; color:var(--c-text-muted); margin-top:2px;"><?= $c['date'] ?></div>
              </div>
              <div class="icon-box icon-box-sm icon-box-warning" style="flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"></circle><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"></path></svg>
              </div>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; border-top:1px dashed var(--c-border); padding-top:12px;">
              <span style="font-size:10px; font-family:monospace; color:var(--c-text-muted); background:var(--c-bg); padding:4px 8px; border-radius:6px; border:1px solid var(--c-border-light);"><?= $c['id'] ?></span>
              <button class="btn btn-sm" style="background:var(--c-primary-pale); color:var(--c-primary); border:none; padding:4px 10px;">Unduh PDF</button>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- BATCH REGISTRATION MODAL -->
<div id="batchModalOverlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;" onclick="if(event.target===this) closeBatchModal()">
  <div style="background:#fff; border-radius:20px; width:90%; max-width:500px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 40px rgba(0,0,0,0.3);">
    <div style="padding:24px 24px 16px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
      <h3 style="margin:0; font-size:1.1rem; font-weight:800; color:#0f172a;">Pilih Jadwal (Batch)</h3>
      <button onclick="closeBatchModal()" style="background:none; border:none; cursor:pointer; color:#64748b;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
    </div>
    
    <div style="padding:24px;">
      <div id="batchModalPelatihanTitle" style="font-size:0.95rem; font-weight:700; color:#475569; margin-bottom:16px;"></div>
      
      <div id="batchListContainer" style="display:flex; flex-direction:column; gap:12px;">
        <!-- Batches will be rendered here by JS -->
        <div style="text-align:center; color:#94a3b8; padding:20px;">Memuat jadwal...</div>
      </div>
      
      <div id="voucherContainer" style="margin-top:16px; padding:12px; border:1px solid var(--c-border-light); border-radius:10px; background:var(--c-bg); display:none;">
        <div style="font-size:0.85rem; font-weight:700; color:var(--c-text); margin-bottom:8px;">Punya Voucher Referral?</div>
        <div style="display:flex; gap:8px;">
          <input type="text" id="voucherCodeInput" placeholder="Masukkan kode voucher" style="flex:1; border:1px solid var(--c-border-light); border-radius:8px; padding:8px 12px; font-size:0.85rem; outline:none; text-transform:uppercase;">
        </div>
        <div style="font-size:0.7rem; color:var(--c-text-muted); margin-top:6px;">Masukkan kode voucher (jika ada) untuk mendapatkan diskon tambahan.</div>
      </div>

      <button id="btnConfirmBatch" onclick="submitPendaftaran()" class="btn btn-primary" style="width:100%; margin-top:24px; padding:12px; border-radius:10px; font-weight:700; display:none;">Konfirmasi Pendaftaran</button>
    </div>
  </div>
</div>

<script>
function gmFilterTraining(btn, filter) {
  // Update UI buttons
  const buttons = document.querySelectorAll('#pelatihan-tabs button');
  buttons.forEach(b => {
    b.className = 'btn btn-outline btn-sm';
  });
  btn.className = 'btn btn-primary btn-sm';

  // Filter sections and items
  const secUpcoming = document.getElementById('sec-upcoming');
  const secHistory = document.getElementById('sec-history');
  const secCert = document.getElementById('sec-cert');

  const upcomingItems = document.querySelectorAll('.upcoming-item');

  if (filter === 'all') {
    secUpcoming.style.display = 'block';
    secHistory.style.display = 'block';
    secCert.style.display = 'block';
    upcomingItems.forEach(i => i.style.display = 'block');
  } 
  else if (filter === 'upcoming') {
    secUpcoming.style.display = 'block';
    secHistory.style.display = 'none';
    secCert.style.display = 'none';
    upcomingItems.forEach(i => {
      // show all upcoming/registered in this view, or maybe just non-registered? Let's show both
      i.style.display = 'block';
    });
  }
  else if (filter === 'registered') {
    secUpcoming.style.display = 'block';
    secHistory.style.display = 'none';
    secCert.style.display = 'none';
    upcomingItems.forEach(i => {
      i.style.display = i.getAttribute('data-status') === 'registered' ? 'block' : 'none';
    });
  }
  else if (filter === 'history') {
    secUpcoming.style.display = 'none';
    secHistory.style.display = 'block';
    secCert.style.display = 'none';
  }
  else if (filter === 'cert') {
    secUpcoming.style.display = 'none';
    secHistory.style.display = 'none';
    secCert.style.display = 'block';
  }
}

let selectedBatchId = null;

function closeBatchModal() {
    document.getElementById('batchModalOverlay').style.display = 'none';
}

async function daftarPelatihan(id, title) {
    selectedBatchId = null;
    document.getElementById('btnConfirmBatch').style.display = 'none';
    document.getElementById('batchModalPelatihanTitle').innerText = title;
    
    const container = document.getElementById('batchListContainer');
    container.innerHTML = '<div style="text-align:center; color:#94a3b8; padding:20px;">Memuat jadwal...</div>';
    document.getElementById('batchModalOverlay').style.display = 'flex';
    
    try {
        const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_pelatihan.php?action=get_batches&pelatihan_id=' + id);
        const data = await res.json();
        
        if (data.status === 'success' && data.data.length > 0) {
            container.innerHTML = '';
            data.data.forEach(b => {
                const isFull = parseInt(b.sisa_kursi) <= 0;
                const priceFmt = parseInt(b.harga) === 0 ? '<span style="color:#10b981;">Gratis</span>' : 'Rp ' + parseInt(b.harga).toLocaleString('id-ID');
                
                const card = document.createElement('div');
                card.style.cssText = `border:2px solid #e2e8f0; border-radius:12px; padding:16px; cursor:${isFull?'not-allowed':'pointer'}; opacity:${isFull?'0.6':'1'}; transition:all 0.2s; position:relative;`;
                card.onclick = () => {
                    if(isFull) return;
                    // Reset others
                    document.querySelectorAll('.batch-card').forEach(c => c.style.borderColor = '#e2e8f0');
                    card.style.borderColor = '#4f46e5';
                    selectedBatchId = b.id;
                    document.getElementById('btnConfirmBatch').style.display = 'block';
                    document.getElementById('voucherContainer').style.display = 'block';
                };
                card.className = 'batch-card';
                
                card.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                        <div style="font-weight:800; color:#0f172a; font-size:1rem;">${b.nama_batch}</div>
                        <div style="font-weight:800; font-size:0.95rem;">${priceFmt}</div>
                    </div>
                    <div style="font-size:0.85rem; color:#475569; display:flex; flex-direction:column; gap:4px;">
                        <div>📅 ${b.tanggal} • ${b.waktu}</div>
                        <div>📍 ${b.lokasi}</div>
                        <div style="font-weight:700; color:${isFull?'#ef4444':'#f59e0b'}; margin-top:4px;">Sisa Kursi: ${b.sisa_kursi}</div>
                    </div>
                `;
                container.appendChild(card);
            });
        } else {
            container.innerHTML = '<div style="text-align:center; color:#ef4444; padding:20px;">Tidak ada batch tersedia.</div>';
        }
    } catch(err) {
        container.innerHTML = '<div style="text-align:center; color:#ef4444; padding:20px;">Gagal memuat jadwal.</div>';
    }
}

async function submitPendaftaran() {
    if(!selectedBatchId) return;
    
    const btn = document.getElementById('btnConfirmBatch');
    btn.innerText = 'Memproses...';
    btn.disabled = true;
    
    const fd = new FormData();
    fd.append('batch_id', selectedBatchId);
    
    const vCode = document.getElementById('voucherCodeInput').value.trim();
    if (vCode) fd.append('voucher_code', vCode);
    
    try {
        const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_pelatihan.php?action=register', {
            method: 'POST', body: fd
        });
        const data = await res.json();
        if(data.status === 'success') {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message);
            btn.innerText = 'Konfirmasi Pendaftaran';
            btn.disabled = false;
        }
    } catch(err) {
        alert("Gagal menghubungi server.");
        btn.innerText = 'Konfirmasi Pendaftaran';
        btn.disabled = false;
    }
}

async function lihatTiket(id) {
    try {
        const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_pelatihan.php?action=get_ticket&pelatihan_id=' + id);
        const data = await res.json();
        if(data.status === 'success') {
            const t = data.data;
            document.getElementById('ticketTitle').innerText = t.title;
            document.getElementById('ticketDate').innerText = t.tanggal + ' • ' + t.waktu;
            document.getElementById('ticketLocation').innerText = t.lokasi;
            document.getElementById('ticketCode').innerText = t.ticket_code;
            
            // Render QR
            document.getElementById('ticketQR').innerHTML = '';
            new QRCode(document.getElementById('ticketQR'), {
                text: t.ticket_code,
                width: 150,
                height: 150,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            
            document.getElementById('ticketModalOverlay').style.display = 'flex';
        } else {
            alert(data.message);
        }
    } catch(err) {
        alert("Gagal memuat tiket.");
    }
}

function closeTicketModal() {
    document.getElementById('ticketModalOverlay').style.display = 'none';
}

function searchPelatihanOffline(val) {
    const filter = val.toLowerCase();
    const items = document.querySelectorAll('.upcoming-item');
    items.forEach(item => {
        const title = item.querySelector('.card-title-text').innerText.toLowerCase();
        if (title.indexOf(filter) > -1) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- TICKET MODAL -->
<div id="ticketModalOverlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;" onclick="if(event.target===this) closeTicketModal()">
  <div style="background:#fff; border-radius:20px; width:90%; max-width:400px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.3);">
    <div style="background:linear-gradient(135deg, #4f46e5, #7c3aed); padding:24px; text-align:center; color:#fff;">
      <h3 style="margin:0 0 4px 0; font-size:1.2rem; font-weight:800;">E-Ticket Pelatihan</h3>
      <p style="margin:0; font-size:0.85rem; opacity:0.8;">Tunjukkan QR Code ini saat registrasi ulang</p>
    </div>
    <div style="padding:24px; text-align:center; display:flex; flex-direction:column; align-items:center;">
      <div id="ticketQR" style="padding:16px; background:#fff; border:2px dashed #cbd5e1; border-radius:12px; margin-bottom:16px;"></div>
      <div id="ticketCode" style="font-family:monospace; font-size:1.1rem; font-weight:800; letter-spacing:2px; color:#334155; margin-bottom:20px;"></div>
      
      <div style="width:100%; text-align:left; background:#f8fafc; padding:16px; border-radius:12px; border:1px solid #e2e8f0;">
        <div id="ticketTitle" style="font-size:0.95rem; font-weight:800; color:#0f172a; margin-bottom:8px; line-height:1.4;"></div>
        
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
          <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          <span id="ticketDate" style="font-size:0.85rem; color:#475569;"></span>
        </div>
        
        <div style="display:flex; align-items:flex-start; gap:8px;">
          <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" style="margin-top:2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          <span id="ticketLocation" style="font-size:0.85rem; color:#475569; line-height:1.4;"></span>
        </div>
      </div>
      
      <button onclick="closeTicketModal()" class="btn" style="width:100%; margin-top:20px; background:#f1f5f9; color:#475569; border:none; padding:12px; border-radius:10px; font-weight:700;">Tutup</button>
    </div>
  </div>
</div>

<?php endif; ?>