<div class="page" id="page-pengaturan">
<style>
/* ── Pengaturan Styles ─────────────────────── */
.sett-tabs {
  display: flex;
  gap: 4px;
  background: #f1f5f9;
  border-radius: 12px;
  padding: 4px;
  width: fit-content;
  margin-bottom: 24px;
  flex-wrap: wrap;
}
.sett-tab {
  padding: 8px 20px;
  border-radius: 9px;
  font-size: 13px;
  font-weight: 600;
  color: #64748b;
  cursor: pointer;
  border: none;
  background: transparent;
  transition: all 0.18s;
  display: flex;
  align-items: center;
  gap: 7px;
}
.sett-tab.active {
  background: #fff;
  color: var(--c-primary);
  box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
.sett-panel { display: none; }
.sett-panel.active { display: block; }

/* Avatar Upload */
.avatar-upload-wrap {
  position: relative;
  display: inline-block;
  cursor: pointer;
}
.avatar-upload-overlay {
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: rgba(0,0,0,0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.2s;
}
.avatar-upload-wrap:hover .avatar-upload-overlay { opacity: 1; }

/* Toggle */
.sett-toggle-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 0;
  border-bottom: 1px solid var(--c-border-light);
}
.sett-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
.sett-toggle-row:first-child { padding-top: 0; }

/* Security btn */
.sett-security-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  border-radius: 10px;
  border: 1px solid var(--c-border);
  background: #fff;
  font-size: 13px;
  font-weight: 600;
  color: var(--c-text);
  cursor: pointer;
  width: 100%;
  text-align: left;
  transition: all 0.18s;
  margin-bottom: 8px;
}
.sett-security-btn:hover { background: var(--c-bg); border-color: var(--c-primary-light); }
.sett-security-btn .sett-sec-icon {
  width: 36px; height: 36px;
  border-radius: 9px;
  background: var(--c-primary-pale);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  color: var(--c-primary);
}
</style>

<!-- ── Page Header ─────────────────────────── -->
<div class="hero-section mb-20" style="padding:14px 24px;min-height:auto">
  <div class="hero-stars" aria-hidden="true">
    <span style="top:20%;left:10%;--d:4s"></span>
    <span style="top:60%;left:70%;--d:3.5s;--delay:1s"></span>
  </div>
  <div class="hero-text">
    <div class="hero-badge">
      <span class="hero-badge-dot" style="background:#a29bfe"></span> Akun Saya
    </div>
    <h1 style="font-size:20px;margin-bottom:4px">Pengaturan</h1>
    <p style="font-size:13px">Kelola profil, notifikasi, dan keamanan akun Anda.</p>
  </div>
</div>

<!-- ── Tabs ───────────────────────────────── -->
<div class="sett-tabs">
  <button class="sett-tab active" onclick="switchSettTab('profil', this)">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
    Profil
  </button>
  <button class="sett-tab" onclick="switchSettTab('notifikasi', this)">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    Notifikasi
  </button>
  <button class="sett-tab" onclick="switchSettTab('keamanan', this)">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    Keamanan
  </button>
  <button class="sett-tab" onclick="switchSettTab('tampilan', this)">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
    Tampilan
  </button>
</div>

