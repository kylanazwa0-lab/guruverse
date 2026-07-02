<?php /* Detail Kolaborasi Proyek — Guru Inspira */ ?>
<div class="page" id="page-proyek-detail" style="animation: fadeIn 0.3s ease-out;">
  
  <div style="margin-bottom:20px;">
    <button class="btn btn-outline btn-sm" onclick="showPage('proyek')" style="background:#fff; border-color:#cbd5e1; color:#64748b;">
      <i class="ti ti-arrow-left"></i> Kembali ke Daftar Proyek
    </button>
  </div>

  <div id="proyekLoading" style="text-align:center; padding:40px; color:#94a3b8;"><div class="spinner"></div></div>
  
  <div id="proyekContentContainer" style="display:none; gap:24px; grid-template-columns: 2fr 1fr;">
    
    <!-- Kolom Kiri: Detail -->
    <div style="display:flex; flex-direction:column; gap:24px;">
      <div class="card mb-0">
        <div id="proyekHeaderBg" style="height:150px; background:linear-gradient(135deg, #059669 0%, #34d399 100%); position:relative;">
          <div style="position:absolute; top:20px; right:20px;">
            <span id="proyekLabelBadge" style="background:rgba(255,255,255,0.9); padding:6px 16px; border-radius:20px; font-size:12px; font-weight:800; color:#059669;">Label</span>
          </div>
        </div>
        
        <div class="card-body" style="padding:32px;">
          <h2 id="proyekTitle" style="font-size:28px; font-weight:800; color:#1e1b4b; margin-bottom:16px; line-height:1.3;">Judul Proyek</h2>
          
          <div style="display:flex; gap:16px; align-items:center; margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid #f1f5f9;">
            <div id="proyekAuthorAvatar" style="width:48px; height:48px; border-radius:50%; background:#f1f5f9; color:#475569; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px;">
              US
            </div>
            <div>
              <div id="proyekAuthorName" style="font-weight:700; color:#1e1b4b; font-size:15px;">Nama User</div>
              <div style="font-size:12px; color:#64748b;"><i class="ti ti-crown" style="color:#f59e0b;"></i> Inisiator Proyek &bull; <span id="proyekTime"></span></div>
            </div>
          </div>
          
          <h3 style="font-size:16px; font-weight:800; color:#1e1b4b; margin-bottom:12px;">Deskripsi Kolaborasi</h3>
          <div id="proyekBody" style="font-size:15px; color:#334155; line-height:1.8; white-space:pre-wrap;">
            Isi proyek...
          </div>
        </div>
      </div>
    </div>
    
    <!-- Kolom Kanan: Status & Anggota -->
    <div style="display:flex; flex-direction:column; gap:24px;">
      
      <!-- Panel Pendaftaran -->
      <div class="card card-body" style="border:2px solid #e2e8f0;">
        <h3 style="font-size:16px; font-weight:800; color:#1e1b4b; margin-bottom:16px;">Status Perekrutan</h3>
        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
          <span style="font-size:14px; font-weight:600; color:#64748b;">Kuota Anggota</span>
          <span style="font-size:16px; font-weight:800; color:#059669;" id="proyekQuota">0/0</span>
        </div>
        
        <div style="background:#f1f5f9; border-radius:12px; height:8px; margin-bottom:24px; overflow:hidden;">
          <div id="proyekProgressBar" style="background:#059669; height:100%; width:0%; border-radius:12px;"></div>
        </div>
        
        <div id="proyekActionContainer">
          <!-- Dinamis via JS -->
        </div>
      </div>
      
      <!-- Daftar Anggota Terpilih -->
      <div class="card card-body">
        <h3 style="font-size:16px; font-weight:800; color:#1e1b4b; margin-bottom:16px;">Anggota Tim (<span id="memberCount">0</span>)</h3>
        <div id="proyekMembersList" style="display:flex; flex-direction:column; gap:12px;">
          <!-- Members go here -->
        </div>
      </div>
      
      <!-- Panel Pendaftar (Hanya untuk Author) -->
      <div class="card card-body" id="proyekApplicantsPanel" style="display:none; border:2px solid var(--c-primary-light);">
        <h3 style="font-size:16px; font-weight:800; color:var(--c-primary); margin-bottom:16px;">Pendaftar Baru (<span id="applicantCount">0</span>)</h3>
        <div id="proyekApplicantsList" style="display:flex; flex-direction:column; gap:12px;">
          <!-- Applicants go here -->
        </div>
      </div>
      
    </div>

  </div>

