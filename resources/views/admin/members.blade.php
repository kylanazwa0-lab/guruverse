@extends('layouts.admin')

@section('title', 'Data Member')
@section('page_title', 'Data Member')

@section('content')
<div class="panel">
  <div class="panel-head">
    <span class="panel-title">Daftar Anggota</span>
    <div class="panel-actions">
      <div class="search-wrap">
        <span class="search-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
        <input class="search-fi" id="search-input" placeholder="Cari nama, instansi, ID…" oninput="filterTable()"/>
      </div>
      <button class="btn-sm" onclick="openImport()" style="background:rgba(52,211,153,.1);color:#10b981;border:1px solid rgba(52,211,153,.2);">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Import Excel
      </button>
      <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle" data-dropdown="export-menu">Export</button>
        <ul id="export-menu" class="dropdown-menu">
          <li><a class="dropdown-item" href="#" onclick="exportData('excel')">Excel</a></li>
          <li><a class="dropdown-item" href="#" onclick="exportData('pdf')">PDF</a></li>
        </ul>
      </div>
      <button class="btn-sm" onclick="openAdd()" style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah
      </button>
      <button class="btn-sm" onclick="loadMembers()" style="background:rgba(255,255,255,.05);color:var(--muted);border:1px solid var(--border);">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23,4 23,10 17,10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Refresh
      </button>
    </div>
  </div>

  <div id="table-err" style="display:none;padding:.75rem 1.1rem;color:#f87171;font-weight:700;font-size:.76rem;"></div>

  <div class="tbl-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Anggota</th><th>Instansi</th><th>Kontak</th><th>Bergabung</th><th style="text-align:center;">Aksi</th></tr>
      </thead>
      <tbody id="table-body">
        @for($i=0;$i<6;$i++)
        <tr>
          @foreach([24,140,120,90,80,90] as $w)
            <td><div class="skel" style="height:11px;width:{{$w}}px;background:rgba(0,0,0,0.05);border-radius:4px"></div></td>
          @endforeach
        </tr>
        @endfor
      </tbody>
    </table>
  </div>
  <div class="pagination" id="pagination" style="display:flex;gap:4px;padding:12px;justify-content:center"></div>
</div>

<!-- MODAL TAMBAH -->
<div class="overlay" id="modal-add" style="display:none" onclick="if(event.target===this)closeAdd()">
  <div class="modal modal-lg">
    <div class="modal-head">
      <h3 class="modal-title">Tambah Anggota Baru</h3>
      <button class="btn-close" onclick="closeAdd()">&times;</button>
    </div>
    <form id="form-add" onsubmit="saveAdd(event)">
      <div class="modal-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
          <div class="fg">
            <label>Nama Lengkap & Gelar</label>
            <input type="text" name="full_name" class="fi" placeholder="Contoh: Budi Santoso, S.Pd." required>
          </div>
          <div class="fg">
            <label>Username / Email</label>
            <input type="text" name="username" class="fi" placeholder="nama@email.com" required>
          </div>
          <div class="fg">
            <label>Asal Instansi / Sekolah</label>
            <input type="text" name="institution" class="fi" placeholder="Contoh: SMA Negeri 1 Jakarta" required>
          </div>
          <div class="fg">
            <label>Nomor WhatsApp</label>
            <input type="text" name="phone" class="fi" placeholder="Contoh: 08123456789">
          </div>
          <div class="fg">
            <label>Password Akun</label>
            <div style="position:relative">
              <input type="password" id="add-pass" name="password" class="fi" placeholder="Minimal 6 karakter" required>
              <button type="button" onclick="togglePass('add-pass')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted2);cursor:pointer">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <p style="font-size:10px;color:var(--muted2);margin-top:4px">Password akan otomatis di-hash dengan Bcrypt.</p>
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn-sm" onclick="closeAdd()" style="background:#f1f5f9;color:#475569;border:none">Batal</button>
        <button type="submit" class="btn-sm" id="btn-save-add" style="background:var(--v1);color:#fff;border:none">Simpan Anggota</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL IMPORT -->
<div class="overlay" id="modal-import" style="display:none" onclick="if(event.target===this)closeImport()">
  <div class="modal modal-md">
    <div class="modal-head">
      <h3 class="modal-title">Import Anggota dari Excel</h3>
      <button class="btn-close" onclick="closeImport()">&times;</button>
    </div>
    <form id="form-import" onsubmit="doImport(event)">
      <div class="modal-body">
        <p style="font-size:0.8rem;color:var(--muted);margin-bottom:1rem">
          Unggah file Excel (.xlsx) yang berisi data anggota. Format kolom: <br>
          <b>Nama Lengkap, Username, Instansi, Password, No WhatsApp</b>
        </p>
        <div class="fg">
          <label>File Excel</label>
          <input type="file" name="excel_file" class="fi" accept=".xlsx,.xls" required>
        </div>
        <div style="margin-top:1rem;padding:0.75rem;background:rgba(245,158,11,0.05);border:1px solid rgba(245,158,11,0.2);border-radius:8px">
          <p style="font-size:0.7rem;color:#b45309;font-weight:700">PENTING:</p>
          <p style="font-size:0.65rem;color:#b45309">Admin berhak memasukkan password asli anggota dalam file Excel. Sistem akan memprosesnya secara otomatis.</p>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn-sm" onclick="closeImport()" style="background:#f1f5f9;color:#475569;border:none">Batal</button>
        <button type="submit" class="btn-sm" id="btn-do-import" style="background:#10b981;color:#fff;border:none">Proses Import</button>
      </div>
    </form>
  </div>
