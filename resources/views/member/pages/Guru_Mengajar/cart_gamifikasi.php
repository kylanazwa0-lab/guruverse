<style>
/* Toast Notification - scoped untuk cart gamifikasi */
#page-cart-gamifikasi .gvg-toast-container {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 9999;
  display: flex;
  flex-direction: column;
  gap: 10px;
  pointer-events: none;
}
#page-cart-gamifikasi .gvg-toast {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  color: var(--c-text, #0f172a);
  padding: 12px 24px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  font-size: 13px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 12px;
  transform: translateY(50px);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: 1px solid var(--c-border-light, #e2e8f0);
}
#page-cart-gamifikasi .gvg-toast.show { transform: translateY(0); opacity: 1; }
#page-cart-gamifikasi .gvg-toast.error { border-left: 4px solid var(--c-danger, #ef4444); }
#page-cart-gamifikasi .gvg-toast.success { border-left: 4px solid var(--c-success, #10b981); }
#page-cart-gamifikasi .gvg-toast-icon { font-size: 18px; display: flex; align-items: center; }
#page-cart-gamifikasi .gvg-toast.error .gvg-toast-icon { color: var(--c-danger, #ef4444); }
#page-cart-gamifikasi .gvg-toast.success .gvg-toast-icon { color: var(--c-success, #10b981); }
</style>

