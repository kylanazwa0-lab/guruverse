@extends('layouts.admin')

@section('title', 'Monitoring Jadwal')
@section('page_title', 'Monitoring Jadwal')

@section('content')
<div class="panel" style="margin-bottom: 2rem;">
  <div class="panel-head">
    <span class="panel-title">Monitoring Jadwal Mengajar</span>
    <div class="panel-actions">
      <form method="GET" style="display:inline-flex;align-items:center;gap:6px">
        <input type="hidden" name="mod" value="mengajar_jadwal">
        <div class="search-wrap">
          <span class="search-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
          <input class="search-fi" name="search" placeholder="Cari jadwal/guru..." value="">
        </div>
      </form>
    </div>
  </div>
  
  <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;padding:20px;">
    <!-- Stat 1 -->
    <div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); padding:20px; border-radius:12px; display:flex; align-items:center; gap:16px;">
      <div style="width:48px;height:48px;border-radius:50%;background:#34d399;color:#fff;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div>
        <div style="font-size:1.5rem;font-weight:800;color:#34d399;">12</div>
        <div style="font-size:0.85rem;color:var(--muted);">Kelas Selesai (Minggu Ini)</div>
      </div>
    </div>
    
    <!-- Stat 2 -->
    <div style="background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.2); padding:20px; border-radius:12px; display:flex; align-items:center; gap:16px;">
      <div style="width:48px;height:48px;border-radius:50%;background:#3b82f6;color:#fff;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div style="font-size:1.5rem;font-weight:800;color:#3b82f6;">5</div>
        <div style="font-size:0.85rem;color:var(--muted);">Kelas Akan Datang</div>
      </div>
    </div>
    
    <!-- Stat 3 -->
    <div style="background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.2); padding:20px; border-radius:12px; display:flex; align-items:center; gap:16px;">
      <div style="width:48px;height:48px;border-radius:50%;background:#f59e0b;color:#fff;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div>
        <div style="font-size:1.5rem;font-weight:800;color:#f59e0b;">24</div>
        <div style="font-size:0.85rem;color:var(--muted);">Total Guru Aktif</div>
      </div>
    </div>
  </div>
  
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>Tanggal & Waktu</th>
          <th>Nama Guru</th>
          <th>Topik Kelas</th>
          <th>Siswa</th>
          <th>Status</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php // Mock data jadwal
          $jadwal_list = [
              ['tanggal' => 'Hari Ini, 08:00 - 09:30', 'guru' => 'Rini Susanti', 'topik' => 'Penerapan Kurikulum Merdeka', 'siswa' => 32, 'status' => 'selesai'],
              ['tanggal' => 'Hari Ini, 10:00 - 11:30', 'guru' => 'Hendra Wijaya', 'topik' => 'Pemanfaatan AI dalam Asesmen', 'siswa' => 25, 'status' => 'berjalan'],
              ['tanggal' => 'Besok, 09:00 - 10:30', 'guru' => 'Dewi Nurhaliza', 'topik' => 'Strategi Pembelajaran Interaktif', 'siswa' => 40, 'status' => 'akan_datang'],
              ['tanggal' => 'Besok, 13:00 - 14:30', 'guru' => 'Ahmad Fauzi', 'topik' => 'Manajemen Kelas Digital', 'siswa' => 28, 'status' => 'akan_datang'],
              ['tanggal' => '15 Jun 2026, 08:00', 'guru' => 'Budi Santoso', 'topik' => 'Ice Breaking Seru untuk SD', 'siswa' => 50, 'status' => 'akan_datang'],
          ];
          
          foreach($jadwal_list as $j): 
              $sc = ''; $tc = ''; $lbl = '';
              if($j['status'] === 'selesai') {
                  $sc = 'rgba(52,211,153,.12)'; $tc = '#34d399'; $lbl = 'SELESAI';
              } elseif($j['status'] === 'berjalan') {
                  $sc = 'rgba(59,130,246,.12)'; $tc = '#3b82f6'; $lbl = 'BERJALAN';
              } else {
                  $sc = 'rgba(245,158,11,.12)'; $tc = '#f59e0b'; $lbl = 'AKAN DATANG';
              } @endphp
        <tr>
          <td><div style="font-weight:600;font-size:0.85rem;color:var(--t);">{{ $j['tanggal'] }}</div></td>
          <td>
             <div style="font-weight:700;font-size:0.85rem;">{{ htmlspecialchars($j['guru']) }}</div>
          </td>
          <td><div style="font-size:0.85rem;color:var(--muted);">{{ htmlspecialchars($j['topik']) }}</div></td>
          <td style="color:var(--muted);font-size:0.85rem;">{{ $j['siswa'] }} Siswa</td>
          <td>
            <span style="font-size:0.65rem;font-weight:700;padding:4px 10px;border-radius:20px;background:{{ $sc }};color:{{ $tc }};">
              {{ $lbl }}
            </span>
          </td>
          <td style="text-align:center;">
            <button class="btn-sm" style="background:rgba(139,47,201,0.08);color:var(--v1);border:1px solid rgba(139,47,201,0.2);">Detail</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection