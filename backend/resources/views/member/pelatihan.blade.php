@extends('layouts.member')

@section('title', 'Pelatihan Online')

@section('styles')
<style>
/* ── Pelatihan Grid ──────────────────────────────────────────────────────── */
.pelatihan-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap: 24px;
}
.pelatihan-card {
  background: var(--c-card);
  border: 1px solid var(--c-border);
  border-radius: 20px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 4px 12px rgba(0,0,0,0.03);
  position: relative;
}
.pelatihan-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 40px rgba(0,0,0,0.08);
}
.pelatihan-card-header {
  padding: 24px 24px 20px;
  background: var(--c-card);
  border-bottom: 1px dashed var(--c-border);
  position: relative;
}
.pelatihan-card-accent {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 6px;
}
.pelatihan-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-bottom: 12px;
}
.pelatihan-tag {
  background: var(--c-bg);
  color: var(--c-text-muted);
  border: 1px solid var(--c-border);
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.3px;
}
.pelatihan-title {
  font-size: 18px;
  font-weight: 800;
  line-height: 1.4;
  color: var(--c-text);
  margin-bottom: 14px;
}
.pelatihan-cert-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(245, 158, 11, 0.1);
  color: #f59e0b;
  border: 1px solid rgba(245, 158, 11, 0.2);
  border-radius: 8px;
  padding: 4px 10px;
  font-size: 11px;
  font-weight: 700;
}
.pelatihan-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  flex: 1;
  background: #f8fafc;
}
/* Batch row */
.batch-row {
  background: #ffffff;
  border: 1px solid var(--c-border);
  border-radius: 14px;
  padding: 16px;
  margin-bottom: 12px;
  transition: all 0.2s;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}
