@extends('layouts.admin')

@section('title', 'Manajemen Kelas')
@section('page_title', 'Manajemen Kelas')

@section('content')


@if ($msg)
  <div class="toast toast-success" style="display:flex;position:static;margin-bottom:1rem">{{ htmlspecialchars($msg) }}</div>
@endif

<div class="panel">
  <div class="panel-head">
    <span class="panel-title">Daftar Kelas ({{ count($kelas_list) }})</span>
    <div class="panel-actions">
      <form method="GET" style="display:inline-flex;align-items:center;gap:6px">
        <input type="hidden" name="mod" value="kelas">
        <div class="search-wrap">
          <span class="search-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
          <input class="search-fi" name="search" value="{{ htmlspecialchars($search) }}" placeholder="Cari kelas...">
        </div>
      </form>
      <button class="btn-sm" onclick="document.getElementById('modal-kelas-add').style.display='flex'"
        style="background:linear-gradient(135deg,#7c3aed,#6d28d9);color:#fff;border:none">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Kelas
      </button>
    </div>
  </div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>#</th><th>Judul Kelas</th><th>Kategori</th><th>Mentor</th><th>Durasi</th><th>Status</th><th style="text-align:center">Aksi</th></tr></thead>
      <tbody>
        @if (empty($kelas_list))
          <tr><td colspan="7"><div class="empty">Belum ada kelas. Tambahkan kelas pertama.</div></td></tr>
        @else
@foreach ($kelas_list as $i => $k)
@php
          $colors = ['active'=>['rgba(52,211,153,.12)','#34d399'],'draft'=>['rgba(255,255,255,.05)','var(--muted)'],'archived'=>['rgba(248,113,113,.1)','#f87171']];
          $st = $k['status'] ?? 'draft';
          [$sc, $tc] = $colors[$st] ?? $colors['draft'];
@endphp
          <tr>
            <td><span class="mono" style="font-size:.65rem;color:var(--muted2)">{{ $i+1 }}</span></td>
            <td>
              <div style="font-weight:700;font-size:.82rem">{{ htmlspecialchars($k['title']) }}</div>
              <div style="font-size:.62rem;color:var(--muted2)">{{ $k['is_free'] ? 'Gratis' : 'Berbayar' }}</div>
            </td>
            <td style="color:var(--muted);font-size:.75rem">{{ htmlspecialchars($k['category'] ?? '-') }}</td>
            <td style="color:var(--muted);font-size:.75rem">{{ htmlspecialchars($k['mentor_name'] ?? '-') }}</td>
            <td style="color:var(--muted2);font-size:.72rem">{{ $k['duration_hours'] }} jam</td>
            <td><span style="font-size:.65rem;font-weight:700;padding:2px 10px;border-radius:20px;background:{{ $sc }};color:{{ $tc }}">{{ strtoupper($st) }}</span></td>
            <td style="text-align:center">
              <div class="dropdown relative inline-flex">
                <button id="dd-kelas-{{ $k['id'] }}" type="button" class="dropdown-toggle btn btn-square btn-ghost btn-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-40 z-50" role="menu" aria-orientation="vertical" aria-labelledby="dd-kelas-{{ $k['id'] }}">
                  <li><a class="dropdown-item" href="#" onclick='openEditKelas({{ json_encode($k) }});return false;'>Edit Kelas</a></li>
                  <hr class="my-1 border-gray-200" />
                  <li>
                    <form method="POST" class="form-delete m-0" data-confirm="Hapus kelas ini?">
                      @csrf
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="{{ $k['id'] }}">
                      <button type="submit" class="dropdown-item text-red-500 hover:bg-red-50 w-full text-left">Hapus Kelas</button>
                    </form>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        @endforeach 
 @endif
      </tbody>
    </table>
  </div>
</div>

