@extends('layouts.admin')

@section('title', 'Statistik Gamifikasi')
@section('page_title', 'Statistik Gamifikasi')

@section('content')
@if (session('msg'))
  @php
      $msg = session('msg');
      $isError = strpos(strtolower($msg), 'gagal') !== false || strpos(strtolower($msg), 'tidak valid') !== false || strpos(strtolower($msg), 'terjadi kesalahan') !== false;
      $isSuccess = !$isError;
  @endphp
  @if ($isSuccess)
  <div style="display:flex;align-items:center;gap:12px;background:rgba(6,214,160,0.12);border:1px solid rgba(6,214,160,0.4);border-left:4px solid #06d6a0;border-radius:10px;padding:14px 18px;margin-bottom:1.2rem;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#06d6a0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <div><div style="font-weight:700;font-size:.88rem;color:#06d6a0">Berhasil!</div><div style="font-size:.8rem;color:var(--muted);margin-top:2px">{{ htmlspecialchars($msg) }}</div></div>
  </div>
  @elseif ($isError)
  <div style="display:flex;align-items:center;gap:12px;background:rgba(239,68,68,0.10);border:1px solid rgba(239,68,68,0.3);border-left:4px solid #ef4444;border-radius:10px;padding:14px 18px;margin-bottom:1.2rem;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div><div style="font-weight:700;font-size:.88rem;color:#ef4444">Gagal</div><div style="font-size:.8rem;color:var(--muted);margin-top:2px">{{ htmlspecialchars($msg) }}</div></div>
  </div>
  @endif
@endif

<!-- BANK GAME & KUIS -->
<div class="panel" style="margin-bottom: 2rem;">
  <div class="panel-head" style="display:flex; justify-content:space-between; align-items:center;">
    <span class="panel-title">Bank Materi Gamifikasi</span>
    <div class="panel-actions">
      <button class="btn-sm" onclick="bulkDeleteMateri()" style="background:rgba(239,68,68,.1);color:#ef4444;border:1px solid rgba(239,68,68,.2);display:none;" id="btn-bulk-delete-materi">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg> Hapus (<span id="bulk-count-materi">0</span>)
      </button>
      <button class="btn-sm" onclick="openUploadModal()" style="background:rgba(6,214,160,.1);color:#06d6a0;border:1px solid rgba(6,214,160,.2);">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Upload Dokumen
      </button>
      <button class="btn-sm" onclick="openBuilderModal()" style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Buat Game Kuis
      </button>
    </div>
  </div>

  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:30px; text-align:center;"><input type="checkbox" onclick="toggleAllMateri(this)"></th>
          <th style="width:50px; text-align:center;">#</th>
          <th>Judul Materi</th>
          <th>Kategori</th>
          <th style="text-align:center;">Tipe</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php $katalogPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
          $katalog = file_exists($katalogPath) ? (json_decode(file_get_contents($katalogPath), true) ?: []) : [];
          if (empty($katalog)): @endphp
          <tr><td colspan="5" style="padding:40px;text-align:center;color:var(--muted2);">Belum ada materi yang diunggah.</td></tr>
        @php else: 
            $reversed = array_reverse($katalog);
            $limit = 10;
            $totalItems = count($reversed);
            $totalPages = ceil($totalItems / $limit);
            $page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
            $start = ($page - 1) * $limit;
            $pagedData = array_slice($reversed, $start, $limit);
            
            $no = $start + 1;
            foreach ($pagedData as $k): 
                $id = $k['id'] ?? $k['path']; @endphp
          <tr>
            <td style="text-align:center;"><input type="checkbox" class="cb-materi" value="{{ htmlspecialchars($id) }}" onclick="updateBulkMateriCount()"></td>
            <td style="text-align:center;"><span class="mono" style="font-size:.65rem;color:var(--muted2)">{{ $no++ }}</span></td>
            <td>
              <div style="display:flex;align-items:center;gap:.65rem;">
                <div style="max-width:300px;">
                  <div style="font-weight:700;color:var(--t);font-size:.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ htmlspecialchars($k['judul']) }}</div>
                  <div style="font-size:.65rem;color:var(--muted);margin-top:2px;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;">{{ htmlspecialchars($k['deskripsi']) }}</div>
                </div>
              </div>
            </td>
            <td><span style="font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:10px;background:rgba(139,47,201,0.12);color:var(--v1);">{{ htmlspecialchars($k['kategori']) }}</span></td>
            <td style="text-align:center;"><span style="font-size:.62rem;background:rgba(0,0,0,0.05);padding:3px 8px;border-radius:4px;color:var(--muted2);text-transform:uppercase;font-weight:bold;">{{ strtoupper($k['tipe'] ?? 'file') }}</span></td>
            <td style="text-align:center;">
              <div class="aksi-dropdown" style="position:relative;display:inline-block;">
                <button type="button" class="aksi-trigger" onclick="toggleAksiDropdown(this)" style="display:inline-flex;align-items:center;gap:5px;background:rgba(139,47,201,.08);color:var(--v1);border:1px solid rgba(139,47,201,.2);border-radius:7px;padding:5px 10px;font-size:.72rem;font-weight:700;cursor:pointer;transition:.15s;">
                  Aksi
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="aksi-menu" style="display:none;position:absolute;right:0;top:calc(100% + 5px);min-width:160px;background:#ffffff;border:1px solid var(--border);border-radius:9px;box-shadow:0 8px 28px rgba(0,0,0,.15);z-index:999;overflow:hidden;">
                  @if ($k['tipe'] === 'json')
                  <a href="{{ route('member.mengajar.gamifikasi.play') }}?id={{ urlencode($k['id']) }}" class="aksi-item" style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:.76rem;color:#3b82f6;text-decoration:none;transition:.12s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg> Mainkan Game
                  </a>
                  @else
                  <button type="button" class="aksi-item" onclick="openPreviewModal('{{ htmlspecialchars($k['path']) }}', '{{ htmlspecialchars($k['tipe']) }}', '{{ htmlspecialchars($k['judul'], ENT_QUOTES) }}');closeAksiDropdowns()" style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:.76rem;color:#10b981;background:none;border:none;width:100%;text-align:left;cursor:pointer;transition:.12s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Pratinjau
                  </button>
                  @endif
                  <button type="button" class="aksi-item" onclick='openEditGame({{ json_encode($k) }});closeAksiDropdowns()' style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:.76rem;color:#8b2fc9;background:none;border:none;width:100%;text-align:left;cursor:pointer;transition:.12s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit Materi
                  </button>
                  <div style="height:1px;background:var(--border);margin:2px 0;"></div>
                  <button type="button" class="aksi-item" onclick="confirmDelete('{{ htmlspecialchars($id) }}');closeAksiDropdowns()" style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:.76rem;color:#ef4444;background:none;border:none;width:100%;text-align:left;cursor:pointer;transition:.12s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg> Hapus Materi
                  </button>
                </div>
              </div>
            </td>
          </tr>
        @endforeach 
 @endif
      </tbody>
    </table>
  </div>
  @if (isset($totalPages) && $totalPages > 1)
  <div class="pagination" style="display:flex;gap:4px;padding:12px;justify-content:center">
      @php for($i=1; $i<=$totalPages; $i++): @endphp
          <a href="?mod=mengajar_gamifikasi&p={{ $i }}" style="text-decoration:none; padding:4px 10px;border-radius:6px;border:1px solid {{ $i===$page ? 'var(--v1)' : 'var(--border)' }};background:{{ $i===$page ? 'var(--v1)' : 'transparent' }};color:{{ $i===$page ? '#fff' : 'var(--muted)' }};">{{ $i }}</a>
      @php endfor; @endphp
  </div>
  @endif