.batch-row:hover { border-color: var(--c-primary); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
.batch-row.registered {
  border-color: #10b981;
  background: #f0fdf4;
}
/* Fasilitas */
.fasilitas-wrap {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-top: 14px;
  padding-top: 14px;
  border-top: 1px solid var(--c-border-light);
}
.fasilitas-chip {
  background: var(--c-bg);
  border: 1px solid var(--c-border-light);
  border-radius: 8px;
  padding: 4px 10px;
  font-size: 11px;
  font-weight: 600;
  color: var(--c-text-muted);
  display: flex;
  align-items: center;
  gap: 4px;
}
/* Stats strip */
.stat-strip {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 28px;
}
.stat-strip-card {
  background: var(--c-card);
  border: 1px solid var(--c-border-light);
  border-radius: 16px;
  padding: 18px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.stat-strip-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.stat-strip-val {
  font-size: 24px;
  font-weight: 900;
  line-height: 1;
  margin-bottom: 2px;
}
.stat-strip-lbl {
  font-size: 12px;
  color: var(--c-text-muted);
  font-weight: 600;
}
</style>
@endsection

@section('content')
<div class="page active" id="page-pelatihan" style="animation: fadeIn 0.3s ease-out;">

  <!-- HERO BANNER -->
  <div class="card mb-24" style="background:linear-gradient(135deg,#1e1b4b 0%,#312e81 50%,#4338ca 100%); color:#fff; padding:32px; border-radius:24px; position:relative; overflow:hidden;">
    <svg style="position:absolute; right:-10px; top:-10px; width:180px; height:180px; opacity:0.07;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
    </svg>
    <div style="position:relative; z-index:1; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
      <div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:20px; padding:5px 14px; font-size:11px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:14px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Workshop & Seminar
        </div>
        <h1 style="font-size:28px; font-weight:800; margin-bottom:8px; line-height:1.2;">Pelatihan Online</h1>
        <p style="color:rgba(255,255,255,0.85); max-width:520px; font-size:14px; line-height:1.6;">Tingkatkan kompetensi Anda melalui workshop, seminar, dan bimtek berkualitas bersama para ahli pendidikan terbaik.</p>
      </div>
      <div style="display:flex; flex-direction:column; align-items:flex-end; gap:10px;">
        <div style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:16px; padding:14px 20px; text-align:center;">
          <div style="font-size:28px; font-weight:900;">{{ $pelatihans->count() }}</div>
          <div style="font-size:11px; font-weight:700; opacity:0.8;">Program Tersedia</div>
        </div>
      </div>
    </div>
  </div>

  <!-- STATS STRIP -->
  <div class="stat-strip">
    <div class="stat-strip-card">
      <div class="stat-strip-icon" style="background:rgba(108,92,231,0.12); color:var(--c-primary);">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
      </div>
      <div>
        <div class="stat-strip-val" style="color:var(--c-primary);">{{ $stats['terdaftar'] }}</div>
        <div class="stat-strip-lbl">Terdaftar</div>
      </div>
    </div>
    <div class="stat-strip-card">
      <div class="stat-strip-icon" style="background:rgba(16,185,129,0.12); color:#10b981;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div>
        <div class="stat-strip-val" style="color:#10b981;">{{ $stats['selesai'] }}</div>
        <div class="stat-strip-lbl">Selesai Diikuti</div>
      </div>
    </div>
    <div class="stat-strip-card">
      <div class="stat-strip-icon" style="background:rgba(245,158,11,0.12); color:#f59e0b;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
      </div>
      <div>
        <div class="stat-strip-val" style="color:#f59e0b;">{{ $pelatihans->where('ada_sertifikat', 1)->count() }}</div>
        <div class="stat-strip-lbl">Ada Sertifikat</div>
      </div>
    </div>
  </div>

  <!-- SUCCESS / ERROR ALERT -->
  @if(session('success'))
    <div style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); color:#10b981; padding:14px 20px; border-radius:14px; font-size:13px; font-weight:700; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; padding:14px 20px; border-radius:14px; font-size:13px; font-weight:700; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      {{ session('error') }}
    </div>
  @endif

  <!-- SECTION LABEL -->
  <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
    <div>
      <div style="font-size:11px; font-weight:700; color:var(--c-text-muted); text-transform:uppercase; letter-spacing:0.6px; margin-bottom:4px;">Program Tersedia</div>
      <div style="font-size:20px; font-weight:800; color:var(--c-text);">Pilih Pelatihan yang Tepat Untukmu</div>
    </div>
  </div>

  <!-- PELATIHAN GRID -->
  @if($pelatihans->isEmpty())
    <div style="text-align:center; padding:64px 24px; background:var(--c-card); border-radius:20px; border:3px dashed var(--c-border);">
      <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--c-text-subtle); margin-bottom:16px;">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      <h3 style="font-size:18px; font-weight:800; color:var(--c-text); margin-bottom:8px;">Belum Ada Program Pelatihan</h3>
      <p style="font-size:14px; color:var(--c-text-muted);">Program pelatihan akan segera hadir. Pantau terus halaman ini!</p>
    </div>
  @else
    <div class="pelatihan-grid">
      @foreach($pelatihans as $p)
        @php
          $pBatches   = $batches->get($p->id, collect());
          $fasilitas  = json_decode($p->fasilitas ?? '[]', true) ?: [];
          $warna      = $p->warna ?: '#4f46e5';
          $tags       = array_map('trim', explode(',', $p->tags));
          $sudahDaftar= $pBatches->whereIn('id', $myBatchIds)->count() > 0;
        @endphp
        <div class="pelatihan-card">
          <div class="pelatihan-card-accent" style="background:{{ $warna }};"></div>
          <!-- HEADER -->
          <div class="pelatihan-card-header">
            <div class="pelatihan-tags">
              @foreach($tags as $tag)
                <span class="pelatihan-tag" style="color:{{ $warna }}; border-color:{{ $warna }}33; background:{{ $warna }}11;">{{ $tag }}</span>
              @endforeach
            </div>
            <div class="pelatihan-title">{{ $p->title }}</div>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
              @if($p->ada_sertifikat)
                <div class="pelatihan-cert-badge">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                  Ada Sertifikat
                </div>
              @endif
              @if($sudahDaftar)
                <div class="pelatihan-cert-badge" style="background:rgba(16,185,129,0.1); color:#10b981; border-color:rgba(16,185,129,0.2);">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                  Sudah Terdaftar
                </div>
              @endif
              <div style="font-size:11px; color:var(--c-text-muted); font-weight:600;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px; margin-right:2px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $p->total_batch }} Batch
              </div>
            </div>
          </div>

          <!-- BODY -->
          <div class="pelatihan-body">
            <!-- Batch list -->
            @if($pBatches->isEmpty())
              <div style="text-align:center; padding:20px; color:var(--c-text-muted); font-size:13px; background:var(--c-bg); border-radius:10px; border:1px dashed var(--c-border);">
                Belum ada jadwal batch tersedia
              </div>
            @else
              @foreach($pBatches as $b)
                @php
                  $isDaftar  = in_array($b->id, $myBatchIds);
                  $isFull    = $b->sisa_kursi > 0 && $b->peserta_count >= $b->sisa_kursi;
                  $sisa      = $b->sisa_kursi > 0 ? ($b->sisa_kursi - $b->peserta_count) : null;
                @endphp
                <div class="batch-row {{ $isDaftar ? 'registered' : '' }}">
                  <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                    <div style="flex:1;">
                      <div style="font-size:13px; font-weight:800; color:var(--c-text); margin-bottom:4px;">{{ $b->nama_batch }}</div>
                      <div style="display:flex; flex-wrap:wrap; gap:10px; font-size:12px; color:var(--c-text-muted);">
                        <span style="display:flex; align-items:center; gap:4px;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                          {{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}
                        </span>
                        <span style="display:flex; align-items:center; gap:4px;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                          {{ $b->waktu }}
                        </span>
                        <span style="display:flex; align-items:center; gap:4px;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                          {{ $b->lokasi }}
                        </span>
                      </div>
                      <div style="margin-top:6px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        <span style="font-size:13px; font-weight:800; color:{{ $warna }};">
                          {{ $b->harga == 0 ? 'Gratis' : 'Rp ' . number_format($b->harga, 0, ',', '.') }}
                        </span>
                        @if($sisa !== null)
                          <span style="font-size:11px; color:{{ $sisa <= 5 ? '#ef4444' : 'var(--c-text-muted)' }}; font-weight:600;">
                            {{ $sisa }} kursi tersisa
                          </span>
                        @endif
                      </div>
                      @if($isDaftar)
                        <div style="margin-top:8px; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.25); border-radius:8px; padding:6px 10px; display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; color:#10b981;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                          Tiket: {{ $b->ticket_code }}
                        </div>
                      @endif
                    </div>
                    <!-- Tombol Daftar -->
                    <div style="flex-shrink:0;">
                      @if($isDaftar)
                        @if($b->payment_status === 'pending')
                          @php
                            $bayarUrl = $b->mayar_link ? ($b->mayar_link . '?ref=' . urlencode($b->ticket_code) . '&email=' . urlencode(Auth::guard('web')->user()->email ?? '')) : '#';
                          @endphp
                          <a href="{{ $bayarUrl }}" target="_blank" style="margin-bottom:6px; width:100%; padding:7px 14px; border-radius:8px; font-size:11px; font-weight:800; background:#f59e0b; color:#fff; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:4px; box-sizing:border-box;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            Bayar
                          </a>
                          <button onclick="openKonfirmasi('{{ $b->ticket_code }}')" type="button" style="width:100%; padding:5px 10px; border-radius:6px; font-size:10px; font-weight:700; background:transparent; color:var(--c-text-muted); border:1px solid var(--c-border-light); cursor:pointer;">
                            Konfirmasi Manual
                          </button>
                        @else
                          <span style="padding:7px 14px; border-radius:10px; font-size:11px; font-weight:800; background:rgba(16,185,129,0.1); color:#10b981; border:1px solid rgba(16,185,129,0.3);">✓ Terdaftar</span>
                        @endif
                      @elseif($isFull)
                        <span style="padding:7px 14px; border-radius:10px; font-size:11px; font-weight:800; background:rgba(239,68,68,0.08); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">Penuh</span>
                      @else
                        <form action="{{ route('member.pelatihan.daftar') }}" method="POST">
                          @csrf
                          <input type="hidden" name="batch_id" value="{{ $b->id }}">
                          <button type="submit" style="padding:7px 16px; border-radius:10px; font-size:12px; font-weight:800; background:{{ $warna }}; color:#fff; border:none; cursor:pointer; transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                            Daftar
                          </button>
                        </form>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            @endif

            <!-- Fasilitas -->
            @if(!empty($fasilitas))
              <div class="fasilitas-wrap">
                <div style="width:100%; font-size:10px; font-weight:700; color:var(--c-text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fasilitas</div>
                @foreach($fasilitas as $f)
                  <div class="fasilitas-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $f }}
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>