<!-- Modal: Tambah Kelas -->
<div class="overlay" id="modal-kelas-add" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Tambah Kelas Baru</div>
      <button class="close-btn" onclick="document.getElementById('modal-kelas-add').style.display='none'">✕</button>
    </div>
    <form method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="action" value="create">
      <div class="modal-body">
        <div class="fg"><label>Judul Kelas</label><input type="text" class="fi" name="title" required placeholder="Nama kelas..."></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Kategori</label><input type="text" class="fi" name="category" placeholder="Pedagogi, IPA..."></div>
          <div class="fg"><label>Durasi (jam)</label><input type="number" class="fi" name="duration_hours" value="4" min="1"></div>
        </div>
        <div class="fg"><label>Nama Mentor</label><input type="text" class="fi" name="mentor_name" placeholder="Nama mentor..."></div>
        <div class="fg"><label>Deskripsi</label><textarea class="fi" name="description" rows="3" placeholder="Deskripsi kelas..."></textarea></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Status</label>
            <select class="fi" name="status"><option value="draft">Draft</option><option value="active">Active</option><option value="archived">Archived</option></select>
          </div>
          <div class="fg" style="padding-top:0.5rem">
            <label>Tipe Kelas</label>
            <div style="display:flex;gap:15px;margin-top:6px">
              <label style="display:flex;align-items:center;gap:6px;font-size:.75rem;cursor:pointer">
                <input type="radio" name="is_paid" value="0" checked onchange="document.getElementById('add-pay-wrap').style.display='none'"> Gratis
              </label>
              <label style="display:flex;align-items:center;gap:6px;font-size:.75rem;cursor:pointer">
                <input type="radio" name="is_paid" value="1" onchange="document.getElementById('add-pay-wrap').style.display='block'"> Berbayar
              </label>
            </div>
          </div>
        </div>
        <div class="fg" id="add-pay-wrap" style="display:none;margin-top:0.5rem">
          <label>Link Pembayaran (Mayar.id / Midtrans)</label>
          <input type="text" class="fi" name="payment_link" placeholder="https://mayar.id/...">
        </div>
        <hr style="border:1px solid var(--border); margin:1rem 0;">
        <div style="font-weight:700; margin-bottom:10px; display:flex; justify-content:space-between;">
          <span>Pengaturan Sertifikat</span>
          <a href="{{ asset('uploads/cert_templates/contoh_template.png') }}" target="_blank" style="font-size:0.75rem; color:var(--v1); font-weight:normal; text-decoration:underline;">Lihat Contoh Desain</a>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Upload Template (JPG/PNG)</label><input type="file" class="fi" name="cert_template" accept="image/jpeg,image/png"></div>
          <div class="fg">
             <label>Layout Visual</label>
             <input type="hidden" name="cert_config" id="add-kelas-cert-config">
             <button type="button" class="btn btn-outline" style="width:100%; padding:0.42rem" onclick="alert('Silakan simpan kelas terlebih dahulu untuk mengatur layout pada template yang baru diunggah.')">Desain Tata Letak</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-kelas-add').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);color:#fff;border:none;padding:.42rem 1.1rem">Simpan Kelas</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Kelas -->