</div>

<!-- MODAL UPLOAD DOKUMEN -->
<div class="overlay" id="modal-upload" style="display:none; z-index:9999;" onclick="if(event.target===this)closeUploadModal()">
  <div class="modal modal-md">
    <div class="modal-head">
      <h3 class="modal-title">Upload Materi Presentasi</h3>
      <button class="btn-close" onclick="closeUploadModal()">&times;</button>
    </div>
    <form method="POST" enctype="multipart/form-data" id="upload-form">
      <div class="modal-body">
        <p style="color:var(--muted);font-size:0.78rem;margin-bottom:14px;line-height:1.5">
          Unggah file <strong>PPT/PPTX, PDF, atau Word</strong>. Judul otomatis terisi dari nama file.
        </p>

        <!-- DROP ZONE -->
        <div id="drop-zone" onclick="document.getElementById('gamifikasi_file_input').click()" style="border:2px dashed var(--border);border-radius:10px;padding:28px 20px;text-align:center;cursor:pointer;transition:.2s;margin-bottom:14px;background:rgba(255,255,255,0.02);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--v1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          <div id="drop-label" style="font-size:.82rem;color:var(--muted);margin-top:4px;">Klik atau seret file ke sini<br><span style="font-size:.72rem;opacity:.7;">PPT, PDF, DOCX</span></div>
        </div>

        <input type="hidden" name="action" value="import_game">
        <input type="file" id="gamifikasi_file_input" name="gamifikasi_file" accept=".pdf,.ppt,.pptx,.doc,.docx" style="display:none">
        
        <div style="display:grid;gap:10px;">
          <div class="fg"><label>Judul Materi</label><input type="text" class="fi" id="judul_input" name="judul_materi" placeholder="Otomatis terisi..." required></div>
          <div class="fg"><label>Deskripsi</label><textarea class="fi" id="deskripsi_input" name="deskripsi_materi" rows="2" placeholder="Otomatis terisi..." required style="resize:vertical;"></textarea></div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div class="fg">
                <label>Kategori</label>
                <select class="fi" name="kategori_materi" required>
                    <option value="Ice Breaking">Ice Breaking</option>
                    <option value="Team Building">Team Building</option>
                    <option value="Buku Panduan">Buku Panduan</option>
                    <option value="Kuis & Teka-teki">Kuis & Teka-teki</option>
                    <option value="Materi Tambahan">Materi Tambahan</option>
                </select>
            </div>
            <div class="fg">
                <label>Status Akses</label>
                <select class="fi" name="status_akses" onchange="document.getElementById('link_upload_container').style.display = this.value === 'premium' ? 'block' : 'none'">
                    <option value="gratis">Gratis (Free)</option>
                    <option value="premium">Berbayar (Premium)</option>
                </select>
            </div>
          </div>
          <div class="fg" id="link_upload_container" style="display:none;">
              <label>Link Pembayaran (Mayar.id) / Akses Eksternal <span style="color:var(--muted);font-weight:normal;">(Opsional, ditampilkan saat materi terkunci)</span></label>
              <input type="url" class="fi" name="link_pembelian" placeholder="https://mayar.id/... atau link form pendaftaran">
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn-sm" onclick="closeUploadModal()" style="background:#f1f5f9;color:#475569;border:none">Batal</button>
        <button type="submit" id="submit-btn" class="btn-sm" style="background:var(--v1);color:#fff;border:none;opacity:.5;cursor:not-allowed;" disabled>Upload Materi</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL GAME BUILDER -->