<!-- MODAL KONFIRMASI -->
<div class="overlay" id="konfirmasiModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:16px; padding:24px; width:100%; max-width:400px; box-shadow:0 12px 40px rgba(0,0,0,0.2); animation:slideDown 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
    <h3 style="font-size:18px; font-weight:800; margin-bottom:8px; color:var(--c-text);">Konfirmasi Pembayaran</h3>
    <p style="font-size:13px; color:var(--c-text-muted); margin-bottom:20px; line-height:1.5;">Masukkan nomor referensi atau ID transaksi dari Mayar.id / Bank.</p>
    
    <form action="{{ route('member.pelatihan.konfirmasi') }}" method="POST">
      @csrf
      <input type="hidden" name="ticket_code" id="konfirmasi_ticket">
      
      <div style="margin-bottom:16px;">
        <label style="display:block; font-size:12px; font-weight:700; color:var(--c-text); margin-bottom:6px;">Nomor Referensi Transaksi</label>
        <input type="text" name="payment_ref" required placeholder="Contoh: INV-123456 / TRF-BANK" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); font-size:14px; outline:none;" onfocus="this.style.borderColor='var(--c-primary)'" onblur="this.style.borderColor='var(--c-border)'">
      </div>
      
      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
        <button type="button" onclick="closeKonfirmasi()" style="padding:10px 16px; border-radius:10px; font-size:13px; font-weight:700; background:#f1f5f9; color:#475569; border:none; cursor:pointer;">Batal</button>
        <button type="submit" style="padding:10px 20px; border-radius:10px; font-size:13px; font-weight:800; background:var(--c-primary); color:#fff; border:none; cursor:pointer;">Konfirmasi Pembayaran</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL MAYAR POPUP (DITAMPILKAN SETELAH DAFTAR BERHASIL) -->
