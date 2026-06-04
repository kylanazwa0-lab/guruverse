<div class="page" id="page-cart">
  <div class="hero-section mb-6" style="padding:15px 24px;min-height:auto">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:15%;left:10%;--d:3s;--delay:0.1s"></span>
      <span style="top:40%;left:80%;--d:5s;--delay:0.5s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge">
        <span class="hero-badge-dot" style="background:var(--c-primary)"></span> Checkout Center
      </div>
      <h1 style="font-size:18px;margin-bottom:2px">Keranjang Saya</h1>
      <p style="font-size:12px;opacity:0.8">Selesaikan pembelian untuk koleksi digital pilihanmu.</p>
    </div>
  </div>

  <div class="card p-0 overflow-hidden" style="background:transparent; border:none; box-shadow:none">
    <!-- Table Header (Shopee Style) -->
    <div style="background:rgba(255,255,255,0.03); padding:15px 24px; border-radius:12px; display:grid; grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr; gap:20px; align-items:center; margin-bottom:12px; border:1px solid var(--c-border-light)">
      <div style="display:flex; align-items:center; gap:12px">
        <input type="checkbox" id="gvHeaderCheckbox" onchange="toggleSelectAll(this)" checked style="accent-color:var(--c-primary); width:18px; height:18px; cursor:pointer">
        <span style="font-size:13px; font-weight:700; color:var(--c-text-muted)">Produk</span>
      </div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:var(--c-text-muted)">Harga Satuan</div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:var(--c-text-muted)">Kuantitas</div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:var(--c-text-muted)">Total Harga</div>
      <div style="text-align:center; font-size:13px; font-weight:700; color:var(--c-text-muted)">Aksi</div>
    </div>

    <!-- Shop Group (Guruverse Official) -->
    <div style="background:var(--c-bg-card); border-radius:12px; border:1px solid var(--c-border-light); margin-bottom:100px">
      <div style="padding:15px 24px; border-bottom:1px solid var(--c-border-light); display:flex; align-items:center; gap:10px">
        <input type="checkbox" id="gvShopCheckbox" onchange="toggleSelectAll(this)" checked style="accent-color:var(--c-primary); width:18px; height:18px; cursor:pointer">
        <span style="background:var(--c-primary); color:#fff; font-size:10px; font-weight:900; padding:2px 6px; border-radius:4px">MEMBER</span>
        <span style="font-size:14px; font-weight:800">Guruverse Official Store</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--c-primary)"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      </div>

      <div id="gvFullCartList">
        <!-- JS will populate this -->
      </div>
    </div>
  </div>

  <!-- Bottom Sticky Bar (Shopee Style) -->
  <div style="position:fixed; bottom:20px; left:280px; right:40px; background:var(--c-bg-card); border:1px solid var(--c-border-light); border-radius:16px; padding:12px 24px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 -10px 30px rgba(0,0,0,0.3); z-index:100; backdrop-filter:blur(10px)">
    <div style="display:flex; align-items:center; gap:20px">
      <label style="display:flex; align-items:center; gap:10px; cursor:pointer">
        <input type="checkbox" id="gvBottomCheckbox" onchange="toggleSelectAll(this)" checked style="accent-color:var(--c-primary); width:18px; height:18px; cursor:pointer">
        <span style="font-size:13px; font-weight:700">Pilih Semua (<span id="gvCartSelectedCount">0</span>)</span>
      </label>
      <button style="background:none; border:none; color:var(--c-danger); font-size:13px; font-weight:700; cursor:pointer">Hapus</button>
    </div>

    <div style="display:flex; align-items:center; gap:24px">
      <div style="text-align:right">
        <div style="font-size:12px; font-weight:600; color:var(--c-text-muted); line-height:1">Total (<span id="gvCartTotalQty">0</span> produk):</div>
        <div style="font-size:20px; font-weight:900; color:var(--c-primary)" id="gvCartFullTotal">Rp0</div>
      </div>
      <button onclick="checkoutGvCart()" style="background:var(--c-primary); color:#fff; border:none; padding:12px 36px; border-radius:10px; font-weight:900; font-size:15px; cursor:pointer; transition:all 0.2s; box-shadow:0 6px 15px rgba(108, 92, 231, 0.3)">
        Checkout
      </button>
    </div>
  </div>

  <script>
    function updateSummary() {
      const itemCheckboxes = document.querySelectorAll('.gv-cart-item-checkbox');
      const masterCheckboxes = [
        document.getElementById('gvHeaderCheckbox'),
        document.getElementById('gvShopCheckbox'),
        document.getElementById('gvBottomCheckbox')
      ];
      
      const selectedCountEl = document.getElementById('gvCartSelectedCount');
      const totalQtyEl = document.getElementById('gvCartTotalQty');
      const fullTotalEl = document.getElementById('gvCartFullTotal');
      
      let selectedCount = 0;
      let totalPrice = 0;
      
      itemCheckboxes.forEach(cb => {
        if (cb.checked) {
          selectedCount++;
          totalPrice += parseFloat(cb.dataset.price);
        }
      });
      
      // Update masters state
      const allChecked = itemCheckboxes.length > 0 && selectedCount === itemCheckboxes.length;
      masterCheckboxes.forEach(m => { if(m) m.checked = allChecked; });
      
      selectedCountEl.textContent = selectedCount;
      totalQtyEl.textContent = selectedCount;
      fullTotalEl.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(totalPrice);
    }

    function toggleSelectAll(masterCb) {
      const itemCheckboxes = document.querySelectorAll('.gv-cart-item-checkbox');
      const isChecked = masterCb.checked;
      
      itemCheckboxes.forEach(cb => cb.checked = isChecked);
      updateSummary();
    }

    function renderFullCart() {
      const container = document.getElementById('gvFullCartList');
      const cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      
      if (cart.length === 0) {
        container.innerHTML = `
          <div style="padding:80px 20px; text-align:center">
            <div style="width:80px; height:80px; background:rgba(255,255,255,0.05); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:0.3"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            </div>
            <h3 style="font-size:18px; font-weight:800; margin-bottom:8px">Keranjang Belanja Kosong</h3>
            <p style="color:var(--c-text-muted); font-size:14px; margin-bottom:24px">Yuk, cari e-book pendidikan terbaik untuk koleksimu!</p>
            <button class="btn btn-primary" onclick="showPage('perpustakaan')">Cari Produk Sekarang</button>
          </div>
        `;
        updateSummary();
        return;
      }

      container.innerHTML = cart.map((item, idx) => {
        return `
          <div style="padding:24px; border-bottom:1px solid var(--c-border-light); display:grid; grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr; gap:20px; align-items:center">
            <div style="display:flex; align-items:center; gap:20px">
              <input type="checkbox" checked class="gv-cart-item-checkbox" data-price="${item.price}" onchange="updateSummary()" style="accent-color:var(--c-primary); width:18px; height:18px; cursor:pointer">
              <img src="${item.image_url}" style="width:80px; height:110px; border-radius:8px; object-fit:cover; border:1px solid var(--c-border-light)">
              <div>
                <h4 style="font-size:15px; font-weight:800; margin-bottom:8px">${item.title}</h4>
                <div style="display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.05); padding:4px 10px; border-radius:6px; font-size:11px; width:fit-content">
                  <span style="color:var(--c-primary)">Variasi:</span> E-Book Digital
                </div>
              </div>
            </div>
            <div style="text-align:center; font-weight:700; font-size:15px">${item.price_formatted}</div>
            <div style="display:flex; justify-content:center">
              <div style="display:flex; align-items:center; border:1px solid var(--c-border-light); border-radius:6px; overflow:hidden">
                <button style="width:32px; height:32px; background:transparent; border:none; border-right:1px solid var(--c-border-light); color:#fff; cursor:pointer">-</button>
                <div style="width:44px; text-align:center; font-weight:800; font-size:14px">1</div>
                <button style="width:32px; height:32px; background:transparent; border:none; border-left:1px solid var(--c-border-light); color:#fff; cursor:pointer">+</button>
              </div>
            </div>
            <div style="text-align:center; font-weight:900; font-size:16px; color:var(--c-primary)">${item.price_formatted}</div>
            <div style="text-align:center">
              <button onclick="removeAndRefreshCart(${idx})" style="background:none; border:none; color:var(--c-danger); font-weight:700; cursor:pointer; font-size:13px">Hapus</button>
            </div>
          </div>
        `;
      }).join('');

      updateSummary();
    }

    function removeAndRefreshCart(idx) {
      let cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      cart.splice(idx, 1);
      localStorage.setItem('gv_cart', JSON.stringify(cart));
      renderFullCart();
    }

    function checkoutGvCart() {
      const selected = Array.from(document.querySelectorAll('.gv-cart-item-checkbox:checked'));
      if (selected.length === 0) {
        alert('Pilih produk terlebih dahulu!');
        return;
      }
      // For now, redirect to first selected item
      const cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      const firstIdx = Array.from(document.querySelectorAll('.gv-cart-item-checkbox')).findIndex(cb => cb.checked);
      if (firstIdx !== -1) window.open(cart[firstIdx].checkout_url, '_blank');
    }

    // Initialize
    renderFullCart();
  </script>
</div>
</div>