<div class="overlay" id="modal-builder" style="display:none; z-index:9999;" onclick="if(event.target===this)closeBuilderModal()">
  <div class="modal modal-lg">
    <div class="modal-head">
      <h3 class="modal-title">✨ Visual Game Builder</h3>
      <button class="btn-close" onclick="closeBuilderModal()">&times;</button>
    </div>
    <form method="POST">
      <div class="modal-body" style="max-height:60vh; overflow-y:auto;">
        <p style="color:var(--muted);font-size:0.78rem;margin-bottom:14px;line-height:1.5">
          Buat kuis pilihan ganda interaktif langsung di sini. Sistem otomatis mengubahnya menjadi game ala Wordwall.
        </p>

        <input type="hidden" name="action" value="build_game">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
          <div class="fg"><label>Judul Game</label><input type="text" class="fi" name="game_judul" placeholder="Cth: Kuis Matematika Seru" required></div>
          <div class="fg"><label>Pesan/Instruksi Singkat</label><input type="text" class="fi" name="game_deskripsi" placeholder="Cth: Kerjakan dengan teliti!" required></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
          <div class="fg">
              <label>Status Akses</label>
              <select class="fi" name="status_akses" onchange="document.getElementById('link_build_container').style.display = this.value === 'premium' ? 'block' : 'none'">
                  <option value="gratis">Gratis (Free)</option>
                  <option value="premium">Berbayar (Premium)</option>
              </select>
          </div>
          <div class="fg" id="link_build_container" style="display:none;">
              <label>Link Pembelian / Akses Eksternal</label>
              <input type="url" class="fi" name="link_pembelian" placeholder="https://wa.me/... atau link">
          </div>
        </div>
        
        <div id="q-container" style="display:flex;flex-direction:column;gap:15px;margin-top:10px;">
          <!-- Question 1 Template -->
          <div class="q-block" style="background:rgba(0,0,0,0.02);border:1px solid var(--border);border-radius:8px;padding:15px;">
            <div style="font-weight:bold;font-size:.75rem;margin-bottom:8px;color:var(--v1);">Pertanyaan 1</div>
            <input type="text" class="fi" name="q_soal[]" placeholder="Ketik pertanyaan di sini..." style="margin-bottom:8px;" required>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
              <input type="text" class="fi" name="q_opsiA[]" placeholder="Opsi A" style="font-size:.75rem;" required>
              <input type="text" class="fi" name="q_opsiB[]" placeholder="Opsi B" style="font-size:.75rem;" required>
              <input type="text" class="fi" name="q_opsiC[]" placeholder="Opsi C" style="font-size:.75rem;">
              <input type="text" class="fi" name="q_opsiD[]" placeholder="Opsi D" style="font-size:.75rem;">
            </div>
            <div class="fg" style="margin-top:10px;margin-bottom:0;">
              <label style="font-size:.7rem;">Kunci Jawaban Benar:</label>
              <select class="fi" name="q_kunci[]" style="font-size:.75rem;padding:4px 8px;">
                <option value="A">Opsi A</option><option value="B">Opsi B</option><option value="C">Opsi C</option><option value="D">Opsi D</option>
              </select>
            </div>
          </div>
        </div>

        <button type="button" onclick="addQuestion()" style="background:rgba(139,47,201,0.1);color:var(--v1);border:1px dashed var(--v1);border-radius:6px;padding:8px;font-size:.75rem;font-weight:bold;cursor:pointer;margin-top:15px; width:100%;">
          + Tambah Pertanyaan Lain
        </button>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn-sm" onclick="closeBuilderModal()" style="background:#f1f5f9;color:#475569;border:none">Batal</button>
        <button type="submit" class="btn-sm" style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;">✨ Generate Game</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL PREVIEW MATERI -->