<div class="overlay" id="modal-kelas-edit" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Edit Kelas</div>
      <button class="close-btn" onclick="document.getElementById('modal-kelas-edit').style.display='none'">✕</button>
    </div>
    <form method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" id="edit-kelas-id">
      <div class="modal-body">
        <div class="fg"><label>Judul Kelas</label><input type="text" class="fi" name="title" id="edit-kelas-title" required></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Kategori</label><input type="text" class="fi" name="category" id="edit-kelas-category"></div>
          <div class="fg"><label>Durasi (jam)</label><input type="number" class="fi" name="duration_hours" id="edit-kelas-duration" min="1"></div>
        </div>
        <div class="fg"><label>Nama Mentor</label><input type="text" class="fi" name="mentor_name" id="edit-kelas-mentor"></div>
        <div class="fg"><label>Deskripsi</label><textarea class="fi" name="description" id="edit-kelas-desc" rows="3"></textarea></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Status</label>
            <select class="fi" name="status" id="edit-kelas-status">
              <option value="draft">Draft</option><option value="active">Active</option><option value="archived">Archived</option>
            </select>
          </div>
          <div class="fg" style="padding-top:0.5rem">
            <label>Tipe Kelas</label>
            <div style="display:flex;gap:15px;margin-top:6px">
              <label style="display:flex;align-items:center;gap:6px;font-size:.75rem;cursor:pointer">
                <input type="radio" name="is_paid" id="edit-kelas-free" value="0" onchange="document.getElementById('edit-pay-wrap').style.display='none'"> Gratis
              </label>
              <label style="display:flex;align-items:center;gap:6px;font-size:.75rem;cursor:pointer">
                <input type="radio" name="is_paid" id="edit-kelas-paid" value="1" onchange="document.getElementById('edit-pay-wrap').style.display='block'"> Berbayar
              </label>
            </div>
          </div>
        </div>
        <div class="fg" id="edit-pay-wrap" style="display:none;margin-top:0.5rem">
          <label>Link Pembayaran (Mayar.id / Midtrans)</label>
          <input type="text" class="fi" name="payment_link" id="edit-kelas-payment-link" placeholder="https://mayar.id/...">
        </div>
        <hr style="border:1px solid var(--border); margin:1rem 0;">
        <div style="font-weight:700; margin-bottom:10px; display:flex; justify-content:space-between;">
          <span>Pengaturan Sertifikat</span>
          <a href="{{ asset('uploads/cert_templates/contoh_template.png') }}" target="_blank" style="font-size:0.75rem; color:var(--v1); font-weight:normal; text-decoration:underline;">Lihat Contoh Desain</a>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Ganti Template (opsional)</label><input type="file" class="fi" name="cert_template" accept="image/jpeg,image/png"></div>
          <div class="fg">
             <label>Layout Visual</label>
             <input type="hidden" name="cert_config" id="edit-kelas-cert-config">
             <input type="hidden" id="edit-kelas-cert-template-url">
             <button type="button" class="btn btn-outline" style="width:100%; padding:0.42rem" onclick="openCertDesigner(document.getElementById('edit-kelas-cert-template-url').value, 'edit-kelas-cert-config')">Ubah Tata Letak &rarr;</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-kelas-edit').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none;padding:.42rem 1.1rem">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditKelas(k) {
  document.getElementById('edit-kelas-id').value        = k.id;
  document.getElementById('edit-kelas-title').value     = k.title;
  document.getElementById('edit-kelas-category').value  = k.category || '';
  document.getElementById('edit-kelas-duration').value  = k.duration_hours || 0;
  document.getElementById('edit-kelas-mentor').value    = k.mentor_name || '';
  document.getElementById('edit-kelas-desc').value      = k.description || '';
  document.getElementById('edit-kelas-status').value    = k.status || 'draft';
  
  // Logic: is_free=1 means Gratis (is_paid=0), is_free=0 means Berbayar (is_paid=1)
  if (k.is_free == 1) {
    document.getElementById('edit-kelas-free').checked = true;
    document.getElementById('edit-pay-wrap').style.display = 'none';
  } else {
    document.getElementById('edit-kelas-paid').checked = true;
    document.getElementById('edit-pay-wrap').style.display = 'block';
  }
  document.getElementById('edit-kelas-payment-link').value = k.payment_link || '';
  document.getElementById('edit-kelas-cert-config').value = k.cert_config || '';
  document.getElementById('edit-kelas-cert-template-url').value = k.cert_template ? '/uploads/cert_templates/' + k.cert_template : '';
  
  document.getElementById('modal-kelas-edit').style.display = 'flex';
}
</script>

@include('admin.cert_designer')

@endsection