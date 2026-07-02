@extends('layouts.admin')

@section('title', 'Sertifikat Member')
@section('page_title', 'Sertifikat Member')

@section('content')
@php // views/sertifikat.php
// $conn is provided by layout_header.php

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = (int)$_POST['id'];
    $cert_num = $conn->real_escape_string($_POST['certificate_number'] ?? '');
    $conn->query("UPDATE gb_certificates SET certificate_number='$cert_num' WHERE id=$id");
    echo "<script>window.location.href='/admin/module/sertifikat';</script>";
    exit;
}

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $conn->query("DELETE FROM gb_certificates WHERE id=$id");
    echo "<script>window.location.href='/admin/module/sertifikat';</script>";
    exit;
}

$q = $_GET['q'] ?? '';
$where = "1=1";
if ($q !== '') {
    $esc_q = $conn->real_escape_string($q);
    $where .= " AND (s.certificate_number LIKE '%$esc_q%' OR m.full_name LIKE '%$esc_q%' OR c.title LIKE '%$esc_q%')";
}

$res = $conn->query("
    SELECT s.*, m.full_name as member_name, c.title as course_title 
    FROM gb_certificates s
    JOIN members m ON s.user_id = m.id
    JOIN gb_courses c ON s.course_id = c.id
    WHERE $where
    ORDER BY s.issued_at DESC
");
$certs = [];
while ($r = $res->fetch_assoc()) $certs[] = $r;

// Stats logic
$resAll = $conn->query("SELECT COUNT(*) as c FROM gb_certificates");
$total_all = $resAll->fetch_assoc()['c'];

$filtered = count($certs);

$m = date('Y-m');
$y = date('Y');
$resM = $conn->query("SELECT COUNT(*) as c FROM gb_certificates WHERE DATE_FORMAT(issued_at, '%Y-%m') = '$m'");
$this_month = $resM->fetch_assoc()['c'];

$resY = $conn->query("SELECT COUNT(*) as c FROM gb_certificates WHERE YEAR(issued_at) = '$y'");
$this_year = $resY->fetch_assoc()['c']; @endphp

<style>
.cert-card { transition: all 0.2s ease; min-height: 350px; display: flex; flex-direction: column; }
.cert-card:hover { transform: translateY(-4px); box-shadow: 0 15px 30px -10px rgba(0,0,0,0.1); border-color: var(--v1); }
.cert-overlay {
  position: absolute; inset: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(2px);
  display: flex; align-items: center; justify-content: center; gap: 12px;
  opacity: 0; transition: all 0.2s ease;
}
.cert-card:hover .cert-overlay { opacity: 1; }
.cert-overlay .btn-action {
  padding: 0.5rem 1rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem;
  cursor: pointer; transition: transform 0.1s; text-decoration: none; border: none;
}
.cert-overlay .btn-action:hover { transform: scale(1.05); }
.cert-overlay .btn-view { background: #3b82f6; color: #fff; box-shadow: 0 4px 10px rgba(59,130,246,0.4); }
.cert-overlay .btn-edit { background: #f59e0b; color: #fff; box-shadow: 0 4px 10px rgba(245,158,11,0.4); }
.cert-overlay .btn-del { background: #ef4444; color: #fff; box-shadow: 0 4px 10px rgba(239,68,68,0.4); }

/* SVG Pattern background */
.cert-bg-pattern {
    background-color: #f8fafc;
    background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23e2e8f0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
}

/* Stat Box */
.stat-box { display: flex; flex-direction: column; align-items: center; padding: 1.25rem 0; }
.stat-label { font-size: 0.75rem; color: var(--muted); font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
.stat-val { font-size: 2rem; font-weight: 900; color: var(--t); font-family: 'JetBrains Mono', monospace; line-height: 1; }
</style>

<div style="padding:1rem 1.5rem">

  <!-- HEADER -->
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
    <div>
      <h2 style="font-size:1.35rem;font-weight:900;color:var(--t);letter-spacing:-.02em;margin-bottom:4px">Manajemen Sertifikat</h2>
      <p style="color:var(--muted);font-size:0.8rem">Kelola semua sertifikat kelulusan dan penghargaan member</p>
    </div>
    <!-- Add button just for visual parity with screenshot, or can link to an add page if it existed -->
    <button class="btn-sm" style="background:var(--v1);color:#fff;border:none;padding:.5rem 1.25rem;font-size:0.85rem">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Buat Sertifikat Manual
    </button>
  </div>

  <!-- SEARCH BAR -->
  <form method="GET" style="margin-bottom:2rem;position:relative">
    <input type="hidden" name="mod" value="sertifikat">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position:absolute;left:16px;top:50%;transform:translateY(-50%)"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" name="q" placeholder="Cari sertifikat berdasarkan Nomor, Nama Member, atau Judul Kelas..." value="{{ htmlspecialchars($_GET['q'] ?? '') }}" 
      style="width:100%;padding:1.1rem 1.1rem 1.1rem 48px;border:1px solid var(--border);border-radius:12px;background:#fff;font-size:0.9rem;box-shadow:0 2px 4px rgba(0,0,0,0.02);font-weight:500;color:var(--t)">
  </form>

  <!-- CARD GRID -->
  @if (empty($certs))
    <div style="background:#fff;border:1px dashed var(--border2);border-radius:12px;padding:4rem;text-align:center">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--muted2)" stroke-width="1.5" style="margin:0 auto 1rem"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
      <div style="font-weight:800;color:var(--t);margin-bottom:8px">Sertifikat tidak ditemukan</div>
      <div style="font-size:0.8rem;color:var(--muted)">Coba kata kunci lain atau belum ada sertifikat yang diterbitkan.</div>
    </div>
  @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;margin-bottom:2.5rem">
      @foreach ($certs as $c)
      <div class="cert-card" style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;position:relative;display:flex;flex-direction:column">
        
        <!-- Image Area -->
        <div class="cert-bg-pattern" style="height:170px;position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;border-bottom:1px solid #e2e8f0;padding:1rem;text-align:center">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px"><path d="M12 15l-2 5l9-5l-9-5l2 5z"/><circle cx="12" cy="8" r="4"/></svg>
          <div style="font-size:0.9rem;font-weight:800;color:#64748b;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;width:100%">{{ htmlspecialchars($c['member_name'] ?? '') }}</div>
          <div style="font-size:0.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px">Sertifikat Kelulusan</div>
          
          <!-- Hover Overlay -->
          <div class="cert-overlay">
            @php $file_link = !empty($c['pdf_path']) ? asset('uploads/certificates/' . $c['pdf_path']) : 'javascript:alert(\'File PDF sertifikat belum tersedia atau masih dalam proses pembuatan.\');'; @endphp
            <a href="{{ $file_link }}" target="_blank" class="btn-action btn-view">
               <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;display:inline-block;vertical-align:text-top"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
               View
            </a>
            <button type="button" class="btn-action btn-edit" onclick='openEditCert({{ json_encode($c) }})'>
               <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;display:inline-block;vertical-align:text-top"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
               Edit
            </button>
            <form method="POST" class="form-delete" data-confirm="Hapus sertifikat ini secara permanen?" style="display:inline;margin:0">
              @csrf
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="{{ $c['id'] }}">
              <button type="submit" class="btn-action btn-del">
                 <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;display:inline-block;vertical-align:text-top"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                 Delete
              </button>
            </form>
          </div>
        </div>

        <!-- Content Area -->
        <div style="padding:1.25rem;flex:1 0 auto">
          <div style="font-weight:800;font-size:0.95rem;color:var(--t);margin-bottom:6px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
            {{ htmlspecialchars($c['course_title'] ?? '') }}
          </div>
          <div style="font-size:0.75rem;color:var(--muted);font-weight:500">Lulus dengan baik</div>
        </div>

        <!-- Footer Area -->
        <div style="padding:0.8rem 1.25rem;background:#fafbfc;border-top:1px solid #f1f5f9;font-size:0.7rem;color:var(--muted);display:flex;flex-direction:column;gap:6px">
          <div style="display:flex;justify-content:space-between"><strong style="color:var(--t2)">ID:</strong> <span class="mono">{{ $c['id'] }}</span></div>
          <div style="display:flex;justify-content:space-between"><strong style="color:var(--t2)">Nomor:</strong> <span class="mono" style="color:var(--v1);font-weight:700">{{ htmlspecialchars($c['certificate_number'] ?? '') }}</span></div>
          <div style="display:flex;justify-content:space-between"><strong style="color:var(--t2)">Added:</strong> <span>{{ date('d/m/Y', strtotime($c['issued_at'])) }}</span></div>
        </div>

      </div>
      @endforeach
    </div>
  @endif

  <!-- BOTTOM STATS -->
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));background:#fff;border-radius:12px;border:1px solid var(--border);box-shadow:0 2px 8px rgba(0,0,0,0.02)">
    <div class="stat-box" style="border-right:1px solid var(--border)">
      <div class="stat-label">Total Certificates</div>
      <div class="stat-val">{{ number_format($total_all) }}</div>
    </div>
    <div class="stat-box" style="border-right:1px solid var(--border)">
      <div class="stat-label">Filtered Results</div>
      <div class="stat-val" style="color:var(--v1)">{{ number_format($filtered) }}</div>
    </div>
    <div class="stat-box" style="border-right:1px solid var(--border)">
      <div class="stat-label">This Month</div>
      <div class="stat-val">{{ number_format($this_month) }}</div>
    </div>
    <div class="stat-box">
      <div class="stat-label">This Year</div>
      <div class="stat-val">{{ number_format($this_year) }}</div>
    </div>
  </div>

</div>

<!-- Modal: Edit Sertifikat -->
<div class="overlay" id="modal-cert-edit" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Edit Sertifikat</div>
      <button class="close-btn" onclick="document.getElementById('modal-cert-edit').style.display='none'">✕</button>
    </div>
    <form method="POST">
      @csrf
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" id="edit-cert-id">
      <div class="modal-body">
        <div class="fg"><label>Nama Member</label><input type="text" class="fi" id="edit-cert-member" disabled></div>
        <div class="fg"><label>Judul Kelas</label><input type="text" class="fi" id="edit-cert-course" disabled></div>
        <div class="fg"><label>Nomor Sertifikat</label><input type="text" class="fi" name="certificate_number" id="edit-cert-number"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-cert-edit').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none;padding:.42rem 1.1rem">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditCert(c) {
  document.getElementById('edit-cert-id').value = c.id;
  document.getElementById('edit-cert-member').value = c.member_name;
  document.getElementById('edit-cert-course').value = c.course_title;
  document.getElementById('edit-cert-number').value = c.certificate_number || '';
  document.getElementById('modal-cert-edit').style.display = 'flex';
}
</script>

@endsection