<div class="overlay" id="modal-preview" style="display:none; z-index:9999;" onclick="if(event.target===this)closePreviewModal()">
  <div class="modal modal-lg" style="max-width:900px; width:95%;">
    <div class="modal-head">
      <h3 class="modal-title" id="preview-title">Pratinjau Materi</h3>
      <button class="btn-close" onclick="closePreviewModal()">&times;</button>
    </div>
    <div class="modal-body" id="preview-content" style="padding:0; height:70vh; background:#f8fafc; display:flex; align-items:center; justify-content:center;">
      <!-- Konten preview akan diisi via JS -->
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div class="overlay" id="modal-confirm" style="display:none; z-index:10000;" onclick="if(event.target===this)closeConfirmModal()">
  <div class="modal modal-sm" style="max-width:400px; text-align:center;">
    <div class="modal-body" style="padding:30px 20px 20px;">
      <div style="width:60px; height:60px; border-radius:50%; background:rgba(239,68,68,0.1); color:#ef4444; display:flex; align-items:center; justify-content:center; margin:0 auto 15px;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      </div>
      <h3 style="margin-bottom:10px; font-size:1.2rem;">Hapus Materi?</h3>
      <p style="color:var(--muted); font-size:0.85rem; line-height:1.5;">Apakah Anda yakin ingin menghapus materi ini? File akan terhapus secara permanen dari sistem.</p>
    </div>
    <div class="modal-foot" style="justify-content:center; gap:10px; border-top:none; padding-bottom:30px;">
      <form method="POST" id="delete-form" style="display:none;">
        <input type="hidden" name="action" value="delete_game">
        <input type="hidden" name="game_id" id="delete-game-id">
      </form>
      <button type="button" class="btn-sm" onclick="closeConfirmModal()" style="background:#f1f5f9;color:#475569;border:none; padding:10px 20px;">Batal</button>
      <button type="button" class="btn-sm" onclick="document.getElementById('delete-form').submit()" style="background:#ef4444;color:#fff;border:none; padding:10px 20px;">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
// ── Dropdown Aksi ──────────────────────────────────────────────
function toggleAksiDropdown(btn) {
  const menu = btn.nextElementSibling;
  const isOpen = menu.style.display === 'block';
  closeAksiDropdowns();
  if (!isOpen) {
    menu.style.display = 'block';
    // flip ke atas jika terlalu dekat bawah layar
    const rect = menu.getBoundingClientRect();
    if (rect.bottom > window.innerHeight) {
      menu.style.top = 'auto';
      menu.style.bottom = 'calc(100% + 5px)';
    }
  }
}
function closeAksiDropdowns() {
  document.querySelectorAll('.aksi-menu').forEach(m => {
    m.style.display = 'none';
    m.style.top = '';
    m.style.bottom = '';
  });
}
document.addEventListener('click', e => {
  if (!e.target.closest('.aksi-dropdown')) closeAksiDropdowns();
});

// ── Modal Konfirmasi Hapus Game ─────────────────────────────────
function confirmDelete(id) {
  document.getElementById('delete-game-id').value = id;
  document.getElementById('modal-confirm').style.display = 'flex';
}
function closeConfirmModal() {
  document.getElementById('modal-confirm').style.display = 'none';
}

// ── Modal Preview ───────────────────────────────────────────────
function openPreviewModal(path, ext, judul) {
  const modal   = document.getElementById('modal-preview');
  const title   = document.getElementById('preview-title');
  const content = document.getElementById('preview-content');
  title.textContent = 'Pratinjau: ' + judul;
  ext = ext.toLowerCase();
  if (ext === 'pdf') {
    content.innerHTML = `<iframe src="${path}" style="width:100%;height:100%;border:none;"></iframe>`;
  } else if (['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'].includes(ext)) {
    const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    if (isLocalhost) {
      content.innerHTML = `
        <div style="text-align:center;padding:40px 20px;">
          <div style="font-size:4rem;margin-bottom:15px;">${ext.includes('ppt') ? '📽️' : '📝'}</div>
          <h2 style="margin-bottom:10px;color:var(--t);">Mode Localhost Aktif</h2>
          <p style="color:var(--muted);font-size:.9rem;max-width:400px;margin:0 auto 20px;line-height:1.5;">
            Sistem mendeteksi Anda sedang menjalankan aplikasi di <strong>Localhost</strong>. Pratinjau langsung memerlukan koneksi internet ke URL publik.
          </p>
          <a href="${path}" download class="btn-sm" style="background:var(--v1);color:#fff;text-decoration:none;display:inline-block;padding:12px 24px;border-radius:8px;font-weight:bold;">
            Unduh File untuk Melihat
          </a>
        </div>`;
    } else {
      const fullUrl = window.location.origin + path;
      const encodedUrl = encodeURIComponent(fullUrl);
      content.innerHTML = `
        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${encodedUrl}" width="100%" height="100%" frameborder="0" style="border:none;"></iframe>`;
    }
  } else {
    content.innerHTML = `
      <div style="text-align:center;padding:40px 20px;">
        <div style="font-size:4rem;margin-bottom:15px;">${ext.includes('ppt') ? '📽️' : '📝'}</div>
        <h2 style="margin-bottom:10px;color:var(--t);">Pratinjau Tidak Tersedia</h2>
        <p style="color:var(--muted);font-size:.9rem;max-width:400px;margin:0 auto 20px;line-height:1.5;">
          Format <strong>${ext.toUpperCase()}</strong> tidak dapat ditampilkan langsung di browser.
        </p>
        <a href="${path}" download class="btn-sm" style="background:var(--v1);color:#fff;text-decoration:none;display:inline-block;padding:12px 24px;border-radius:8px;font-weight:bold;">
          Unduh File untuk Melihat
        </a>
      </div>`;
  }
  modal.style.display = 'flex';
}
function closePreviewModal() {
  document.getElementById('modal-preview').style.display = 'none';
  document.getElementById('preview-content').innerHTML = '';
}

