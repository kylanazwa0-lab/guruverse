          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="avatar-circle" style="<?= $l['you'] ? 'background:linear-gradient(135deg,#6d28d9,#a78bfa)' : '' ?>">
                <?= strtoupper(substr($l['name'],0,1)) ?>
              </div>
              <div>
                <div style="font-weight:700;font-size:12px;color:<?= $l['you'] ? '#6d28d9' : '#374151' ?>"><?= $l['name'] ?></div>
                <div style="font-size:10px;color:#94a3b8"><?= $l['inst'] ?></div>
              </div>
            </div>
          </td>
          <td><span style="font-size:11px;color:#64748b"><?= $l['level'] ?></span></td>
          <td><span style="font-weight:800;color:#f59e0b"><?= number_format($l['xp']) ?> XP</span></td>
          <td><span style="font-weight:700;color:#ef4444">🔥 <?= $l['streak'] ?> hari</span></td>
          <td><span style="font-weight:700;color:#6d28d9">🏅 <?= $l['badges'] ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- KOLEKSI MATERI GAMIFIKASI -->
  <div class="card" style="margin-bottom:24px;">
    <div class="section-head">
      <h2><span class="section-dot" style="background:#f59e0b;"></span> Koleksi Materi Gamifikasi (Ice Breaking & Kuis)</h2>
      <span class="badge badge-amber">Premium & Free</span>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
      <?php foreach($katalog as $item): ?>
      <div style="border-radius:14px;padding:20px;border:1px solid #e2e8f0;background:#fff;transition:all .2s;cursor:pointer;" onmouseover="this.style.borderColor='#cbd5e1';this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 20px rgba(0,0,0,.04)';" onmouseout="this.style.borderColor='#e2e8f0';this.style.transform='none';this.style.boxShadow='none';">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
          <div style="font-size:36px;"><?= $item['ikon'] ?></div>
          <span style="font-size:9px;font-weight:700;padding:4px 8px;border-radius:6px;background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;text-transform:uppercase;"><?= htmlspecialchars($item['kategori']) ?></span>
        </div>
        <div style="font-size:14px;font-weight:800;color:#0f172a;margin-bottom:6px;line-height:1.3;"><?= htmlspecialchars($item['judul']) ?></div>
        <div style="font-size:11px;color:#64748b;margin-bottom:16px;line-height:1.5;height:34px;overflow:hidden;"><?= htmlspecialchars($item['deskripsi']) ?></div>
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <span style="font-size:10px;font-weight:700;color:#94a3b8;display:flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> <?= strtoupper($item['tipe']) ?></span>
          <div style="display:flex;gap:6px;align-items:center;">
            <?php if(strtolower($item['tipe']) === 'pdf' || strtolower($item['tipe']) === 'json'): ?>
            <a href="<?= strtolower($item['tipe']) === 'json' ? '/guruverse/guru-belajar/member/pages/Guru_Mengajar/gamifikasi_play.php?id='.urlencode($item['id']) : '/guruverse/guru-belajar/member/read_book.php?url='.urlencode($item['path']).'&title='.urlencode($item['judul']) ?>" target="_blank" style="display:flex;align-items:center;gap:4px;padding:6px 10px;font-size:11px;border:1px solid #cbd5e1;color:#64748b;border-radius:6px;text-decoration:none;background:#f8fafc;transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9';this.style.color='#0f172a'" onmouseout="this.style.background='#f8fafc';this.style.color='#64748b'">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              Pratinjau
            </a>
            <?php endif; ?>
            <button class="btn-primary" style="padding:6px 14px;font-size:11px;<?= (!$is_premium && $free_left == 0) ? 'background:#ef4444;border-color:#ef4444;' : '' ?>" onclick="handleDownloadGamifikasi('<?= $item['path'] ?>')">
              <?= (!$is_premium && $free_left == 0) ? 'Terkunci 🔒' : 'Gunakan' ?>
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- MODAL UPGRADE PREMIUM -->
  <div id="modal-premium-gamifikasi" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,.8); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:32px; max-width:400px; width:90%; text-align:center; position:relative; animation:fadeUp .3s ease-out;">
      <button onclick="document.getElementById('modal-premium-gamifikasi').style.display='none'" style="position:absolute; top:16px; right:16px; background:none; border:none; font-size:24px; color:#94a3b8; cursor:pointer;">&times;</button>
      <div style="font-size:48px; margin-bottom:16px;">🚀</div>
      <h3 style="font-size:20px; font-weight:800; color:#0f172a; margin-bottom:8px;">Jatah Gratis Habis!</h3>
      <p style="font-size:13px; color:#64748b; line-height:1.6; margin-bottom:24px;">Anda telah menggunakan 3x kesempatan gratis. Upgrade ke akun <b>Premium Gamifikasi</b> untuk membuka akses tak terbatas ke ratusan ice breaking, game kelas, dan kuis interaktif.</p>
      
      <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:24px; text-align:left;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
          <span style="color:#10b981; font-weight:900;">✓</span> <span style="font-size:12px; font-weight:600; color:#334155;">100+ Template PPT Interaktif</span>
        </div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
          <span style="color:#10b981; font-weight:900;">✓</span> <span style="font-size:12px; font-weight:600; color:#334155;">Ebook Ice Breaking Anti Boring</span>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <span style="color:#10b981; font-weight:900;">✓</span> <span style="font-size:12px; font-weight:600; color:#334155;">Game Based Learning Modul</span>
        </div>
      </div>

      <button onclick="simulasiUpgradePremium()" style="width:100%; padding:14px; background:linear-gradient(135deg,#f59e0b,#ef4444); color:#fff; border:none; border-radius:12px; font-size:14px; font-weight:800; cursor:pointer; box-shadow:0 8px 16px rgba(245,158,11,.2);">
        Upgrade Premium (Simulasi)
      </button>
    </div>
  </div>

  <script>
  let isGamifikasiPremium = <?= $is_premium ? 'true' : 'false' ?>;
  let freeLeft = <?= $free_left ?>;

  function handleDownloadGamifikasi(path) {
      if (isGamifikasiPremium) {
          window.open(path, '_blank');
          return;
      }
      
      if (freeLeft <= 0) {
          document.getElementById('modal-premium-gamifikasi').style.display = 'flex';
          return;
      }

      // Gunakan jatah
      fetch('api_gamifikasi.php?action=use_free_play')
      .then(res => res.json())
      .then(data => {
          if (data.status === 'success') {
              if (data.premium) {
                  isGamifikasiPremium = true;
              } else {
                  freeLeft = data.left;
                  let display = document.getElementById('free-left-display');
                  if(display) {
                      display.innerText = freeLeft;
                      if(freeLeft === 0) display.style.color = '#ef4444';
                  }
                  
                  if(freeLeft === 0) {
                      // Update buttons to show locked
                      document.querySelectorAll('.btn-primary').forEach(btn => {
                          if(btn.innerText.includes('Gunakan')) {
                              btn.innerText = 'Terkunci 🔒';
                              btn.style.background = '#ef4444';
                              btn.style.borderColor = '#ef4444';
                          }
                      });
                  }
              }
              window.open(path, '_blank');
          } else {
              if(data.code === 'OUT_OF_FREE_PLAYS') {
                  document.getElementById('modal-premium-gamifikasi').style.display = 'flex';
              } else {
                  alert("Gagal: " + data.message);
              }
          }
      }).catch(err => {
          console.error(err);
          alert("Terjadi kesalahan jaringan.");
      });
  }

  function simulasiUpgradePremium() {
      fetch('api_gamifikasi.php?action=upgrade_premium')
      .then(res => res.json())
      .then(data => {
          if (data.status === 'success') {
              alert("Selamat! Akun Anda kini Premium.");
              location.reload();
          } else {
              alert("Gagal memproses upgrade.");
          }
      });
  }
  </script>

</div><!-- /page-gamifikasi -->
<?php endif; ?>