</div>

<script>
let allMembers=[], filteredData=[];
const PAGE_SIZE=12;
let currentPage=1;

function esc(s){ return s?s.replace(/</g,'&lt;').replace(/>/g,'&gt;'):''; }
function fmtDate(d){ return d ? new Date(d).toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}) : '-'; }

function openAdd(){ document.getElementById('modal-add').style.display='flex'; }
function closeAdd(){ document.getElementById('modal-add').style.display='none'; document.getElementById('form-add').reset(); }
function openImport(){ document.getElementById('modal-import').style.display='flex'; }
function closeImport(){ document.getElementById('modal-import').style.display='none'; document.getElementById('form-import').reset(); }

function togglePass(id) {
  const el = document.getElementById(id);
  el.type = el.type === 'password' ? 'text' : 'password';
}

function loadMembers() {
  const tbody = document.getElementById('table-body');
  tbody.innerHTML = '<tr><td colspan="6" style="padding:40px;text-align:center"><span class="spin" style="display:inline-block">⌛</span> Memuat data...</td></tr>';

  fetch("{{ route('admin.members') }}", {
      headers: {
        'Accept': 'application/json'
      }
    })
    .then(r => {
      if (r.status === 401) {
        showTableErr('Sesi admin tidak aktif. Silakan <a href="{{ route("admin.login") }}" style="color:var(--acc);text-decoration:underline">login kembali</a>.');
        return null;
      }
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(data => {
      if (!data) return;
      if (data.success) {
        allMembers = data.members;
        filteredData = [...allMembers];
        renderTable();
      } else {
        showTableErr(data.message || 'Gagal memuat data.');
      }
    })
    .catch(err => showTableErr('Gagal menghubungi server: ' + err.message));
}

function showTableErr(msg){
  document.getElementById('table-err').innerHTML=msg;
  document.getElementById('table-err').style.display='block';
  document.getElementById('table-body').innerHTML='';
}

function renderTable() {
  document.getElementById('table-err').style.display='none';
  const tbody = document.getElementById('table-body');
  if(filteredData.length===0){
    tbody.innerHTML=`<tr><td colspan="6"><div style="padding:40px;text-align:center;color:var(--muted2)">Tidak ada anggota ditemukan.</div></td></tr>`;
    document.getElementById('pagination').innerHTML='';
    return;
  }
  const totalPages = Math.ceil(filteredData.length/PAGE_SIZE);
  if(currentPage>totalPages) currentPage=1;
  const start = (currentPage-1)*PAGE_SIZE;
  const pageData = filteredData.slice(start, start+PAGE_SIZE);
  
  tbody.innerHTML = pageData.map((m, i) => {
    const num = start+i+1;
    const phone = m.phone || '';
    const name  = m.fullName || '?';
    const wa = phone.replace(/\D/g,'');
    const waNum = wa.startsWith('0') ? '62'+wa.slice(1) : wa;
    const avatarColors = ['#8b2fc9','#06d6a0','#f8961e','#4cc9f0','#ef233c'];
    const avatarBg = avatarColors[name.charCodeAt(0) % avatarColors.length];
    const photo = m.photo
      ? `<img src="${esc(m.photo)}" style="width:34px;height:34px;border-radius:9px;object-fit:cover">`
      : `<div style="width:34px;height:34px;border-radius:9px;background:${avatarBg};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;flex-shrink:0">${name.charAt(0).toUpperCase()}</div>`;
    
    return `<tr>
      <td><span class="mono" style="font-size:.65rem;color:var(--muted2)">${num}</span></td>
      <td><div style="display:flex;align-items:center;gap:.65rem;">
        ${photo}
        <div>
          <div style="font-weight:700;color:var(--t);font-size:.8rem;">${esc(name)}</div>
          <div class="mono" style="font-size:.58rem;color:var(--muted);">${esc(m.memberId||'')}</div>
        </div>
      </div></td>
      <td style="color:var(--muted);font-size:.75rem">${esc(m.institution||'-')}</td>
      <td>${phone ? `<a href="https://wa.me/${waNum}" target="_blank" style="color:#10b981;text-decoration:none;font-size:.75rem">${esc(phone)}</a>` : '<span style="color:var(--muted2);font-size:.75rem">-</span>'}</td>
      <td style="color:var(--muted2);font-size:.7rem">${fmtDate(m.joinedAt)}</td>
      <td style="text-align:center">
        <div class="dropdown relative inline-flex">
          <button id="dd-${m.memberId}" type="button" class="dropdown-toggle btn btn-square btn-ghost btn-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
          </button>
          <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-40 z-50" role="menu" aria-orientation="vertical" aria-labelledby="dd-${m.memberId}">
            <li><a class="dropdown-item" href="#" onclick="showToast('Fitur detail sedang dalam pengembangan','success');return false;">Lihat Detail</a></li>
            <li><a class="dropdown-item" href="#" onclick="sendWaInvite('${m.memberId}', '${esc(name)}', '${esc(phone)}');return false;">Hubungi via WA</a></li>
            <hr class="my-1 border-gray-200" />
            <li><a class="dropdown-item text-red-500 hover:bg-red-50" href="#" onclick="deleteMember(${m.id}, '${esc(name)}');return false;">Hapus Anggota</a></li>
          </ul>
        </div>
      </td>
    </tr>`;
  }).join('');
  
  // Pagination
  let pg = '';
  for(let i=1;i<=totalPages;i++){
     pg += `<button onclick="currentPage=${i};renderTable()" style="padding:4px 10px;border-radius:6px;border:1px solid ${i===currentPage?'var(--v1)':'var(--border)'};background:${i===currentPage?'var(--v1)':'transparent'};color:${i===currentPage?'#fff':'var(--muted)'};cursor:pointer">${i}</button>`;
  }
  document.getElementById('pagination').innerHTML = pg;
}

function filterTable(){
  const q = document.getElementById('search-input').value.toLowerCase().trim();
  filteredData = allMembers.filter(m => [m.fullName, m.institution, m.memberId, m.phone].some(v => v && v.toLowerCase().includes(q)));
  currentPage = 1;
  renderTable();
}

function saveAdd(e) {
  e.preventDefault();
  const btn = document.getElementById('btn-save-add');
  const oldText = btn.innerText;
  btn.disabled = true;
  btn.innerText = 'Menyimpan...';

  const fd = new FormData(e.target);
  fd.append('_token', '{{ csrf_token() }}');
  
  fetch("{{ route('admin.members.store') }}", {
    method: 'POST',
    body: fd,
    headers: {
      'Accept': 'application/json'
    }
  })
  .then(r => r.json())
  .then(data => {
    if(data.success) {
      showToast('Anggota berhasil ditambahkan');
      closeAdd();
      loadMembers();
    } else {
      alert('Gagal: ' + data.message);
    }
  })
  .catch(err => alert('Kesalahan: ' + err.message))
  .finally(() => {
    btn.disabled = false;
    btn.innerText = oldText;
  });
}

function doImport(e) {
  e.preventDefault();
  const btn = document.getElementById('btn-do-import');
  btn.disabled = true;
  btn.innerText = 'Mengimport...';

  const fd = new FormData(e.target);
  fd.append('_token', '{{ csrf_token() }}');

  fetch('/admin/members/import', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(data => {
    if(data.success) {
      showToast(data.message || 'Import berhasil');
      closeImport();
      loadMembers();
    } else {
      alert('Gagal: ' + data.message);
    }
  })
  .catch(err => alert('Kesalahan: ' + err.message))
  .finally(() => {
    btn.disabled = false;
    btn.innerText = 'Proses Import';
  });
}

function sendWaInvite(memberId, name, phone) {
  if (!phone) {
    alert('Nomor WhatsApp anggota ini tidak terdaftar!');
    return;
  }
  
  let cleanPhone = phone.replace(/\D/g, '');
  if (cleanPhone.startsWith('0')) {
    cleanPhone = '62' + cleanPhone.slice(1);
  }
  
  const siteUrl = window.location.origin + '/';
  const setPassUrl = siteUrl + 'guru-belajar/member/set-password.php';

  const message = `Halo Kak *${name}*, selamat bergabung di *Guruverse.id*! 🌟

Akun Anggota Anda telah diaktifkan di sistem. Berikut informasi akses login Anda:

👤 *Username / Member ID* : ${memberId}
📱 *No. WhatsApp* : ${phone}

Silakan atur password akun Anda pertama kali melalui link aman di bawah ini:
🔗 ${setPassUrl}

Setelah membuat password, Kakak bisa langsung masuk dan belajar bersama Guruverse. Terima kasih! ✨`;

  const encodedMsg = encodeURIComponent(message);
  const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodedMsg}`;
  
  window.open(waUrl, '_blank');
}

function deleteMember(id, name) {
  document.getElementById('delete-modal-text').innerText = 'Hapus anggota "' + name + '"? Tindakan ini tidak dapat dibatalkan.';
  document.getElementById('global-delete-modal').style.display = 'flex';
  const confirmBtn = document.getElementById('delete-modal-confirm');
  
  confirmBtn.onclick = () => {
    document.getElementById('global-delete-modal').style.display = 'none';
    fetch(`/admin/members/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) { 
        showToast('Anggota berhasil dihapus'); 
        loadMembers(); 
      } else {
        alert('Gagal: ' + data.message);
      }
    })
    .catch(err => alert('Kesalahan: ' + err.message));
  };
}

document.addEventListener('DOMContentLoaded', loadMembers);
</script>
@endsection
