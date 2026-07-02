<div class="page" id="page-referral">
  <div class="card mb-24" style="background:linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color:#fff; padding:32px; border-radius:24px; position:relative; overflow:hidden;">
    <svg style="position:absolute; right:-20px; top:-20px; width:200px; height:200px; opacity:0.1; transform:rotate(15deg);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
    <div style="position:relative; z-index:1;">
      <h1 style="font-size:1.8rem; font-weight:800; margin-bottom:8px;">Ajak Rekan Guru, Dapatkan Keuntungan!</h1>
      <p style="font-size:1rem; opacity:0.9; max-width:600px; line-height:1.5;">Bagikan kode referral Anda ke rekan sejawat. Semakin banyak yang mendaftar melalui link Anda, semakin besar diskon Pelatihan Offline yang Anda dapatkan (Hingga GRATIS 100%).</p>
    </div>
  </div>

  <div class="layout-two-col mb-24" style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
    <!-- KODE REFERRAL -->
    <div class="card card-body">
      <div class="section-head">
        <h2>Kode & Link Referral Anda</h2>
      </div>
      <div style="background:var(--c-bg); border:1px solid var(--c-border); border-radius:12px; padding:20px; text-align:center;">
        <div style="font-size:0.85rem; color:var(--c-text-muted); margin-bottom:8px;">Kode Referral Unik:</div>
        <div id="refCodeDisplay" style="font-size:1.5rem; font-weight:900; letter-spacing:2px; color:var(--c-primary); margin-bottom:16px;">Memuat...</div>
        
        <div style="font-size:0.85rem; color:var(--c-text-muted); margin-bottom:8px;">Link Pendaftaran:</div>
        <div style="display:flex; align-items:center; background:#fff; border:1px solid var(--c-border-light); border-radius:8px; overflow:hidden;">
          <input type="text" id="refLinkDisplay" readonly style="flex:1; border:none; padding:10px 12px; font-size:0.85rem; color:#475569; outline:none;" value="Memuat...">
          <button onclick="copyRefLink()" class="btn btn-primary" style="border-radius:0; height:100%; padding:10px 16px;">Salin</button>
        </div>
      </div>
    </div>

    <!-- STATISTIK & TIER -->
    <div class="card card-body">
      <div class="section-head">
        <h2>Target & Hadiah (Tiers)</h2>
      </div>
      <div style="display:flex; flex-direction:column; gap:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border-radius:12px; border:1px solid var(--c-border-light); background:var(--c-bg);">
          <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; border-radius:50%; background:rgba(99,102,241,0.1); color:#6366f1; display:flex; align-items:center; justify-content:center; font-weight:800;">1</div>
            <div>
              <div style="font-weight:700; font-size:0.95rem; color:var(--c-text);">Ajak 1 Orang</div>
              <div style="font-size:0.8rem; color:var(--c-text-muted);">Diskon Pelatihan 20%</div>
            </div>
          </div>
        </div>
        
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border-radius:12px; border:1px solid var(--c-border-light); background:var(--c-bg);">
          <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; border-radius:50%; background:rgba(168,85,247,0.1); color:#a855f7; display:flex; align-items:center; justify-content:center; font-weight:800;">3</div>
            <div>
              <div style="font-weight:700; font-size:0.95rem; color:var(--c-text);">Ajak 3 Orang</div>
              <div style="font-size:0.8rem; color:var(--c-text-muted);">Diskon Pelatihan 50%</div>
            </div>
          </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border-radius:12px; border:1px solid var(--c-border-light); background:var(--c-bg);">
          <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; border-radius:50%; background:rgba(234,179,8,0.1); color:#eab308; display:flex; align-items:center; justify-content:center; font-weight:800;">5</div>
            <div>
              <div style="font-weight:700; font-size:0.95rem; color:var(--c-text);">Ajak 5 Orang</div>
              <div style="font-size:0.8rem; color:var(--c-text-muted);">Gratis 100% Pelatihan</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="layout-two-col" style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
    <!-- DAFTAR REKAN YANG BERHASIL DIAJAK -->
    <div class="card card-body">
      <div class="section-head">
        <h2>Rekan yang Berhasil Mendaftar (<span id="totalRef">0</span>)</h2>
      </div>
      <div id="referredList" style="display:flex; flex-direction:column; gap:12px;">
        <div style="text-align:center; padding:24px; color:var(--c-text-muted); font-size:13px;">Memuat data...</div>
      </div>
    </div>

    <!-- VOUCHER SAYA -->
    <div class="card card-body">
      <div class="section-head">
        <h2>Voucher Diskon Anda</h2>
      </div>
      <div id="voucherList" style="display:flex; flex-direction:column; gap:12px;">
        <div style="text-align:center; padding:24px; color:var(--c-text-muted); font-size:13px;">Memuat data...</div>
      </div>
    </div>
  </div>

