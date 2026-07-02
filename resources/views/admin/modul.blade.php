@extends('layouts.admin')

@section('title', 'Modul Pembelajaran')
@section('page_title', 'Modul Pembelajaran')

@section('content')


@if ($msg)
  <div class="toast toast-success" style="display:flex;position:static;margin-bottom:1rem">{{ htmlspecialchars($msg) }}</div>
@endif

<div class="panel" style="padding:1.5rem">
  <!-- PAGE HEADER -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div>
      <h2 style="font-size:1.2rem;font-weight:900;color:var(--t);letter-spacing:-.02em;margin-bottom:4px">Manajemen Modul</h2>
      <p style="font-size:.75rem;color:var(--muted);">Kelola materi, video, dan dokumen untuk setiap kelas</p>
    </div>
    
    <div style="display:flex; gap:.6rem;">
      <!-- Tombol Import E-book -->
      <button onclick="document.getElementById('import-ebook-input').click()" class="btn-sm"
        style="background:#fff;color:var(--v1);border:1px solid rgba(139,47,201,.3);padding:.5rem 1rem;font-size:.8rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Import E-book
      </button>
      <input type="file" id="import-ebook-input" style="display:none" accept=".pdf" onchange="handleImportEbook(this)">
      
      <!-- Tombol Upload Modul -->
      <button onclick="document.getElementById('modal-modul-add').style.display='flex'" class="btn-sm"
        style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;padding:.5rem 1rem;font-size:.8rem;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Upload Modul
      </button>
    </div>
  </div>

  <!-- SheetJS for Excel Import/Export -->
  <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
  <!-- FILTER BAR -->
  <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap;">
    <form method="GET" style="display:flex;align-items:center;gap:.5rem;flex:1">
      <input type="hidden" name="mod" value="modul">
      <div class="search-wrap" style="flex:1;max-width:300px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px">
        <span class="search-ico" style="padding-left:12px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
        <input class="search-fi" name="q" placeholder="Cari modul..." value="{{ htmlspecialchars($_GET['q'] ?? '') }}" style="background:transparent;border:none;padding:.5rem .5rem .5rem 36px;font-size:.8rem">
      </div>
      <select name="course_id" class="fi" style="width:200px;padding:.5rem .8rem;font-size:.8rem;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px" onchange="this.form.submit()">
        <option value="">Semua Kelas</option>
        @foreach ($courses as $c)
          <option value="{{ $c['id'] }}" {{ $course_filter == $c['id'] ? 'selected' : '' }}>{{ htmlspecialchars($c['title']) }}</option>
        @endforeach
      </select>
    </form>
    <div style="font-size:.75rem;color:var(--muted);font-weight:600;">
      {{ count($modul_list) }} modul ditemukan
    </div>
  </div>

  <!-- CARD GRID -->
  @if (empty($modul_list))
    <div class="empty" style="padding:4rem;background:#f8fafc;border-radius:12px;border:1px dashed #cbd5e1">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;display:block;color:var(--muted2)"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
      <div style="font-weight:700;margin-bottom:.3rem;">Belum ada modul</div>
      <div style="font-size:.75rem">Upload modul pertama untuk kelas ini</div>
    </div>
  @else
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
    @php $q = strtolower(request()->query('q', ''));
    foreach ($modul_list as $m):
      if ($q && stripos($m['title'] ?? '', $q) === false && stripos($m['course_title'] ?? '', $q) === false) continue;
      $type = $m['type'] ?? 'text';
      $meta = \App\Helpers\ModulHelper::getTypeMeta($type);
      $order = $m['order_index'] ?? null; @endphp
    <div class="modul-card" style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;display:flex;flex-direction:column;transition:all 0.2s">
      <!-- Card Header — type icon area -->
      <div style="background:{{ $meta['bg'] }};padding:1.5rem 1.25rem;display:flex;align-items:center;gap:.75rem;position:relative;">
        <div style="width:48px;height:48px;border-radius:12px;background:{{ $meta['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="{{ $meta['color'] }}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{{ $meta['icon'] }}</svg>
        </div>
        <span style="font-size:.65rem;font-weight:800;padding:4px 12px;border-radius:20px;background:{{ $meta['color'] }}15;color:{{ $meta['color'] }};letter-spacing:.05em">
          {{ $meta['label'] }}
        </span>
        @if ($order)
          <span style="position:absolute;bottom:12px;right:12px;font-size:.65rem;font-weight:700;color:var(--muted);background:rgba(255,255,255,0.7);padding:2px 8px;border-radius:4px;">
            Bab {{ $order }}
          </span>
        @endif

        <!-- FlyonUI Tailwind Dropdown -->
        <div class="dropdown absolute top-3 right-3">
          <button id="dd-modul-{{ $m['id'] }}" type="button" class="dropdown-toggle btn btn-square btn-ghost btn-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
          </button>
          <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-40 z-50" role="menu" aria-orientation="vertical" aria-labelledby="dd-modul-{{ $m['id'] }}">
            <li><a class="dropdown-item" href="#" onclick='openEditModul({{ json_encode($m) }});return false;'>Edit Modul</a></li>
            <hr class="my-1 border-gray-200" />
            <li>
              <form method="POST" class="form-delete m-0" data-confirm="Hapus modul ini?">
                @csrf
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="{{ $m['id'] }}">
                <button type="submit" class="dropdown-item text-red-500 hover:bg-red-50 w-full text-left">Hapus Modul</button>
              </form>
            </li>
          </ul>
        </div>
      </div>

      <!-- Card Body -->
      <div style="padding:1.25rem;flex:1;">
        <div style="font-size:.7rem;color:var(--muted2);font-weight:600;margin-bottom:6px;display:flex;align-items:center;gap:4px;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
          {{ htmlspecialchars($m['course_title'] ?? 'Tanpa Kelas') }}
        </div>
        <div style="font-weight:800;font-size:.95rem;color:var(--t);line-height:1.4;margin-bottom:.5rem;">
          {{ htmlspecialchars($m['title'] ?? '') }}
        </div>
        @if (!empty($m['description']))
          <div style="font-size:.75rem;color:var(--muted);line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
            {{ htmlspecialchars($m['description']) }}
          </div>
        @else
          <div style="font-size:.75rem;color:var(--muted2);font-style:italic">Tidak ada deskripsi</div>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>

