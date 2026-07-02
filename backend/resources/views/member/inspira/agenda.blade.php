@extends('layouts.inspira')

@section('title', 'Agenda & Event - Guru Inspira')

@section('content')

<div class="page active" id="page-agenda" style="animation: fadeIn 0.3s ease-out;">
  
  <div class="card mb-24" style="background:linear-gradient(135deg, #0f0c2e 0%, #1a1242 50%, #2d1b6e 100%); color:#fff; padding:32px; border-radius:24px; position:relative; overflow:hidden;">
    <svg style="position:absolute; right:-20px; top:-20px; width:200px; height:200px; opacity:0.1; transform:rotate(15deg);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <div style="position:relative; z-index:1; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
      <div>
        <h2 style="font-size:28px; font-weight:800; margin-bottom:8px;">Agenda & Event Guru</h2>
        <p style="color:rgba(255,255,255,0.9); max-width:500px; font-size:14px; line-height:1.5;">Ikuti berbagai webinar, lokakarya, dan pertemuan virtual untuk terus mengembangkan kompetensi Anda.</p>
      </div>
      <div>
        <button class="btn" style="background:linear-gradient(135deg, #f59e0b, #f97316); color:#fff; border:none; padding:12px 24px; font-size:14px; border-radius:12px; font-weight:800; box-shadow:0 6px 20px rgba(245,158,11,0.4); cursor:pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 28px rgba(245,158,11,0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(245,158,11,0.4)';" onclick="openNewEventModal()">
          + Buat Event Baru
        </button>
      </div>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success mb-24" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700;">
      {{ session('success') }}
    </div>
  @endif

  <div id="agendaListContainer" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:24px;">
    @if ($events->isEmpty())
      <div style="grid-column: 1/-1; background: transparent; border-radius: 20px; padding: 48px 40px; display: flex; align-items: center; justify-content: center; flex-direction: column; text-align: center; gap: 20px; border: 3px dashed var(--c-text-subtle); min-height: 240px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--c-text-subtle); margin-bottom: -10px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <div style="flex: 1;">
          <div style="font-size: 18px; font-weight: 800; color: var(--c-text); line-height: 1.3; margin-bottom: 8px;">
            Belum Ada Jadwal Event
          </div>
          <p style="color: var(--c-text-muted); font-size: 13px; line-height: 1.65; max-width: 380px; margin: 0 auto 24px;">
            Jadilah inisiator pertama untuk berbagi wawasan di komunitas ini!
          </p>
          <button onclick="openNewEventModal()" style="display: inline-flex; align-items: center; gap: 8px; background: var(--c-primary); color: #fff; border: none; border-radius: 12px; padding: 12px 24px; font-size: 14px; font-weight: 800; cursor: pointer; transition: all 0.2s; letter-spacing: 0.2px;" onmouseover="this.style.background='var(--c-primary-dark)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='var(--c-primary)'; this.style.transform='translateY(0)';">
            + Buat Event Baru
          </button>
        </div>
      </div>
    @else
      @foreach ($events as $e)
        @php
          $hasJoined = in_array($e->id, $rsvps);
        @endphp
        <div class="card" style="background: var(--c-card); border: 1px solid var(--c-border); overflow:hidden; display:flex; flex-direction:column; border-radius:18px; transition:transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
          <div class="card-body" style="flex:1; display:flex; flex-direction:column; padding:24px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
              <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:48px; height:48px; border-radius:12px; background:{{ $e->warna_bg }}; color:{{ $e->warna_text }}; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">
                  <i class="{{ $e->icon ?? 'ti ti-calendar' }}"></i>
                </div>
                <div>
                  <span class="badge" style="background:var(--c-border-light); color:var(--c-text-muted); border-radius:20px; font-size:10px; font-weight:800; padding:4px 10px; margin-bottom:4px; display:inline-block;">{{ $e->tipe }}</span>
                  <div style="font-weight:700; color:var(--c-text); font-size:12px;">
                    {{ date('d M Y, H:i', strtotime($e->event_date)) }}
                  </div>
                </div>
              </div>
            </div>
            
            <h3 style="font-size:17px; font-weight:800; color:var(--c-text); margin-bottom:8px; line-height:1.4;">{{ $e->judul }}</h3>
            <p style="font-size:13px; color:var(--c-text-muted); margin-bottom:20px; line-height:1.6; flex:1;">{{ $e->deskripsi }}</p>
            
            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed var(--c-border); padding-top:16px; margin-bottom:16px;">
              <div style="font-size:12px; color:var(--c-text-muted);">
                Penyelenggara: <strong style="color:var(--c-text);">{{ $e->author_name }}</strong>
              </div>
              <div style="font-size:12px; font-weight:700; color:#059669; display:flex; align-items:center; gap:4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; margin-right:2px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                {{ $e->peserta_count }} Peserta
              </div>
            </div>
            
            @if ($hasJoined)
              <form action="{{ route('member.inspira.agenda.rsvp') }}" method="POST" style="margin-bottom: 8px;">
                @csrf
                <input type="hidden" name="event_id" value="{{ $e->id }}">
                <button type="submit" class="btn btn-success" style="width: 100%; font-weight: 800; background: var(--c-success); border-color: var(--c-success);">
                  ✓ Sudah Terdaftar (Batal RSVP)
                </button>
              </form>
              @if ($e->link_meeting)
                <a href="{{ $e->link_meeting }}" target="_blank" class="btn btn-outline" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 700; text-decoration: none; color: var(--c-primary); border-color: var(--c-primary);">
                  Akses Link Meeting &rarr;
                </a>
              @endif
            @else
              <form action="{{ route('member.inspira.agenda.rsvp') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $e->id }}">
                <button type="submit" class="btn btn-primary" style="width: 100%; font-weight: 800; background: {{ $e->warna_bg }}; color: {{ $e->warna_text }}; border: none;">
                  Daftar Event (RSVP)
                </button>
              </form>
            @endif
          </div>
        </div>
      @endforeach
    @endif
  </div>

