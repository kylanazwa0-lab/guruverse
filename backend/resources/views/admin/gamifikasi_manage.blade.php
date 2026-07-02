@extends('layouts.admin')

@section('title', 'Kelola Gamifikasi')
@section('page_title', 'Kelola Gamifikasi')

@section('content')
@php // admin/views/gamifikasi_manage.php
// $conn is provided by layout_header.php — do NOT output <html>/<body> here

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['definition'])) {
    $allowedExt = ['json', 'yaml', 'yml'];
    $fileName   = $_FILES['definition']['name'];
    $tmpPath    = $_FILES['definition']['tmp_name'];
    $ext        = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        $gm_error = "Hanya file JSON atau YAML yang diperbolehkan.";
    } else {
        $destDir = __DIR__ . "/../../asset/docs/gamifikasi/";
        if (!is_dir($destDir)) mkdir($destDir, 0777, true);
        $dest = $destDir . basename($fileName);
        if (move_uploaded_file($tmpPath, $dest)) {
            $gm_success = "File \"" . htmlspecialchars($fileName) . "\" berhasil diunggah.";
        } else {
            $gm_error = "Gagal memindahkan file yang diunggah. Periksa permission folder.";
        }
    }
}

$definitionDir = __DIR__ . "/../../asset/docs/gamifikasi/";
$gm_files = [];
if (is_dir($definitionDir)) {
    $gm_files = array_values(array_filter(scandir($definitionDir), function($f) use ($definitionDir) {
        return is_file($definitionDir . $f) && preg_match('/\.(json|yaml|yml)$/i', $f);
    }));
} @endphp

@if (!empty($gm_error))
  <div class="toast toast-error" style="display:flex;position:static;margin-bottom:1rem">{{ htmlspecialchars($gm_error) }}</div>
@endif
@if (!empty($gm_success))
  <div class="toast toast-success" style="display:flex;position:static;margin-bottom:1rem">{{ htmlspecialchars($gm_success) }}</div>
@endif

<div class="panel">
  <div class="panel-head" style="display:flex;justify-content:space-between;align-items:center">
    <span class="panel-title" style="display:flex;align-items:center;gap:8px">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--v1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 22 22 7 12 2"/></svg>
      Kelola Definisi Gamifikasi
    </span>
  </div>

  <div style="padding:1.5rem">
    <form method="POST" enctype="multipart/form-data" style="background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:1.25rem;margin-bottom:1.5rem">
      @csrf
      <div style="font-weight:800;font-size:.82rem;margin-bottom:.75rem;color:var(--t)">Upload File Definisi (JSON / YAML)</div>
      <div style="display:flex;gap:.75rem;align-items:flex-end">
        <div class="fg" style="flex:1;margin-bottom:0">
          <label>Pilih File</label>
          <input type="file" name="definition" class="fi" accept=".json,.yaml,.yml" required>
        </div>
        <button type="submit" class="btn-sm"
          style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;padding:.55rem 1.25rem;white-space:nowrap">
          ⬆ Upload
        </button>
      </div>
    </form>

    <div style="font-weight:800;font-size:.85rem;margin-bottom:.75rem;color:var(--t)">
      Daftar Aktivitas <span style="color:var(--muted);font-weight:500">({{ count($gm_files) }} file)</span>
    </div>

    @if (empty($gm_files))
      <div class="empty">Belum ada file definisi yang diunggah.</div>
    @else
      <div style="display:flex;flex-direction:column;gap:.5rem">
        @foreach ($gm_files as $f)
          <div style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;background:var(--card,#fff);border:1px solid var(--border);border-radius:8px">
            <div>
              <div style="font-size:.82rem;font-weight:700;color:var(--t)">{{ htmlspecialchars($f) }}</div>
            </div>
            <button onclick="previewGmFile('{{ htmlspecialchars($f, ENT_QUOTES) }}')" class="btn-sm"
              style="background:rgba(139,47,201,.1);color:var(--v1);border:1px solid rgba(139,47,201,.2);font-size:.72rem">
              👁 Preview
            </button>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

<!-- Preview Modal -->
<div class="overlay" id="modal-gm-preview" style="display:none;z-index:9999" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md" style="max-width:640px">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Preview Definisi</div>
      <button class="close-btn" onclick="document.getElementById('modal-gm-preview').style.display='none'">✕</button>
    </div>
    <div class="modal-body">
      <pre id="gm-preview-content" style="background:var(--bg,#f8fafc);padding:1rem;border-radius:8px;font-size:.75rem;max-height:400px;overflow:auto;white-space:pre-wrap;word-break:break-all;border:1px solid var(--border)"></pre>
    </div>
    <div class="modal-footer">
      <button class="btn-sm" onclick="document.getElementById('modal-gm-preview').style.display='none'"
        style="background:var(--bg);color:var(--muted);border:1px solid var(--border)">Tutup</button>
    </div>
  </div>
</div>

<script>
function previewGmFile(file) {
  fetch('/asset/docs/gamifikasi/' + encodeURIComponent(file))
    .then(r => r.text())
    .then(t => {
      document.getElementById('gm-preview-content').textContent = t;
      document.getElementById('modal-gm-preview').style.display = 'flex';
    })
    .catch(e => showToast('Gagal memuat preview: ' + e.message, 'error'));
}
</script>

@endsection