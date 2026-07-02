@extends('layouts.admin')

@section('title', 'Manajemen Bot')
@section('page_title', 'Manajemen Bot')

@section('content')
@php // views/bot_settings.php
// $conn is provided by layout_header.php — do NOT call getConnection() again

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'add' || $action === 'edit') {
        $keywords = $conn->real_escape_string($_POST['keywords']);
        $answer = $conn->real_escape_string($_POST['answer']);
        if ($action === 'add') {
            $conn->query("INSERT INTO gb_bot_rules (keywords, answer) VALUES ('$keywords', '$answer')");
        } else {
            $id = (int)$_POST['id'];
            $conn->query("UPDATE gb_bot_rules SET keywords='$keywords', answer='$answer' WHERE id=$id");
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM gb_bot_rules WHERE id=$id");
    }
    echo "<script>window.location='?mod=bot_settings';</script>";
    exit;
}

// Fetch existing rules
$rules = [];
$res = $conn->query("SELECT * FROM gb_bot_rules ORDER BY id DESC");
if ($res) {
    while($row = $res->fetch_assoc()) {
        $rules[] = $row;
    }
} @endphp

<div class="panel">
  <div class="panel-head" style="display:flex; justify-content:space-between; align-items:center;">
    <span class="panel-title" style="display:flex;align-items:center;gap:8px">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--v1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
      Manajemen Bot Penjawab (Auto-responder)
    </span>
    <button class="btn btn-primary" onclick="openBotModal()">+ Tambah Aturan</button>
  </div>
  
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Kata Kunci (Dipisahkan koma)</th>
          <th>Jawaban Bot</th>
          <th style="text-align:center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @if (empty($rules))
          <tr><td colspan="4"><div class="empty">Belum ada aturan bot. Tambahkan aturan pertama Anda.</div></td></tr>
        @else
@foreach($rules as $r)
          <tr>
            <td style="font-weight:700;color:var(--muted)">#{{ $r['id'] }}</td>
            <td>
              <div style="display:flex;flex-wrap:wrap;gap:4px">
                @foreach (explode(',', $r['keywords']) as $kw)
                  <span style="background:rgba(139,47,201,0.1);color:var(--v1);padding:2px 8px;border-radius:12px;font-size:0.75rem;font-weight:600">{{ htmlspecialchars(trim($kw)) }}</span>
                @endforeach
              </div>
            </td>
            <td style="font-size:0.8rem;color:var(--t2);max-width:300px;white-space:normal">{{ nl2br(htmlspecialchars($r['answer'])) }}</td>
            <td style="text-align:center">
              <div class="row-actions" style="justify-content:center;gap:8px">
                <button type="button" class="btn-sm" onclick="editBotRule({{ $r['id'] }}, `{{ htmlspecialchars(addslashes($r['keywords'])) }}`, `{{ htmlspecialchars(addslashes($r['answer'])) }}`); return false;" style="background:rgba(139,47,201,.1);color:var(--v1);border:none;padding:6px;border-radius:6px" title="Edit">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </button>
                <form method="POST" class="form-delete" data-confirm="Hapus aturan bot ini?" style="margin:0">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="{{ $r['id'] }}">
                  <button type="submit" class="btn-sm" style="background:rgba(239,68,68,.1);color:#ef4444;border:none;padding:6px;border-radius:6px" title="Hapus">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach 
 @endif
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah/Edit Aturan -->
<div class="overlay" id="modal-bot" style="display:none;z-index:9999" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-head">
      <span class="modal-title" id="bot-modal-title">Tambah Aturan Baru</span>
      <button type="button" class="modal-close" onclick="document.getElementById('modal-bot').style.display='none'">×</button>
    </div>
    <form method="POST" class="modal-body">
      <input type="hidden" name="action" id="bot-action" value="add">
      <input type="hidden" name="id" id="bot-id" value="">
      
      <div class="fg">
        <label>Kata Kunci / Keywords</label>
        <div style="font-size:0.7rem;color:var(--muted);margin-bottom:6px">Gunakan koma (,) untuk memisahkan beberapa kata kunci. Contoh: <i>sertifikat, piagam, cetak</i></div>
        <input type="text" name="keywords" id="bot-keywords" class="fi" required placeholder="Contoh: sertifikat, piagam">
      </div>
      
      <div class="fg">
        <label>Jawaban / Respons Bot</label>
        <div style="font-size:0.7rem;color:var(--muted);margin-bottom:6px">Tuliskan pesan balasan lengkap yang akan dikirim bot.</div>
        <textarea name="answer" id="bot-answer" class="fi" required placeholder="Tuliskan jawaban bot di sini..." style="min-height:120px;resize:vertical"></textarea>
      </div>
      
      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:1.5rem">
        <button type="button" class="btn" style="background:#f1f5f9;color:#475569;border:none" onclick="document.getElementById('modal-bot').style.display='none'">Batal</button>
        <button type="submit" class="btn btn-primary" id="bot-submit-btn">Simpan Aturan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openBotModal() {
    document.getElementById('bot-modal-title').innerText = 'Tambah Aturan Baru';
    document.getElementById('bot-action').value = 'add';
    document.getElementById('bot-id').value = '';
    document.getElementById('bot-keywords').value = '';
    document.getElementById('bot-answer').value = '';
    document.getElementById('bot-submit-btn').innerText = 'Simpan Aturan';
    document.getElementById('modal-bot').style.display = 'flex';
}

function editBotRule(id, keywords, answer) {
    document.getElementById('bot-modal-title').innerText = 'Edit Aturan Bot';
    document.getElementById('bot-action').value = 'edit';
    document.getElementById('bot-id').value = id;
    document.getElementById('bot-keywords').value = keywords;
    document.getElementById('bot-answer').value = answer;
    document.getElementById('bot-submit-btn').innerText = 'Update Aturan';
    document.getElementById('modal-bot').style.display = 'flex';
}
</script>

@endsection