<!-- Modal: Add Modul -->
<div class="overlay" id="modal-modul-add" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.95rem;color:var(--t)">Upload Modul Baru</div>
      <button class="close-btn" onclick="document.getElementById('modal-modul-add').style.display='none'">✕</button>
    </div>
    <form method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="action" value="create">
      <div class="modal-body">
        <div class="fg">
          <label>Pilih Kelas</label>
          <select class="fi" name="course_id" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach ($courses as $c)
              <option value="{{ $c['id'] }}">{{ htmlspecialchars($c['title']) }}</option>
            @endforeach
          </select>
        </div>
        <div class="fg">
          <label>Judul Modul</label>
          <input type="text" class="fi" name="title" id="add-modul-title" required placeholder="Bab 1: Pendahuluan...">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div class="fg">
            <label>Urutan (Bab)</label>
            <input type="number" class="fi" name="order_index" value="1" min="1">
          </div>
          <div class="fg">
            <label>Tipe Konten</label>
            <select class="fi" name="type" id="add-modul-type">
              <option value="text">📄 Teks / Artikel</option>
              <option value="video">🎬 Video URL</option>
              <option value="pdf">📋 Dokumen PDF</option>
              <option value="quiz">❓ Quiz</option>
            </select>
          </div>
        </div>
        <div class="fg">
          <label>URL Video / Link (Opsional)</label>
          <input type="text" class="fi" name="video_url" placeholder="https://youtube.com/...">
        </div>
        <div class="fg">
          <label>Upload File (PDF/Docs)</label>
          <input type="file" class="fi" name="file" id="add-modul-file" accept=".pdf,.doc,.docx" style="padding:.5rem .9rem;" onchange="handleFileSelect(this)">
          <div id="pdf-loading-indicator" style="display:none; font-size:0.7rem; color:var(--v1); margin-top:4px;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;" class="spin"><circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> Membaca metadata file...
          </div>
        </div>
        <div class="fg">
          <label>Deskripsi Singkat</label>
          <textarea class="fi" name="description" id="add-modul-desc" rows="3" placeholder="Deskripsi materi..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-modul-add').style.display='none'"
          style="background:var(--bg);color:var(--muted);border:1px solid var(--border);">Batal</button>
        <button type="submit" class="btn-sm"
          style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;padding:.42rem 1.1rem;">
          Upload Modul
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Modul (with Quiz Builder) -->
<div class="overlay" id="modal-modul-edit" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal" style="max-width:700px;width:95vw;">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.95rem;color:var(--t)">Edit Modul</div>
      <button class="close-btn" onclick="document.getElementById('modal-modul-edit').style.display='none'">✕</button>
    </div>
    <form method="POST" id="form-edit-modul">
      @csrf
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" id="edit-modul-id">
      <input type="hidden" name="quiz_data" id="edit-modul-quiz-data">

      <!-- Tabs -->
      <div style="display:flex;gap:0;border-bottom:2px solid var(--border);padding:0 1.5rem;background:var(--bg);">
        <button type="button" class="qb-tab active" id="tab-info" onclick="switchTab('info')"
          style="padding:.7rem 1.2rem;font-size:.8rem;font-weight:700;border:none;background:transparent;border-bottom:2px solid var(--v1);margin-bottom:-2px;color:var(--v1);cursor:pointer;">
          📋 Info Modul
        </button>
        <button type="button" class="qb-tab" id="tab-content" onclick="switchTab('content')"
          style="padding:.7rem 1.2rem;font-size:.8rem;font-weight:700;border:none;background:transparent;border-bottom:2px solid transparent;margin-bottom:-2px;color:var(--muted);cursor:pointer;">
          📝 Konten
        </button>
        <button type="button" class="qb-tab" id="tab-quiz" onclick="switchTab('quiz')"
          style="padding:.7rem 1.2rem;font-size:.8rem;font-weight:700;border:none;background:transparent;border-bottom:2px solid transparent;margin-bottom:-2px;color:var(--muted);cursor:pointer;">
          ❓ Quiz Builder
        </button>
      </div>

      <div class="modal-body" style="max-height:60vh;overflow-y:auto;">

        <!-- TAB: Info -->
        <div id="panel-info">
          <div class="fg">
            <label>Judul Modul</label>
            <input type="text" class="fi" name="title" id="edit-modul-title" required>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem;">
            <div class="fg">
              <label>No. Modul</label>
              <input type="number" class="fi" name="module_number" id="edit-modul-modnum" min="1">
            </div>
            <div class="fg">
              <label>Durasi (menit)</label>
              <input type="number" class="fi" name="duration_minutes" id="edit-modul-duration" min="0">
            </div>
            <div class="fg">
              <label>Tipe Konten</label>
              <select class="fi" name="type" id="edit-modul-type" onchange="onTypeChange(this.value)">
                <option value="text">📄 Teks</option>
                <option value="video">🎬 Video URL</option>
                <option value="pdf">📋 PDF</option>
                <option value="quiz">❓ Quiz</option>
              </select>
            </div>
          </div>
          <div class="fg">
            <label>URL Video (jika tipe Video)</label>
            <input type="text" class="fi" name="video_url" id="edit-modul-videourl" placeholder="https://youtube.com/embed/...">
          </div>
          <div class="fg">
            <label>Deskripsi Singkat</label>
            <textarea class="fi" name="description" id="edit-modul-desc" rows="2"></textarea>
          </div>
        </div>

        <!-- TAB: Konten -->
        <div id="panel-content" style="display:none;">
          <div class="fg">
            <label>Konten / Materi (HTML diperbolehkan)</label>
            <textarea class="fi" name="content" id="edit-modul-content" rows="12"
              style="font-family:monospace;font-size:.8rem;line-height:1.6;"></textarea>
          </div>
        </div>

        <!-- TAB: Quiz Builder -->
        <div id="panel-quiz" style="display:none;">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <div>
              <div style="font-weight:800;font-size:.85rem;color:var(--t);">Daftar Soal Quiz</div>
              <div style="font-size:.72rem;color:var(--muted);margin-top:2px;">Tambahkan soal pilihan ganda (A, B, C, D)</div>
            </div>
            <div style="display:flex;gap:.5rem;align-items:center;">
              <button type="button" onclick="qbDownloadTemplateExcel()" 
                style="background:#f8fafc;color:#475569;border:1px solid #e2e8f0;padding:.45rem .75rem;border-radius:8px;font-size:.75rem;font-weight:600;cursor:pointer;">
                📄 Template Excel
              </button>
              <label style="background:#f8fafc;color:#475569;border:1px solid #e2e8f0;padding:.45rem .75rem;border-radius:8px;font-size:.75rem;font-weight:600;cursor:pointer;display:flex;align-items:center;margin:0;">
                📥 Import Excel
                <input type="file" accept=".xlsx, .xls" style="display:none;" onchange="qbImportExcel(event)">
              </label>
              <button type="button" onclick="qbAddQuestion()"
                style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;padding:.45rem 1rem;border-radius:8px;font-size:.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Soal
              </button>
            </div>
          </div>
          <div id="qb-questions-container" style="display:flex;flex-direction:column;gap:16px;">
            <div id="qb-empty" style="text-align:center;padding:40px 20px;border:2px dashed var(--border);border-radius:12px;color:var(--muted);">
              <div style="font-size:2rem;margin-bottom:8px;">❓</div>
              <div style="font-weight:700;font-size:.85rem;">Belum ada soal</div>
              <div style="font-size:.75rem;margin-top:4px;">Klik "Tambah Soal" untuk mulai membuat quiz</div>
            </div>
          </div>
        </div>

      </div><!-- end modal-body -->

      <div class="modal-footer" style="display:flex;align-items:center;justify-content:space-between;">
        <div id="qb-soal-count" style="font-size:.75rem;color:var(--muted);"></div>
        <div style="display:flex;gap:.5rem;">
          <button type="button" class="btn-sm" onclick="document.getElementById('modal-modul-edit').style.display='none'"
            style="background:var(--bg);color:var(--muted);border:1px solid var(--border);">Batal</button>
          <button type="submit" class="btn-sm" onclick="qbSerialize()"
            style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;padding:.42rem 1.1rem;">
            💾 Simpan Perubahan
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
.modul-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.02); }
@keyframes spin { 100% { transform: rotate(360deg); } }
.spin { animation: spin 1s linear infinite; }