<!-- ── Panel: Profil ──────────────────────── -->
<div class="sett-panel active" id="sett-profil">
  <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">

    <div class="card card-body-lg">
      <h3 class="mb-20" style="font-size:15px">Informasi Profil</h3>

      <!-- Avatar -->
      <div class="flex items-center gap-16 mb-24">
        <div class="avatar-upload-wrap">
          <div class="avatar avatar-xl" style="width:64px;height:64px;background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));color:#fff;font-size:22px;font-weight:800">
            <?= htmlspecialchars($user_initials) ?>
          </div>
          <div class="avatar-upload-overlay">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
          </div>
        </div>
        <div>
          <div style="font-weight:700;font-size:15px;margin-bottom:2px"><?= htmlspecialchars($user_name) ?></div>
          <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:10px"><?= htmlspecialchars($user['email'] ?? '') ?></div>
          <div style="display:flex;gap:8px">
            <button class="btn btn-outline btn-sm">Ganti Foto</button>
            <button class="btn btn-ghost btn-sm">Hapus Foto</button>
          </div>
        </div>
      </div>

      <form id="form-profile" onsubmit="saveProfile(event)">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="fullName" class="form-input" value="<?= htmlspecialchars($user_name) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label class="form-label">No. HP / WhatsApp</label>
            <input type="text" name="phone" class="form-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Contoh: 08123456789">
          </div>
          <div class="form-group">
            <label class="form-label">Kota / Kabupaten</label>
            <input type="text" name="city" class="form-input" value="<?= htmlspecialchars($user['city'] ?? '') ?>" placeholder="Kota Anda">
          </div>
          <div class="form-group">
            <label class="form-label">Jenjang Mengajar</label>
            <select name="institution" class="form-input">
              <?php foreach (['Guru SD','Guru SMP','Guru SMA/SMK','Dosen','Lainnya'] as $j): ?>
                <option <?= ($user['institution'] ?? '') === $j ? 'selected' : '' ?>><?= $j ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Mata Pelajaran</label>
            <input type="text" name="subject" class="form-input" value="<?= htmlspecialchars($user['subject'] ?? '') ?>" placeholder="Cth: Matematika, IPA">
          </div>
        </div>

        <div class="divider"></div>
        <div class="flex gap-12">
          <button type="submit" class="btn btn-primary" id="btn-save-profile">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><polyline points="20 6 9 17 4 12"/></svg>
            Simpan Perubahan
          </button>
          <button type="button" class="btn btn-ghost" onclick="location.reload()">Batal</button>
        </div>
      </form>
    </div>

    <!-- Right: Summary Card -->
    <div>
      <div class="card card-body" style="text-align:center;margin-bottom:16px">
        <div class="avatar" style="width:72px;height:72px;background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));color:#fff;font-size:26px;font-weight:800;margin:0 auto 12px">
          <?= htmlspecialchars($user_initials) ?>
        </div>
        <div style="font-weight:800;font-size:15px;margin-bottom:2px"><?= htmlspecialchars($user_name) ?></div>
        <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:14px"><?= htmlspecialchars($user['institution'] ?? 'Member Guruverse') ?></div>
        <div style="display:flex;justify-content:center;gap:20px;padding-top:14px;border-top:1px solid var(--c-border-light)">
          <div style="text-align:center">
            <div style="font-size:18px;font-weight:800;color:var(--c-primary)"><?= $total_kelas ?></div>
            <div style="font-size:11px;color:var(--c-text-muted)">Kelas</div>
          </div>
          <div style="text-align:center">
            <div style="font-size:18px;font-weight:800;color:var(--c-success)"><?= $total_sertifikat ?></div>
            <div style="font-size:11px;color:var(--c-text-muted)">Sertifikat</div>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <div style="font-size:11px;font-weight:700;color:var(--c-text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Info Akun</div>
        <div style="display:flex;flex-direction:column;gap:10px;font-size:12px">
          <div class="flex justify-between items-center">
            <span style="color:var(--c-text-muted)">Status</span>
            <span class="badge badge-success">Aktif</span>
          </div>
          <div class="flex justify-between items-center">
            <span style="color:var(--c-text-muted)">Bergabung</span>
            <span style="font-weight:600"><?= isset($user['created_at']) ? date('M Y', strtotime($user['created_at'])) : '-' ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ── Panel: Notifikasi ──────────────────── -->
<div class="sett-panel" id="sett-notifikasi">
  <div style="max-width:600px">
    <div class="card card-body-lg">
      <h3 style="font-size:15px;margin-bottom:4px">Preferensi Notifikasi</h3>
      <p class="t-xs t-muted mb-20">Pilih notifikasi yang ingin Anda terima.</p>

      <?php
        $notifs = [
          ['Modul Baru', 'Notifikasi saat modul baru tersedia di kelas Anda', true],
          ['Pengingat Belajar', 'Pengingat jadwal belajar harian', true],
          ['Balasan Diskusi', 'Notifikasi saat ada balasan di topik diskusi Anda', false],
          ['Sertifikat Siap', 'Notifikasi saat sertifikat Anda siap diunduh', true],
          ['Pengumuman Mentor', 'Pengumuman penting dari mentor kelas', false],
        ];
        foreach ($notifs as $n):
      ?>
        <div class="sett-toggle-row">
          <div>
            <div style="font-weight:600;font-size:13px;margin-bottom:2px"><?= $n[0] ?></div>
            <div class="t-xs t-muted"><?= $n[1] ?></div>
          </div>
          <div class="toggle <?= $n[2] ? 'on' : 'off' ?>" onclick="this.classList.toggle('on');this.classList.toggle('off')">
            <div class="toggle-knob"></div>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="divider"></div>
      <button class="btn btn-primary btn-sm">Simpan Preferensi</button>
    </div>
  </div>
