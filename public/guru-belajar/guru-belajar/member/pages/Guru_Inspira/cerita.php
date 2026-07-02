<?php /* Cerita Inspiratif — Guru Inspira */ ?>
<style>
/* ── Cerita page scoped ── */
#page-cerita .cerita-page-title {
  font-size: 36px;
  font-weight: 900;
  color: var(--c-text);
  letter-spacing: -0.8px;
  line-height: 1.2;
  margin-bottom: 10px;
}
#page-cerita .cerita-page-sub {
  color: var(--c-text-muted);
  font-size: 14px;
  line-height: 1.65;
  max-width: 500px;
  margin-bottom: 32px;
}

/* ── Empty state dark card (full-width split layout) ── */
#page-cerita .empty-cerita-card {
  background: linear-gradient(135deg, #1e1a3c 0%, #2a2060 60%, #1e1a3c 100%);
  border-radius: 20px;
  padding: 48px 48px;
  display: flex;
  align-items: center;
  gap: 40px;
  border: 1px solid rgba(255,255,255,0.07);
  box-shadow: 0 8px 40px rgba(0,0,0,0.25);
  min-height: 260px;
}
#page-cerita .empty-cerita-illustration {
  flex-shrink: 0;
  width: 260px;
  display: flex;
  align-items: center;
  justify-content: center;
}
#page-cerita .empty-cerita-illustration img {
  width: 260px;
  height: auto;
  object-fit: contain;
  filter: drop-shadow(0 12px 24px rgba(0,0,0,0.5));
}
#page-cerita .empty-cerita-text {}
#page-cerita .empty-cerita-title {
  font-size: 24px;
  font-weight: 900;
  color: #fff;
  line-height: 1.3;
  margin-bottom: 12px;
}
#page-cerita .empty-cerita-desc {
  color: rgba(255,255,255,0.6);
  font-size: 14px;
  line-height: 1.65;
  max-width: 380px;
  margin-bottom: 24px;
}
#page-cerita .empty-cerita-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  border: 2px solid rgba(245,158,11,0.8);
  color: #f59e0b;
  border-radius: 12px;
  padding: 12px 28px;
  font-size: 14px;
  font-weight: 800;
  cursor: pointer;
  transition: all 0.2s;
  letter-spacing: 0.2px;
}
#page-cerita .empty-cerita-btn:hover {
  background: rgba(245,158,11,0.12);
  border-color: #f59e0b;
  box-shadow: 0 0 20px rgba(245,158,11,0.25);
}

/* ── Cerita card grid ── */
#page-cerita .cerita-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
#page-cerita .cerita-card {
  background: var(--c-card);
  border: 1.5px solid var(--c-border);
  border-radius: 18px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.25s cubic-bezier(.4,0,.2,1);
  cursor: pointer;
}
#page-cerita .cerita-card:hover {
  transform: translateY(-5px);
  border-color: #fcd34d;
  box-shadow: 0 12px 36px rgba(245,158,11,0.14);
}
#page-cerita .cerita-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
#page-cerita .cerita-author-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}
#page-cerita .cerita-author-av {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #fef3c7;
  color: #d97706;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 800;
  flex-shrink: 0;
}
#page-cerita .cerita-title {
  font-size: 16px;
  font-weight: 800;
  color: var(--c-text);
  line-height: 1.4;
  margin-bottom: 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
#page-cerita .cerita-preview {
  font-size: 13px;
  color: var(--c-text-muted);
  line-height: 1.65;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
  margin-bottom: 16px;
}
#page-cerita .cerita-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 14px;
  border-top: 1px dashed var(--c-border-light);
}
#page-cerita .cerita-read-btn {
  padding: 6px 14px;
  font-size: 11px;
  font-weight: 800;
  border-radius: 9px;
  background: transparent;
  color: #f59e0b;
  border: 1.5px solid #fcd34d;
  cursor: pointer;
  transition: all 0.15s;
}
#page-cerita .cerita-read-btn:hover {
  background: rgba(245,158,11,0.1);
}

/* ── Skeleton ── */
#page-cerita .skel {
  background: linear-gradient(90deg, var(--c-border) 25%, var(--c-border-light) 50%, var(--c-border) 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 8px;
}
@keyframes shimmer { 0% { background-position:200% 0; } 100% { background-position:-200% 0; } }
</style>

