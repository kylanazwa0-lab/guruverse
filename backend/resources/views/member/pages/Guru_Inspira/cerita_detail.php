<?php /* Detail Cerita Inspiratif — Guru Inspira */ ?>
<div class="page" id="page-cerita-detail" style="animation: fadeIn 0.3s ease-out;">
  
  <div style="margin-bottom:20px;">
    <button class="btn btn-outline btn-sm" onclick="showPage('cerita')" style="background:#fff; border-color:#cbd5e1; color:#64748b;">
      <i class="ti ti-arrow-left"></i> Kembali ke Daftar Cerita
    </button>
  </div>

  <div id="ceritaLoading" style="text-align:center; padding:40px; color:#94a3b8;"><div class="spinner"></div></div>
  
  <div id="ceritaContentContainer" style="display:none; max-width:800px; margin:0 auto;">
    
    <div class="card mb-24">
      <div class="card-body" style="padding:40px;">
        
        <div style="text-align:center; margin-bottom:32px;">
          <h2 id="ceritaTitle" style="font-size:32px; font-weight:800; color:#1e1b4b; margin-bottom:24px; line-height:1.3;">Judul Cerita</h2>
          
          <div style="display:flex; justify-content:center; align-items:center; gap:16px;">
            <div id="ceritaAuthorAvatar" style="width:56px; height:56px; border-radius:50%; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:18px;">
              US
            </div>
            <div style="text-align:left;">
              <div id="ceritaAuthorName" style="font-weight:700; color:#1e1b4b; font-size:16px;">Nama User</div>
              <div style="font-size:13px; color:#64748b;"><span id="ceritaTime"></span> &bull; <i class="ti ti-eye"></i> <span id="ceritaViews"></span> Kali dibaca</div>
            </div>
          </div>
        </div>
        
        <!-- Pemisah Visual -->
        <div style="display:flex; justify-content:center; gap:8px; margin-bottom:40px;">
          <div style="width:8px; height:8px; border-radius:50%; background:#fcd34d;"></div>
          <div style="width:8px; height:8px; border-radius:50%; background:#fbbf24;"></div>
          <div style="width:8px; height:8px; border-radius:50%; background:#f59e0b;"></div>
        </div>
        
        <div id="ceritaBody" style="font-size:17px; color:#334155; line-height:1.9; white-space:pre-wrap; font-family:'Merriweather', serif;">
          Isi cerita...
        </div>
        
      </div>
    </div>
    
  </div>

</div>

<script>
function loadCeritaDetail(id) {
    document.getElementById('ceritaContentContainer').style.display = 'none';
    document.getElementById('ceritaLoading').style.display = 'block';
    
    fetch('api_cerita.php?action=get_detail&id=' + id)
    .then(r => r.json())
    .then(res => {
        if(res.status === 'success') {
            const c = res.data;
            
            document.getElementById('ceritaTitle').textContent = c.judul;
            document.getElementById('ceritaAuthorAvatar').textContent = c.author_initials;
            document.getElementById('ceritaAuthorName').textContent = c.author_name;
            document.getElementById('ceritaTime').textContent = c.time_ago;
            document.getElementById('ceritaViews').textContent = c.views;
            document.getElementById('ceritaBody').innerHTML = c.konten_html;
            
            document.getElementById('ceritaLoading').style.display = 'none';
            document.getElementById('ceritaContentContainer').style.display = 'block';
        } else {
            gbShowAlert('Error', 'Gagal memuat cerita: ' + res.message, 'error');
            showPage('cerita');
        }
    })
    .catch(err => console.error(err));
}
</script>
