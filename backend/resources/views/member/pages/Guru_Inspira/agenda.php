<?php /* Agenda & Event — Guru Inspira */ ?>
<div class="page" id="page-agenda" style="animation: fadeIn 0.3s ease-out;">
  
  <div class="card mb-24" style="background:linear-gradient(135deg, #be123c 0%, #e11d48 100%); color:#fff; padding:32px; border-radius:24px; position:relative; overflow:hidden;">
    <svg style="position:absolute; right:-20px; top:-20px; width:200px; height:200px; opacity:0.1; transform:rotate(15deg);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <div style="position:relative; z-index:1; display:flex; justify-content:space-between; align-items:center;">
      <div>
        <h2 style="font-size:28px; font-weight:800; margin-bottom:8px;">Agenda & Event Guru</h2>
        <p style="color:rgba(255,255,255,0.9); max-width:500px;">Ikuti berbagai webinar, lokakarya, dan pertemuan virtual untuk terus mengembangkan kompetensi Anda.</p>
      </div>
      <div>
        <button class="btn" style="background:#fff; color:#be123c; border:none; padding:12px 24px; font-size:16px; border-radius:12px; font-weight:800; box-shadow:0 4px 15px rgba(0,0,0,0.1);" onclick="openNewEventModal()">
          + Buat Event Baru
        </button>
      </div>
    </div>
  </div>

  <div id="agendaListContainer" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:24px;">
    <div style="grid-column:1/-1; text-align:center; padding:40px; color:#94a3b8;"><div class="spinner"></div></div>
  </div>

</div>

<!-- Modal Buat Event Baru -->
<div class="modal-overlay" id="modalNewEvent" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.6); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease;">
  <div class="modal-content" style="background:#fff; width:90%; max-width:500px; border-radius:24px; padding:32px; transform:translateY(20px); transition:transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
      <h3 style="font-size:22px; font-weight:800; color:#1e1b4b;">Jadwalkan Event Baru</h3>
      <button onclick="closeNewEventModal()" style="background:none; border:none; font-size:24px; color:#94a3b8; cursor:pointer;">&times;</button>
    </div>

    <div class="form-group mb-16">
      <label class="form-label">Nama Event</label>
      <input type="text" id="newEventTitle" class="form-control" placeholder="Contoh: Webinar Strategi Mengajar Era AI">
    </div>
    
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;" class="mb-16">
        <div class="form-group">
          <label class="form-label">Tipe Event</label>
          <select id="newEventType" class="form-control">
            <option value="Webinar">Webinar (Online)</option>
            <option value="Lokakarya">Lokakarya (Offline)</option>
            <option value="Diskusi Santai">Diskusi Santai</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Waktu Pelaksanaan</label>
          <input type="datetime-local" id="newEventDate" class="form-control">
        </div>
    </div>
    
    <div class="form-group mb-16">
      <label class="form-label">Link Meeting (Zoom/Meet)</label>
      <input type="text" id="newEventLink" class="form-control" placeholder="Kosongkan jika offline atau belum ada">
    </div>

    <div class="form-group mb-24">
      <label class="form-label">Deskripsi Event</label>
      <textarea id="newEventDesc" class="form-control" rows="3" placeholder="Siapa pembicaranya? Apa yang akan dibahas?"></textarea>
    </div>

    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-outline" onclick="closeNewEventModal()">Batal</button>
      <button class="btn btn-primary" style="background:#be123c; border-color:#be123c;" onclick="submitNewEvent()">Jadwalkan Event</button>
    </div>
  </div>
</div>

<script>
let agendaDataCache = [];

function loadAgendaData() {
    fetch('api_agenda.php?action=get_all')
    .then(r => r.json())
    .then(res => {
        if(res.status === 'success') {
            agendaDataCache = res.data;
            renderAgenda();
        }
    })
    .catch(err => console.error(err));
}

