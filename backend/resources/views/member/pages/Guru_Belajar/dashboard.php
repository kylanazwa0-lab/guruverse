  <div class="page active" id="page-dashboard">

    <!-- Hero -->

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

        <?php
        // Fetch latest active enrollment
        $latest_enrollment = null;
        $stmt_latest = $conn->prepare("SELECT e.id, e.course_id, e.completed_modules, e.status,
                c.title, c.total_modules
            FROM gb_enrollments e
            JOIN gb_courses c ON e.course_id = c.id
            WHERE e.user_id = ? AND e.status != 'completed'
            ORDER BY e.enrolled_at DESC LIMIT 1");
        $stmt_latest->bind_param("i", $user_id);
        $stmt_latest->execute();
        $res_latest = $stmt_latest->get_result();
        if ($res_latest && $res_latest->num_rows > 0) {
            $latest_enrollment = $res_latest->fetch_assoc();
        }
        $stmt_latest->close();
        ?>
        <?php if (!$latest_enrollment): ?>
        <div style="text-align:center;padding:28px 20px;background:var(--c-bg-card);border-radius:14px;border:2px dashed var(--c-border)">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:10px;opacity:0.4"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
          <div style="font-weight:600;color:var(--c-text-muted);margin-bottom:4px">Belum ada kelas aktif</div>
          <div style="font-size:12px;color:var(--c-text-muted);opacity:0.7">Progress belajar akan muncul di sini setelah Anda mendaftar kelas.</div>
        </div>
        <?php else: 
          $pct = $latest_enrollment['total_modules'] > 0 ? round(($latest_enrollment['completed_modules'] / $latest_enrollment['total_modules']) * 100) : 0;
        ?>
        <div class="card card-body" onclick="openCoursePlayer(<?= $latest_enrollment['course_id'] ?>)" style="padding:20px;border:1px solid var(--c-border-light);border-left:4px solid var(--c-primary);background:var(--c-bg);cursor:pointer;transition:all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.05)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <div style="font-size:11px;font-weight:700;color:var(--c-text-muted);text-transform:uppercase;">Sedang Dipelajari</div>
            <div style="font-size:12px;font-weight:800;color:var(--c-primary);"><?= $pct ?>% Selesai</div>
          </div>
          <h3 style="font-size:15px;font-weight:800;color:var(--c-text);margin-bottom:16px;"><?= htmlspecialchars($latest_enrollment['title']) ?></h3>
          <div style="height:6px;background:var(--c-border);border-radius:99px;margin-bottom:16px;overflow:hidden;">
            <div style="width:<?= $pct ?>%;height:100%;background:var(--c-primary);border-radius:99px;"></div>
          </div>
          <button class="btn btn-primary btn-sm" onclick="openCoursePlayer(<?= $latest_enrollment['course_id'] ?>)" style="width:100%;">Lanjutkan Modul</button>
        </div>
        <?php endif; ?>

      </div>


      <!-- Calendar -->
      <div class="card card-body">
        <div class="cal-header">
          <button class="cal-nav">&lsaquo;</button>
          <span class="cal-month"><?= date('F Y') ?></span>
          <button class="cal-nav">&rsaquo;</button>
        </div>
        <div class="cal-days">
          <div class="cal-day-label">Sen</div><div class="cal-day-label">Sel</div>
          <div class="cal-day-label">Rab</div><div class="cal-day-label">Kam</div>
          <div class="cal-day-label">Jum</div><div class="cal-day-label">Sab</div>
          <div class="cal-day-label">Min</div>
          <?php
            // Simple dynamic calendar generator for current month
            $y = date('Y'); $m = date('n');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m, $y);
            $firstDay = date('N', strtotime("$y-$m-01"));
            for ($i = 1; $i < $firstDay; $i++) echo '<div class="cal-day cal-empty"></div>';
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $isToday = ($d == date('j') && $m == date('n') && $y == date('Y')) ? 'today' : '';
                echo "<div class=\"cal-day $isToday\">$d</div>";
            }
          ?>
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
    
    <?php
    // Ambil kelas yang BELUM di-enroll user
    $rekomendasi = [];
    $rekomendasi_enrolled = false; // flag: apakah sedang menampilkan kelas yg sudah enrolled
    $stmt_rek = $conn->prepare("SELECT c.id, c.title, c.category, c.duration_hours, c.total_modules, c.is_free, c.rating, c.thumbnail,
            CASE WHEN e.id IS NOT NULL THEN 1 ELSE 0 END as is_enrolled,
            e.status as enroll_status, cert.pdf_path
        FROM gb_courses c
        LEFT JOIN gb_enrollments e ON e.course_id = c.id AND e.user_id = ?
        LEFT JOIN gb_certificates cert ON cert.course_id = c.id AND cert.user_id = ?
        WHERE c.status = 'active' AND e.id IS NULL
        ORDER BY c.created_at DESC LIMIT 3");
    $stmt_rek->bind_param("ii", $user_id, $user_id);
    $stmt_rek->execute();
    $res_rek = $stmt_rek->get_result();
    if ($res_rek) {
        while ($row = $res_rek->fetch_assoc()) $rekomendasi[] = $row;
    }
    $stmt_rek->close();

    // Fallback: jika user sudah enrolled semua kelas, tampilkan kelas yang BELUM selesai dulu
    if (empty($rekomendasi)) {
        $rekomendasi_enrolled = true;
        // Prioritaskan kelas yang masih aktif (belum selesai)
        $stmt_rek2 = $conn->prepare("SELECT c.id, c.title, c.category, c.duration_hours, c.total_modules, c.is_free, c.rating, c.thumbnail,
                e.status as enroll_status, e.completed_modules, cert.pdf_path
            FROM gb_courses c
            JOIN gb_enrollments e ON e.course_id = c.id AND e.user_id = ?
            LEFT JOIN gb_certificates cert ON cert.course_id = c.id AND cert.user_id = ?
            WHERE c.status = 'active' AND e.status != 'completed'
            ORDER BY e.enrolled_at DESC LIMIT 3");
        $stmt_rek2->bind_param("ii", $user_id, $user_id);
        $stmt_rek2->execute();
        $res_rek2 = $stmt_rek2->get_result();
        if ($res_rek2) {
            while ($row = $res_rek2->fetch_assoc()) $rekomendasi[] = $row;
        }
        $stmt_rek2->close();

        // Jika semua kelas sudah selesai, tampilkan kelas selesai sebagai fallback terakhir
        if (empty($rekomendasi)) {
            $stmt_rek3 = $conn->prepare("SELECT c.id, c.title, c.category, c.duration_hours, c.total_modules, c.is_free, c.rating, c.thumbnail,
                    e.status as enroll_status, e.completed_modules, cert.pdf_path
                FROM gb_courses c
                JOIN gb_enrollments e ON e.course_id = c.id AND e.user_id = ?
                LEFT JOIN gb_certificates cert ON cert.course_id = c.id AND cert.user_id = ?
                WHERE c.status = 'active' AND e.status = 'completed'
                ORDER BY e.enrolled_at DESC LIMIT 3");
            $stmt_rek3->bind_param("ii", $user_id, $user_id);
            $stmt_rek3->execute();
            $res_rek3 = $stmt_rek3->get_result();
            if ($res_rek3) {
                while ($row = $res_rek3->fetch_assoc()) $rekomendasi[] = $row;
            }
            $stmt_rek3->close();
        }
    }
    ?>
    
    <?php if (empty($rekomendasi)): ?>
      <div style="text-align:center;padding:32px 20px;background:var(--c-bg-card);border-radius:14px;border:2px dashed var(--c-border);margin-bottom:24px">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px;opacity:0.4"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        <div style="font-weight:600;color:var(--c-text-muted);margin-bottom:4px">Kelas akan segera hadir</div>
        <div style="font-size:12px;color:var(--c-text-muted);opacity:0.7">Belum ada kelas yang tersedia saat ini.</div>
      </div>
    <?php else: ?>
      <?php
        // Cek apakah semua kelas yang ditampilkan sudah selesai
        $all_completed = $rekomendasi_enrolled && count(array_filter($rekomendasi, fn($r) => $r['enroll_status'] === 'completed')) === count($rekomendasi);
      ?>
      <?php if ($rekomendasi_enrolled && !$all_completed): ?>
      <div style="margin-bottom:12px;padding:10px 14px;background:rgba(108,92,231,0.07);border-radius:10px;border-left:3px solid var(--c-primary);font-size:12px;color:var(--c-primary);font-weight:600">
        ▶ Lanjutkan kelas yang sedang Anda ikuti:
      </div>
      <?php elseif ($all_completed): ?>
      <div style="margin-bottom:12px;padding:10px 14px;background:rgba(16,185,129,0.07);border-radius:10px;border-left:3px solid #10b981;font-size:12px;color:#059669;font-weight:600">
        🎉 Selamat! Anda telah menyelesaikan semua kelas. Lihat sertifikat Anda:
      </div>
      <?php endif; ?>
      <div class="kelas-grid mb-24">
        <?php foreach ($rekomendasi as $rk): 
          $pct_rek = (!empty($rk['total_modules']) && !empty($rk['completed_modules'])) ? round(($rk['completed_modules'] / $rk['total_modules']) * 100) : 0;
          $is_rk_completed = ($rk['enroll_status'] ?? '') === 'completed';
        ?>
        <div class="card p-0 overflow-hidden" style="display:flex;flex-direction:column;cursor:pointer" onclick="<?= $is_rk_completed ? (!empty($rk['pdf_path']) ? "viewCertificate('".htmlspecialchars($rk['pdf_path'])."')" : "") : "openCoursePlayer({$rk['id']})" ?>">
          <div style="height:140px;background:<?= $is_rk_completed ? 'linear-gradient(135deg,#10b981,#059669)' : 'linear-gradient(135deg,var(--c-primary-light),var(--c-primary))' ?>;position:relative; <?= $rk['thumbnail'] ? 'background-image:url(\'/uploads/thumbnails/'.$rk['thumbnail'].'\');background-size:cover;background-position:center;' : '' ?>">
            <div style="position:absolute;top:12px;right:12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(4px);color:#fff;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;">
              <?= htmlspecialchars($rk['category']) ?>
            </div>
            <?php if ($rekomendasi_enrolled && !empty($rk['enroll_status'])): ?>
            <div style="position:absolute;bottom:10px;left:10px;background:rgba(255,255,255,0.92);color:var(--c-text);font-size:10px;font-weight:800;padding:3px 8px;border-radius:6px;">
              <?= $is_rk_completed ? '✅ Selesai' : '▶ Sedang Dipelajari' ?>
            </div>
            <?php endif; ?>
          </div>
          <div style="padding:16px;flex:1;display:flex;flex-direction:column;">
            <h3 style="font-size:15px;font-weight:800;margin-bottom:8px;line-height:1.4"><?= htmlspecialchars($rk['title']) ?></h3>
            <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:<?= $rekomendasi_enrolled ? '8px' : '16px' ?>;display:flex;gap:12px;">
              <span style="display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> <?= $rk['duration_hours'] ?> Jam</span>
              <span style="display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> <?= $rk['total_modules'] ?> Modul</span>
            </div>
            <?php if ($pct_rek > 0): ?>
            <div style="height:4px;background:var(--c-border);border-radius:99px;margin-bottom:12px;overflow:hidden;">
              <div style="width:<?= $pct_rek ?>%;height:100%;background:<?= $is_rk_completed ? '#10b981' : 'var(--c-primary)' ?>;border-radius:99px;"></div>
            </div>
            <?php endif; ?>
            <div style="margin-top:auto;display:flex;justify-content:space-between;align-items:center;">
              <span style="font-size:14px;font-weight:800;color:var(--c-success)"><?= $rk['is_free'] ? 'Gratis' : 'Berbayar' ?></span>
              <?php if ($is_rk_completed): ?>
                <?php if (!empty($rk['pdf_path'])): ?>
                  <button class="btn btn-sm" style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;" onclick="event.stopPropagation(); viewCertificate('<?= htmlspecialchars($rk['pdf_path']) ?>')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    Lihat Sertifikat
                  </button>
                <?php else: ?>
                  <button class="btn btn-sm" style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;opacity:0.7;cursor:not-allowed" disabled onclick="event.stopPropagation();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    Sertifikat Diproses
                  </button>
                <?php endif; ?>
              <?php elseif ($rekomendasi_enrolled): ?>
              <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); openCoursePlayer(<?= $rk['id'] ?>)">Lanjutkan</button>
              <?php else: ?>
              <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); gvEnroll(<?= $rk['id'] ?>)">Daftar</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Program Populer untuk Guru (Darkened Background for better contrast) -->
    <div style="background: rgba(108, 92, 231, 0.04); border-radius: 24px; padding: 32px 24px; margin-bottom: 32px; border: 1px solid rgba(108, 92, 231, 0.08);">
      <div style="text-align:center;margin-bottom:24px">
        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--c-primary);margin-bottom:8px">PROGRAM PILIHAN</div>
        <h2 class="t-h2">Program Populer untuk Guru</h2>
        <p class="t-body t-muted mt-4">Pilih program terbaik sesuai kebutuhan pengembangan dirimu</p>
      </div>
      
      <?php
      $populer = [];
      $stmt_pop = $conn->prepare("SELECT c.id, c.title, c.category, c.duration_hours, c.total_modules, c.is_free, c.rating, c.thumbnail, COUNT(e.id) as enroll_count FROM gb_courses c
          LEFT JOIN gb_enrollments e ON e.course_id = c.id
          WHERE c.status = 'active'
          GROUP BY c.id
          ORDER BY enroll_count DESC LIMIT 3");
      $stmt_pop->execute();
      $res_pop = $stmt_pop->get_result();
      if ($res_pop) {
          while ($row = $res_pop->fetch_assoc()) $populer[] = $row;
      }
      $stmt_pop->close();
      ?>
      
      <?php if (empty($populer)): ?>
      <div style="text-align:center;padding:40px 20px;background:#fff;border-radius:18px;border:2px dashed var(--c-border);box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px;opacity:0.4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        <div style="font-weight:600;color:var(--c-text-muted);margin-bottom:4px">Kelas akan segera hadir</div>
        <div style="font-size:12px;color:var(--c-text-muted);opacity:0.7">Program populer akan ditampilkan di sini ketika sudah tersedia.</div>
      </div>
      <?php else: ?>
      <div class="kelas-grid">
        <?php foreach ($populer as $pop): ?>
        <div class="card p-0 overflow-hidden" style="display:flex;flex-direction:column;cursor:pointer;background:#fff" onclick="showPage('detail_kelas')">
          <div style="height:140px;background:linear-gradient(135deg,var(--c-primary-light),var(--c-primary));position:relative; <?= $pop['thumbnail'] ? 'background-image:url(\'/uploads/thumbnails/'.$pop['thumbnail'].'\');background-size:cover;background-position:center;' : '' ?>">
            <div style="position:absolute;top:12px;right:12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(4px);color:#fff;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;">
              <?= htmlspecialchars($pop['category']) ?>
            </div>
            <div style="position:absolute;bottom:12px;left:12px;background:rgba(255,255,255,0.9);color:var(--c-text);font-size:10px;font-weight:800;padding:4px 8px;border-radius:8px;display:flex;align-items:center;gap:4px">
              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#fbbf24" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <?= $pop['rating'] ?? '5.0' ?>
            </div>
          </div>
          <div style="padding:16px;flex:1;display:flex;flex-direction:column;">
            <h3 style="font-size:15px;font-weight:800;margin-bottom:8px;line-height:1.4"><?= htmlspecialchars($pop['title']) ?></h3>
            <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:16px;display:flex;gap:12px;">
              <span style="display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> <?= $pop['duration_hours'] ?> Jam</span>
              <span style="display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> <?= $pop['enroll_count'] ?> Siswa</span>
            </div>
            <div style="margin-top:auto;display:flex;justify-content:space-between;align-items:center;">
              <span style="font-size:14px;font-weight:800;color:var(--c-success)"><?= $pop['is_free'] ? 'Gratis' : 'Berbayar' ?></span>
              <button class="btn btn-outline btn-sm" onclick="event.stopPropagation(); gvEnroll(<?= $pop['id'] ?>)">Daftar</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
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
        <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="/guruverse/asset/img/hero_classroom_hub.png" alt="Kelas Online" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block"></div>
        <div class="feature-title">Kelas Online &amp; Webinar</div>
        <div class="feature-desc">Belajar langsung bersama mentor profesional melalui kelas online interaktif.</div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Live session interaktif</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Tanya jawab langsung</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Rekaman dapat diputar ulang</span></div>
      </div>
      <div class="feature-card">
        <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="/guruverse/asset/img/pilar_learning.png" alt="Modul Belajar" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block"></div>
        <div class="feature-title">Modul Pembelajaran Terstruktur</div>
        <div class="feature-desc">Belajar mandiri dengan materi yang disusun sistematis dan mudah dipahami.</div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Materi ringkas &amp; fokus</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Video, infografis &amp; latihan</span></div>
        <div class="feature-check"><span class="feature-check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span><span class="feature-check-text">Progress belajar otomatis</span></div>
      </div>
      <div class="feature-card">
        <div class="feature-illustration" style="padding:0;overflow:hidden;border-radius:10px"><img src="/guruverse/asset/img/premium-teacher-certificate.png" alt="Sertifikat" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top center;display:block"></div>
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
      
      // Make updateDashboardCartCount globally available for showPage in footer.php
      window.updateDashboardCartCount = updateDashboardCartCount;
    })();
  </script>
  </div><!-- /page-dashboard -->