</div>

<!-- Modal Gabung -->
<div class="modal-overlay" id="modalJoinProject" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.6); z-index:9999; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s ease;">
  <div class="modal-content" style="background:#fff; width:90%; max-width:500px; border-radius:24px; padding:32px; transform:translateY(20px); transition:transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
    <h3 style="font-size:22px; font-weight:800; color:#1e1b4b; margin-bottom:8px;">Ajukan Diri</h3>
    <p style="color:#64748b; margin-bottom:20px;">Beritahu inisiator proyek mengapa Anda cocok untuk bergabung di kolaborasi ini.</p>
    
    <div class="form-group mb-24">
      <textarea id="joinMessage" class="form-control" rows="4" placeholder="Halo, saya memiliki pengalaman dalam... dan sangat tertarik untuk berkontribusi pada..."></textarea>
    </div>

    <div style="display:flex; gap:12px; justify-content:flex-end;">
      <button class="btn btn-outline" onclick="closeJoinModal()">Batal</button>
      <button class="btn btn-primary" style="background:#059669; border-color:#059669;" onclick="submitJoinRequest()">Kirim Permintaan</button>
    </div>
  </div>
</div>

<script>
function loadProjectDetail(id) {
    document.getElementById('proyekContentContainer').style.display = 'none';
    document.getElementById('proyekLoading').style.display = 'block';
    
    fetch('api_proyek.php?action=get_detail&id=' + id)
    .then(r => r.json())
    .then(res => {
        if(res.status === 'success') {
            const p = res.data.proyek;
            const members = res.data.members;
            
            document.getElementById('proyekHeaderBg').style.background = `linear-gradient(135deg, ${p.warna_bg} 0%, #34d399 100%)`;
            document.getElementById('proyekLabelBadge').textContent = p.label;
            document.getElementById('proyekLabelBadge').style.color = p.warna_bg;
            document.getElementById('proyekTitle').textContent = p.judul;
            document.getElementById('proyekAuthorAvatar').textContent = p.author_initials;
            document.getElementById('proyekAuthorName').textContent = p.author_name;
            document.getElementById('proyekTime').textContent = p.time_ago;
            document.getElementById('proyekBody').innerHTML = p.deskripsi;
            
            const currentCount = members.length;
            const maxCount = p.kebutuhan_anggota;
            document.getElementById('proyekQuota').textContent = `${currentCount}/${maxCount}`;
            document.getElementById('memberCount').textContent = currentCount;
            
            const pct = Math.min(100, Math.round((currentCount / maxCount) * 100));
            document.getElementById('proyekProgressBar').style.width = pct + '%';
            
            // Action button logic
            const actionContainer = document.getElementById('proyekActionContainer');
            if (res.data.is_author) {
                actionContainer.innerHTML = `<button class="btn btn-primary btn-block" style="background:var(--c-primary); pointer-events:none;">Anda Inisiator Proyek</button>`;
            } else if (res.data.is_member) {
                actionContainer.innerHTML = `<button class="btn btn-success btn-block" disabled style="opacity:0.8;"><i class="ti ti-check"></i> Anda adalah Anggota</button>`;
            } else if (res.data.has_requested) {
                actionContainer.innerHTML = `<button class="btn btn-warning btn-block" disabled style="opacity:0.8;"><i class="ti ti-clock"></i> Menunggu Persetujuan</button>`;
            } else if (currentCount >= maxCount) {
                actionContainer.innerHTML = `<button class="btn btn-secondary btn-block" disabled>Kuota Penuh</button>`;
            } else {
                actionContainer.innerHTML = `<button class="btn btn-primary btn-block" style="background:#059669; border-color:#059669;" onclick="openJoinModal()">Ajukan Diri</button>`;
            }
            
            // Members list
            const mList = document.getElementById('proyekMembersList');
            let mHtml = '';
            if (members.length === 0) mHtml = '<p style="color:#94a3b8;font-size:13px;text-align:center;padding:10px 0;">Belum ada anggota.</p>';
            members.forEach(m => {
                mHtml += `<div style="display:flex; align-items:center; gap:12px; padding:10px; border-radius:12px; background:#f8fafc;">
                    <div style="width:36px; height:36px; border-radius:50%; background:#cbd5e1; color:#334155; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px;">
                        ${m.user_initials}
                    </div>
                    <div style="font-weight:700; color:#1e1b4b; font-size:14px;">${m.user_name}</div>
                </div>`;
            });
            mList.innerHTML = mHtml;
            
            // Applicants List (untuk inisiator)
            const aPanel = document.getElementById('proyekApplicantsPanel');
            const aList = document.getElementById('proyekApplicantsList');
            const applicants = res.data.applicants || [];
            
            if (res.data.is_author && applicants.length > 0) {
                aPanel.style.display = 'block';
                document.getElementById('applicantCount').textContent = applicants.length;
                let aHtml = '';
                applicants.forEach(a => {
                    aHtml += `
                    <div style="border:1px solid var(--c-border); border-radius:12px; padding:12px; background:#fff;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <div style="width:32px; height:32px; border-radius:50%; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; flex-shrink:0;">
                                ${a.user_initials}
                            </div>
                            <div style="font-weight:800; color:var(--c-text); font-size:13px;">${a.user_name}</div>
                        </div>
                        <div style="font-size:12px; color:var(--c-text-muted); background:#f8fafc; padding:10px; border-radius:8px; margin-bottom:12px; line-height:1.5; white-space:pre-wrap;">
                            "${a.pesan}"
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button class="btn btn-outline btn-sm" style="flex:1; border-color:var(--c-danger); color:var(--c-danger); padding:6px; font-size:12px;" onclick="manageApplicant(${a.user_id}, 'rejected')">Tolak</button>
                            <button class="btn btn-primary btn-sm" style="flex:1; background:var(--c-success); border-color:var(--c-success); padding:6px; font-size:12px;" onclick="manageApplicant(${a.user_id}, 'accepted')">Terima</button>
                        </div>
                    </div>`;
                });
                aList.innerHTML = aHtml;
            } else {
                aPanel.style.display = 'none';
            }
            
            document.getElementById('proyekLoading').style.display = 'none';
            document.getElementById('proyekContentContainer').style.display = 'grid';
        } else {
            gbShowAlert('Error', 'Gagal memuat proyek: ' + res.message, 'error');
            showPage('proyek');
        }
    })
    .catch(err => console.error(err));
}

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