</div>

<!-- ── Panel: Keamanan ────────────────────── -->
<div class="sett-panel" id="sett-keamanan">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:800px">

    <div class="card card-body-lg">
      <h3 style="font-size:15px;margin-bottom:4px">Keamanan Akun</h3>
      <p class="t-xs t-muted mb-20">Kelola password dan akses perangkat Anda.</p>

      <button class="sett-security-btn">
        <div class="sett-sec-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div>
          <div>Ubah Password</div>
          <div style="font-size:11px;color:var(--c-text-muted);font-weight:500">Perbarui kata sandi akun Anda</div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:auto;opacity:0.4"><polyline points="9 18 15 12 9 6"/></svg>
      </button>

      <button class="sett-security-btn">
        <div class="sett-sec-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
        </div>
        <div>
          <div>Perangkat Aktif</div>
          <div style="font-size:11px;color:var(--c-text-muted);font-weight:500">Lihat dan kelola sesi login</div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:auto;opacity:0.4"><polyline points="9 18 15 12 9 6"/></svg>
      </button>

      <div class="divider"></div>
      <button class="btn btn-danger-soft btn-block" onclick="memberLogout()" style="justify-content:flex-start;gap:10px">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar dari Akun
      </button>
    </div>

    <div class="card card-body-lg" style="border-color:rgba(225,112,85,0.3);background:rgba(254,242,242,0.4)">
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
        <div style="width:32px;height:32px;background:var(--c-danger-pale);border-radius:8px;display:flex;align-items:center;justify-content:center">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--c-danger)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3 style="font-size:14px;color:var(--c-danger)">Zona Berbahaya</h3>
      </div>
      <p class="t-xs t-muted mb-20" style="line-height:1.6">Tindakan di bawah ini bersifat <strong>permanen dan tidak dapat dibatalkan</strong>. Harap berhati-hati sebelum melanjutkan.</p>
      <button class="btn btn-danger-soft btn-sm" onclick="if(confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.')) alert('Hubungi admin untuk menghapus akun.')">
        Hapus Akun Saya
      </button>
    </div>

  </div>
</div>

