<style>
/* Toast Notification */
.gv-toast-container {
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
.gv-toast {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  color: var(--c-text);
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
  border: 1px solid var(--c-border-light);
}
[data-theme="dark"] .gv-toast { background: var(--c-card); }
.gv-toast.show { transform: translateY(0); opacity: 1; }
.gv-toast.error { border-left: 4px solid var(--c-danger); }
.gv-toast.success { border-left: 4px solid var(--c-success); }
.gv-toast-icon { font-size: 18px; display: flex; align-items: center; }
.gv-toast.error .gv-toast-icon { color: var(--c-danger); }
.gv-toast.success .gv-toast-icon { color: var(--c-success); }
</style>

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
  <div style="position:fixed; bottom:20px; left:280px; right:40px; background:var(--c-card, #1e1b4b); border:1px solid var(--c-border-light); border-radius:16px; padding:12px 24px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 -10px 30px rgba(0,0,0,0.4); z-index:100;">
    <div style="display:flex; align-items:center; gap:20px">
      <label style="display:flex; align-items:center; gap:10px; cursor:pointer">
        <input type="checkbox" id="gvBottomCheckbox" onchange="toggleSelectAll(this)" checked style="accent-color:var(--c-primary); width:18px; height:18px; cursor:pointer">
        <span style="font-size:13px; font-weight:700">Pilih Semua (<span id="gvCartSelectedCount">0</span>)</span>
      </label>
      <button onclick="deleteSelectedItems()" style="background:none; border:none; color:var(--c-danger); font-size:13px; font-weight:700; cursor:pointer">Hapus</button>
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
      let totalQty = 0;
      let totalPrice = 0;
      
      itemCheckboxes.forEach(cb => {
        if (cb.checked) {
          selectedCount++;
          const qty = parseInt(cb.dataset.qty || 1);
          totalQty += qty;
          totalPrice += parseFloat(cb.dataset.price) * qty;
        }
      });
      
      // Update masters state
      const allChecked = itemCheckboxes.length > 0 && selectedCount === itemCheckboxes.length;
      masterCheckboxes.forEach(m => { if(m) m.checked = allChecked; });
      
      selectedCountEl.textContent = selectedCount;
      totalQtyEl.textContent = totalQty;
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
              <input type="checkbox" checked id="cb-item-${idx}" class="gv-cart-item-checkbox" data-price="${item.price}" data-qty="${item.qty || 1}" onchange="updateSummary()" style="accent-color:var(--c-primary); width:18px; height:18px; cursor:pointer">
              <img src="/guruverse/asset/img/${item.image_url}" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22300%22%20height%3D%22400%22%20viewBox%3D%220%200%20300%20400%22%3E%3Crect%20width%3D%22300%22%20height%3D%22400%22%20fill%3D%22%231e293b%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20fill%3D%22%23ffffff%22%20font-family%3D%22sans-serif%22%20font-size%3D%2224%22%20font-weight%3D%22bold%22%3EE-Book%3C%2Ftext%3E%3C%2Fsvg%3E'" style="width:80px; height:110px; border-radius:8px; object-fit:cover; border:1px solid var(--c-border-light)">
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
                <button onclick="updateCartQty(${idx}, -1)" style="width:32px; height:32px; background:transparent; border:none; border-right:1px solid var(--c-border-light); color:var(--c-text); cursor:pointer">-</button>
                <div id="qty-val-${idx}" style="width:44px; text-align:center; font-weight:800; font-size:14px">${item.qty || 1}</div>
                <button onclick="updateCartQty(${idx}, 1)" style="width:32px; height:32px; background:transparent; border:none; border-left:1px solid var(--c-border-light); color:var(--c-text); cursor:pointer">+</button>
              </div>
            </div>
            <div id="row-total-${idx}" style="text-align:center; font-weight:900; font-size:16px; color:var(--c-primary)">Rp${new Intl.NumberFormat('id-ID').format(item.price * (item.qty || 1))}</div>
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

    function updateCartQty(idx, change) {
      let cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      if (!cart[idx].qty) cart[idx].qty = 1;
      cart[idx].qty += change;
      if (cart[idx].qty < 1) cart[idx].qty = 1; // Minimum quantity is 1
      localStorage.setItem('gv_cart', JSON.stringify(cart));
      
      // Update DOM manually to avoid re-rendering entire list and losing checkbox states
      const qtyEl = document.getElementById('qty-val-' + idx);
      const rowTotalEl = document.getElementById('row-total-' + idx);
      const checkbox = document.getElementById('cb-item-' + idx);
      
      if (qtyEl && rowTotalEl && checkbox) {
        qtyEl.textContent = cart[idx].qty;
        rowTotalEl.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(cart[idx].price * cart[idx].qty);
        checkbox.dataset.qty = cart[idx].qty;
        updateSummary();
      }
    }

    function checkoutGvCart() {
      const checkedCbs = Array.from(document.querySelectorAll('.gv-cart-item-checkbox:checked'));
      if (checkedCbs.length === 0) {
        showCartToast('Pilih produk terlebih dahulu!', 'error');
        return;
      }
      
      const allCbs = Array.from(document.querySelectorAll('.gv-cart-item-checkbox'));
      const cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      const selectedItems = checkedCbs.map(cb => {
        const idx = allCbs.indexOf(cb);
        return cart[idx];
      }).filter(Boolean);

      // Separate free vs paid
      const freeItems = selectedItems.filter(item => item.price == 0 || item.is_free == 1);
      const paidItems = selectedItems.filter(item => item.price > 0 && !item.is_free);

      // Process free items: download each
      freeItems.forEach(item => {
        if (item.pdf_url && item.pdf_url !== 'null' && item.pdf_url.trim() !== '') {
          const link = document.createElement('a');
          link.href = item.pdf_url;
          link.target = '_blank';
          link.download = item.title + '.pdf';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        } else {
          showCartToast('File "' + item.title + '" belum tersedia. Hubungi Admin.', 'error');
        }
      });

      if (freeItems.length > 0) {
        showCartToast(freeItems.length + ' produk gratis sedang dibuka...', 'success');
      }

      // Process paid items: open checkout URL for each
      paidItems.forEach(item => {
        if (!item.checkout_url || item.checkout_url === 'null' || item.checkout_url.trim() === '') {
          showCartToast('Link bayar "' + item.title + '" belum tersedia. Hubungi Admin.', 'error');
        } else {
          window.open(item.checkout_url, '_blank');
        }
      });
    }

    function deleteSelectedItems() {
      const allCbs = Array.from(document.querySelectorAll('.gv-cart-item-checkbox'));
      const checkedIdxs = allCbs.map((cb, i) => cb.checked ? i : -1).filter(i => i >= 0).reverse();
      if (checkedIdxs.length === 0) {
        showCartToast('Pilih produk yang ingin dihapus.', 'error');
        return;
      }
      let cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      checkedIdxs.forEach(i => cart.splice(i, 1));
      localStorage.setItem('gv_cart', JSON.stringify(cart));
      showCartToast(checkedIdxs.length + ' produk dihapus dari keranjang.', 'success');
      renderFullCart();
    }

    function showCartToast(msg, type = 'success') {
      const container = document.getElementById('gvCartToastContainer');
      if (!container) return;
      const toast = document.createElement('div');
      toast.className = `gv-toast ${type}`;
      
      const iconHtml = type === 'error' 
        ? `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;
        
      toast.innerHTML = `<div class="gv-toast-icon">${iconHtml}</div> <div>${msg}</div>`;
      container.appendChild(toast);
      
      setTimeout(() => { toast.classList.add('show'); }, 10);
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => { toast.remove(); }, 300);
      }, 3000);
    }

    // Initialize
    renderFullCart();
  </script>
  
  <div class="gv-toast-container" id="gvCartToastContainer"></div>
</div>