// ── Upload & Builder Modal ──────────────────────────────────────
function openUploadModal()  { document.getElementById('modal-upload').style.display  = 'flex'; }
function closeUploadModal() { document.getElementById('modal-upload').style.display  = 'none'; }
function openBuilderModal() { document.getElementById('modal-builder').style.display = 'flex'; }
function closeBuilderModal(){ document.getElementById('modal-builder').style.display = 'none'; }

// ── Tambah Pertanyaan ───────────────────────────────────────────
let qCount = 1;
function addQuestion() {
  qCount++;
  const container = document.getElementById('q-container');
  const html = `
    <div class="q-block" style="background:rgba(0,0,0,0.02);border:1px solid var(--border);border-radius:8px;padding:15px;margin-top:10px;">
      <div style="font-weight:bold;font-size:.75rem;margin-bottom:8px;color:var(--v1);">Pertanyaan ${qCount}</div>
      <input type="text" class="fi" name="q_soal[]" placeholder="Ketik pertanyaan di sini..." style="margin-bottom:8px;" required>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
        <input type="text" class="fi" name="q_opsiA[]" placeholder="Opsi A" style="font-size:.75rem;" required>
        <input type="text" class="fi" name="q_opsiB[]" placeholder="Opsi B" style="font-size:.75rem;" required>
        <input type="text" class="fi" name="q_opsiC[]" placeholder="Opsi C" style="font-size:.75rem;">
        <input type="text" class="fi" name="q_opsiD[]" placeholder="Opsi D" style="font-size:.75rem;">
      </div>
      <div class="fg" style="margin-top:10px;margin-bottom:0;">
        <label style="font-size:.7rem;">Kunci Jawaban Benar:</label>
        <select class="fi" name="q_kunci[]" style="font-size:.75rem;padding:4px 8px;">
          <option value="A">Opsi A</option><option value="B">Opsi B</option><option value="C">Opsi C</option><option value="D">Opsi D</option>
        </select>
      </div>
    </div>`;
  container.insertAdjacentHTML('beforeend', html);
}

// ── Upload File Handler ─────────────────────────────────────────
(function () {
  const fileInput = document.getElementById('gamifikasi_file_input');
  const dropZone  = document.getElementById('drop-zone');
  const dropLabel = document.getElementById('drop-label');
  const judulInp  = document.getElementById('judul_input');
  const deskInp   = document.getElementById('deskripsi_input');
  const submitBtn = document.getElementById('submit-btn');

  const descs = {
    pdf:  'Materi pembelajaran interaktif untuk ditayangkan di kelas.',
    ppt:  'Materi presentasi untuk digunakan saat kegiatan belajar mengajar.',
    pptx: 'Materi presentasi untuk digunakan saat kegiatan belajar mengajar.',
    doc:  'Materi dokumen berisi panduan atau instruksi.',
    docx: 'Materi dokumen berisi panduan atau instruksi.',
  };

  function toTitleCase(str) { return str.replace(/[-_]+/g, ' ').replace(/\b\w/g, c => c.toUpperCase()); }

  function handleFile(file) {
    if (!file) return;
    const ext   = file.name.split('.').pop().toLowerCase();
    const title = toTitleCase(file.name.replace(/\.[^/.]+$/, ''));
    judulInp.value = title;
    deskInp.value  = descs[ext] || 'Materi gamifikasi untuk kegiatan belajar mengajar.';
    dropLabel.innerHTML = `<span style="color:#06d6a0;font-weight:700;">✔ File Terpilih: ${file.name}</span>`;
    dropZone.style.borderColor = '#06d6a0';
    dropZone.style.background  = 'rgba(6,214,160,0.04)';
    submitBtn.disabled = false;
    submitBtn.style.opacity = '1';
    submitBtn.style.cursor  = 'pointer';
  }

  if (fileInput) {
    fileInput.addEventListener('change', () => handleFile(fileInput.files[0]));
    dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.style.borderColor = '#06d6a0'; });
    dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = 'var(--border)'; });
    dropZone.addEventListener('drop', e => {
      e.preventDefault();
      const file = e.dataTransfer.files[0];
      const dt = new DataTransfer(); dt.items.add(file);
      fileInput.files = dt.files;
      handleFile(file);
    });
  }
})();

// ── Hover style untuk aksi-item ─────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.aksi-item').forEach(el => {
    el.addEventListener('mouseenter', () => el.style.background = 'rgba(139,47,201,.06)');
    el.addEventListener('mouseleave', () => el.style.background = 'none');
  });
});
</script>