function renderAgenda() {
    const list = document.getElementById('agendaListContainer');
    
    if(agendaDataCache.length === 0) {
        list.innerHTML = `<div style="grid-column:1/-1; text-align:center; padding:60px; background:#fff1f2; border-radius:24px; border:2px dashed #fda4af;">
            <div style="font-size:48px; margin-bottom:16px;">🗓️</div>
            <div style="font-size:18px; font-weight:800; color:#1e1b4b; margin-bottom:8px;">Belum Ada Jadwal Event</div>
            <p style="color:#e11d48;">Jadilah inisiator pertama untuk berbagi wawasan di komunitas ini!</p>
        </div>`;
        return;
    }
    
    let html = '';
    agendaDataCache.forEach(e => {
        
        let actionBtn = '';
        if(e.has_joined) {
            actionBtn = `<button class="btn btn-success btn-block" disabled style="opacity:0.8;"><i class="ti ti-check"></i> Sudah Terdaftar</button>`;
            if(e.link_meeting) {
                actionBtn += `<a href="${e.link_meeting}" target="_blank" class="btn btn-outline btn-block mt-8" style="color:var(--c-primary); border-color:var(--c-primary);"><i class="ti ti-external-link"></i> Akses Link Meeting</a>`;
            }
        } else {
            actionBtn = `<button class="btn btn-primary btn-block" style="background:${e.warna_bg}; color:${e.warna_text}; border:none;" onclick="joinEvent(${e.id})">Daftar Event (RSVP)</button>`;
        }
        
        html += `<div class="card" style="border:1px solid #e2e8f0; overflow:hidden; display:flex; flex-direction:column; transition:transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            
            <div class="card-body" style="flex:1; display:flex; flex-direction:column; padding:24px;">
                
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="width:48px; height:48px; border-radius:12px; background:${e.warna_bg}; color:${e.warna_text}; display:flex; align-items:center; justify-content:center; font-size:24px;">
                            <i class="${e.icon}"></i>
                        </div>
                        <div>
                            <span class="badge" style="background:rgba(226,232,240,0.5); color:#475569; border-radius:20px; font-size:11px; font-weight:700; padding:4px 10px; margin-bottom:4px;">${e.tipe}</span>
                            <div style="font-weight:700; color:#1e1b4b; font-size:13px;"><i class="ti ti-calendar-event"></i> ${e.tanggal_formatted}</div>
                        </div>
                    </div>
                </div>
                
                <h3 style="font-size:18px; font-weight:800; color:#1e1b4b; margin-bottom:8px; line-height:1.4;">${e.judul}</h3>
                <p style="font-size:13px; color:#64748b; margin-bottom:20px; line-height:1.6; flex:1;">${e.deskripsi}</p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #e2e8f0; padding-top:16px; margin-bottom:16px;">
                    <div style="font-size:12px; color:#64748b; display:flex; align-items:center; gap:6px;">
                        Penyelenggara: <strong style="color:#1e1b4b;">${e.author_name}</strong>
                    </div>
                    <div style="font-size:12px; font-weight:700; color:#059669; display:flex; align-items:center; gap:4px;">
                        <i class="ti ti-users"></i> ${e.peserta_count} Peserta
                    </div>
                </div>
                
                ${actionBtn}
            </div>
        </div>`;
    });
    list.innerHTML = html;
}

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

function submitNewEvent() {
    const judul = document.getElementById('newEventTitle').value.trim();
    const tipe = document.getElementById('newEventType').value;
    const tgl = document.getElementById('newEventDate').value;
    const link = document.getElementById('newEventLink').value.trim();
    const desc = document.getElementById('newEventDesc').value.trim();
    
    if(!judul || !tgl || !desc) {
        gbShowAlert('Oopss!', 'Judul, Tanggal, dan Deskripsi wajib diisi.', 'error');
        return;
    }
    
    const fd = new FormData();
    fd.append('judul', judul);
    fd.append('tipe', tipe);
    fd.append('event_date', tgl);
    fd.append('link_meeting', link);
    fd.append('deskripsi', desc);
    
    fetch('api_agenda.php?action=create', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(res => {
        if(res.status === 'success') {
            closeNewEventModal();
            gbShowAlert('Berhasil!', 'Jadwal Event baru berhasil ditambahkan.', 'success');
            document.getElementById('newEventTitle').value = '';
            document.getElementById('newEventDate').value = '';
            document.getElementById('newEventLink').value = '';
            document.getElementById('newEventDesc').value = '';
            loadAgendaData();
        } else {
            gbShowAlert('Gagal', res.message, 'error');
        }
    }).catch(err => console.error(err));
}

function joinEvent(eventId) {
    const fd = new FormData();
    fd.append('id', eventId);
    
    fetch('api_agenda.php?action=rsvp', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(res => {
        if(res.status === 'success') {
            gbShowAlert('Berhasil Terdaftar!', 'Anda telah terdaftar sebagai peserta event ini.', 'success');
            loadAgendaData();
        } else {
            gbShowAlert('Error', res.message, 'error');
        }
    }).catch(err => console.error(err));
}

document.addEventListener('DOMContentLoaded', () => {
    loadAgendaData();
});
</script>