<div class="page" id="page-cerita" style="animation: fadeIn 0.3s ease-out;">

  <!-- ═══════════ PAGE HEADER ═══════════ -->
  <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px;">
    <div>
      <h1 class="cerita-page-title">Cerita Inspiratif</h1>
      <p class="cerita-page-sub">Setiap guru memiliki kisah perjuangan. Bagikan momen tak terlupakan Anda di kelas dan inspirasi ribuan guru lainnya.</p>
    </div>
    <button id="btnTulisCerita" class="btn btn-primary" onclick="openNewCeritaModal()" style="margin-top:6px; padding:11px 22px; font-size:13px; font-weight:800; background:linear-gradient(135deg,#f59e0b,#f97316); border:none; box-shadow:0 6px 18px rgba(245,158,11,0.35); display:none;">
      <i class="ti ti-pencil"></i> Tulis Cerita
    </button>
  </div>

  <!-- ═══════════ CONTENT AREA ═══════════ -->
  <div class="cerita-grid" id="ceritaListContainer">
    <!-- Skeleton placeholder saat loading -->
    <?php for($i=0; $i<6; $i++): ?>
    <div class="cerita-card" style="pointer-events:none;">
      <div class="cerita-body">
        <div style="display:flex;justify-content:space-between;margin-bottom:16px;">
          <div style="display:flex;align-items:center;gap:8px;">
            <div class="skel" style="width:32px;height:32px;border-radius:50%;"></div>
            <div class="skel" style="width:90px;height:13px;"></div>
          </div>
          <div class="skel" style="width:55px;height:12px;"></div>
        </div>
        <div class="skel" style="height:17px;width:90%;margin-bottom:8px;"></div>
        <div class="skel" style="height:17px;width:65%;margin-bottom:20px;"></div>
        <div class="skel" style="height:12px;width:100%;margin-bottom:6px;"></div>
        <div class="skel" style="height:12px;width:100%;margin-bottom:6px;"></div>
        <div class="skel" style="height:12px;width:75%;margin-bottom:20px;"></div>
        <div style="display:flex;justify-content:space-between;padding-top:14px;border-top:1px dashed var(--c-border-light);">
          <div class="skel" style="width:80px;height:13px;"></div>
          <div class="skel" style="width:110px;height:28px;border-radius:9px;"></div>
        </div>
      </div>
    </div>
    <?php endfor; ?>
  </div>

</div>

<!-- ═══════════ MODAL TULIS CERITA ═══════════ -->
<div class="modal-overlay" id="modalNewCerita" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(6px);">
  <div class="modal-content" style="background:var(--c-card); width:92%; max-width:680px; border-radius:24px; padding:36px; transform:translateY(24px); transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1); max-height:90vh; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.25);">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
      <div>
        <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:4px;">Tulis Kisah Anda</h3>
        <p style="font-size:12px; color:var(--c-text-muted);">Bagikan pengalaman Anda dan inspirasi guru-guru lain di seluruh Indonesia.</p>
      </div>
      <button onclick="closeNewCeritaModal()" style="background:var(--c-bg); border:none; width:36px; height:36px; border-radius:50%; font-size:18px; color:var(--c-text-muted); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;">&times;</button>
    </div>

    <div class="form-group mb-20">
      <label class="form-label">Judul Cerita</label>
      <input type="text" id="newCeritaTitle" class="form-control" placeholder="Contoh: Senyum Pertama Budi di Kelas Remedial">
    </div>

    <div class="form-group mb-24">
      <label class="form-label">Isi Cerita</label>
      <div style="background:#f8fafc; border:1.5px solid var(--c-border); border-radius:12px; padding:12px;">
        <textarea id="newCeritaContent" class="form-control" style="border:none; background:transparent; resize:vertical; min-height:260px; padding:0; box-shadow:none; font-size:14px; line-height:1.7;" placeholder="Mulailah mengetik kisah inspiratif Anda..."></textarea>
      </div>
      <small style="color:var(--c-text-muted); margin-top:10px; display:block; font-size:11px;">Gunakan Enter untuk memisahkan paragraf. Kisah Anda akan langsung diterbitkan ke komunitas.</small>
    </div>

    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-ghost" onclick="closeNewCeritaModal()" style="padding:10px 20px;">Batal</button>
      <button class="btn btn-primary" onclick="submitNewCerita()" style="padding:10px 24px; background:linear-gradient(135deg,#f59e0b,#f97316); border-color:#f59e0b;">
        <i class="ti ti-send"></i> Terbitkan Cerita
      </button>
    </div>
  </div>
</div>

<script>
let ceritaDataCache = [];

/* ── Boot ── */
loadCeritaData();