<!-- LEADERBOARD STATS -->
<div class="panel" style="margin-bottom: 2rem;">
  <div class="panel-head">
    <span class="panel-title">Leaderboard Guru Mengajar (Top 5)</span>
  </div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Peringkat</th><th>Nama Member</th><th>Level</th><th>Total XP</th><th>Siswa Terbantu</th><th>Jam Mengajar</th></tr></thead>
      <tbody>
        @if (empty($stats_list))
          <tr><td colspan="6"><div class="empty">Belum ada data statistik gamifikasi.</div></td></tr>
        @php else: 
            $count = 0;
            foreach ($stats_list as $i => $s): 
                if($count >= 5) break;
                $count++; @endphp
          <tr>
            <td><span class="mono" style="font-size:.85rem;font-weight:700;color:var(--v1)">#{{ $i+1 }}</span></td>
            <td><div style="font-weight:700;font-size:.82rem">{{ htmlspecialchars($s['member_name']) }}</div></td>
            <td><span style="font-size:.75rem;padding:2px 8px;border-radius:12px;background:rgba(6,214,160,0.1);color:#06d6a0;font-weight:bold">Level {{ $s['level_saat_ini'] }}</span></td>
            <td style="color:var(--muted);font-size:.85rem;font-weight:600">{{ number_format($s['total_xp']) }} XP</td>
            <td style="color:var(--muted);font-size:.85rem">{{ number_format($s['siswa_terbantu']) }} Siswa</td>
            <td style="color:var(--muted);font-size:.85rem">{{ $s['jam_mengajar'] }} Jam</td>
          </tr>
        @endforeach 
 @endif
      </tbody>
    </table>
  </div>
</div>

<!-- TANTANGAN CRUD -->
<div class="panel">
  <div class="panel-head">
    <span class="panel-title">Daftar Tantangan Member ({{ count($tantangan_list) }})</span>
    <div class="panel-actions">
      <form method="GET" style="display:inline-flex;align-items:center;gap:6px">
        <input type="hidden" name="mod" value="mengajar_gamifikasi">
        <div class="search-wrap">
          <span class="search-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
          <input class="search-fi" name="search" value="{{ htmlspecialchars($search) }}" placeholder="Cari tantangan/member...">
        </div>
      </form>
      <button class="btn-sm" onclick="bulkDeleteTantangan()" style="background:rgba(239,68,68,.1);color:#ef4444;border:1px solid rgba(239,68,68,.2);display:none;" id="btn-bulk-delete-tantangan">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg> Hapus (<span id="bulk-count-tantangan">0</span>)
      </button>
      <button class="btn-sm" onclick="document.getElementById('modal-tantangan-add').style.display='flex'"
        style="background:linear-gradient(135deg,#06d6a0,#05b086);color:#fff;border:none">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Tantangan
      </button>
    </div>
  </div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th style="width:30px; text-align:center;"><input type="checkbox" onclick="toggleAllTantangan(this)"></th><th>#</th><th>Nama Tantangan</th><th>Member</th><th>XP Reward</th><th>Progress</th><th>Status</th><th style="text-align:center">Aksi</th></tr></thead>
      <tbody>
        @if (empty($tantangan_list))
          <tr><td colspan="7"><div class="empty">Belum ada tantangan.</div></td></tr>
        @else
@foreach ($tantangan_list as $i => $k)
@php
          $st = $k['is_done'] ? 'selesai' : 'berjalan';
          $sc = $k['is_done'] ? 'rgba(52,211,153,.12)' : 'rgba(255,165,0,.1)';
          $tc = $k['is_done'] ? '#34d399' : '#ffa500';
          $progress_pct = min(100, ($k['target'] > 0) ? ($k['progress'] / $k['target']) * 100 : 0);
@endphp
          <tr>
            <td style="text-align:center;"><input type="checkbox" class="cb-tantangan" value="{{ $k['id'] }}" onclick="updateBulkTantanganCount()"></td>
            <td><span class="mono" style="font-size:.65rem;color:var(--muted2)">{{ $i+1 }}</span></td>
            <td>
              <div style="font-weight:700;font-size:.82rem">{{ htmlspecialchars($k['ikon'] . ' ' . $k['nama_tantangan']) }}</div>
              <div style="font-size:.62rem;color:var(--muted2)">Tanggal: {{ $k['tanggal'] }}</div>
            </td>
            <td style="color:var(--muted);font-size:.75rem;font-weight:600">{{ htmlspecialchars($k['member_name']) }}</td>
            <td style="color:var(--muted);font-size:.75rem;font-weight:bold;color:var(--v1)">+{{ $k['xp_reward'] }} XP</td>
            <td>
              <div style="font-size:.7rem;color:var(--muted);margin-bottom:4px">{{ $k['progress'] }} / {{ $k['target'] }}</div>
              <div style="width:100px;height:6px;background:var(--border);border-radius:4px;overflow:hidden">
                 <div style="width:{{ $progress_pct }}%;height:100%;background:{{ $tc }};"></div>
              </div>
            </td>
            <td><span style="font-size:.65rem;font-weight:700;padding:2px 10px;border-radius:20px;background:{{ $sc }};color:{{ $tc }}">{{ strtoupper($st) }}</span></td>
            <td style="text-align:center">
              <div class="aksi-dropdown" style="position:relative;display:inline-block;">
                <button type="button" class="aksi-trigger" onclick="toggleAksiDropdown(this)" style="display:inline-flex;align-items:center;gap:5px;background:rgba(139,47,201,.08);color:var(--v1);border:1px solid rgba(139,47,201,.2);border-radius:7px;padding:5px 10px;font-size:.72rem;font-weight:700;cursor:pointer;transition:.15s;">
                  Aksi
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="aksi-menu" style="display:none;position:absolute;right:0;top:calc(100% + 5px);min-width:160px;background:#ffffff;border:1px solid var(--border);border-radius:9px;box-shadow:0 8px 28px rgba(0,0,0,.15);z-index:999;overflow:hidden;text-align:left;">
                  <button type="button" class="aksi-item" onclick='openEditTantangan({{ json_encode($k) }});closeAksiDropdowns()' style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:.76rem;color:var(--v1);background:none;border:none;width:100%;text-align:left;cursor:pointer;transition:.12s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit Tantangan
                  </button>
                  <div style="height:1px;background:var(--border);margin:2px 0;"></div>
                  <form method="POST" class="form-delete" data-confirm="Hapus tantangan ini?" style="margin:0;width:100%;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="{{ $k['id'] }}">
                    <button type="submit" class="aksi-item" style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:.76rem;color:#ef4444;background:none;border:none;width:100%;text-align:left;cursor:pointer;transition:.12s;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg> Hapus Tantangan
                    </button>
                  </form>
                </div>
              </div>
            </td>
          </tr>
        @endforeach 
 @endif
      </tbody>
    </table>
  </div>
