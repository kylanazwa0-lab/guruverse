<?php /* Jendela Dunia — Guru Inspira */ ?>
<style>
#page-jendela .jendela-page-title { font-size: 36px; font-weight: 900; color: var(--c-text); letter-spacing: -0.8px; line-height: 1.2; margin-bottom: 10px; }
#page-jendela .jendela-page-sub { color: var(--c-text-muted); font-size: 14px; line-height: 1.65; max-width: 500px; margin-bottom: 32px; }

#page-jendela .jendela-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
#page-jendela .jendela-card { background: var(--c-card); border: 1.5px solid var(--c-border); border-radius: 18px; overflow: hidden; display: flex; flex-direction: column; transition: all 0.25s; cursor: pointer; }
#page-jendela .jendela-card:hover { transform: translateY(-5px); border-color: var(--c-primary); box-shadow: 0 12px 36px rgba(0,0,0,0.1); }
#page-jendela .jendela-body { padding: 24px; display: flex; flex-direction: column; flex: 1; }
#page-jendela .jendela-category { font-size:10px; font-weight:800; color:var(--c-primary); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
#page-jendela .jendela-title { font-size: 16px; font-weight: 800; color: var(--c-text); line-height: 1.4; margin-bottom: 10px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
#page-jendela .jendela-preview { font-size: 13px; color: var(--c-text-muted); line-height: 1.65; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; flex:1; margin-bottom:16px; }

#page-jendela .empty-jendela { background: #f8fafc; border-radius: 20px; padding: 48px; text-align: center; border: 1px dashed var(--c-border); }
</style>

<div class="page" id="page-jendela" style="animation: fadeIn 0.3s ease-out;">
  <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px;">
    <div>
      <h1 class="jendela-page-title">Jendela Dunia</h1>
      <p class="jendela-page-sub">Eksplorasi inovasi pendidikan, artikel, dan tren global. Tambahkan wawasan baru untuk kemajuan pendidikan kita.</p>
    </div>
    <button class="btn btn-primary" onclick="openNewJendelaModal()" style="margin-top:6px; padding:11px 22px; font-size:13px; font-weight:800; border:none; box-shadow:0 6px 18px rgba(0,0,0,0.15);">
      <i class="ti ti-plus"></i> Tambah Artikel
    </button>
  </div>

  <div class="jendela-grid" id="jendelaListContainer">
    <div style="grid-column: 1 / -1; text-align:center; padding: 40px; color:var(--c-text-muted);">Memuat artikel...</div>
  </div>
</div>

<!-- Modal Tambah Artikel -->
<div class="modal-overlay" id="modalNewJendela" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:600px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s; max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Tambah Artikel / Inovasi</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Bagikan inovasi pendidikan yang menarik.</p>
      </div>
      <button onclick="closeNewJendelaModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; cursor:pointer;">&times;</button>
    </div>

    <div class="form-group mb-20">
      <label class="form-label">Judul Artikel</label>
      <input type="text" id="newJendelaTitle" class="form-control" placeholder="Contoh: Penggunaan AI dalam Pendidikan">
    </div>
    <div class="form-group mb-20">
      <label class="form-label">Kategori</label>
      <select id="newJendelaKategori" class="form-control">
        <option value="Inovasi">Inovasi</option>
        <option value="Metode Belajar">Metode Belajar</option>
        <option value="Teknologi">Teknologi</option>
      </select>
    </div>
    <div class="form-group mb-20">
      <label class="form-label">Sumber (URL Opsional)</label>
      <input type="text" id="newJendelaSumber" class="form-control" placeholder="https://...">
    </div>
    <div class="form-group mb-24">
      <label class="form-label">Isi Artikel</label>
      <textarea id="newJendelaContent" class="form-control" style="resize:vertical; min-height:160px;" placeholder="Tulis rangkuman atau isi artikel..."></textarea>
    </div>
    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-ghost" onclick="closeNewJendelaModal()">Batal</button>
      <button class="btn btn-primary" onclick="submitNewJendela()">Simpan Artikel</button>
    </div>
  </div>
</div>

<script>
function loadJendelaData() {
  fetch('api_jendela.php?action=get_all')
    .then(r => r.json())
    .then(res => {
      const grid = document.getElementById('jendelaListContainer');
      if (res.status === 'success') {
        if (res.data.length === 0) {
          grid.innerHTML = `<div class="empty-jendela" style="grid-column: 1 / -1;">
            <div style="font-size:40px; margin-bottom:12px;">🌍</div>
            <h3 style="font-weight:800; font-size:18px; margin-bottom:8px;">Belum Ada Artikel</h3>
            <p>Jadilah yang pertama membagikan inovasi dunia pendidikan.</p>
          </div>`;
        } else {
          grid.innerHTML = res.data.map(j => `
            <div class="jendela-card" onclick="openJendelaDetail(${j.id})">
              <div style="height:140px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:48px;">🌍</div>
              <div class="jendela-body">
                <div class="jendela-category">${j.kategori}</div>
                <h3 class="jendela-title">${j.judul}</h3>
                <p class="jendela-preview">${j.konten_raw.substring(0, 100)}...</p>
                <div style="font-size:11px; color:var(--c-text-muted); margin-top:auto;">
                  Oleh: ${j.author_name} &bull; ${j.time_ago}
                </div>
              </div>
            </div>
          `).join('');
        }
      }
    });
}

function openNewJendelaModal() {
  const m = document.getElementById('modalNewJendela');
  m.style.display = 'flex';
  requestAnimationFrame(() => { m.style.opacity = '1'; m.querySelector('.modal-content').style.transform = 'translateY(0)'; });
}
function closeNewJendelaModal() {
  const m = document.getElementById('modalNewJendela');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}

function submitNewJendela() {
  const judul = document.getElementById('newJendelaTitle').value;
  const kategori = document.getElementById('newJendelaKategori').value;
  const sumber = document.getElementById('newJendelaSumber').value;
  const konten = document.getElementById('newJendelaContent').value;
  
  if(!judul || !konten) { alert('Judul dan konten wajib diisi'); return; }
  
  const fd = new FormData();
  fd.append('judul', judul); fd.append('kategori', kategori); fd.append('sumber', sumber); fd.append('konten', konten);
  
  fetch('api_jendela.php?action=create', { method:'POST', body:fd })
    .then(r => r.json())
    .then(res => {
      if(res.status === 'success') {
        closeNewJendelaModal();
        document.getElementById('newJendelaTitle').value = '';
        document.getElementById('newJendelaContent').value = '';
        loadJendelaData();
      } else {
        alert(res.message);
      }
    });
}

function openJendelaDetail(id) {
  if (typeof loadJendelaDetail === 'function') loadJendelaDetail(id);
  showPage('jendela-detail');
}

// Load init
loadJendelaData();
</script>
