@extends('layouts.admin')

@section('title', 'Notifikasi')
@section('page_title', 'Notifikasi')

@section('content')


@if ($msg)
  <div class="toast toast-success" style="display:flex;position:static;margin-bottom:1rem">{{ htmlspecialchars($msg) }}</div>
@endif

<div style="display:grid;grid-template-columns:300px 1fr;gap:1.5rem;align-items:start">
  
  <div class="panel">
    <div class="panel-head"><span class="panel-title">Kirim Notifikasi</span></div>
    <form method="POST" action="{{ route('admin.notifikasi.store') }}" style="padding:1.5rem">
      @csrf
      <input type="hidden" name="action" value="create">
      <div class="fg" style="margin-bottom:1rem">
        <label>Penerima</label>
        <select class="fi" name="target">
          <option value="all">Semua Member (Broadcast)</option>
        </select>
      </div>
      <div class="fg" style="margin-bottom:1rem">
        <label>Judul Pesan</label>
        <input type="text" class="fi" name="title" required placeholder="Modul Baru Telah Hadir!">
      </div>
      <div class="fg" style="margin-bottom:1rem">
        <label>Isi Pesan</label>
        <textarea class="fi" name="message" rows="4" required placeholder="Ayo cek modul terbaru di kelas Anda..."></textarea>
      </div>
      <div class="fg" style="margin-bottom:1.5rem">
        <label>Link Aksi (Opsional)</label>
        <input type="text" class="fi" name="link" placeholder="modul">
      </div>
      <button type="submit" class="btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        Kirim Sekarang
      </button>
    </form>
  </div>

  <div class="panel">
    <div class="panel-head"><span class="panel-title">Riwayat Notifikasi Terbaru</span></div>
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Tanggal</th><th>Penerima</th><th>Pesan</th><th>Status</th><th style="text-align:center">Aksi</th></tr></thead>
        <tbody>
          @if (empty($notif_list))
            <tr><td colspan="5"><div class="empty">Belum ada riwayat notifikasi.</div></td></tr>
          @else
          @foreach ($notif_list as $n)
            <tr>
              <td style="color:var(--muted2);font-size:.7rem">{{ date('d M Y, H:i', strtotime($n['created_at'])) }}</td>
              <td><strong style="font-size:.75rem">{{ htmlspecialchars($n['member_name'] ?? 'Semua Member') }}</strong></td>
              <td>
                <div style="font-weight:700;font-size:.8rem;color:var(--t)">{{ htmlspecialchars($n['title'] ?? '') }}</div>
                <div style="color:var(--muted);font-size:.7rem;max-width:250px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ htmlspecialchars($n['message'] ?? '') }}</div>
              </td>
              <td>
                @if ($n['is_read'])
                  <span style="font-size:.6rem;padding:2px 8px;background:rgba(52,211,153,.15);color:#34d399;border-radius:12px">Dibaca</span>
                @else
                  <span style="font-size:.6rem;padding:2px 8px;background:rgba(0,0,0,.05);color:var(--muted);border-radius:12px">Terkirim</span>
                @endif
              </td>
              <td style="text-align:center">
                <div class="row-actions" style="justify-content:center;gap:8px">
                  <button type="button" class="btn-sm" onclick="showToast('Fitur detail sedang dalam pengembangan','success');return false;" style="background:rgba(59,130,246,.1);color:#3b82f6;border:none;padding:6px;border-radius:6px" title="Lihat Detail">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                  <form method="POST" class="form-delete" data-confirm="Hapus riwayat notifikasi ini?" style="margin:0">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="{{ $n['id'] }}">
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

</div>

@endsection