</div>

<!-- Modal: Tambah Tantangan -->
<div class="overlay" id="modal-tantangan-add" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Buat Tantangan Baru</div>
      <button class="close-btn" onclick="document.getElementById('modal-tantangan-add').style.display='none'">✕</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="create">
      <div class="modal-body">
        <div class="fg">
            <label>Member (Penerima Tantangan)</label>
            <select class="fi" name="member_id" required>
                <option value="">-- Pilih Member --</option>
                @foreach ($members_list as $m)
                    <option value="{{ $m['id'] }}">{{ htmlspecialchars($m['name']) }}</option>
                @endforeach
            </select>
        </div>
        <div class="fg"><label>Nama Tantangan</label><input type="text" class="fi" name="nama_tantangan" required placeholder="Contoh: Mengajar 5 Jam Minggu Ini"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Tanggal Aktif</label><input type="date" class="fi" name="tanggal" value="{{ date('Y-m-d') }}" required></div>
          <div class="fg"><label>Ikon (Emoji)</label><input type="text" class="fi" name="ikon" value="🎯" placeholder="🎯"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>XP Reward</label><input type="number" class="fi" name="xp_reward" value="100" min="10" required></div>
          <div class="fg"><label>Target (Jumlah)</label><input type="number" class="fi" name="target" value="1" min="1" required></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-tantangan-add').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:linear-gradient(135deg,#06d6a0,#05b086);color:#fff;border:none;padding:.42rem 1.1rem">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Tantangan -->
<div class="overlay" id="modal-tantangan-edit" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Edit Tantangan</div>
      <button class="close-btn" onclick="document.getElementById('modal-tantangan-edit').style.display='none'">✕</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" id="edit-t-id">
      <div class="modal-body">
        <div class="fg"><label>Member</label><input type="text" class="fi" id="edit-t-member" disabled></div>
        <div class="fg"><label>Nama Tantangan</label><input type="text" class="fi" name="nama_tantangan" id="edit-t-nama" required></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>XP Reward</label><input type="number" class="fi" name="xp_reward" id="edit-t-xp" min="10" required></div>
          <div class="fg"><label>Target (Jumlah)</label><input type="number" class="fi" name="target" id="edit-t-target" min="1" required></div>
        </div>
        <div class="fg">
          <label>Progress Saat Ini</label>
          <input type="number" class="fi" name="progress" id="edit-t-progress" min="0" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-tantangan-edit').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none;padding:.42rem 1.1rem">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Materi -->
<div class="overlay" id="modal-materi-edit" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Edit Materi Gamifikasi</div>
      <button class="close-btn" onclick="document.getElementById('modal-materi-edit').style.display='none'">✕</button>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="update_game">
      <input type="hidden" name="game_id" id="edit-g-id">
      <div class="modal-body">
        <div class="fg"><label>Judul Materi</label><input type="text" class="fi" name="judul_materi" id="edit-g-judul" required></div>
        <div class="fg"><label>Deskripsi</label><textarea class="fi" name="deskripsi_materi" id="edit-g-deskripsi" rows="2" required style="resize:vertical;"></textarea></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg">
              <label>Kategori</label>
              <select class="fi" name="kategori_materi" id="edit-g-kategori" required>
                  <option value="Ice Breaking">Ice Breaking</option>
                  <option value="Team Building">Team Building</option>
                  <option value="Buku Panduan">Buku Panduan</option>
                  <option value="Kuis & Teka-teki">Kuis & Teka-teki</option>
                  <option value="Materi Tambahan">Materi Tambahan</option>
              </select>
          </div>
          <div class="fg">
              <label>Status Akses</label>
              <select class="fi" name="status_akses" id="edit-g-akses" onchange="toggleEditLink(this.value)">
                  <option value="gratis">Gratis (Free)</option>
                  <option value="premium">Berbayar (Premium)</option>
              </select>
          </div>
        </div>
        <div class="fg" id="edit-link-container" style="display:none;">
            <label>Link Pembayaran (Mayar.id) / Akses Eksternal</label>
            <input type="url" class="fi" name="link_pembelian" id="edit-g-link" placeholder="https://mayar.id/... atau link lain">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-materi-edit').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none;padding:.42rem 1.1rem">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
function toggleEditLink(val) {
  const container = document.getElementById('edit-link-container');
  if(val === 'premium') {
      container.style.display = 'block';
  } else {
      container.style.display = 'none';
      document.getElementById('edit-g-link').value = ''; // Reset form link bila diganti gratis
  }
}

