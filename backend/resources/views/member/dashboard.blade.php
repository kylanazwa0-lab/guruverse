@extends('layouts.member')

@section('title', ucwords(str_replace('_', ' ', 'dashboard')))

@section('styles')
<style>
/* ── Premium Dashboard Overrides ── */
.dash-hero-premium {
  background: linear-gradient(135deg, rgba(124,58,237,.1) 0%, rgba(6,182,212,.05) 100%);
  border: 1px solid rgba(124,58,237,.2);
  border-radius: 20px;
  padding: 1.5rem 1.25rem;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  text-align: left;
  margin-bottom: 1.5rem;
}
.dash-hero-premium::after {
  content: ''; position: absolute; top: -50%; right: -10%; width: 50%; height: 200%;
  background: radial-gradient(circle, rgba(124,58,237,.08) 0%, transparent 60%);
  pointer-events: none;
}
.hero-greeting { font-size: 1.5rem; font-weight: 900; color: var(--text); line-height: 1.2; margin-bottom: 0.25rem; }
.hero-greeting span {
  background: linear-gradient(135deg, var(--c-primary), #06b6d4);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}
.hero-sub { font-size: 0.85rem; color: var(--c-text-muted); line-height: 1.5; max-width: 450px; margin-bottom: 1rem; }

.stat-card-premium {
  background: var(--c-card);
  border: 1px solid var(--c-border);
  border-radius: 12px;
  padding: 1rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  transition: all 0.3s;
}
.stat-card-premium:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(124,58,237,.08);
  border-color: rgba(124,58,237,.3);
}
.scp-icon {
  width: 40px; height: 40px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
}
.scp-value { font-size: 1.25rem; font-weight: 900; color: var(--text); line-height: 1; margin-bottom: 2px; }
.scp-label { font-size: 0.7rem; font-weight: 700; color: var(--c-text-muted); text-transform: uppercase; letter-spacing: 0.05em; }

.card-course-premium {
  background: var(--c-card);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  padding: 0;
  overflow: hidden;
  transition: all 0.3s;
  display: flex; flex-direction: column;
}
.card-course-premium:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(124,58,237,.1);
  border-color: rgba(124,58,237,.3);
}
.ccp-img {
  height: 110px;
  background-size: cover; background-position: center;
  position: relative;
}
.ccp-badge {
  position: absolute; top: 10px; right: 10px;
  background: rgba(255,255,255,0.2); backdrop-filter: blur(4px);
  color: #fff; font-size: 0.55rem; font-weight: 800; padding: 2px 6px; border-radius: 12px;
}
.ccp-body { padding: 1rem; flex: 1; display: flex; flex-direction: column; }
.ccp-title { font-size: 0.9rem; font-weight: 800; color: var(--c-text); margin-bottom: 10px; line-height: 1.4; }

@media(max-width: 768px) {
  .dash-hero-premium { padding: 2rem 1.5rem; }
}
</style>
@endsection