</div>

<!-- Modal Buat Event Baru -->
<div class="modal-overlay" id="modalNewEvent" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease; backdrop-filter:blur(4px);">
  <div class="modal-content" style="background:var(--c-card); width:90%; max-width:500px; border-radius:24px; padding:32px; transform:translateY(20px); transition:transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
      <h3 style="font-size:22px; font-weight:800; color:var(--c-text);">Jadwalkan Event Baru</h3>
      <button onclick="closeNewEventModal()" style="background:none; border:none; font-size:24px; color:var(--c-text-muted); cursor:pointer;">&times;</button>
    </div>

    <form action="{{ route('member.inspira.agenda.create') }}" method="POST">
      @csrf
      <div class="form-group mb-16">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Nama Event</label>
        <input type="text" name="judul" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="Contoh: Webinar Strategi Mengajar Era AI">
      </div>
      
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Tipe Event</label>
          <select name="tipe" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;">
            <option value="Webinar">Webinar (Online)</option>
            <option value="Lokakarya">Lokakarya (Offline)</option>
            <option value="Diskusi Santai">Diskusi Santai</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Waktu Pelaksanaan</label>
          <input type="datetime-local" name="event_date" required class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;">
        </div>
      </div>
      
      <div class="form-group mb-16">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Link Meeting (Zoom/Meet)</label>
        <input type="url" name="link_meeting" class="form-control" style="width:100%; padding:10px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none;" placeholder="Kosongkan jika offline atau belum ada">
      </div>

      <div class="form-group mb-24">
        <label class="form-label" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 6px; display: block;">Deskripsi Event</label>
        <textarea name="deskripsi" required class="form-control" rows="3" style="width:100%; padding:12px 14px; border-radius:10px; border:1px solid var(--c-border); background:var(--c-bg); color:var(--c-text); outline:none; resize:vertical; min-height:80px;" placeholder="Siapa pembicaranya? Apa yang akan dibahas?"></textarea>
      </div>

      <div style="display:flex; gap:12px; justify-content:flex-end;">
        <button type="button" class="btn btn-ghost" onclick="closeNewEventModal()">Batal</button>
        <button type="submit" class="btn btn-primary" style="background:#be123c; border-color:#be123c;">Jadwalkan Event</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function openNewEventModal() {
  const m = document.getElementById('modalNewEvent');
  m.style.display = 'flex';
  setTimeout(() => {
    m.style.opacity = '1';
    m.querySelector('.modal-content').style.transform = 'translateY(0)';
  }, 10);
}

function closeNewEventModal() {
  const m = document.getElementById('modalNewEvent');
  m.style.opacity = '0';
  m.querySelector('.modal-content').style.transform = 'translateY(20px)';
  setTimeout(() => { m.style.display = 'none'; }, 300);
}
</script>
@endsection
