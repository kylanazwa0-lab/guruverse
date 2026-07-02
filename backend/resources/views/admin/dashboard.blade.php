@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<!-- STAT CARDS -->
<div class="stats-row">
  @php
    $cards = [
      [
        'label' => 'Total Member',
        'val'   => $stats['total_member'],
        'icon_bg' => 'rgba(67,97,238,.12)',
        'icon_color' => '#4361ee',
        'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>',
      ],
      [
        'label' => 'Kelas Aktif',
        'val'   => $stats['total_kelas'],
        'icon_bg' => 'rgba(6,214,160,.12)',
        'icon_color' => '#06d6a0',
        'icon' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
      ],
      [
        'label' => 'Total Modul',
        'val'   => $stats['total_modul'],
        'icon_bg' => 'rgba(86,11,173,.1)',
        'icon_color' => '#560bad',
        'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
      ],
      [
        'label' => 'Sertifikat',
        'val'   => $stats['total_sertifikat'],
        'icon_bg' => 'rgba(248,150,30,.12)',
        'icon_color' => '#f8961e',
        'icon' => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>',
      ],
      [
        'label' => 'Member Baru Hari Ini',
        'val'   => $stats['new_today'],
        'icon_bg' => 'rgba(76,201,240,.12)',
        'icon_color' => '#4cc9f0',
        'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>',
      ],
      [
        'label' => 'Jam Mengajar (Total)',
        'val'   => $stats['total_jam_mengajar'],
        'icon_bg' => 'rgba(6,214,160,.12)',
        'icon_color' => '#06d6a0',
        'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
      ],
      [
        'label' => 'Total Cerita/Artikel',
        'val'   => $stats['total_cerita'],
        'icon_bg' => 'rgba(248,150,30,.12)',
        'icon_color' => '#f8961e',
        'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
      ],
    ];
  @endphp

  @foreach ($cards as $c)
    <div class="stat-card">
      <div class="stat-icon-wrap" style="background:{!! $c['icon_bg'] !!};">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{!! $c['icon_color'] !!}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $c['icon'] !!}</svg>
      </div>
      <div>
        <div class="stat-label">{{ $c['label'] }}</div>
        <div class="stat-val" style="color:{!! $c['icon_color'] !!}">{{ number_format($c['val']) }}</div>
      </div>
    </div>
  @endforeach
</div>

<!-- PANELS ROW -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">

  <!-- Member Terbaru -->
  <div class="panel">
    <div class="panel-head">
      <div class="panel-title-wrap">
        <div class="panel-icon" style="background:rgba(67,97,238,.1);">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#4361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <span class="panel-title">Member Terbaru</span>
      </div>
      <a href="{{ route('admin.members') }}" class="panel-link">
        Lihat Semua
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9,18 15,12 9,6"/></svg>
      </a>
    </div>
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Nama</th><th>Institusi</th><th>Bergabung</th></tr></thead>
        <tbody>
          @if (empty($stats['recent_members']))
            <tr><td colspan="3"><div class="empty">Belum ada member</div></td></tr>
          @else
            @foreach ($stats['recent_members'] as $m)
              @php
                $initial = strtoupper(substr($m['full_name'], 0, 1));
                $colors = ['#4361ee','#06d6a0','#f8961e','#560bad','#4cc9f0'];
                $bg = $colors[crc32($m['full_name']) % count($colors)];
              @endphp
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <div class="member-avatar" style="background:{{ $bg }}">{{ $initial }}</div>
                    <strong style="font-size:.82rem">{{ $m['full_name'] }}</strong>
                  </div>
                </td>
                <td style="color:var(--muted);font-size:.76rem">{{ $m['institution'] ?? '-' }}</td>
                <td style="color:var(--muted2);font-size:.7rem;white-space:nowrap">{{ date('d M Y', strtotime($m['created_at'])) }}</td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>

  <!-- Kelas Terbaru -->
  <div class="panel">
    <div class="panel-head">
      <div class="panel-title-wrap">
        <div class="panel-icon" style="background:rgba(6,214,160,.1);">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#06d6a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
        <span class="panel-title">Kelas Terbaru</span>
      </div>
      <a href="{{ route('admin.kelas') }}" class="panel-link" style="color:var(--mint)">
        Kelola
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9,18 15,12 9,6"/></svg>
      </a>
    </div>
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th></tr></thead>
        <tbody>
          @if (empty($stats['recent_kelas']))
            <tr><td colspan="3"><div class="empty">Belum ada kelas</div></td></tr>
          @else
            @foreach ($stats['recent_kelas'] as $k)
              @php
                $st = $k['status'] ?? 'draft';
              @endphp
              <tr>
                <td><strong style="font-size:.82rem">{{ $k['title'] }}</strong></td>
                <td style="color:var(--muted);font-size:.76rem">{{ $k['category'] ?? '-' }}</td>
                <td><span class="pill pill-{{ $st }}">{{ strtoupper($st) }}</span></td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
