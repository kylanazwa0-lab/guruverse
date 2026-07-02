<?php
// ── Query E-Book dari tabel products (hanya dimuat dari halaman ini) ──────
$ebooks = [];
$stmt_eb = $conn->prepare("SELECT id, title, price, image_url, pdf_url, category, is_free, author FROM products WHERE type = 'ebook' AND status = 'published' ORDER BY created_at DESC");
$stmt_eb->execute();
$res_eb = $stmt_eb->get_result();
if ($res_eb) {
    while ($row = $res_eb->fetch_assoc()) {
        $row['price_formatted'] = 'Rp' . number_format($row['price'], 0, ',', '.');
        $ebooks[] = $row;
    }
}
$stmt_eb->close();
?>
<style>
  .gv-cart-float {
    position: fixed;
    bottom: 96px;
    right: 24px;
    width: 64px;
    height: 64px;
    background: var(--c-primary); 
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 8px 24px rgba(108, 92, 231, 0.4);
    cursor: pointer;
    z-index: 1000;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: none;
  }
  .gv-cart-float:hover { transform: scale(1.1); box-shadow: 0 12px 32px rgba(108, 92, 231, 0.5); }
  .gv-cart-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #fff;
    color: var(--c-primary);
    font-size: 12px;
    font-weight: 800;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--c-primary);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  .gv-btn-add-cart { 
    width: 32px; height: 32px; border-radius: 8px; background: rgba(108, 92, 231, 0.1); color: var(--c-primary); 
    display: flex; align-items: center; justify-content: center; transition: all 0.2s; border: none; cursor: pointer;
  }
  .gv-btn-add-cart:hover { background: var(--c-primary); color: #fff; }
  
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
  [data-theme="dark"] .gv-toast {
    background: var(--c-card);
  }
  .gv-toast.show { transform: translateY(0); opacity: 1; }
  .gv-toast.error { border-left: 4px solid var(--c-danger); }
  .gv-toast.success { border-left: 4px solid var(--c-success); }
  .gv-toast-icon { font-size: 18px; display: flex; align-items: center; }
  .gv-toast.error .gv-toast-icon { color: var(--c-danger); }
  .gv-toast.success .gv-toast-icon { color: var(--c-success); }

  /* Solid Modal Background */
  .gv-modal-solid {
    background: #ffffff !important;
  }
  [data-theme="dark"] .gv-modal-solid {
    background: #1e293b !important;
  }
</style>

<div class="page" id="page-perpustakaan">
  <!-- Cart Float Button (Direct to Cart Page) -->
  <button class="gv-cart-float" onclick="showPage('cart')">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
    <div class="gv-cart-count" id="gvCartCount">0</div>
  </button>

  <div class="hero-section mb-16" style="padding:20px 24px;min-height:auto">
    <div class="hero-stars" aria-hidden="true">
      <span style="top:15%;left:10%;--d:3s;--delay:0.1s"></span>
      <span style="top:40%;left:80%;--d:5s;--delay:0.5s"></span>
      <span style="top:75%;left:25%;--d:4.5s;--delay:1.2s"></span>
    </div>
    <div class="hero-text">
      <div class="hero-badge">
        <span class="hero-badge-dot" style="background:var(--c-primary)"></span> Marketplace
      </div>
      <h1 style="font-size:20px;margin-bottom:4px">Jendela Dunia</h1>
      <p style="font-size:13px">Koleksi referensi & e-book terbaik. Pilih materi favoritmu dan selesaikan di keranjang belanja.</p>
    </div>
  </div>

  <?php if (empty($ebooks)): ?>
    <div class="empty-state-card" style="margin-top:20px">
      <div class="empty-state-icon-wrap" style="background:rgba(108, 92, 231, 0.1);color:var(--c-primary)">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
        </svg>
      </div>
      <h2 class="t-h2" style="margin-bottom:12px">Segera Hadir: Perpustakaan Digital</h2>
      <p class="t-body t-muted" style="max-width:480px;margin:0 auto 32px">
        Kami sedang mengurasi ribuan koleksi literasi pendidikan untuk membantu Anda memperluas cakrawala pengetahuan. Pantau terus perkembangannya!
      </p>
      <button class="btn btn-primary" onclick="showPage('dashboard')">
        <i class="ti ti-arrow-left" style="margin-right:8px"></i> Kembali ke Dashboard
      </button>
    </div>
  <?php else: ?>
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:20px;">
      <?php foreach ($ebooks as $eb): ?>
        <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all" style="border:1px solid var(--c-border-light)">
            <div style="position:relative; width:100%; height:220px; background:var(--c-bg-card); display:flex; align-items:center; justify-content:center; overflow:hidden">
              <img src="/guruverse/asset/img/<?= htmlspecialchars($eb['image_url']) ?>" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22300%22%20height%3D%22400%22%20viewBox%3D%220%200%20300%20400%22%3E%3Crect%20width%3D%22300%22%20height%3D%22400%22%20fill%3D%22%231e293b%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%20fill%3D%22%23ffffff%22%20font-family%3D%22sans-serif%22%20font-size%3D%2224%22%20font-weight%3D%22bold%22%3EE-Book%3C%2Ftext%3E%3C%2Fsvg%3E'" alt="<?= htmlspecialchars($eb['title']) ?>" 
                   style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;" class="group-hover:scale-110">
            <div style="position:absolute; top:12px; right:12px; background:var(--c-primary); color:#fff; font-size:10px; font-weight:800; padding:4px 10px; border-radius:20px; backdrop-filter:blur(4px)">
              E-BOOK
            </div>
          </div>
          <div style="padding:14px 16px;">
            <h3 style="font-size:14px; font-weight:700; margin:0 0 14px 0; min-height:38px; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; line-height:1.4; color:var(--c-text)">
              <?= htmlspecialchars($eb['title']) ?>
            </h3>
            <!-- Card Footer: konsisten untuk semua tipe -->
            <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; padding-top:12px; border-top:1px solid var(--c-border-light)">
              <!-- Kiri: badge harga -->
              <div style="flex-shrink:0">
                <?php if ($eb['is_free']): ?>
                  <span style="display:inline-flex; align-items:center; gap:5px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#059669; font-size:0.73rem; font-weight:800; padding:5px 11px; border-radius:20px; text-transform:uppercase; letter-spacing:0.4px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Gratis
                  </span>
                <?php else: ?>
                  <span style="font-size:1rem; font-weight:900; color:var(--c-text)"><?= $eb['price_formatted'] ?></span>
                <?php endif; ?>
              </div>
              <!-- Kanan: tombol aksi -->
              <div style="flex-shrink:0">
                <?php if ($eb['is_free']): ?>
                  <button
                    onclick="openEbookAccessModal('<?= htmlspecialchars(addslashes($eb['pdf_url'] ?? '')) ?>', '<?= htmlspecialchars(addslashes($eb['title'])) ?>')"
                    style="background:linear-gradient(135deg,#10b981,#059669); color:#fff; border:none; padding:9px 16px; border-radius:10px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:6px; font-size:0.8rem; box-shadow:0 4px 12px rgba(16,185,129,0.3); transition:all 0.2s; white-space:nowrap;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Akses Gratis
                  </button>
                <?php else: ?>
                  <button
                    onclick='addToGvCart(<?= json_encode($eb) ?>)'
                    style="background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; border:none; padding:9px 16px; border-radius:10px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:6px; font-size:0.8rem; box-shadow:0 4px 12px rgba(79,70,229,0.3); transition:all 0.2s; white-space:nowrap;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Beli
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <script>
    // ── Modal Akses Gratis E-Book ──
    let _ebModalPdfUrl = '', _ebModalTitle = '';

    function openEbookAccessModal(pdfUrl, title) {
      _ebModalPdfUrl = pdfUrl;
      _ebModalTitle  = title;
      document.getElementById('ebModalTitle').textContent = title;

      // Tampilkan/sembunyikan tombol download sesuai ketersediaan PDF
      const hasPdf = pdfUrl && pdfUrl.trim() !== '';
      document.getElementById('ebModalDownloadBtn').style.display = hasPdf ? 'flex' : 'none';
      document.getElementById('ebModalReadBtn').style.display     = hasPdf ? 'flex' : 'none';
      document.getElementById('ebModalNoPdf').style.display       = hasPdf ? 'none'  : 'block';

      const overlay = document.getElementById('ebAccessModalOverlay');
      overlay.style.display = 'flex';
      setTimeout(() => {
        overlay.style.opacity = '1';
        overlay.querySelector('.eb-modal-box').style.transform = 'translateY(0) scale(1)';
      }, 10);
    }

    function closeEbookModal() {
      const overlay = document.getElementById('ebAccessModalOverlay');
      overlay.style.opacity = '0';
      overlay.querySelector('.eb-modal-box').style.transform = 'translateY(20px) scale(0.96)';
      setTimeout(() => { overlay.style.display = 'none'; }, 280);
    }

    function ebReadOnline() {
      closeEbookModal();
      
      const ext = _ebModalPdfUrl.split('.').pop().toLowerCase();
      const isOfficeFile = ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'].includes(ext);
      
      if (isOfficeFile) {
          let absoluteUrl = _ebModalPdfUrl.startsWith('http') ? _ebModalPdfUrl : window.location.origin + _ebModalPdfUrl;
          window.open('https://docs.google.com/viewer?url=' + encodeURIComponent(absoluteUrl) + '&embedded=true', '_blank');
      } else {
          window.open('/guruverse/guru-belajar/member/read_book.php?url=' + encodeURIComponent(_ebModalPdfUrl) + '&title=' + encodeURIComponent(_ebModalTitle), '_blank');
      }
    }

    function ebDownload() {
      closeEbookModal();
      confirmGvDownload(_ebModalPdfUrl, _ebModalTitle);
    }

    function updateGvCartUI() {
      const cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      const count = cart.length;
      const countEl = document.getElementById('gvCartCount');
      if(countEl) {
        countEl.textContent = count;
        countEl.style.display = count > 0 ? 'flex' : 'none';
      }
    }

    function addToGvCart(item) {
      let cart = JSON.parse(localStorage.getItem('gv_cart') || '[]');
      if (cart.find(i => i.id === item.id)) {
        showGvToast('Produk sudah ada di keranjang!', 'error');
        return;
      }
      cart.push(item);
      localStorage.setItem('gv_cart', JSON.stringify(cart));
      updateGvCartUI();
      
      showGvToast('Berhasil ditambahkan ke keranjang!', 'success');
      
      // Animation effect
      const btn = event.currentTarget;
      btn.style.background = 'var(--c-primary)';
      btn.style.color = '#fff';
      setTimeout(() => {
        btn.style.background = '';
        btn.style.color = '';
      }, 500);
    }

    function showGvToast(msg, type = 'success') {
      const container = document.getElementById('gvToastContainer');
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

    // Confirm Download Modal Functions
    function confirmGvDownload(url, title) {
      document.getElementById('gvConfirmTitle').textContent = title;
      document.getElementById('gvConfirmDownloadBtn').onclick = function() {
        closeConfirmModal();
        const link = document.createElement('a');
        link.href = url;
        link.download = title + '.pdf';
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showGvToast('Mengunduh ' + title + '...', 'success');
      };
      document.getElementById('gvConfirmModal').style.display = 'flex';
    }
    function closeConfirmModal() {
      document.getElementById('gvConfirmModal').style.display = 'none';
    }

    // Init UI
    updateGvCartUI();
  </script>
  
  <div class="gv-toast-container" id="gvToastContainer"></div>

  <!-- ══ MODAL AKSES GRATIS E-BOOK ══ -->
  <div id="ebAccessModalOverlay" style="display:none; opacity:0; position:fixed; inset:0; background:rgba(15,23,42,0.55); backdrop-filter:blur(6px); z-index:9998; align-items:center; justify-content:center; transition:opacity 0.28s ease;" onclick="if(event.target===this) closeEbookModal()">
    <div class="eb-modal-box" style="background:#fff; border-radius:20px; padding:36px 32px; max-width:460px; width:90%; box-shadow:0 30px 80px rgba(0,0,0,0.25); transform:translateY(20px) scale(0.96); transition:transform 0.28s cubic-bezier(0.34,1.56,0.64,1);">
      
      <!-- Icon -->
      <div style="width:64px; height:64px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
      </div>

      <!-- Badge -->
      <div style="text-align:center; margin-bottom:12px;">
        <span style="background:#d1fae5; color:#059669; font-size:0.7rem; font-weight:800; padding:4px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">Konten Gratis</span>
      </div>

      <!-- Title -->
      <h3 id="ebModalTitle" style="font-size:1.1rem; font-weight:900; color:#0f172a; text-align:center; margin-bottom:6px; line-height:1.4;"></h3>
      <p style="text-align:center; color:#64748b; font-size:0.85rem; margin-bottom:24px;">Pilih cara mengakses materi ini:</p>

      <!-- No PDF notice -->
      <div id="ebModalNoPdf" style="display:none; text-align:center; padding:16px; background:#fef9c3; border-radius:12px; margin-bottom:20px; color:#854d0e; font-size:0.85rem; font-weight:700;">
        ⚠️ File PDF belum diunggah oleh Admin.
      </div>

      <!-- Choices -->
      <div id="ebModalReadBtn" style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
        <!-- Baca Online -->
        <button onclick="ebReadOnline()" style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:20px 16px; background:#eff6ff; border:2px solid #bfdbfe; border-radius:14px; cursor:pointer; transition:all 0.2s; font-weight:800; color:#2563eb; font-size:0.85rem;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#93c5fd'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe'; this.style.transform='translateY(0)'">
          <div style="width:44px; height:44px; background:linear-gradient(135deg,#3b82f6,#2563eb); border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
          </div>
          Baca Online
          <span style="font-size:0.72rem; font-weight:600; color:#93c5fd;">Langsung di browser</span>
        </button>

        <!-- Unduh PDF -->
        <button id="ebModalDownloadBtn" onclick="ebDownload()" style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:20px 16px; background:#f0fdf4; border:2px solid #bbf7d0; border-radius:14px; cursor:pointer; transition:all 0.2s; font-weight:800; color:#059669; font-size:0.85rem;" onmouseover="this.style.background='#dcfce7'; this.style.borderColor='#86efac'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='#f0fdf4'; this.style.borderColor='#bbf7d0'; this.style.transform='translateY(0)'">
          <div style="width:44px; height:44px; background:linear-gradient(135deg,#10b981,#059669); border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          </div>
          Unduh PDF
          <span style="font-size:0.72rem; font-weight:600; color:#6ee7b7;">Simpan ke perangkat</span>
        </button>
      </div>

      <!-- Cancel -->
      <button onclick="closeEbookModal()" style="width:100%; padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; font-weight:700; color:#64748b; font-size:0.85rem; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">Batal</button>
    </div>
  </div>

  <!-- Confirm Download Modal -->
  <div id="gvConfirmModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:10000; flex-direction:column; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(4px);">
    <div class="gv-modal-solid" style="width:100%; max-width:400px; border-radius:20px; padding:32px 24px; text-align:center; box-shadow:0 25px 50px rgba(0,0,0,0.3); border:1px solid var(--c-border-light);">
      <div style="width:64px; height:64px; background:rgba(16,185,129,0.1); color:#10b981; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      </div>
      <h3 style="margin:0 0 8px; font-size:18px; font-weight:800; color:var(--c-text);">Konfirmasi Unduhan</h3>
      <p style="margin:0 0 24px; font-size:14px; color:var(--c-text-muted); line-height:1.5;">Anda akan mengunduh <br><strong id="gvConfirmTitle" style="color:var(--c-text)"></strong></p>
      <div style="display:flex; gap:12px; justify-content:center;">
        <button onclick="closeConfirmModal()" style="flex:1; padding:12px; border-radius:10px; background:var(--c-bg); border:1px solid var(--c-border-light); color:var(--c-text); font-weight:700; cursor:pointer; transition:all 0.2s;">Batal</button>
        <button id="gvConfirmDownloadBtn" style="flex:1; padding:12px; border-radius:10px; background:var(--c-primary); border:none; color:#fff; font-weight:800; cursor:pointer; transition:all 0.2s; box-shadow:0 8px 20px rgba(108, 92, 231, 0.3);">Unduh PDF</button>
      </div>
    </div>
  </div>
</div><!-- /page-perpustakaan -->