<div class="page" id="page-cart-gamifikasi">
  <div class="hero-section mb-6" style="padding:15px 24px;min-height:auto; background:linear-gradient(135deg, #4f46e5, #8b2fc9); color:#fff; border-radius:12px; margin-bottom:20px;">
    <div class="hero-text">
      <div class="hero-badge" style="background:rgba(255,255,255,0.2); padding:4px 10px; border-radius:20px; font-size:10px; font-weight:800; display:inline-block; margin-bottom:10px;">
        Gamifikasi Center
      </div>
      <h1 style="font-size:18px;margin-bottom:2px; font-weight:800;">Keranjang Gamifikasi Saya</h1>
      <p style="font-size:12px;opacity:0.8">Selesaikan pembelian untuk materi gamifikasi &amp; ice breaking pilihanmu.</p>
    </div>
  </div>

  <div class="card p-0 overflow-hidden" style="background:transparent; border:none; box-shadow:none">
    <!-- Table Header -->
    <div id="gvgTableHeader" style="background:rgba(255,255,255,0.8); padding:15px 24px; border-radius:12px; display:grid; grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr; gap:20px; align-items:center; margin-bottom:12px; border:1px solid #e2e8f0">
      <div style="display:flex; align-items:center; gap:12px">
        <input type="checkbox" id="gvgHeaderCheckbox" onchange="gvgToggleSelectAll(this)" checked style="accent-color:#4f46e5; width:18px; height:18px; cursor:pointer">
        <span style="font-size:13px; font-weight:700; color:#64748b">Produk Gamifikasi</span>
      </div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:#64748b">Harga Satuan</div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:#64748b">Kuantitas</div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:#64748b">Total Harga</div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:#64748b">Aksi</div>
    </div>

    <!-- Shop Group -->
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:100px">
      <div id="gvgShopGroup" style="padding:15px 24px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; gap:10px">
        <input type="checkbox" id="gvgShopCheckbox" onchange="gvgToggleSelectAll(this)" checked style="accent-color:#4f46e5; width:18px; height:18px; cursor:pointer">
        <span style="background:#4f46e5; color:#fff; font-size:10px; font-weight:900; padding:2px 6px; border-radius:4px">OFFICIAL</span>
        <span style="font-size:14px; font-weight:800; color:#0f172a;">Guruverse Gamifikasi Store</span>
      </div>

      <div id="gvgFullCartList">
        <!-- JS will populate this -->
      </div>
    </div>
  </div>

  <!-- Bottom Sticky Bar -->
  <div id="gvgBottomBar" style="position:fixed; bottom:20px; left:280px; right:40px; background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:12px 24px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 -10px 30px rgba(0,0,0,0.1); z-index:100;">
    <div style="display:flex; align-items:center; gap:20px">
      <label style="display:flex; align-items:center; gap:10px; cursor:pointer">
        <input type="checkbox" id="gvgBottomCheckbox" onchange="gvgToggleSelectAll(this)" checked style="accent-color:#4f46e5; width:18px; height:18px; cursor:pointer">
        <span style="font-size:13px; font-weight:700; color:#0f172a;">Pilih Semua (<span id="gvgCartSelectedCount">0</span>)</span>
      </label>
      <button onclick="gvgHapusTerpilih()" style="background:none; border:none; color:#ef4444; font-size:13px; font-weight:700; cursor:pointer">Hapus</button>
    </div>

    <div style="display:flex; align-items:center; gap:24px">
      <div style="text-align:right">
        <div style="font-size:12px; font-weight:600; color:#64748b; line-height:1">Total (<span id="gvgCartTotalQty">0</span> produk):</div>
        <div style="font-size:20px; font-weight:900; color:#4f46e5" id="gvgCartFullTotal">Rp0</div>
      </div>
      <button onclick="gvgCheckoutCart()" style="background:#10b981; color:#fff; border:none; padding:12px 36px; border-radius:10px; font-weight:900; font-size:15px; cursor:pointer; transition:all 0.2s; box-shadow:0 6px 15px rgba(16, 185, 129, 0.3)">
        Checkout
      </button>
    </div>
  </div>

  <script>
    /* =========================================================
       CART GAMIFIKASI — semua fungsi & ID pakai prefix "gvg"
       agar tidak bentrok dengan cart.php (Guru Belajar)
    ========================================================= */

    const GVG_CART_KEY = 'gv_gamifikasi_cart';
    const GVG_OWNED_KEY = 'gv_owned_games';

    function gvgUpdateSummary() {
      const itemCheckboxes = document.querySelectorAll('#page-cart-gamifikasi .gvg-item-checkbox');
      const masterCheckboxes = [
        document.getElementById('gvgHeaderCheckbox'),
        document.getElementById('gvgShopCheckbox'),
        document.getElementById('gvgBottomCheckbox')
      ];

      const selectedCountEl = document.getElementById('gvgCartSelectedCount');
      const totalQtyEl     = document.getElementById('gvgCartTotalQty');
      const fullTotalEl    = document.getElementById('gvgCartFullTotal');

      let selectedCount = 0, totalQty = 0, totalPrice = 0;

      itemCheckboxes.forEach(cb => {
        if (cb.checked) {
          selectedCount++;
          const qty = parseInt(cb.dataset.qty || 1);
          totalQty  += qty;
          totalPrice += parseFloat(cb.dataset.price) * qty;
        }
      });

      const allChecked = itemCheckboxes.length > 0 && selectedCount === itemCheckboxes.length;
      masterCheckboxes.forEach(m => { if (m) m.checked = allChecked; });

      if (selectedCountEl) selectedCountEl.textContent = selectedCount;
      if (totalQtyEl)      totalQtyEl.textContent      = totalQty;
      if (fullTotalEl)     fullTotalEl.textContent      = 'Rp' + new Intl.NumberFormat('id-ID').format(totalPrice);

      // Sinkronisasi badge di dashboard Guru Mengajar (jika ada)
      if (typeof window.gvgUpdateDashboardCartCount === 'function') {
        window.gvgUpdateDashboardCartCount();
      }
    }

    function gvgToggleSelectAll(masterCb) {
      const itemCheckboxes = document.querySelectorAll('#page-cart-gamifikasi .gvg-item-checkbox');
      const isChecked = masterCb.checked;

      // Sync semua master checkbox
      ['gvgHeaderCheckbox','gvgShopCheckbox','gvgBottomCheckbox'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.checked = isChecked;
      });

      itemCheckboxes.forEach(cb => cb.checked = isChecked);
      gvgUpdateSummary();
    }

    function gvgRenderCart() {
      const container = document.getElementById('gvgFullCartList');
      if (!container) return;

      const cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
      const bottomBar = document.getElementById('gvgBottomBar');
      const tableHeader = document.getElementById('gvgTableHeader');
      const shopGroup = document.getElementById('gvgShopGroup');

      if (cart.length === 0) {
        if (bottomBar) bottomBar.style.display = 'none';
        if (tableHeader) tableHeader.style.display = 'none';
        if (shopGroup) shopGroup.style.display = 'none';
        
        container.innerHTML = `
          <div style="padding:80px 20px; text-align:center">
            <div style="width:80px; height:80px; background:rgba(79,70,229,0.05); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="1.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            </div>
            <h3 style="font-size:18px; font-weight:800; margin-bottom:8px; color:#0f172a;">Keranjang Belanja Kosong</h3>
            <p style="color:#64748b; font-size:14px; margin-bottom:24px">Yuk, eksplorasi bank materi gamifikasi untuk kelasmu!</p>
            <a href="javascript:void(0)" onclick="showPage('gamifikasi')" style="background:#4f46e5; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:700;">Kembali ke Gamifikasi</a>
          </div>
        `;
        gvgUpdateSummary();
        return;
      }

      if (bottomBar) bottomBar.style.display = 'flex';
      if (tableHeader) tableHeader.style.display = 'grid';
      if (shopGroup) shopGroup.style.display = 'flex';

      container.innerHTML = cart.map((item, idx) => `
        <div style="padding:24px; border-bottom:1px solid #e2e8f0; display:grid; grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr; gap:20px; align-items:center">
          <div style="display:flex; align-items:center; gap:20px">
            <input type="checkbox" checked
              id="gvg-cb-item-${idx}"
              class="gvg-item-checkbox"
              data-id="${item.id}"
              data-price="${item.price}"
              data-qty="1"
              onchange="gvgUpdateSummary()"
              style="accent-color:#4f46e5; width:18px; height:18px; cursor:pointer">
            <div style="width:80px; height:80px; background:linear-gradient(45deg, #8b2fc9, #4f46e5); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:2rem; flex-shrink:0;">
              🎮
            </div>
            <div>
              <h4 style="font-size:15px; font-weight:800; margin-bottom:8px; color:#0f172a;">${item.title}</h4>
              <div style="display:flex; align-items:center; gap:6px; background:#f1f5f9; padding:4px 10px; border-radius:6px; font-size:11px; width:fit-content">
                <span style="color:#4f46e5; font-weight:700;">Tipe:</span> Materi Digital
              </div>
            </div>
          </div>
          <div style="text-align:center; font-weight:700; font-size:15px; color:#0f172a;">Rp${new Intl.NumberFormat('id-ID').format(item.price)}</div>
          <div style="display:flex; justify-content:center">
            <div style="display:flex; align-items:center; border:1px solid #e2e8f0; border-radius:6px; overflow:hidden">
              <button disabled style="width:32px; height:32px; background:#f8fafc; border:none; border-right:1px solid #e2e8f0; color:#cbd5e1; cursor:not-allowed">-</button>
              <div id="gvg-qty-val-${idx}" style="width:44px; text-align:center; font-weight:800; font-size:14px; color:#0f172a;">1</div>
              <button disabled style="width:32px; height:32px; background:#f8fafc; border:none; border-left:1px solid #e2e8f0; color:#cbd5e1; cursor:not-allowed">+</button>
            </div>
          </div>
          <div id="gvg-row-total-${idx}" style="text-align:center; font-weight:900; font-size:16px; color:#4f46e5">Rp${new Intl.NumberFormat('id-ID').format(item.price)}</div>
          <div style="text-align:center">
            <button onclick="gvgRemoveItem('${item.id}')" style="background:none; border:none; color:#ef4444; font-weight:700; cursor:pointer; font-size:13px">Hapus</button>
          </div>
        </div>
      `).join('');

      gvgUpdateSummary();
    }

    function gvgRemoveItem(id) {
      if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) return;
      let cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
      cart = cart.filter(i => String(i.id) !== String(id));
      localStorage.setItem(GVG_CART_KEY, JSON.stringify(cart));
      gvgRenderCart();
      gvgShowToast('Item dihapus dari keranjang', 'success');
    }

    function gvgHapusTerpilih() {
      const selected = Array.from(document.querySelectorAll('#page-cart-gamifikasi .gvg-item-checkbox:checked'));
      if (selected.length === 0) {
        gvgShowToast('Pilih item yang ingin dihapus terlebih dahulu!', 'error');
        return;
      }

      if (!confirm(`Apakah Anda yakin ingin menghapus ${selected.length} item terpilih dari keranjang?`)) return;

      let cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
      selected.forEach(cb => {
        cart = cart.filter(i => String(i.id) !== String(cb.dataset.id));
      });
      localStorage.setItem(GVG_CART_KEY, JSON.stringify(cart));
      gvgRenderCart();
      gvgShowToast(`${selected.length} item berhasil dihapus`, 'success');
    }

    async function gvgCheckoutCart() {
      const selected = Array.from(document.querySelectorAll('#page-cart-gamifikasi .gvg-item-checkbox:checked'));
      if (selected.length === 0) {
        gvgShowToast('Pilih materi gamifikasi terlebih dahulu!', 'error');
        return;
      }

      let cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
      const selectedIds = selected.map(cb => String(cb.dataset.id));

      try {
          const btn = document.querySelector('#gvgBottomBar button[onclick="gvgCheckoutCart()"]');
          if(btn) { btn.disabled = true; btn.innerText = 'Memproses...'; }

          const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_gamifikasi.php?action=checkout_cart', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ game_ids: selectedIds })
          });
          
          const data = await res.json();
          if(data.status === 'success') {
              // Sukses, update localStorage juga agar UI tetap sinkron tanpa refresh penuh
              let ownedGames = JSON.parse(localStorage.getItem(GVG_OWNED_KEY) || '[]');
              data.purchased.forEach(gid => {
                  if(!ownedGames.includes(gid)) ownedGames.push(gid);
              });
              localStorage.setItem(GVG_OWNED_KEY, JSON.stringify(ownedGames));
              
              // Sisakan yang tidak di-checkout di cart
              const cartRemaining = cart.filter(item => !selectedIds.includes(String(item.id)));
              localStorage.setItem(GVG_CART_KEY, JSON.stringify(cartRemaining));

              // Update UI secara real-time
              gvgRenderCart();
              if(btn) { btn.disabled = false; btn.innerText = 'Checkout'; }

              gvgShowToast('Pembayaran Berhasil! Mengalihkan ke Gamifikasi...', 'success');
              setTimeout(() => { showPage('gamifikasi'); }, 1500);
          } else {
              gvgShowToast(data.message || 'Gagal memproses checkout', 'error');
              if(btn) { btn.disabled = false; btn.innerText = 'Checkout'; }
          }
      } catch (err) {
          console.error(err);
          gvgShowToast('Terjadi kesalahan jaringan', 'error');
          const btn = document.querySelector('#gvgBottomBar button[onclick="gvgCheckoutCart()"]');
          if(btn) { btn.disabled = false; btn.innerText = 'Checkout'; }
      }
    }

    function gvgShowToast(msg, type = 'success') {
      const container = document.getElementById('gvgCartToastContainer');
      if (!container) return;
      const toast = document.createElement('div');
      toast.className = `gvg-toast ${type}`;

      const iconHtml = type === 'error'
        ? `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;

      toast.innerHTML = `<div class="gvg-toast-icon">${iconHtml}</div> <div>${msg}</div>`;
      container.appendChild(toast);

      setTimeout(() => { toast.classList.add('show'); }, 10);
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => { toast.remove(); }, 300);
      }, 3000);
    }

    // Expose render function globally (dipanggil oleh footer.php showPage)
    window.gvgRenderCart = gvgRenderCart;

    // Expose untuk update badge di dashboard Guru Mengajar
    window.gvgUpdateDashboardCartCount = function() {
      const cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
      const el = document.getElementById('gvgDashboardCartCount');
      if (el) el.textContent = cart.length;
    };

    // Initialize saat page pertama kali dimuat
    document.addEventListener('DOMContentLoaded', gvgRenderCart);
  </script>

  <div class="gvg-toast-container" id="gvgCartToastContainer"></div>
</div>