.qb-question-card {
  background: var(--bg, #f8fafc);
  border: 1px solid var(--border, #e2e8f0);
  border-radius: 12px;
  padding: 16px;
}
.qb-option-row {
  display: grid;
  grid-template-columns: auto 1fr auto;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
}
.qb-opt-label {
  width: 28px; height: 28px;
  border-radius: 50%;
  background: var(--border, #e2e8f0);
  display: flex; align-items: center; justify-content: center;
  font-size: .72rem; font-weight: 800; color: var(--t, #1e293b);
  flex-shrink: 0;
}
.qb-correct-radio:checked + .qb-opt-label {
  background: #22c55e;
  color: #fff;
}
</style>

<script>
/* ── Edit Modul util ── */
function openEditModul(m) {
  // Info tab
  document.getElementById('edit-modul-id').value       = m.id;
  document.getElementById('edit-modul-title').value    = m.title || '';
  document.getElementById('edit-modul-type').value     = m.type || 'text';
  document.getElementById('edit-modul-modnum').value   = m.module_number || '';
  document.getElementById('edit-modul-duration').value = m.duration_minutes || '';
  document.getElementById('edit-modul-videourl').value = m.video_url || '';
  document.getElementById('edit-modul-desc').value     = m.description || '';
  // Content tab
  document.getElementById('edit-modul-content').value  = m.content || '';
  // Quiz Builder
  qbLoadQuestions(m.quiz_data ? (typeof m.quiz_data === 'string' ? JSON.parse(m.quiz_data) : m.quiz_data) : []);
  // Reset tabs
  switchTab('info');
  document.getElementById('modal-modul-edit').style.display = 'flex';
}

function switchTab(tab) {
  ['info','content','quiz'].forEach(t => {
    document.getElementById('panel-' + t).style.display = (t === tab) ? '' : 'none';
    const btn = document.getElementById('tab-' + t);
    btn.style.borderBottomColor = (t === tab) ? 'var(--v1)' : 'transparent';
    btn.style.color = (t === tab) ? 'var(--v1)' : 'var(--muted)';
  });
}

function onTypeChange(val) {
  if (val === 'quiz') switchTab('quiz');
}

/* ── Quiz Builder ── */
let qbQuestions = [];

function qbLoadQuestions(questions) {
  qbQuestions = questions || [];
  qbRender();
}

function qbAddQuestion() {
  qbQuestions.push({
    id: 'q' + Date.now(),
    question: '',
    options: [
      { id: 'a', text: '' },
      { id: 'b', text: '' },
      { id: 'c', text: '' },
      { id: 'd', text: '' },
    ],
    answer: 'a'
  });
  qbRender();
  // scroll to bottom
  setTimeout(() => {
    const c = document.getElementById('qb-questions-container');
    c.scrollTop = c.scrollHeight;
  }, 50);
}

function qbDownloadTemplateExcel() {
  if (typeof XLSX === 'undefined') {
    showToast("Library Excel sedang dimuat. Coba lagi.", "error");
    return;
  }
  const data = [
    ["Pertanyaan", "Opsi A", "Opsi B", "Opsi C", "Opsi D", "Jawaban Benar (A/B/C/D)"],
    ["Siapa penemu lampu pijar?", "Thomas Edison", "Nikola Tesla", "Albert Einstein", "Isaac Newton", "A"],
    ["Ibukota Indonesia adalah?", "Bandung", "Jakarta", "Surabaya", "Medan", "B"]
  ];
  const ws = XLSX.utils.aoa_to_sheet(data);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Template Quiz");
  XLSX.writeFile(wb, "template_quiz_guruverse.xlsx");
}

function qbImportExcel(e) {
  if (typeof XLSX === 'undefined') {
    showToast("Library Excel sedang dimuat. Coba lagi.", "error");
    return;
  }
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function(event) {
    try {
      const data = new Uint8Array(event.target.result);
      const workbook = XLSX.read(data, {type: 'array'});
      const firstSheetName = workbook.SheetNames[0];
      const worksheet = workbook.Sheets[firstSheetName];
      const rows = XLSX.utils.sheet_to_json(worksheet, {header: 1});
      
      if (rows.length < 2) {
        showToast("File Excel kosong atau format tidak valid.", "error");
        return;
      }
      
      let addedCount = 0;
      for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        if (row.length >= 6) {
          const questionText = row[0]?.toString() || '';
          const optA = row[1]?.toString() || '';
          const optB = row[2]?.toString() || '';
          const optC = row[3]?.toString() || '';
          const optD = row[4]?.toString() || '';
          let ans = (row[5]?.toString() || 'a').toLowerCase().trim();
          if (!['a','b','c','d'].includes(ans)) ans = 'a';
          
          if (!questionText.trim()) continue;

          qbQuestions.push({
            id: 'q' + Date.now() + i,
            question: questionText,
            options: [
              { id: 'a', text: optA },
              { id: 'b', text: optB },
              { id: 'c', text: optC },
              { id: 'd', text: optD }
            ],
            answer: ans
          });
          addedCount++;
        }
      }
      
      if (addedCount > 0) {
        qbRender();
        showToast(addedCount + " soal berhasil diimpor!", "success");
      } else {
        showToast("Tidak ada soal yang valid untuk diimpor. Pastikan format sesuai template.", "error");
      }
    } catch(err) {
      showToast("Gagal membaca file Excel. Pastikan format file .xlsx atau .xls valid.", "error");
      console.error(err);
    }
  };
  reader.readAsArrayBuffer(file);
  e.target.value = ''; // reset file input
}

function qbRemoveQuestion(idx) {
  qbQuestions.splice(idx, 1);
  qbRender();
}

function qbRender() {
  const container = document.getElementById('qb-questions-container');
  const empty = document.getElementById('qb-empty');
  const count = document.getElementById('qb-soal-count');

  if (qbQuestions.length === 0) {
    container.innerHTML = '';
    container.appendChild(empty);
    empty.style.display = '';
    count.textContent = '';
    return;
  }
  empty.style.display = 'none';
  count.textContent = qbQuestions.length + ' soal tersimpan';

  const optLabels = ['A', 'B', 'C', 'D'];

  container.innerHTML = qbQuestions.map((q, qi) => `
    <div class="qb-question-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
        <span style="font-size:.72rem;font-weight:800;color:var(--v1);background:var(--v1)15;padding:3px 10px;border-radius:20px;">SOAL ${qi + 1}</span>
        <button type="button" onclick="qbRemoveQuestion(${qi})"
          style="background:#fee2e2;color:#dc2626;border:none;padding:4px 10px;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">
          🗑 Hapus
        </button>
      </div>
      <div style="margin-bottom:12px;">
        <label style="font-size:.72rem;font-weight:700;color:var(--muted);display:block;margin-bottom:4px;">Pertanyaan</label>
        <textarea
          style="width:100%;border:1px solid var(--border);border-radius:8px;padding:8px 12px;font-size:.82rem;resize:vertical;min-height:60px;background:var(--card,#fff);color:var(--t);"
          oninput="qbQuestions[${qi}].question=this.value"
          placeholder="Tulis pertanyaan di sini...">${q.question || ''}</textarea>
      </div>
      <div style="margin-bottom:8px;">
        <label style="font-size:.72rem;font-weight:700;color:var(--muted);display:block;margin-bottom:4px;">Pilihan Jawaban &amp; Kunci (pilih yang benar)</label>
        ${q.options.map((opt, oi) => `
          <div class="qb-option-row">
            <div style="display:flex;align-items:center;gap:6px;">
              <input type="radio" name="qb_correct_${qi}" value="${opt.id}"
                ${q.answer === opt.id ? 'checked' : ''}
                onchange="qbQuestions[${qi}].answer='${opt.id}'"
                style="accent-color:#22c55e;transform:scale(1.2);">
              <div class="qb-opt-label" style="${q.answer === opt.id ? 'background:#22c55e;color:#fff;' : ''}">${optLabels[oi]}</div>
            </div>
            <input type="text"
              style="border:1px solid var(--border);border-radius:8px;padding:7px 10px;font-size:.82rem;width:100%;background:var(--card,#fff);color:var(--t);"
              placeholder="Pilihan ${optLabels[oi]}..."
              value="${opt.text.replace(/"/g, '&quot;')}"
              oninput="qbQuestions[${qi}].options[${oi}].text=this.value">
            <div style="width:20px;"></div>
          </div>`).join('')}
      </div>
    </div>
  `).join('');
}

function qbSerialize() {
  // Sync textarea values (in case oninput wasn't triggered)
  document.getElementById('edit-modul-quiz-data').value =
    qbQuestions.length > 0 ? JSON.stringify(qbQuestions) : '';
}

/* ── File & PDF utils ── */
function handleFileSelect(input) {
  if (!input.files || input.files.length === 0) return;
  const file = input.files[0];
  const titleInput = document.getElementById('add-modul-title');
  const typeInput = document.getElementById('add-modul-type');
  const descInput = document.getElementById('add-modul-desc');
  const indicator = document.getElementById('pdf-loading-indicator');

  if (file.name.toLowerCase().endsWith('.pdf')) {
    typeInput.value = 'pdf';
    const formData = new FormData();
    formData.append('pdf_file', file);
    indicator.style.display = 'block';
    fetch('/api/parse_pdf.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(data => {
        indicator.style.display = 'none';
        if (data.success && data.data) {
          if (!titleInput.value) titleInput.value = data.data.title;
          if (!descInput.value) descInput.value = data.data.description;
        }
      })
      .catch(err => {
        indicator.style.display = 'none';
        if (!titleInput.value) {
          let name = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, " ");
          titleInput.value = name.charAt(0).toUpperCase() + name.slice(1);
        }
      });
  } else {
    if (!titleInput.value) {
      let name = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, " ");
      titleInput.value = name.charAt(0).toUpperCase() + name.slice(1);
    }
  }
}

function handleImportEbook(input) {
  if (!input.files || input.files.length === 0) return;
  const file = input.files[0];
  document.getElementById('modal-modul-add').style.display = 'flex';
  const dataTransfer = new DataTransfer();
  dataTransfer.items.add(file);
  const modalInput = document.getElementById('add-modul-file');
  modalInput.files = dataTransfer.files;
  handleFileSelect(modalInput);
  input.value = '';
}
</script>

@endsection