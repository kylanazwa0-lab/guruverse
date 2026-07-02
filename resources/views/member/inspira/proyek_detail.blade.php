@extends('layouts.inspira')

@section('title', $proyek->judul . ' - Proyek Kolaborasi')

@section('styles')
<style>
.project-detail-layout {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 24px;
}
@media (max-width: 991px) {
  .project-detail-layout {
    grid-template-columns: 1fr;
  }
}
</style>
@endsection

@section('content')

<div class="page active" id="page-proyek-detail" style="animation: fadeIn 0.3s ease-out;">
  
  <div style="margin-bottom: 24px;">
    <a class="btn btn-ghost btn-sm" href="{{ route('member.inspira.proyek') }}" style="font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--c-text-muted);">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
      Kembali ke Daftar Proyek
    </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger mb-24" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.25); color: #ef4444; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('error') }}
    </div>
  @endif

  @php
    $labelColors = [
      'Modul Ajar' => ['from' => '#6C5CE7', 'to' => '#A29BFE'],
      'Aplikasi/Web' => ['from' => '#0ea5e9', 'to' => '#38bdf8'],
      'Penelitian' => ['from' => '#059669', 'to' => '#34d399'],
      'Gerakan Sosial' => ['from' => '#f59e0b', 'to' => '#fcd34d'],
      'Media Pembelajaran' => ['from' => '#e11d48', 'to' => '#fb7185'],
      'Komunitas Belajar' => ['from' => '#7c3aed', 'to' => '#c4b5fd'],
      'Kolaborasi' => ['from' => '#0369a1', 'to' => '#38bdf8'],
    ];
    $colors = $labelColors[$proyek->label] ?? ['from' => '#6C5CE7', 'to' => '#A29BFE'];
    
    $parts = explode(' ', $proyek->author_name);
    $initials = strtoupper(substr($parts[0], 0, 1));
    if(count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
    
    $currentCount = count($project_members);
    $maxCount = $proyek->kebutuhan_anggota;
    $pct = ($maxCount > 0) ? min(100, round(($currentCount / $maxCount) * 100)) : 0;
  @endphp

  <div class="project-detail-layout">
    
    <!-- Kolom Kiri: Detail -->
    <div style="display:flex; flex-direction:column; gap:24px;">
      <div class="card p-0" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <div style="height:150px; background:linear-gradient(135deg, {{ $colors['from'] }} 0%, {{ $colors['to'] }} 100%); position:relative;">
          <div style="position:absolute; top:20px; right:20px;">
            <span style="background:rgba(255,255,255,0.95); padding:6px 16px; border-radius:20px; font-size:12px; font-weight:800; color:{{ $colors['from'] }};">
              {{ $proyek->label }}
            </span>
          </div>
        </div>
        
        <div class="card-body" style="padding:32px;">
          <h2 style="font-size:28px; font-weight:800; color:var(--c-text); margin-bottom:16px; line-height:1.3;">
            {{ $proyek->judul }}
          </h2>
          
          <div style="display:flex; gap:16px; align-items:center; margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid var(--c-border-light);">
            <div style="width:48px; height:48px; border-radius:50%; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:16px;">
              {{ $initials }}
            </div>
            <div>
              <div style="font-weight:800; color:var(--c-text); font-size:15px;">{{ $proyek->author_name }}</div>
              <div style="font-size:12px; color:var(--c-text-muted);">
                Inisiator Proyek &bull; {{ date('d M Y, H:i', strtotime($proyek->created_at)) }}
              </div>
            </div>
          </div>
          
          <h3 style="font-size:16px; font-weight:800; color:var(--c-text); margin-bottom:12px;">Deskripsi Kolaborasi</h3>
          <div style="font-size:15px; color:var(--c-text); line-height:1.8; white-space:pre-wrap;">{{ $proyek->deskripsi }}</div>
        </div>
      </div>
    </div>
    
    <!-- Kolom Kanan: Status & Anggota -->
    <div style="display:flex; flex-direction:column; gap:24px;">
      
      <!-- Panel Pendaftaran -->
      <div class="card" style="background: var(--c-card); border: 2px solid var(--c-border); border-radius: 18px; padding: 24px;">
        <h3 style="font-size:16px; font-weight:800; color:var(--c-text); margin-bottom:16px;">Status Perekrutan</h3>
        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <span style="font-size:13px; font-weight:600; color:var(--c-text-muted);">Kuota Anggota</span>
          <span style="font-size:15px; font-weight:800; color:var(--c-success);">{{ $currentCount }}/{{ $maxCount }} orang</span>
        </div>
        
        <div style="background:var(--c-border-light); border-radius:12px; height:8px; margin-bottom:24px; overflow:hidden;">
          <div style="background:var(--c-primary); height:100%; width:{{ $pct }}%; border-radius:12px;"></div>
        </div>
        
        <div>
          @if ($is_author)
            <button class="btn btn-primary" style="width:100%; pointer-events:none; background:var(--c-primary-pale); color:var(--c-primary); border:none; font-weight:800;">
              Anda Inisiator Proyek
            </button>
          @elseif ($is_member)
            <button class="btn btn-success" disabled style="width:100%; opacity:0.8; font-weight:800;">
              ✓ Anda adalah Anggota
            </button>
          @elseif ($has_requested)
            <button class="btn btn-warning" disabled style="width:100%; opacity:0.8; font-weight:800;">
              ⏳ Menunggu Persetujuan
            </button>
          @elseif ($currentCount >= $maxCount)
            <button class="btn btn-secondary" disabled style="width:100%; font-weight:800;">
              Kuota Penuh
            </button>
          @else
            <button class="btn btn-primary" style="width:100%; font-weight:800;" onclick="openJoinModal()">
              Ajukan Diri Bergabung
            </button>
          @endif
        </div>
      </div>
      
      <!-- Daftar Anggota Terpilih -->
      <div class="card" style="background: var(--c-card); border: 1px solid var(--c-border); border-radius: 18px; padding: 24px;">
        <h3 style="font-size:16px; font-weight:800; color:var(--c-text); margin-bottom:16px;">Anggota Tim ({{ $currentCount }})</h3>
        <div style="display:flex; flex-direction:column; gap:12px;">
          @if ($project_members->isEmpty())
            <p style="color:var(--c-text-muted); font-size:13px; text-align:center; padding:10px 0;">Belum ada anggota terpilih.</p>
          @else
            @foreach ($project_members as $m)
              @php
                $mParts = explode(' ', $m->full_name);
                $mInitials = strtoupper(substr($mParts[0], 0, 1));
                if(count($mParts) > 1) $mInitials .= strtoupper(substr($mParts[1], 0, 1));
              @endphp
              <div style="display:flex; align-items:center; gap:12px; padding:10px; border-radius:12px; background:var(--c-bg); border: 1px solid var(--c-border-light);">
                <div style="width:36px; height:36px; border-radius:50%; background:var(--c-border); color:var(--c-text); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px; flex-shrink:0;">
                  {{ $mInitials }}
                </div>
                <div>
                  <div style="font-weight:800; color:var(--c-text); font-size:13px;">{{ $m->full_name }}</div>
                  <div style="font-size:10px; color:var(--c-text-muted);">{{ $m->institution ?? 'Member' }}</div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
      
      <!-- Panel Pendaftar (Hanya untuk Author) -->
      @if ($is_author)
        <div class="card" style="background: var(--c-card); border: 2px solid var(--c-primary-light); border-radius: 18px; padding: 24px;">
          <h3 style="font-size:16px; font-weight:800; color:var(--c-primary); margin-bottom:16px;">
            Pendaftar Baru ({{ count($applicants) }})
          </h3>
          <div style="display:flex; flex-direction:column; gap:12px;">
            @if (count($applicants) === 0)
              <p style="color:var(--c-text-muted); font-size:13px; text-align:center; padding:10px 0;">Belum ada pendaftar baru.</p>
            @else
              @foreach ($applicants as $app)
                @php
                  $appParts = explode(' ', $app->full_name);
                  $appInitials = strtoupper(substr($appParts[0], 0, 1));
                  if(count($appParts) > 1) $appInitials .= strtoupper(substr($appParts[1], 0, 1));
                @endphp
                <div style="border:1px solid var(--c-border); border-radius:12px; padding:12px; background:var(--c-bg);">
                  <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                    <div style="width:32px; height:32px; border-radius:50%; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px; flex-shrink:0;">
                      {{ $appInitials }}
                    </div>
                    <div>
                      <div style="font-weight:800; color:var(--c-text); font-size:13px;">{{ $app->full_name }}</div>
                      <div style="font-size:10px; color:var(--c-text-muted);">{{ $app->institution ?? 'Member' }}</div>
                    </div>
                  </div>
                  <div style="font-size:12px; color:var(--c-text-muted); background:var(--c-card); border: 1px solid var(--c-border-light); padding:10px; border-radius:8px; margin-bottom:12px; line-height:1.5; white-space:pre-wrap;">
                    "{{ $app->pesan }}"
                  </div>
                  <div style="display:flex; gap:8px;">
                    <form action="{{ route('member.inspira.proyek.applicant.manage') }}" method="POST" style="flex:1;">
                      @csrf
                      <input type="hidden" name="proyek_id" value="{{ $proyek->id }}">
                      <input type="hidden" name="applicant_id" value="{{ $app->user_id }}">
                      <input type="hidden" name="status_update" value="rejected">
                      <button type="submit" class="btn btn-ghost btn-sm" style="width:100%; border:1px solid var(--c-danger); color:var(--c-danger); padding:6px; font-size:12px;" onclick="return confirm('Tolak pendaftar ini?')">Tolak</button>
                    </form>
                    <form action="{{ route('member.inspira.proyek.applicant.manage') }}" method="POST" style="flex:1;">
                      @csrf
                      <input type="hidden" name="proyek_id" value="{{ $proyek->id }}">
                      <input type="hidden" name="applicant_id" value="{{ $app->user_id }}">
                      <input type="hidden" name="status_update" value="accepted">
                      <button type="submit" class="btn btn-primary btn-sm" style="width:100%; background:var(--c-success); border-color:var(--c-success); padding:6px; font-size:12px;" onclick="return confirm('Terima pendaftar ini?')">Terima</button>
                    </form>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      @endif
      
    </div>

  </div>

</div>

<!-- Modal Gabung -->
<div class="modal-overlay" id="modalJoinProject" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(4px);">
  <div class="modal-content" style="background:var(--c-card); width:90%; max-width:500px; border-radius:24px; padding:32px; transform:translateY(20px); transition:transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
    <h3 style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:8px;">Ajukan Diri</h3>
    <p style="color:var(--c-text-muted); font-size:13px; margin-bottom:20px;">Beritahu inisiator proyek mengapa Anda cocok untuk bergabung di kolaborasi ini.</p>
    
    <form action="{{ route('member.inspira.proyek.join') }}" method="POST">
      @csrf
      <input type="hidden" name="proyek_id" value="{{ $proyek->id }}">
      <div class="form-group mb-24">
        <textarea name="pesan" required class="form-control" rows="4" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; font-size:14px; margin-bottom: 20px;" placeholder="Halo, saya memiliki pengalaman dalam... dan sangat tertarik untuk berkontribusi pada..."></textarea>
      </div>

      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeJoinModal()">Batal</button>
        <button type="submit" class="btn btn-primary" style="background:#059669; border-color:#059669;">Kirim Permintaan</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function openJoinModal() {
  const m = document.getElementById('modalJoinProject');
  m.style.display = 'flex';
  setTimeout(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  }, 10);
}

function closeJoinModal() {
  const m = document.getElementById('modalJoinProject');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(20px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}
</script>
@endsection
