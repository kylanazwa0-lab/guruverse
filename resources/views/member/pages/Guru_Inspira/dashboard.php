<?php /* Dashboard — Guru Inspira */
$forums = [];
$res = $conn->query("SELECT * FROM gb_inspira_forum");
if($res) while($r = $res->fetch_assoc()) $forums[] = $r;

$proyeks = [];
$res = $conn->query("SELECT * FROM gb_inspira_proyek");
if($res) while($r = $res->fetch_assoc()) $proyeks[] = $r;

$ceritas = [];
$res = $conn->query("SELECT * FROM gb_inspira_cerita");
if($res) while($r = $res->fetch_assoc()) $ceritas[] = $r;

$events = [];
$res = $conn->query("SELECT * FROM gb_inspira_event");
if($res) while($r = $res->fetch_assoc()) $events[] = $r;
?>
<div class="page active" id="page-dashboard">

  <!-- HERO -->
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
      <div>
        <div class="hero-badge"><span class="hero-badge-dot"></span> Portal Guru Inspira</div>
        <h1 style="font-size: 32px; margin-bottom: 16px; line-height: 1.3;">Portal Guru Inspira – Jendela<br/>Kolaborasi & Pertumbuhan.</h1>
        <p class="t-body mb-24" style="color: rgba(255,255,255,0.85); max-width: 600px; line-height: 1.6;">
          Selamat datang, <strong><?= htmlspecialchars($user_first ?? 'Intan Lestari') ?></strong>! Mari kita bangun masa depan pendidikan melalui diskusi, proyek, dan jejaring. Guru yang saling menguatkan dan berbagi semangat.
        </p>
        <button class="hero-cta" style="box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);" onclick="showPage('forum')">
          Gabung Diskusi Sekarang
        </button>
      </div>
    </div>
    <div class="hero-illustration">
      <div class="hero-glow-ring"></div>
      <div class="hero-img-3d-wrap">
        <img class="hero-main-img" src="/guruverse/asset/img/community_teachers_muslim (2).png" alt="Guru Inspira" onerror="this.style.display='none'">
      </div>
    </div>
  </div>

  <!-- ROW 1: PROYEK, ACARA, JEJARING -->
  <div style="display: grid; grid-template-columns: 1.8fr 1.2fr 1fr; gap: 20px;" class="mb-32">
      
      <!-- Kolaborasi Proyek (Takes 2 fractions) -->
      <div style="display: flex; flex-direction: column; height: 100%;">
          <div class="section-head mb-16" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
              <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0;">Kolaborasi Proyek</h2>
              <span class="link-action" onclick="showPage('proyek')" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap;">Lihat Semua &rarr;</span>
          </div>
          <div style="flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <?php 
              $proyek_limit = array_slice($proyeks, 0, 2);
              if (empty($proyek_limit)): 
              ?>
              <div style="grid-column: 1 / -1; padding: 40px 20px; text-align: center; background: var(--c-card); border: 2px dashed var(--c-border); border-radius: 14px; height: 100%; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px; opacity: 0.4;"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                  <div style="font-weight:700; color:var(--c-text-muted); font-size:14px; margin-bottom:4px;">Belum ada kolaborasi proyek</div>
                  <div style="font-size:12px; color:var(--c-text-muted); opacity:0.7;">Proyek kolaborasi akan muncul di sini.</div>
              </div>
              <?php 
              else:
              foreach($proyek_limit as $p): 
              ?>
              <div class="card card-body card-hover" style="display: flex; flex-direction: column; justify-content: space-between; padding: 18px;">
                  <div class="flex gap-12 mb-16">
                      <div style="width: 70px; height: 70px; border-radius: 8px; flex-shrink: 0; background:linear-gradient(135deg, <?= htmlspecialchars($p['warna_bg'] ?? '#4f46e5') ?> 0%, #34d399 100%); overflow: hidden;">
                          <img src="/guruverse/asset/img/<?= htmlspecialchars($p['gambar']) ?>" alt="" style="width:100%; height:100%; object-fit:cover; opacity: 0.9;" onerror="this.style.display='none'">
                      </div>
                      <div>
                          <div class="t-md fw-800 mb-4" style="line-height: 1.3;"><?= htmlspecialchars($p['judul']) ?></div>
                          <div class="t-xs t-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($p['deskripsi'] ?? 'Proyek kolaborasi guru') ?></div>
                      </div>
                  </div>
                  <div class="flex items-end justify-between mt-auto">
                      <div>
                          <div class="t-xs t-muted mb-4">Project Lead</div>
                          <div class="flex items-center gap-6">
                              <div class="avatar avatar-sm"><img src="/guruverse/asset/img/default_avatar.png" alt="" onerror="this.style.display='none'"></div>
                              <div class="t-xs fw-700">Intan Lestari</div>
                          </div>
                      </div>
                      <div class="text-right">
                          <div class="t-xs t-muted mb-4">Members joined</div>
                          <div class="flex items-center justify-end" style="margin-right: 8px;">
                              <div class="avatar avatar-sm" style="border: 2px solid var(--c-card); margin-right: -8px; z-index: 3;"><img src="/guruverse/asset/img/default_avatar.png" onerror="this.style.display='none'"></div>
                              <div class="avatar avatar-sm" style="border: 2px solid var(--c-card); margin-right: -8px; z-index: 2;"><img src="/guruverse/asset/img/default_avatar.png" onerror="this.style.display='none'"></div>
                              <div class="avatar avatar-sm" style="border: 2px solid var(--c-card); z-index: 1; background: var(--c-primary-light); color: #fff; font-size: 11px;">+2</div>
                          </div>
                      </div>
                  </div>
              </div>
              <?php endforeach; endif; ?>
          </div>
      </div>

      <!-- Acara Mendatang (Takes 1 fraction) -->
      <div style="display: flex; flex-direction: column; height: 100%;">
          <div class="section-head mb-16" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
              <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0; white-space:nowrap;">Acara Mendatang</h2>
              <span class="link-action" onclick="showPage('agenda')" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap;">Lihat Semua &rarr;</span>
          </div>
          <div style="flex: 1;">
              <?php 
              $e = isset($events[0]) ? $events[0] : null; 
              if($e):
              ?>
              <div class="card card-body card-hover" style="display: flex; flex-direction: column; justify-content: space-between; padding: 18px; height: 100%;">
                  <div>
                      <div class="t-md fw-800 mb-6" style="line-height: 1.3; font-size: 15px;"><?= htmlspecialchars($e['judul']) ?></div>
                      <div class="t-sm t-muted mb-16 fw-600"><?= htmlspecialchars($e['tanggal_text'] ?? '25 Okt, 2023') ?></div>
                  </div>
                  <div class="flex items-center gap-10 mb-16">
                      <div class="avatar avatar-md" style="background: <?= htmlspecialchars($e['warna_bg'] ?? '#f1f5f9') ?>; color: <?= htmlspecialchars($e['warna_text'] ?? '#333') ?>;">
                          <?php if(!empty($e['icon'])): ?>
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="<?= htmlspecialchars($e['icon']) ?>"/></svg>
                          <?php else: ?>
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                          <?php endif; ?>
                      </div>
                      <div>
                          <div class="t-xs t-muted mb-2">speaker: <span class="fw-700 t-text">Dr. Sari</span></div>
                          <div class="t-xs fw-600">25 Okt, 14:00 WIB</div>
                      </div>
                  </div>
                  <div class="flex items-center gap-6 t-xs t-muted mt-auto fw-600">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                      Workshop. Liria, Hataa.
                  </div>
              </div>
              <?php else: ?>
              <div style="padding: 40px 20px; text-align: center; background: var(--c-card); border: 2px dashed var(--c-border); border-radius: 14px; height: 100%; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px; opacity: 0.4;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                  <div style="font-weight:700; color:var(--c-text-muted); font-size:14px; margin-bottom:4px;">Belum ada acara mendatang</div>
                  <div style="font-size:12px; color:var(--c-text-muted); opacity:0.7;">Acara dan agenda akan ditampilkan di sini.</div>
              </div>
              <?php endif; ?>
          </div>
      </div>

      <!-- Jejaring & Inspirasi (Takes 1 fraction) -->
      <div style="display: flex; flex-direction: column; height: 100%;">
          <div class="section-head mb-16" style="visibility: hidden;">
              <h2 class="t-h2">Spacer</h2>
          </div>
          <div class="card card-body card-hover" style="display: flex; flex-direction: column; justify-content: space-between; padding: 20px; height: 100%;">
              <div>
                  <h2 class="t-md fw-800 mb-16 t-primary">Jejaring & Inspirasi</h2>
                  <div class="flex items-center mb-20" style="margin-left: 8px;">
                      <div class="avatar avatar-md" style="border: 2px solid var(--c-card); margin-left: -8px; z-index: 4;"><img src="/guruverse/asset/img/default_avatar.png" onerror="this.style.display='none'"></div>
                      <div class="avatar avatar-md" style="border: 2px solid var(--c-card); margin-left: -8px; z-index: 3;"><img src="/guruverse/asset/img/default_avatar.png" onerror="this.style.display='none'"></div>
                      <div class="avatar avatar-md" style="border: 2px solid var(--c-card); margin-left: -8px; z-index: 2;"><img src="/guruverse/asset/img/default_avatar.png" onerror="this.style.display='none'"></div>
                      <div class="avatar avatar-md" style="border: 2px solid var(--c-card); margin-left: -8px; z-index: 1;"><img src="/guruverse/asset/img/default_avatar.png" onerror="this.style.display='none'"></div>
                  </div>
                  <div class="t-xs t-muted mb-16" style="line-height: 1.6;">
                      Selamat datang, <strong class="t-text"><?= htmlspecialchars($user_first ?? 'Intan Lestari') ?></strong>! Mari kita bangun masa depan pendidikan melalui diskusi, proyek, dan jejaring.
                  </div>
              </div>
              <div class="t-xs fw-700 mt-auto">
                  229 <span class="t-muted fw-500">Connections</span> &bull; 201 <span class="t-muted fw-500">Views</span>
              </div>
          </div>
      </div>

  </div>

  <!-- ROW 2: FORUM DISKUSI (Full Width) -->
  <div class="mb-24">
      <div class="card card-body">
        <div class="section-head mb-24" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
          <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0;">Forum Diskusi</h2>
          <span class="link-action" onclick="showPage('forum')" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap;">Lihat Semua &rarr;</span>
        </div>
        
        <!-- Grid 4 Kolom agar melebar dengan rapi -->
        <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
          <?php foreach($forums as $f): ?>
          <div class="flex items-center gap-12 card-hover" style="padding: 16px; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; border: 1px solid var(--c-border); background: var(--c-bg); box-shadow: 0 4px 12px rgba(0,0,0,0.04);" onclick="showPage('forum')" onmouseover="this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.04)'; this.style.transform='translateY(0)';">
            <div class="icon-box icon-box-md <?= htmlspecialchars($f['icon'] ?? 'ti ti-messages') ?>" style="background: var(--c-primary-pale); color: var(--c-primary); font-size: 20px;">
               <?php if(empty($f['icon'])): ?>
               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
               <?php endif; ?>
            </div>
            <div>
              <div class="t-sm fw-800 mb-2" style="line-height:1.2;"><?= htmlspecialchars($f['judul']) ?></div>
              <div class="t-xs t-muted"><?= $f['total_postingan'] ?> Postingan</div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
  </div>

  <!-- ROW 3: CERITA INSPIRATIF (Full Width) -->
  <div class="mb-24">
      <div class="card card-body">
        <div class="section-head mb-24" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
          <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0;">Cerita Inspiratif</h2>
          <span class="link-action" onclick="showPage('cerita')" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap;">Bagikan Kisahmu &rarr;</span>
        </div>
        
        <!-- Grid 2 Kolom untuk list cerita -->
        <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
          <?php 
          $cerita_limit = array_slice($ceritas, 0, 4);
          if (empty($cerita_limit)): 
          ?>
          <div class="card flex items-center justify-center" style="grid-column: 1 / -1; padding: 32px; text-align: center; background: transparent; border: 1px dashed var(--c-border); border-radius: 12px; height: 100%; min-height: 120px;">
              <div class="t-sm t-muted">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-8" style="margin: 0 auto; display: block; opacity: 0.5;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                  Belum ada cerita inspiratif yang dibagikan.
              </div>
          </div>
          <?php 
          else:
          foreach($cerita_limit as $c): 
          ?>
          <div class="flex items-center gap-16 card-hover" style="padding: 16px; border: 1px solid var(--c-border); background: var(--c-bg); cursor: pointer; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.04);" onclick="showPage('cerita')" onmouseover="this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.04)'; this.style.transform='translateY(0)';">
            <div style="width:90px; height:65px; border-radius:8px; overflow:hidden; flex-shrink:0;">
               <img src="/guruverse/asset/img/<?= htmlspecialchars($c['gambar']) ?>" alt="" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.background='var(--c-primary-light)'">
            </div>
            <div style="flex:1;">
              <div class="t-sm fw-800 mb-6" style="line-height:1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($c['judul']) ?></div>
              <div class="t-xs t-primary fw-700">Baca Cerita &rarr;</div>
            </div>
          </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
  </div>

</div>
