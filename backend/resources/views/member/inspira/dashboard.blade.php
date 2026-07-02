@extends('layouts.inspira')

@section('title', 'Dashboard Guru Inspira')

@section('content')

<div class="page active" id="page-dashboard">

  <!-- HERO -->
  <div class="hero-section mb-24">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:12%;left:8%;--d:2.5s;--delay:0s"></span>
      <span style="top:28%;left:18%;--d:3.2s;--delay:0.8s"></span>
      <span style="top:55%;left:12%;--d:2s;--delay:0.3s"></span>
      <span style="top:20%;left:55%;--d:4s;--delay:1.2s"></span>
      <span style="top:70%;left:45%;--d:3s;--delay:0.6s"></span>
      <span style="top:10%;left:72%;--d:2.8s;--delay:1.8s"></span>
    </div>
    <div class="hero-text">
      <div>
        <div class="hero-badge"><span class="hero-badge-dot"></span> Portal Guru Inspira</div>
        <h1 style="font-size: 32px; margin-bottom: 16px; line-height: 1.3;">Portal Guru Inspira – Jendela<br/>Kolaborasi & Pertumbuhan.</h1>
        <p class="t-body mb-24" style="color: rgba(255,255,255,0.85); max-width: 600px; line-height: 1.6;">
          Selamat datang, <strong>{{ $user_first }}</strong>! Mari kita bangun masa depan pendidikan melalui diskusi, proyek, dan jejaring. Guru yang saling menguatkan dan berbagi semangat.
        </p>
        <a href="{{ route('member.inspira.forum') }}" class="hero-cta" style="box-shadow: 0 0 20px rgba(245, 158, 11, 0.4); text-decoration: none; display: inline-block; text-align: center;">
          Gabung Diskusi Sekarang
        </a>
      </div>
    </div>
    <div class="hero-illustration">
      <div class="hero-glow-ring"></div>
      <div class="hero-img-3d-wrap">
        <img class="hero-main-img" src="/asset/img/community_teachers_muslim (2).png" alt="Guru Inspira" onerror="this.style.display='none'">
      </div>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <!-- ROW 1: PROYEK, ACARA, JEJARING -->
  <div style="display: grid; grid-template-columns: 1.8fr 1.2fr 1fr; gap: 20px;" class="mb-32">
      
      <!-- Kolaborasi Proyek (Takes 2 fractions) -->
      <div style="display: flex; flex-direction: column; height: 100%;">
          <div class="section-head mb-16" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
              <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0;">Kolaborasi Proyek</h2>
              <a href="{{ route('member.inspira.proyek') }}" class="link-action" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap; text-decoration: none;">Lihat Semua &rarr;</a>
          </div>
          <div style="flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              @if ($proyeks->isEmpty())
              <div style="grid-column: 1 / -1; padding: 40px 20px; text-align: center; background: var(--c-card); border: 2px dashed var(--c-border); border-radius: 14px; height: 100%; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px; opacity: 0.4;"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                  <div style="font-weight:700; color:var(--c-text-muted); font-size:14px; margin-bottom:4px;">Belum ada kolaborasi proyek</div>
                  <div style="font-size:12px; color:var(--c-text-muted); opacity:0.7;">Proyek kolaborasi akan muncul di sini.</div>
              </div>
              @else
              @foreach($proyeks as $p)
              <div class="card card-body card-hover" style="display: flex; flex-direction: column; justify-content: space-between; padding: 18px; cursor: pointer;" onclick="window.location.href='{{ route('member.inspira.proyek.detail', $p->id) }}'">
                  <div class="flex gap-12 mb-16">
                      <div style="width: 70px; height: 70px; border-radius: 8px; flex-shrink: 0; background:linear-gradient(135deg, {{ $p->warna_bg ?? '#4f46e5' }} 0%, #34d399 100%); overflow: hidden;">
                          <img src="/asset/img/{{ $p->gambar }}" alt="" style="width:100%; height:100%; object-fit:cover; opacity: 0.9;" onerror="this.style.display='none'">
                      </div>
                      <div style="flex:1;">
                          <div class="t-md fw-800 mb-4" style="line-height: 1.3; font-size: 14px; font-weight: 800;">{{ $p->judul }}</div>
                          <div class="t-xs t-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 11px;">{{ $p->deskripsi ?? 'Proyek kolaborasi guru' }}</div>
                      </div>
                  </div>
                  <div class="flex items-end justify-between mt-auto">
                      <div>
                          <div class="t-xs t-muted mb-4" style="font-size: 10px;">Status</div>
                          <span style="font-size: 11px; font-weight: 700; color: var(--c-primary);">{{ $p->status }}</span>
                      </div>
                      <div class="text-right">
                          <div class="t-xs t-muted mb-4" style="font-size: 10px;">Kebutuhan Anggota</div>
                          <div class="t-xs fw-700" style="font-size: 11px; font-weight: 700;">{{ $p->kebutuhan_anggota }} Orang</div>
                      </div>
                  </div>
              </div>
              @endforeach
              @endif
          </div>
      </div>

      <!-- Acara Mendatang (Takes 1 fraction) -->
      <div style="display: flex; flex-direction: column; height: 100%;">
          <div class="section-head mb-16" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
              <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0; white-space:nowrap;">Acara Mendatang</h2>
              <a href="{{ route('member.inspira.agenda') }}" class="link-action" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap; text-decoration: none;">Lihat Semua &rarr;</a>
          </div>
          <div style="flex: 1;">
              @if ($events->isEmpty())
              <div style="padding: 40px 20px; text-align: center; background: var(--c-card); border: 2px dashed var(--c-border); border-radius: 14px; height: 100%; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="var(--c-text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px; opacity: 0.4;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                  <div style="font-weight:700; color:var(--c-text-muted); font-size:14px; margin-bottom:4px;">Belum ada acara mendatang</div>
                  <div style="font-size:12px; color:var(--c-text-muted); opacity:0.7;">Acara dan agenda akan ditampilkan di sini.</div>
              </div>
              @else
              @php $e = $events->first(); @endphp
              <div class="card card-body card-hover" style="display: flex; flex-direction: column; justify-content: space-between; padding: 18px; height: 100%;">
                  <div>
                      <div class="t-md fw-800 mb-6" style="line-height: 1.3; font-size: 15px; font-weight: 800;">{{ $e->judul }}</div>
                      <div class="t-sm t-muted mb-16 fw-600" style="font-size: 12px; font-weight: 600;">{{ date('d M Y, H:i', strtotime($e->event_date)) }} WIB</div>
                  </div>
                  <div class="flex items-center gap-10 mb-16">
                      <div class="avatar avatar-md" style="background: {{ $e->warna_bg ?? 'var(--c-primary-pale)' }}; color: {{ $e->warna_text ?? 'var(--c-primary)' }}; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px;">
                          @if(!empty($e->icon))
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $e->icon }}"/></svg>
                          @else
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                          @endif
                      </div>
                      <div>
                          <div class="t-xs t-muted mb-2" style="font-size: 10px;">Tipe Event</div>
                          <div class="t-xs fw-700" style="font-size: 12px; font-weight: 700;">{{ $e->tipe }}</div>
                      </div>
                  </div>
                  <div class="flex items-center gap-6 t-xs t-muted mt-auto fw-600" style="font-size: 11px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                      @if($e->link_meeting)
                        <a href="{{ $e->link_meeting }}" target="_blank" style="color: var(--c-primary); font-weight: 700; text-decoration: none;">Gabung Link Meeting</a>
                      @else
                        Link belum tersedia
                      @endif
                  </div>
              </div>
              @endif
          </div>
      </div>

      <!-- Jejaring & Inspirasi (Takes 1 fraction) -->
      <div style="display: flex; flex-direction: column; height: 100%;">
          <div class="section-head mb-16" style="visibility: hidden;">
              <h2 class="t-h2">Spacer</h2>
          </div>
          <div class="card card-body card-hover" style="display: flex; flex-direction: column; justify-content: space-between; padding: 20px; height: 100%;">
              <div>
                  <h2 class="t-md fw-800 mb-16 t-primary" style="font-size: 15px; font-weight: 800; color: var(--c-primary);">Jejaring & Inspirasi</h2>
                  <div class="t-xs t-muted mb-16" style="line-height: 1.6; font-size: 11px;">
                      Selamat datang, <strong class="t-text" style="color: var(--c-text);">{{ $user_first }}</strong>! Mari kita bangun masa depan pendidikan melalui diskusi, proyek, dan jejaring.
                  </div>
              </div>
              <div class="t-xs fw-700 mt-auto" style="font-size: 11px; font-weight: 700;">
                  Aktif Berkolaborasi &bull; <a href="{{ route('member.inspira.diskusi') }}" style="color: var(--c-primary); text-decoration: none;">Hubungkan Rekan</a>
              </div>
          </div>
      </div>

  </div>

  <!-- ROW 2: FORUM DISKUSI (Full Width) -->
  <div class="mb-24">
      <div class="card card-body" style="padding: 24px;">
        <div class="section-head mb-24" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
          <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0;">Forum Diskusi</h2>
          <a href="{{ route('member.inspira.forum') }}" class="link-action" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap; text-decoration: none;">Lihat Semua &rarr;</a>
        </div>
        
        <!-- Grid 3 Kolom agar melebar dengan rapi -->
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
          @foreach($forums as $f)
          <div class="flex items-center gap-12 card-hover" style="padding: 16px; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; border: 1px solid var(--c-border); background: var(--c-border-light); box-shadow: 0 4px 12px rgba(0,0,0,0.04);" onclick="window.location.href='{{ route('member.inspira.forum', ['forum_id' => $f->id]) }}'">
            <div class="icon-box icon-box-md" style="background: var(--c-primary-pale); color: var(--c-primary); font-size: 20px; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
               @if(!empty($f->icon))
                 <i class="{{ $f->icon }}"></i>
               @else
                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
               @endif
            </div>
            <div>
              <div class="t-sm fw-800 mb-2" style="line-height:1.2; font-size: 14px; font-weight: 800; color: var(--c-text);">{{ $f->judul }}</div>
              <div class="t-xs t-muted" style="font-size: 11px;">{{ $f->total_postingan }} Postingan</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
  </div>

  <!-- ROW 3: CERITA INSPIRATIF (Full Width) -->
  <div class="mb-24">
      <div class="card card-body" style="padding: 24px;">
        <div class="section-head mb-24" style="align-items:flex-end; width:100%; justify-content:space-between; display:flex;">
          <h2 style="font-size:16px; font-weight:800; color:var(--c-text); margin:0;">Cerita Inspiratif</h2>
          <a href="{{ route('member.inspira.cerita') }}" class="link-action" style="font-size:12px; font-weight:700; color:var(--c-primary); white-space:nowrap; text-decoration: none;">Bagikan Kisahmu &rarr;</a>
        </div>
        
        <!-- Grid 2 Kolom untuk list cerita -->
        <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
          @if ($ceritas->isEmpty())
          <div class="card flex items-center justify-center" style="grid-column: 1 / -1; padding: 32px; text-align: center; background: transparent; border: 1px dashed var(--c-border); border-radius: 12px; height: 100%; min-height: 120px;">
              <div class="t-sm t-muted" style="font-size: 13px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-8" style="margin: 0 auto; display: block; opacity: 0.5;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                  Belum ada cerita inspiratif yang dibagikan.
              </div>
          </div>
          @else
          @foreach($ceritas as $c)
          <div class="flex items-center gap-16 card-hover" style="padding: 16px; border: 1px solid var(--c-border); background: var(--c-bg); cursor: pointer; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.04);" onclick="window.location.href='{{ route('member.inspira.cerita.detail', $c->id) }}'">
            <div style="width:90px; height:65px; border-radius:8px; overflow:hidden; flex-shrink:0; background: var(--c-primary-pale);">
               <img src="/asset/img/{{ $c->gambar }}" alt="" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='/asset/img/default-avatar.png'">
            </div>
            <div style="flex:1;">
              <div class="t-sm fw-800 mb-6" style="line-height:1.3; font-size: 13px; font-weight: 800; color: var(--c-text); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $c->judul }}</div>
              <div class="t-xs t-primary fw-700" style="font-size: 11px; font-weight: 700; color: var(--c-primary);">Baca Cerita &rarr;</div>
            </div>
          </div>
          @endforeach
          @endif
        </div>
      </div>
  </div>

</div>

@endsection