@if(session('mayar_url'))
<div class="overlay" id="mayarPopup" style="display:flex; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:20px; padding:32px; width:100%; max-width:400px; box-shadow:0 20px 50px rgba(0,0,0,0.25); animation:slideDown 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-align:center;">
    <div style="width:64px; height:64px; background:rgba(16,185,129,0.1); color:#10b981; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
    <h3 style="font-size:22px; font-weight:900; margin-bottom:12px; color:var(--c-text);">Pendaftaran Berhasil!</h3>
    <p style="font-size:14px; color:var(--c-text-muted); margin-bottom:28px; line-height:1.6;">Kursi Anda sudah diamankan. Silakan lanjutkan pembayaran untuk menyelesaikan proses pendaftaran.</p>
    
    <div style="display:flex; flex-direction:column; gap:12px;">
      <a href="{{ session('mayar_url') }}" target="_blank" onclick="document.getElementById('mayarPopup').style.display='none'" style="padding:14px 20px; border-radius:12px; font-size:14px; font-weight:800; background:#f59e0b; color:#fff; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 12px rgba(245,158,11,0.25); transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        Bayar Sekarang
      </a>
      <button onclick="document.getElementById('mayarPopup').style.display='none'" style="padding:12px 20px; border-radius:12px; font-size:14px; font-weight:700; background:#f1f5f9; color:#475569; border:none; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
        Nanti Saja
      </button>
    </div>
  </div>
</div>
@endif

<script>
function openKonfirmasi(ticket) {
  document.getElementById('konfirmasi_ticket').value = ticket;
  document.getElementById('konfirmasiModal').style.display = 'flex';
}
function closeKonfirmasi() {
  document.getElementById('konfirmasiModal').style.display = 'none';
}
</script>

@endsection
