<?php
// ── Query E-Book (hanya dimuat dari halaman ini) ─────────────────────────
$ebooks = [];
$res = $conn->query("SELECT * FROM products WHERE type = 'ebook' ORDER BY created_at DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $row['price_formatted'] = 'Rp' . number_format($row['price'], 0, ',', '.');
        $ebooks[] = $row;
    }
}
?>
<style>
  .gv-cart-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
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
          <div style="height:260px; position:relative; overflow:hidden; background:var(--c-bg)">
            <img src="<?= htmlspecialchars($eb['image_url']) ?>" alt="<?= htmlspecialchars($eb['title']) ?>" 
                 style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;" class="group-hover:scale-110">
            <div style="position:absolute; top:12px; right:12px; background:var(--c-primary); color:#fff; font-size:10px; font-weight:800; padding:4px 10px; border-radius:20px; backdrop-filter:blur(4px)">
              E-BOOK
            </div>
          </div>
          <div style="padding:16px;">
            <h3 style="font-size:14px; font-weight:700; margin-bottom:8px; height:40px; overflow:hidden; line-height:1.4">
              <?= htmlspecialchars($eb['title']) ?>
            </h3>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px">
              <span style="font-weight:800; color:var(--c-primary); font-size:15px"><?= $eb['is_free'] ? 'GRATIS' : $eb['price_formatted'] ?></span>
              <?php if ($eb['is_free'] && !empty($eb['pdf_url'])): ?>
                <a href="<?= htmlspecialchars($eb['pdf_url']) ?>" download="<?= htmlspecialchars($eb['title']) ?>.pdf" 
                   style="padding:6px 12px; border-radius:8px; background:rgba(16,185,129,0.1); color:#10b981; font-size:11px; font-weight:800; display:flex; align-items:center; gap:6px; transition:all 0.2s"
                   class="hover:bg-success hover:text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                  Baca
                </a>
              <?php else: ?>
                <button onclick='addToGvCart(<?= json_encode($eb) ?>)' class="gv-btn-add-cart">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <script>
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
        alert('Produk sudah ada di keranjang!');
        return;
      }
      cart.push(item);
      localStorage.setItem('gv_cart', JSON.stringify(cart));
      updateGvCartUI();
      
      // Animation effect
      const btn = event.currentTarget;
      btn.style.background = 'var(--c-primary)';
      btn.style.color = '#fff';
      setTimeout(() => {
        btn.style.background = '';
        btn.style.color = '';
      }, 500);
    }

    // Init UI
    updateGvCartUI();
  </script>
</div><!-- /page-perpustakaan -->