<!-- ── Panel: Tampilan ──────────────────────── -->
<div class="sett-panel" id="sett-tampilan">
  <div style="max-width:600px">
    <div class="card card-body-lg">
      <h3 style="font-size:15px;margin-bottom:4px">Tampilan & Aksesibilitas</h3>
      <p class="t-xs t-muted mb-20">Sesuaikan tampilan antarmuka sesuai preferensi Anda.</p>

      <!-- Dark Mode Row (FlyonUI switch style) -->
      <div class="flex items-start gap-4" style="padding:14px 0;border-bottom:1px solid var(--c-border-light)">
        <input
          type="checkbox"
          class="switch switch-primary mt-2"
          id="settDarkModeSwitch"
          onchange="onSettDarkModeChange(this)"
        />
        <label class="label-text cursor-pointer flex flex-col" for="settDarkModeSwitch" style="display:flex;flex-direction:column;gap:3px">
          <span style="font-weight:700;font-size:13px">Mode Gelap</span>
          <span style="font-size:12px;color:var(--c-text-muted)">Aktifkan tampilan gelap untuk kenyamanan membaca di malam hari</span>
        </label>
      </div>

      <!-- Font Size Preference (dekoratif) -->
      <div class="sett-toggle-row">
        <div>
          <div style="font-weight:600;font-size:13px;margin-bottom:2px">Animasi Antarmuka</div>
          <div class="t-xs t-muted">Tampilkan animasi halus saat berpindah halaman</div>
        </div>
        <div class="toggle on" id="toggleAnimasi" onclick="this.classList.toggle('on');this.classList.toggle('off')">
          <div class="toggle-knob"></div>
        </div>
      </div>

      <div class="sett-toggle-row" style="border-bottom:none;padding-bottom:0">
        <div>
          <div style="font-weight:600;font-size:13px;margin-bottom:2px">Sidebar Kompak</div>
          <div class="t-xs t-muted">Sembunyikan sidebar secara otomatis saat layar kecil</div>
        </div>
        <div class="toggle off" onclick="this.classList.toggle('on');this.classList.toggle('off')">
          <div class="toggle-knob"></div>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Preview Mode Card -->
      <div id="darkModePreviewCard" style="border-radius:12px;border:1.5px solid var(--c-border);overflow:hidden;margin-bottom:16px">
        <div style="padding:14px 16px;background:var(--c-bg);display:flex;align-items:center;justify-content:space-between">
          <div style="font-size:12px;font-weight:700;color:var(--c-text-muted)">PRATINJAU TAMPILAN</div>
          <span id="darkModePreviewLabel" style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;background:var(--c-primary-pale);color:var(--c-primary)">Mode Terang</span>
        </div>
        <div style="padding:16px;background:var(--c-card);display:flex;gap:12px">
          <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;flex-shrink:0">📚</div>
          <div>
            <div style="font-size:13px;font-weight:700;color:var(--c-text);margin-bottom:4px">Contoh Kelas — Matematika Dasar</div>
            <div style="font-size:11px;color:var(--c-text-muted)">Mentor: Budi Santoso &bull; 8 modul &bull; 4.5 jam</div>
            <div style="margin-top:8px;height:5px;border-radius:99px;background:var(--c-border)"><div style="width:65%;height:100%;border-radius:99px;background:linear-gradient(90deg,var(--c-primary),var(--c-primary-light))"></div></div>
          </div>
        </div>
      </div>

      <button class="btn btn-primary btn-sm" onclick="alert('Preferensi tampilan sudah tersimpan secara otomatis!')">Selesai</button>
    </div>
  </div>
</div>

</div><!-- /page-pengaturan -->

<script>
function switchSettTab(id, el) {
  document.querySelectorAll('#page-pengaturan .sett-tab').forEach(function(t) { t.classList.remove('active'); });
  document.querySelectorAll('#page-pengaturan .sett-panel').forEach(function(p) { p.classList.remove('active'); });
  el.classList.add('active');
  document.getElementById('sett-' + id).classList.add('active');
}

function saveProfile(e) {
  e.preventDefault();
  const btn = document.getElementById('btn-save-profile');
  const oldHtml = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="loading loading-spinner loading-xs" style="margin-right:6px"></span> Menyimpan...';

  const fd = new FormData(e.target);
  fetch('api/update_profile.php', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      alert(data.message || 'Profil berhasil disimpan!');
      // Reload halaman agar semua inisial & nama di sidebar terupdate secara akurat
      location.reload();
    } else {
      alert(data.message || 'Gagal menyimpan perubahan.');
    }
  })
  .catch(err => alert('Terjadi kesalahan koneksi: ' + err.message))
  .finally(() => {
    btn.disabled = false;
    btn.innerHTML = oldHtml;
  });
}
// ── Dark Mode Settings Switch ─────────────────────
function onSettDarkModeChange(cb) {
  const isDark = cb.checked;
  document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
  localStorage.setItem('guruverse_theme', isDark ? 'dark' : 'light');
  // Update preview label
  const lbl = document.getElementById('darkModePreviewLabel');
  if (lbl) lbl.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
}

// Sync switch state when settings panel is opened
document.addEventListener('DOMContentLoaded', function() {
  var sw = document.getElementById('settDarkModeSwitch');
  if (sw) {
    var saved = localStorage.getItem('guruverse_theme');
    sw.checked = (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches));
    // Sync preview label
    var lbl = document.getElementById('darkModePreviewLabel');
    if (lbl) lbl.textContent = sw.checked ? 'Mode Gelap' : 'Mode Terang';
  }
});
</script>