function submitJoinRequest() {
    const pesan = document.getElementById('joinMessage').value.trim();
    if(!pesan) {
        gbShowAlert('Oopss', 'Pesan pengajuan tidak boleh kosong', 'error');
        return;
    }
    
    const fd = new FormData();
    fd.append('id', window.currentInspiraProyekId);
    fd.append('pesan', pesan);
    
    fetch('api_proyek.php?action=join_request', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(res => {
        if(res.status === 'success') {
            closeJoinModal();
            loadProjectDetail(window.currentInspiraProyekId);
            gbShowAlert('Berhasil', 'Permintaan bergabung Anda telah dikirim ke inisiator proyek.', 'success');
        } else {
            gbShowAlert('Error', res.message, 'error');
        }
    }).catch(err => console.error(err));
}

function manageApplicant(applicant_id, status) {
    if(!confirm('Anda yakin ingin ' + (status === 'accepted' ? 'menerima' : 'menolak') + ' pendaftar ini?')) return;
    
    const fd = new FormData();
    fd.append('proyek_id', window.currentInspiraProyekId);
    fd.append('applicant_id', applicant_id);
    fd.append('status_update', status);
    
    fetch('api_proyek.php?action=manage_applicant', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(res => {
        if(res.status === 'success') {
            gbShowAlert('Berhasil', 'Status pendaftar telah diperbarui.', 'success');
            loadProjectDetail(window.currentInspiraProyekId);
        } else {
            gbShowAlert('Gagal', res.message, 'error');
        }
    }).catch(err => console.error(err));
}
</script>