</div>

<script>
async function loadReferralData() {
  try {
    const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_referral.php?action=get_data');
    const data = await res.json();
    if(data.status === 'success') {
      const d = data.data;
      
      // Update Code & Link
      document.getElementById('refCodeDisplay').innerText = d.referral_code;
      const link = window.location.origin + '/guruverse/register/register.php?ref=' + d.referral_code;
      document.getElementById('refLinkDisplay').value = link;
      
      // Update Total
      document.getElementById('totalRef').innerText = d.total_referrals;

      // Render Referred List
      const refList = document.getElementById('referredList');
      if(d.referred_users.length > 0) {
        refList.innerHTML = d.referred_users.map(u => `
          <div style="display:flex; align-items:center; gap:12px; padding:12px; border-radius:12px; border:1px solid var(--c-border-light); background:var(--c-bg);">
            <div style="width:36px; height:36px; border-radius:50%; background:var(--c-primary-pale); color:var(--c-primary); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.8rem;">
              ${u.initials}
            </div>
            <div>
              <div style="font-weight:700; font-size:0.9rem; color:var(--c-text);">${u.full_name}</div>
              <div style="font-size:0.75rem; color:var(--c-text-muted);">Mendaftar pada: ${u.created_at}</div>
            </div>
          </div>
        `).join('');
      } else {
        refList.innerHTML = `
          <div style="text-align:center; padding:32px 16px; color:var(--c-text-muted); font-size:13px; background:var(--c-bg); border-radius:12px; border:1px dashed var(--c-border);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 12px auto; opacity:0.4; display:block;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Belum ada rekan yang mendaftar.
          </div>
        `;
      }

      // Render Vouchers
      const vList = document.getElementById('voucherList');
      if(d.vouchers.length > 0) {
        vList.innerHTML = d.vouchers.map(v => `
          <div style="display:flex; justify-content:space-between; align-items:center; padding:16px; border-radius:12px; border:1px solid ${v.is_used ? 'var(--c-border-light)' : '#8b5cf6'}; background:${v.is_used ? 'var(--c-bg)' : 'linear-gradient(135deg, rgba(139,92,246,0.05), rgba(139,92,246,0.1))'}; opacity:${v.is_used ? '0.6' : '1'};">
            <div>
              <div style="font-weight:800; font-size:1.2rem; color:${v.is_used ? 'var(--c-text-muted)' : '#7c3aed'}; margin-bottom:4px;">Diskon ${v.discount_percent}%</div>
              <div style="font-family:monospace; font-size:0.9rem; font-weight:700; color:var(--c-text); background:#fff; padding:2px 8px; border-radius:4px; display:inline-block; border:1px solid var(--c-border-light);">
                ${v.voucher_code}
              </div>
            </div>
            <div>
              ${v.is_used 
                ? '<span class="badge" style="background:var(--c-bg-card); color:var(--c-text-muted);">Sudah Dipakai</span>' 
                : '<span class="badge badge-green">Tersedia</span>'}
            </div>
          </div>
        `).join('');
      } else {
        vList.innerHTML = `
          <div style="text-align:center; padding:32px 16px; color:var(--c-text-muted); font-size:13px; background:var(--c-bg); border-radius:12px; border:1px dashed var(--c-border);">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 12px auto; opacity:0.4; display:block;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            Belum ada voucher yang didapatkan.
          </div>
        `;
      }
    }
  } catch(err) {
    console.error("Gagal memuat data referral", err);
  }
}

function copyRefLink() {
  const input = document.getElementById('refLinkDisplay');
  input.select();
  input.setSelectionRange(0, 99999); 
  navigator.clipboard.writeText(input.value);
  alert("Link berhasil disalin!");
}

// Tambahkan hook agar data diload saat halaman referral dibuka
document.addEventListener('DOMContentLoaded', () => {
  // Panggil sekali di awal untuk preload (opsional)
  // loadReferralData();
});
</script>
