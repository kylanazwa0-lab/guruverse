<?php /* Rekan Kolaborasi — Guru Inspira */ ?>
<style>
#page-diskusi .rekan-page-title { font-size: 36px; font-weight: 900; color: var(--c-text); letter-spacing: -0.8px; line-height: 1.2; margin-bottom: 10px; }
#page-diskusi .rekan-page-sub { color: var(--c-text-muted); font-size: 14px; line-height: 1.65; max-width: 500px; margin-bottom: 32px; }

#page-diskusi .rekan-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
#page-diskusi .rekan-card { background: var(--c-card); border: 1.5px solid var(--c-border); border-radius: 18px; padding: 24px; text-align: center; transition: all 0.25s; }
#page-diskusi .rekan-card:hover { transform: translateY(-5px); border-color: var(--c-primary); box-shadow: 0 12px 36px rgba(0,0,0,0.1); }
#page-diskusi .rekan-av { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--c-primary), #8b5cf6); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; margin-bottom: 16px; }
#page-diskusi .rekan-name { font-size: 16px; font-weight: 800; color: var(--c-text); margin-bottom: 4px; }
#page-diskusi .rekan-inst { font-size: 12px; color: var(--c-text-muted); margin-bottom: 12px; }
#page-diskusi .rekan-minat { display: inline-block; padding: 4px 10px; background: var(--c-primary-pale); color: var(--c-primary); border-radius: 20px; font-size: 11px; font-weight: 700; margin-bottom: 16px; }
#page-diskusi .rekan-desc { font-size: 12px; color: var(--c-text-muted); line-height: 1.5; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<div class="page" id="page-diskusi" style="animation: fadeIn 0.3s ease-out;">
  <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px;">
    <div>
      <h1 class="rekan-page-title">Rekan Kolaborasi</h1>
      <p class="rekan-page-sub">Temukan guru-guru lain di seluruh Indonesia yang memiliki minat sama untuk berkolaborasi dan mengembangkan proyek bersama.</p>
    </div>
    <button class="btn btn-primary" onclick="openProfilRekanModal()" style="margin-top:6px; padding:11px 22px; font-size:13px; font-weight:800; border:none; box-shadow:0 6px 18px rgba(0,0,0,0.15);">
      <i class="ti ti-user-edit"></i> Profil Kolaborasi Saya
    </button>
  </div>

  <div class="rekan-grid" id="rekanListContainer">
    <div style="grid-column: 1 / -1; text-align:center; padding: 40px; color:var(--c-text-muted);">Memuat data rekan...</div>
  </div>
</div>

<!-- Modal Profil Kolaborasi -->
<div class="modal-overlay" id="modalProfilRekan" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:500px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s; max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Profil Kolaborasi Saya</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Atur bagaimana orang lain melihat Anda di halaman jejaring.</p>
      </div>
      <button onclick="closeProfilRekanModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; cursor:pointer;">&times;</button>
    </div>

    <div class="form-group mb-20">
      <label class="form-label">Status Kolaborasi</label>
      <select id="prStatus" class="form-control">
        <option value="1">Terbuka untuk Kolaborasi</option>
        <option value="0">Sedang Sibuk / Tidak Tersedia</option>
      </select>
    </div>
    <div class="form-group mb-20">
      <label class="form-label">Bidang Minat Utama</label>
      <input type="text" id="prMinat" class="form-control" placeholder="Contoh: STEM, Literasi Digital, Kurikulum Merdeka">
    </div>
    <div class="form-group mb-24">
      <label class="form-label">Bio Singkat / Keahlian</label>
      <textarea id="prDesc" class="form-control" style="resize:vertical; min-height:100px;" placeholder="Ceritakan sedikit tentang keahlian dan proyek yang ingin Anda kerjakan..."></textarea>
    </div>
    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-ghost" onclick="closeProfilRekanModal()">Batal</button>
      <button class="btn btn-primary" onclick="submitProfilRekan()">Simpan Profil</button>
    </div>
  </div>
</div>

<script>
function loadRekanData() {
  fetch('api_rekan.php?action=get_all')
    .then(r => r.json())
    .then(res => {
      const grid = document.getElementById('rekanListContainer');
      if (res.status === 'success') {
        if (res.data.length === 0) {
          grid.innerHTML = `<div style="grid-column: 1 / -1; background:#f8fafc; padding:48px; border-radius:20px; text-align:center; border:1px dashed var(--c-border);">

            <h3 style="font-weight:800; font-size:18px; margin-bottom:8px;">Belum Ada Rekan Terdaftar</h3>
            <p>Jadilah yang pertama untuk membuka peluang kolaborasi dengan guru lain.</p>
          </div>`;
        } else {
          grid.innerHTML = res.data.map(r => `
            <div class="rekan-card">
              <div class="rekan-av">${r.user_initials}</div>
              <h3 class="rekan-name">${r.user_name} ${r.is_me ? '(Anda)' : ''}</h3>
              <div class="rekan-inst">${r.institution || 'Instansi tidak diketahui'}</div>
              <div class="rekan-minat">${r.bidang_minat}</div>
              <div class="rekan-desc">${r.deskripsi || 'Belum ada deskripsi profil.'}</div>
              <button class="btn btn-outline" style="width:100%; font-size:12px; padding:8px 0;" onclick="alert('Fitur pesan (chat) akan segera hadir!')">Sapa Rekan</button>
            </div>
          `).join('');
        }
      }
    });
}

function openProfilRekanModal() {
  // Ambil data profil saya dulu
  fetch('api_rekan.php?action=get_my_profile')
    .then(r => r.json())
    .then(res => {
      if(res.status === 'success') {
        document.getElementById('prStatus').value = res.data.status_open;
        document.getElementById('prMinat').value = res.data.bidang_minat;
        document.getElementById('prDesc').value = res.data.deskripsi;
      } else {
        document.getElementById('prStatus').value = "1";
        document.getElementById('prMinat').value = "";
        document.getElementById('prDesc').value = "";
      }
      
      const m = document.getElementById('modalProfilRekan');
      m.style.display = 'flex';
      requestAnimationFrame(() => { m.style.opacity = '1'; m.querySelector('.modal-content').style.transform = 'translateY(0)'; });
    });
}

function closeProfilRekanModal() {
  const m = document.getElementById('modalProfilRekan');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}

function submitProfilRekan() {
  const minat = document.getElementById('prMinat').value;
  const desc = document.getElementById('prDesc').value;
  const status = document.getElementById('prStatus').value;
  
  if(!minat) { alert('Bidang minat wajib diisi'); return; }
  
  const fd = new FormData();
  fd.append('bidang_minat', minat); fd.append('deskripsi', desc); fd.append('status_open', status);
  
  fetch('api_rekan.php?action=update_profile', { method:'POST', body:fd })
    .then(r => r.json())
    .then(res => {
      if(res.status === 'success') {
        closeProfilRekanModal();
        loadRekanData();
      } else {
        alert(res.message);
      }
    });
}

// Load init
loadRekanData();
</script>
