<?php /* Jendela Dunia Detail — Guru Inspira */ ?>
<div class="page" id="page-jendela-detail" style="display:none; animation: fadeIn 0.3s ease-out;">
  <div style="margin-bottom: 24px;">
    <button class="btn btn-ghost" onclick="showPage('jendela')" style="padding:8px 0; color:var(--c-text-muted);">
      <i class="ti ti-arrow-left"></i> Kembali ke Jendela Dunia
    </button>
  </div>

  <div id="jendelaDetailLoader" style="padding:40px; text-align:center; color:var(--c-text-muted);">
    Memuat artikel...
  </div>

  <div id="jendelaDetailContent" style="display:none; background:var(--c-card); border-radius:24px; padding:48px; border:1px solid var(--c-border); box-shadow:0 12px 40px rgba(0,0,0,0.05);">
    <div style="text-align:center; margin-bottom:32px;">
      <span id="jdCategory" style="font-size:12px; font-weight:800; color:var(--c-primary); text-transform:uppercase; letter-spacing:1px;">Kategori</span>
      <h1 id="jdTitle" style="font-size:32px; font-weight:900; color:var(--c-text); line-height:1.3; margin:12px 0;">Judul Artikel</h1>
      <div style="font-size:13px; color:var(--c-text-muted); display:flex; align-items:center; justify-content:center; gap:8px;">
        <div id="jdAuthorAv" style="width:24px; height:24px; border-radius:50%; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:800;">A</div>
        <span id="jdAuthor">Author</span> &bull; <span id="jdDate">Date</span>
      </div>
    </div>
    
    <div style="height:200px; background:#f1f5f9; border-radius:16px; margin-bottom:40px; display:flex; align-items:center; justify-content:center; font-size:64px;">
      🌍
    </div>
    
    <div id="jdContent" style="font-size:16px; line-height:1.8; color:var(--c-text); max-width:760px; margin:0 auto;">
      Isi artikel...
    </div>
    
    <div id="jdSourceBox" style="display:none; margin-top:40px; padding:16px; background:#f8fafc; border-radius:12px; font-size:13px; color:var(--c-text-muted); text-align:center;">
      Sumber referensi: <a id="jdSourceLink" href="#" target="_blank" style="color:var(--c-primary); font-weight:600;">Link</a>
    </div>
  </div>
</div>

<script>
function loadJendelaDetail(id) {
  document.getElementById('jendelaDetailLoader').style.display = 'block';
  document.getElementById('jendelaDetailContent').style.display = 'none';
  
  fetch(`api_jendela.php?action=get_detail&id=${id}`)
    .then(r => r.json())
    .then(res => {
      document.getElementById('jendelaDetailLoader').style.display = 'none';
      if(res.status === 'success') {
        const j = res.data;
        document.getElementById('jendelaDetailContent').style.display = 'block';
        document.getElementById('jdCategory').innerText = j.kategori;
        document.getElementById('jdTitle').innerText = j.judul;
        document.getElementById('jdAuthor').innerText = j.author_name;
        document.getElementById('jdAuthorAv').innerText = j.author_initials;
        document.getElementById('jdDate').innerText = j.time_ago;
        document.getElementById('jdContent').innerHTML = j.konten_html;
        
        const srcBox = document.getElementById('jdSourceBox');
        if(j.sumber && j.sumber.trim() !== '') {
          srcBox.style.display = 'block';
          document.getElementById('jdSourceLink').href = j.sumber;
          document.getElementById('jdSourceLink').innerText = j.sumber;
        } else {
          srcBox.style.display = 'none';
        }
      } else {
        alert('Gagal memuat artikel');
        showPage('jendela');
      }
    });
}
</script>