function openEditGame(k) {
  console.log('DATA GAME:', k);
  console.log('is_premium:', k.is_premium, typeof k.is_premium);
  console.log('status_akses:', k.status_akses);
  console.log('link_pembelian:', k.link_pembelian);
  
  document.getElementById('edit-g-id').value = k.id || k.path;
  document.getElementById('edit-g-judul').value = k.judul;
  document.getElementById('edit-g-deskripsi').value = k.deskripsi || '';
  
  // Set category safely
  const catSelect = document.getElementById('edit-g-kategori');
  let catFound = false;
  for(let i=0; i<catSelect.options.length; i++) {
      if(catSelect.options[i].value.includes(k.kategori)) {
          catSelect.selectedIndex = i;
          catFound = true;
          break;
      }
  }
  if(!catFound) catSelect.value = "Materi Tambahan";
  catSelect.dispatchEvent(new Event('change', { bubbles: true }));

  // --- PERBAIKAN: deteksi premium lebih luas ---
  const isPremium = k.status_akses === 'premium' 
    || k.is_premium === true 
    || k.is_premium === "true" 
    || k.is_premium === 1 
    || k.is_premium === "1"
    || (k.link_pembelian && k.link_pembelian.trim() !== '');
  
  const aksesSelect = document.getElementById('edit-g-akses');
  const targetVal = isPremium ? 'premium' : 'gratis';
  for(let i=0; i<aksesSelect.options.length; i++) {
      if(aksesSelect.options[i].value === targetVal) {
          aksesSelect.selectedIndex = i;
          break;
      }
  }
  // Tetap gunakan dispatchEvent karena layout_footer.php butuh event 'change' untuk update UI custom dropdown
  aksesSelect.dispatchEvent(new Event('change', { bubbles: true }));
  
  document.getElementById('edit-g-link').value = k.link_pembelian || '';
  toggleEditLink(isPremium ? 'premium' : 'gratis');
  
  document.getElementById('modal-materi-edit').style.display = 'flex';
}

function openEditTantangan(k) {
  document.getElementById('edit-t-id').value = k.id;
  document.getElementById('edit-t-member').value = k.member_name;
  document.getElementById('edit-t-nama').value = k.nama_tantangan;
  document.getElementById('edit-t-xp').value = k.xp_reward;
  document.getElementById('edit-t-target').value = k.target;
  document.getElementById('edit-t-progress').value = k.progress;
  document.getElementById('modal-tantangan-edit').style.display = 'flex';
}

// Bulk Delete JS Logic
function toggleAllMateri(source) {
  const checkboxes = document.querySelectorAll('.cb-materi');
  checkboxes.forEach(cb => cb.checked = source.checked);
  updateBulkMateriCount();
}

function updateBulkMateriCount() {
  const checked = document.querySelectorAll('.cb-materi:checked');
  const btn = document.getElementById('btn-bulk-delete-materi');
  const countSpan = document.getElementById('bulk-count-materi');
  if (countSpan) countSpan.textContent = checked.length;
  if (btn) btn.style.display = checked.length > 0 ? 'inline-flex' : 'none';
}

function bulkDeleteMateri() {
  const checked = document.querySelectorAll('.cb-materi:checked');
  if (checked.length === 0) return;
  if (!confirm(`Apakah Anda yakin ingin menghapus ${checked.length} materi yang dipilih?`)) return;
  
  const form = document.createElement('form');
  form.method = 'POST';
  
  const inputAction = document.createElement('input');
  inputAction.type = 'hidden';
  inputAction.name = 'action';
  inputAction.value = 'delete_game_bulk';
  form.appendChild(inputAction);
  
  checked.forEach(cb => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'game_ids[]';
      input.value = cb.value;
      form.appendChild(input);
  });
  
  document.body.appendChild(form);
  form.submit();
}

function toggleAllTantangan(source) {
  const checkboxes = document.querySelectorAll('.cb-tantangan');
  checkboxes.forEach(cb => cb.checked = source.checked);
  updateBulkTantanganCount();
}

function updateBulkTantanganCount() {
  const checked = document.querySelectorAll('.cb-tantangan:checked');
  const btn = document.getElementById('btn-bulk-delete-tantangan');
  const countSpan = document.getElementById('bulk-count-tantangan');
  if (countSpan) countSpan.textContent = checked.length;
  if (btn) btn.style.display = checked.length > 0 ? 'inline-flex' : 'none';
}

function bulkDeleteTantangan() {
  const checked = document.querySelectorAll('.cb-tantangan:checked');
  if (checked.length === 0) return;
  if (!confirm(`Apakah Anda yakin ingin menghapus ${checked.length} tantangan yang dipilih?`)) return;
  
  const form = document.createElement('form');
  form.method = 'POST';
  
  const inputAction = document.createElement('input');
  inputAction.type = 'hidden';
  inputAction.name = 'action';
  inputAction.value = 'delete_bulk';
  form.appendChild(inputAction);
  
  checked.forEach(cb => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'ids[]';
      input.value = cb.value;
      form.appendChild(input);
  });
  
  document.body.appendChild(form);
  form.submit();
}
</script>

@endsection