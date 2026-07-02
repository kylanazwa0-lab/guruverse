@extends('layouts.public')

@section('title', 'Semua Produk | Guruverse')

@push('styles')
<style>
/* ── PRODUCT GRID CSS ── */
.products-page {
  padding: 60px 0 60px;
  min-height: 80vh;
  background-color: var(--bg);
  color: var(--text);
}
.products-header {
  max-width: 1000px;
  margin: 0 auto 30px;
  padding: 0 20px;
  text-align: left;
}
.products-header h1 {
  font-size: 2.2rem;
  font-weight: 800;
  margin-bottom: 10px;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

/* SEARCH & FILTER BAR */
.tools-bar {
  max-width: 1000px;
  margin: 0 auto 30px;
  padding: 0 20px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
}
.search-wrapper {
  width: 320px;
  position: relative;
}
.search-input {
  width: 100%;
  padding: 12px 20px 12px 45px;
  border-radius: 50px;
  border: 1px solid var(--border);
  background: var(--card);
  color: var(--text);
  font-size: 0.95rem;
  box-sizing: border-box;
  outline: none;
  transition: all 0.3s;
}
.search-input:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}
.search-icon {
  position: absolute;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
}
.filter-pills {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  justify-content: center;
}
.filter-pill {
  padding: 8px 16px;
  border-radius: 50px;
  border: 1px solid var(--border);
  background: var(--card);
  color: var(--text-muted);
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.filter-pill:hover {
  border-color: var(--primary);
  color: var(--primary);
}
.filter-pill.active {
  background: var(--primary);
  color: white;
  border-color: var(--primary);
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 20px;
}
.product-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 12px;
  overflow: hidden;
  transition: all .3s;
  display: flex;
  flex-direction: column;
}
.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  border-color: rgba(124,58,237,.3);
}
.product-img-wrap {
  width: 100%;
  aspect-ratio: 4/5;
  overflow: hidden;
  background: var(--card);
  position: relative;
}
.product-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .5s;
}
.product-img-wrap img.default-img {
  object-fit: contain;
  padding: 2rem;
  background: linear-gradient(135deg, var(--card), var(--bg));
}
.product-card:hover .product-img-wrap img {
  transform: scale(1.05);
}
.product-badge {
  position: absolute;
  top: 8px;
  left: 8px;
  background: rgba(124,58,237, 0.9);
  color: #fff;
  font-size: 9px;
  font-weight: 700;
  padding: 4px 6px;
  border-radius: 12px;
  backdrop-filter: blur(4px);
  z-index: 2;
}
.product-body {
  padding: 12px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.product-author {
  font-size: 9px;
  color: var(--text-muted) !important;
  text-transform: uppercase;
  letter-spacing: .05em;
  font-weight: 700;
  margin-bottom: 4px;
}
.product-title {
  font-size: 13px;
  font-weight: 800;
  color: var(--text) !important;
  margin-bottom: 6px;
  line-height: 1.3;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.product-price {
  font-size: 13px;
  font-weight: 700;
  color: var(--text);
  margin-top: auto;
  margin-bottom: 10px;
}
.btn-buy {
  width: 100%;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: 700;
  background: transparent;
  color: #f8fafc;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  transition: all .2s;
}
.btn-buy:hover {
  background: rgba(255,255,255,.05);
}
.lm-reveal {
  opacity: 0;
  transform: translateY(20px);
  animation: revealUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
}
@keyframes revealUp {
  to { opacity: 1; transform: translateY(0); }
}
.hidden-product {
  display: none !important;
}
.no-results {
  text-align: center;
  grid-column: 1 / -1;
  padding: 40px;
  color: var(--text-muted);
}
@media (max-width: 768px) {
  .tools-bar {
    flex-direction: column;
    align-items: stretch;
  }
  .search-wrapper {
    width: 100%;
  }
  .filter-pills {
    justify-content: flex-start;
    overflow-x: auto;
    padding-bottom: 10px;
    flex-wrap: nowrap;
  }
  .filter-pill {
    white-space: nowrap;
  }
}
</style>
@endpush

@section('content')
<div class="products-page">
    <div class="products-header">
        <a href="{{ url('/') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-muted); text-decoration: none; font-weight: 600; margin-bottom: 20px; transition: color 0.2s; font-size: 0.95rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali ke Beranda
        </a><br>
        <h1>Semua Produk Guruverse</h1>
        <p style="color:var(--text-muted); font-size:0.95rem;">Jelajahi seluruh katalog E-Book, Pelatihan, dan Merchandise kami.</p>
    </div>

    <!-- SEARCH & FILTER BAR -->
    <div class="tools-bar">
        <div class="search-wrapper">
            <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari buku, pelatihan, merchandise...">
        </div>
        <div class="filter-pills">
            <button class="filter-pill active" data-filter="all">Semua</button>
            <button class="filter-pill" data-filter="e-book">E-Book</button>
            <button class="filter-pill" data-filter="pelatihan">Pelatihan</button>
            <button class="filter-pill" data-filter="merchandise">Merchandise</button>
        </div>
    </div>

    <!-- RECOMMENDED PRODUCT SECTION -->
    @if($products->count() > 0)
    <div class="recommended-section" style="max-width: 1000px; margin: 0 auto 40px; padding: 0 20px;">
        <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--text); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #f59e0b;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            Paling Direkomendasikan
        </h2>
        @php
            // Pick the first product as recommended, or random
            $recommended = $products->first();
        @endphp
        <div class="recommended-card" style="display: flex; background: var(--card); border: 1px solid var(--primary); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(124, 58, 237, 0.1); position: relative;">
            <div style="position: absolute; top: 15px; left: -30px; background: #f59e0b; color: white; padding: 5px 30px; font-size: 0.75rem; font-weight: 800; transform: rotate(-45deg); z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.2); letter-spacing: 1px;">BEST SELLER</div>
            
            <div class="rec-img" style="width: 250px; background: linear-gradient(135deg, var(--card), var(--bg)); border-right: 1px solid var(--border); position: relative;">
                <img src="{{ $recommended->image ?: asset('images/default-product.png') }}" style="width: 100%; height: 100%; object-fit: cover; {{ !$recommended->image ? 'padding: 2rem; object-fit: contain;' : '' }}">
            </div>
            
            <div class="rec-content" style="padding: 25px; flex: 1; display: flex; flex-direction: column; justify-content: center;">
                <span style="display: inline-block; padding: 4px 10px; background: rgba(124,58,237,0.1); color: var(--primary); border-radius: 50px; font-size: 0.75rem; font-weight: 700; margin-bottom: 12px; width: max-content;">Kategori: {{ ucfirst($recommended->type) }}</span>
                
                <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--text); margin-bottom: 8px; line-height: 1.3;">{{ $recommended->name }}</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 15px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">Buku / Pelatihan paling populer minggu ini. Jangan lewatkan kesempatan untuk mengakses materi terbaik Guruverse.</p>
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                    <div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Harga Spesial</div>
                        <div style="font-size: 1.4rem; font-weight: 800; color: {{ $recommended->price == 0 ? '#10b981' : '#f59e0b' }};">
                            {{ $recommended->price == 0 ? 'Gratis' : 'Rp ' . number_format($recommended->price, 0, ',', '.') }}
                        </div>
                    </div>
                    
                    <form action="{{ route('cart.add') }}" method="POST">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $recommended->id }}">
                      <button type="submit" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);">
                          Beli Sekarang
                      </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media(max-width: 768px) {
            .recommended-card { flex-direction: column; }
            .rec-img { width: 100% !important; height: 200px; border-right: none !important; border-bottom: 1px solid var(--border); }
            .rec-content { padding: 20px !important; }
        }
    </style>
    @endif

    <div class="products-grid" id="productsGrid">
        @foreach($products as $index => $product)
        <div class="product-card lm-reveal" data-type="{{ strtolower($product->type) }}" data-name="{{ strtolower($product->name) }}" style="animation-delay: {{ ($index % 8) * 0.1 }}s">
          <div class="product-img-wrap">
            <div class="product-badge" style="background: {{ $product->badge_color ?? 'rgba(124, 58, 237, 0.9)' }};">{{ $product->badge }}</div>
            <img src="{{ $product->image ?: asset('images/default-product.png') }}" alt="{{ $product->name }}" class="{{ $product->image ? '' : 'default-img' }}">
          </div>
          <div class="product-body">
            <div class="product-author">{{ $product->author }}</div>
            <h3 class="product-title">{{ $product->name }}</h3>
            <div class="product-price" style="color: {{ $product->price == 0 ? '#10b981' : '#f59e0b' }};">
                {{ $product->price == 0 ? 'Gratis' : 'Rp ' . number_format($product->price, 0, ',', '.') }}
            </div>
            
            <form action="{{ route('cart.add') }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              @if($product->price == 0)
              <button type="submit" class="btn-buy" style="color: #10b981; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Unduh
              </button>
              @else
              <button type="submit" class="btn-buy" style="color: #f59e0b; background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                Tambahkan
              </button>
              @endif
            </form>
          </div>
        </div>
        @endforeach
        
        <div id="noResults" class="no-results" style="display: none;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:15px; opacity:0.5;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <h3>Tidak ada produk yang cocok</h3>
            <p>Coba gunakan kata kunci lain atau pilih kategori "Semua".</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterPills = document.querySelectorAll('.filter-pill');
    const productCards = document.querySelectorAll('.product-card');
    const noResults = document.getElementById('noResults');
    let currentFilter = 'all';
    let currentSearch = '';

    function filterProducts() {
        let visibleCount = 0;
        
        productCards.forEach(card => {
            const type = card.dataset.type;
            const name = card.dataset.name;
            
            const matchesFilter = (currentFilter === 'all') || (type === currentFilter);
            const matchesSearch = name.includes(currentSearch);
            
            if (matchesFilter && matchesSearch) {
                card.classList.remove('hidden-product');
                visibleCount++;
            } else {
                card.classList.add('hidden-product');
            }
        });

        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', function(e) {
        currentSearch = e.target.value.toLowerCase();
        filterProducts();
    });

    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            // Update active state
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            
            // Update filter and run
            currentFilter = this.dataset.filter;
            filterProducts();
        });
    });
});
</script>
@endpush
@endsection
