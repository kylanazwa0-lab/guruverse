@extends('layouts.admin')

@section('title', 'Agenda & Event')
@section('page_title', 'Agenda & Event')

@section('content')
@if (session('msg'))
  <div class="toast toast-success" style="display:flex;position:static;margin-bottom:1rem">{{ htmlspecialchars(session('msg')) }}</div>
@endif

<div class="panel">
  <div class="panel-head">
    <span class="panel-title">Daftar Agenda ({{ count($agenda_list) }})</span>
    <div class="panel-actions">
      <form method="GET" style="display:inline-flex;align-items:center;gap:6px">
        <input type="hidden" name="mod" value="inspira_agenda">
        <div class="search-wrap">
          <span class="search-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
          <input class="search-fi" name="search" value="{{ htmlspecialchars($search) }}" placeholder="Cari event...">
        </div>
      </form>
      <button class="btn-sm" onclick="document.getElementById('modal-agenda-add').style.display='flex'"
        style="background:linear-gradient(135deg,#7c3aed,#6d28d9);color:#fff;border:none">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Agenda
      </button>
    </div>
  </div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>#</th><th>Nama Event</th><th>Tanggal</th><th>Lokasi</th><th style="text-align:center">Aksi</th></tr></thead>
      <tbody>
        @if (empty($agenda_list))
          <tr><td colspan="5"><div class="empty">Belum ada agenda.</div></td></tr>
        @else
@foreach ($agenda_list as $i => $a)
          <tr>
            <td><span class="mono" style="font-size:.65rem;color:var(--muted2)">{{ $i+1 }}</span></td>
            <td><div style="font-weight:700;font-size:.82rem">{{ htmlspecialchars($a['judul']) }}</div></td>
            <td style="color:var(--muted);font-size:.75rem">{{ date('d M Y', strtotime($a['event_date'])) }}</td>
            <td style="color:var(--muted);font-size:.75rem">{{ htmlspecialchars($a['lokasi']) }}</td>
            <td style="text-align:center">
              <div class="dropdown relative inline-flex">
                <button id="dd-agenda-{{ $a['id'] }}" type="button" class="dropdown-toggle btn btn-square btn-ghost btn-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-40 z-50" role="menu" aria-orientation="vertical" aria-labelledby="dd-agenda-{{ $a['id'] }}">
                  <li><a class="dropdown-item" href="#" onclick='openEditAgenda({{ json_encode($a) }});return false;'>Edit Agenda</a></li>
                  <hr class="my-1 border-gray-200" />
                  <li>
                    <form method="POST" class="form-delete m-0" onsubmit="return confirm('Hapus agenda ini?');">
                      @csrf
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="{{ $a['id'] }}">
                      <button type="submit" class="dropdown-item text-red-500 hover:bg-red-50 w-full text-left">Hapus Agenda</button>
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

<!-- Modal Tambah -->
<div class="overlay" id="modal-agenda-add" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Tambah Agenda Baru</div>
      <button class="close-btn" onclick="document.getElementById('modal-agenda-add').style.display='none'">✕</button>
    </div>
    <form method="POST">
      @csrf
      <input type="hidden" name="action" value="create">
      <div class="modal-body">
        <div class="fg"><label>Nama Event</label><input type="text" class="fi" name="nama_event" required></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Tanggal Event</label><input type="date" class="fi" name="tanggal_event" required></div>
          <div class="fg"><label>Lokasi</label><input type="text" class="fi" name="lokasi" required></div>
        </div>
        <div class="fg"><label>Deskripsi</label><textarea class="fi" name="deskripsi" rows="3"></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-agenda-add').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="overlay" id="modal-agenda-edit" style="display:none" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-header">
      <div style="font-weight:900;font-size:.9rem">Edit Agenda</div>
      <button class="close-btn" onclick="document.getElementById('modal-agenda-edit').style.display='none'">✕</button>
    </div>
    <form method="POST">
      @csrf
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" id="edit-agenda-id">
      <div class="modal-body">
        <div class="fg"><label>Nama Event</label><input type="text" class="fi" name="nama_event" id="edit-agenda-nama" required></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
          <div class="fg"><label>Tanggal Event</label><input type="date" class="fi" name="tanggal_event" id="edit-agenda-tanggal" required></div>
          <div class="fg"><label>Lokasi</label><input type="text" class="fi" name="lokasi" id="edit-agenda-lokasi" required></div>
        </div>
        <div class="fg"><label>Deskripsi</label><textarea class="fi" name="deskripsi" id="edit-agenda-deskripsi" rows="3"></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm" onclick="document.getElementById('modal-agenda-edit').style.display='none'" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
        <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditAgenda(a) {
  document.getElementById('edit-agenda-id').value = a.id;
  document.getElementById('edit-agenda-nama').value = a.judul;
  if(a.event_date) {
    document.getElementById('edit-agenda-tanggal').value = a.event_date.substring(0, 10);
  }
  document.getElementById('edit-agenda-lokasi').value = a.lokasi;
  document.getElementById('edit-agenda-deskripsi').value = a.deskripsi;
  document.getElementById('modal-agenda-edit').style.display = 'flex';
}
</script>

@endsection