/* ── Load ── */
function loadCeritaData() {
  fetch('api_cerita.php?action=get_all')
    .then(r => r.json())
    .then(res => {
      ceritaDataCache = (res.status === 'success') ? (res.data || []) : [];
      renderCerita();
    })
    .catch(err => {
      console.error('Cerita API error:', err);
      ceritaDataCache = [];
      renderCerita();
    });
}

/* ── Render ── */
function renderCerita() {
  const grid = document.getElementById('ceritaListContainer');
  const writeBtn = document.getElementById('btnTulisCerita');

  // ─ Empty state ─
  if (ceritaDataCache.length === 0) {
    writeBtn.style.display = 'none';
    grid.style.display = 'block'; /* single-col for empty card */
    grid.innerHTML = `
      <div class="empty-cerita-card">
        <div class="empty-cerita-illustration">
          <img src="/guruverse/asset/img/community_teachers_muslim (2).png"
               alt="Belum ada cerita"
               onerror="this.parentElement.innerHTML='<span style=\\'font-size:100px;\\'>📖</span>'">
        </div>
        <div class="empty-cerita-text">
          <div class="empty-cerita-title">📖 Belum Ada Cerita.</div>
          <div class="empty-cerita-desc">
            Jadilah penulis pertama dan inspirasi rekan pendidik di seluruh Indonesia! Bagikan momen berharga Anda di kelas.
          </div>
          <button class="empty-cerita-btn" onclick="openNewCeritaModal()">
            Mulai Tulis Cerita Baru
          </button>
        </div>
      </div>`;
    return;
  }

  // ─ Has data ─
  writeBtn.style.display = 'inline-flex';
  grid.style.display = 'grid';
  grid.innerHTML = ceritaDataCache.map(c => {
    const preview = c.konten_raw.substring(0, 160) + (c.konten_raw.length > 160 ? '...' : '');
    return `
    <div class="cerita-card" onclick="openCeritaDetail(${c.id})">
      <div class="cerita-body">
        <div class="cerita-author-row">
          <div style="display:flex;align-items:center;gap:9px;">
            <div class="cerita-author-av">${c.author_initials}</div>
            <div>
              <div style="font-size:12px;font-weight:800;color:var(--c-text);">${c.author_name}</div>
              <div style="font-size:10px;color:var(--c-text-muted);">${c.author_role || 'Guru'}</div>
            </div>
          </div>
          <div style="font-size:11px;color:var(--c-text-muted);">${c.time_ago}</div>
        </div>
        <h3 class="cerita-title">${c.judul}</h3>
        <p class="cerita-preview">${preview}</p>
        <div class="cerita-footer">
          <div style="font-size:11px;font-weight:700;color:var(--c-text-muted);display:flex;align-items:center;gap:5px;">
            <i class="ti ti-eye" style="font-size:14px;"></i> ${c.views || 0} Kali dibaca
          </div>
          <button class="cerita-read-btn" onclick="event.stopPropagation(); openCeritaDetail(${c.id})">
            Baca Selengkapnya
          </button>
        </div>
      </div>
    </div>`;
  }).join('');
}

/* ── Modal ── */
function openNewCeritaModal() {
  const m = document.getElementById('modalNewCerita');
  m.style.display = 'flex';
  requestAnimationFrame(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  });
}
function closeNewCeritaModal() {
  const m = document.getElementById('modalNewCerita');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(24px)';
  setTimeout(() => { m.style.display = 'none'; }, 320);
}

/* ── Submit ── */
function submitNewCerita() {
  const judul  = document.getElementById('newCeritaTitle').value.trim();
  const konten = document.getElementById('newCeritaContent').value.trim();
  if (!judul || !konten) { gbShowAlert('Oops!', 'Judul dan isi cerita harus diisi.', 'error'); return; }

  const fd = new FormData();
  fd.append('judul', judul);
  fd.append('konten', konten);

  fetch('api_cerita.php?action=create', { method:'POST', body:fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'success') {
        closeNewCeritaModal();
        gbShowAlert('Berhasil Diterbitkan!', 'Kisah inspiratif Anda berhasil dibagikan.', 'success');
        document.getElementById('newCeritaTitle').value = '';
        document.getElementById('newCeritaContent').value = '';
        loadCeritaData();
      } else {
        gbShowAlert('Gagal', res.message || 'Terjadi kesalahan.', 'error');
      }
    })
    .catch(err => console.error(err));
}

/* ── Detail ── */
function openCeritaDetail(id) {
  if (typeof loadCeritaDetail === 'function') loadCeritaDetail(id);
  showPage('cerita-detail');
}
</script>