@section('content')

  <div class="page active" id="page-dashboard">

    <!-- Hero Section Premium -->
    <div class="dash-hero-premium">
      <div style="display:inline-flex;align-items:center;gap:4px;background:rgba(124,58,237,.1);padding:3px 10px;border-radius:20px;color:var(--c-primary);font-size:0.65rem;font-weight:800;margin-bottom:10px;">
        <span style="width:5px;height:5px;border-radius:50%;background:var(--c-primary);"></span> Platform Belajar Guru #1
      </div>
      <h1 class="hero-greeting">Halo, <span>{{ $member->full_name }}</span>!</h1>
      <p class="hero-sub">Semangat belajar hari ini! Terus tingkatkan kompetensimu untuk pendidikan Indonesia yang lebih baik.</p>
      <a href="{{ route('member.kelas') }}" class="btn btn-primary" style="border-radius:10px; font-weight:700; min-height:40px; padding:0 1.25rem; display:inline-flex; align-items:center; justify-content:center; gap:6px; line-height:1; font-size:0.85rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top:-1px;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        <span style="transform:translateY(1px);">Mulai Belajar Sekarang</span>
      </a>
    </div>

    <!-- Stats Grid Premium -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; margin-bottom:2rem;">
      <div class="stat-card-premium">
        <div class="scp-icon" style="background:linear-gradient(135deg,rgba(16,185,129,.15),rgba(5,150,105,.1)); color:#10b981;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div>
          <div class="scp-value">{{ $total_kelas > 0 ? round(($kelas_selesai / max($total_kelas, 1)) * 100) : 0 }}%</div>
          <div class="scp-label">Progress Belajar</div>
          <div style="font-size:0.75rem; color:var(--c-text-subtle); margin-top:2px;">{{ $kelas_selesai }} dari {{ $total_kelas }} kelas</div>
        </div>
      </div>

      <div class="stat-card-premium">
        <div class="scp-icon" style="background:linear-gradient(135deg,rgba(59,130,246,.15),rgba(37,99,235,.1)); color:#3b82f6;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div>
          <div class="scp-value">{{ $total_kelas }}</div>
          <div class="scp-label">Kelas Aktif</div>
          <div style="font-size:0.75rem; color:var(--c-text-subtle); margin-top:2px;">Sedang dipelajari</div>
        </div>
      </div>

      <div class="stat-card-premium">
        <div class="scp-icon" style="background:linear-gradient(135deg,rgba(245,158,11,.15),rgba(217,119,6,.1)); color:#f59e0b;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
        </div>
        <div>
          <div class="scp-value">{{ $total_sertifikat }}</div>
          <div class="scp-label">Sertifikat</div>
          <div style="font-size:0.75rem; color:var(--c-text-subtle); margin-top:2px;">Telah diperoleh</div>
        </div>
      </div>

      <div class="stat-card-premium" style="cursor:pointer;" onclick="window.location.href='#'">
        <div class="scp-icon" style="background:linear-gradient(135deg,rgba(124,58,237,.15),rgba(109,40,217,.1)); color:#7c3aed;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <div>
          <div class="scp-value">0</div>
          <div class="scp-label">Keranjang</div>
          <div style="font-size:0.75rem; color:var(--c-text-subtle); margin-top:2px;">Belum ada item</div>
        </div>
      </div>
    </div>

    <!-- Continue Learning & Calendar Layout -->
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; margin-bottom:2rem;">
      
      <!-- Lanjutkan Belajar -->
      <div>
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
          <h2 style="font-size:1.2rem; font-weight:800; color:var(--c-text);">Lanjutkan Belajar</h2>
          <a href="{{ route('member.kelas') }}" style="font-size:0.8rem; font-weight:700; color:var(--c-primary); text-decoration:none;">Lihat Semua</a>
        </div>
        
        @if (!$latest_enrollment)
        <div style="background:var(--c-card); border:2px dashed var(--c-border); border-radius:24px; padding:3rem 2rem; text-align:center;">
          <div style="width:48px; height:48px; background:rgba(124,58,237,.05); color:var(--c-primary-light); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 0.75rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
          </div>
          <h3 style="font-size:1rem; font-weight:800; color:var(--c-text); margin-bottom:4px;">Belum ada kelas aktif</h3>
          <p style="font-size:0.8rem; color:var(--c-text-muted); max-width:300px; margin:0 auto;">Progress belajar akan muncul di sini setelah Anda mendaftar kelas.</p>
        </div>
        @else
          @php $pct = $latest_enrollment['total_modules'] > 0 ? round(($latest_enrollment['completed_modules'] / $latest_enrollment['total_modules']) * 100) : 0; @endphp
          <div class="card-course-premium" style="flex-direction:row; cursor:pointer;" onclick="openCoursePlayer({{ $latest_enrollment['course_id'] }})">
            <div style="width:140px; background:linear-gradient(135deg,var(--c-primary-light),var(--c-primary)); flex-shrink:0; position:relative;">
              <div style="position:absolute; inset:0; background:url('/asset/img/pattern-dots.png') center; opacity:0.1;"></div>
            </div>
            <div class="ccp-body" style="justify-content:center;">
              <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:0.75rem; font-weight:800; color:var(--c-primary); text-transform:uppercase; letter-spacing:1px;">Sedang Dipelajari</span>
                <span style="font-size:0.8rem; font-weight:800; color:var(--c-text);">{{ $pct }}%</span>
              </div>
              <h3 class="ccp-title">{{ htmlspecialchars($latest_enrollment['title']) }}</h3>
              
              <div style="height:6px; background:var(--c-border); border-radius:99px; margin-bottom:1.5rem; overflow:hidden;">
                <div style="width:{{ $pct }}%; height:100%; background:linear-gradient(90deg,var(--c-primary-light),var(--c-primary)); border-radius:99px;"></div>
              </div>
              <button class="btn btn-primary" style="border-radius:10px; width:100%; font-weight:700;">Lanjutkan Modul</button>
            </div>
          </div>
        @endif
      </div>

      <!-- Kalender Mini -->
      <div>
        <h2 style="font-size:1.2rem; font-weight:800; color:var(--c-text); margin-bottom:0.75rem;">Kalender</h2>
        <div style="background:var(--c-card); border:1px solid var(--c-border); border-radius:16px; padding:1.25rem;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <button style="background:none; border:none; color:var(--c-text-muted); cursor:pointer;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
            <span style="font-weight:800; font-size:1rem; color:var(--c-text);">{{ date('F Y') }}</span>
            <button style="background:none; border:none; color:var(--c-text-muted); cursor:pointer;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
          </div>
          
          <div style="display:grid; grid-template-columns:repeat(7, 1fr); gap:4px; text-align:center; margin-bottom:8px;">
            <div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">S</div><div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">S</div>
            <div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">R</div><div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">K</div>
            <div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">J</div><div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">S</div>
            <div style="font-size:0.75rem; font-weight:700; color:var(--c-text-subtle);">M</div>
          </div>
          
          <div style="display:grid; grid-template-columns:repeat(7, 1fr); gap:4px; text-align:center;">
            @php
              $y = date('Y'); $m = date('n');
              $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m, $y);
              $firstDay = date('N', strtotime("$y-$m-01"));
              for ($i = 1; $i < $firstDay; $i++) echo '<div></div>';
              for ($d = 1; $d <= $daysInMonth; $d++) {
                  $isToday = ($d == date('j') && $m == date('n') && $y == date('Y'));
                  $bg = $isToday ? 'var(--c-primary)' : 'transparent';
                  $col = $isToday ? '#fff' : 'var(--c-text)';
                  $fw = $isToday ? '800' : '600';
                  echo "<div style=\"width:28px;height:28px;margin:auto;display:flex;align-items:center;justify-content:center;border-radius:50%;background:$bg;color:$col;font-weight:$fw;font-size:0.8rem;\">$d</div>";
              }
            @endphp
          </div>
        </div>
      </div>
      
    </div>

    <!-- Rekomendasi Program -->
    <div>
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
        <div>
          <div style="font-size:0.75rem; font-weight:800; color:var(--c-primary); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">Disarankan</div>
          <h2 style="font-size:1.4rem; font-weight:900; color:var(--c-text);">Rekomendasi Kelas</h2>
        </div>
        <div style="display:flex; gap:8px;">
          <button style="width:36px; height:36px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-card); display:flex; align-items:center; justify-content:center; cursor:pointer;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
          <button style="width:36px; height:36px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-card); display:flex; align-items:center; justify-content:center; cursor:pointer;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--c-text-muted)" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
      </div>

      @if (empty($rekomendasi))
        <div style="text-align:center;padding:2rem;background:var(--c-card);border-radius:16px;border:1px solid var(--c-border);">
          <div style="width:48px;height:48px;margin:0 auto 1rem;background:rgba(124,58,237,.05);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--c-primary-light);">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
          </div>
          <h3 style="font-size:1.1rem;font-weight:800;color:var(--c-text);margin-bottom:4px;">Belum ada rekomendasi</h3>
          <p style="font-size:0.9rem;color:var(--c-text-muted);">Kelas baru sedang dipersiapkan untuk Anda.</p>
        </div>
      @else
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:1.5rem;">
          @foreach ($rekomendasi as $rk)
            @php 
              $is_completed = ($rk['enroll_status'] ?? '') === 'completed';
              $is_enrolled = !empty($rk['enroll_status']);
            @endphp
            <div class="card-course-premium" onclick="{{ $is_completed && !empty($rk['pdf_path']) ? "viewCertificate('".htmlspecialchars($rk['pdf_path'])."')" : "openCoursePlayer({$rk['id']})" }}">
              <div class="ccp-img" style="background:linear-gradient(135deg,var(--c-primary-light),var(--c-primary)); {{ $rk['thumbnail'] ? 'background-image:url(\''.asset('uploads/thumbnails/'.$rk['thumbnail']).'\');' : '' }}">
                <div class="ccp-badge">{{ htmlspecialchars($rk['category']) }}</div>
              </div>
              <div class="ccp-body">
                <h3 class="ccp-title">{{ htmlspecialchars($rk['title']) }}</h3>
                <div style="display:flex; gap:12px; margin-bottom:1.5rem; color:var(--c-text-muted); font-size:0.8rem; font-weight:600;">
                  <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $rk['duration_hours'] }} Jam</span>
                  <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg> {{ $rk['total_modules'] }} Modul</span>
                </div>
                <div style="margin-top:auto; display:flex; align-items:center; justify-content:space-between;">
                  <span style="font-weight:800; color:var(--c-success); font-size:0.9rem;">Gratis</span>
                  @if($is_completed)
                    <button class="btn btn-sm" style="background:#10b981; color:#fff; border-radius:8px; font-weight:700;">Lihat Sertifikat</button>
                  @elseif($is_enrolled)
                    <button class="btn btn-primary btn-sm" style="border-radius:8px; font-weight:700;">Lanjutkan</button>
                  @else
                    <button class="btn btn-primary btn-sm" style="border-radius:8px; font-weight:700;" onclick="event.stopPropagation(); gvEnroll({{ $rk['id'] }})">Daftar</button>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

  </div>
@endsection