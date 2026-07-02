@extends('layouts.public')

@section('title', 'Keranjang Belanja | Guruverse')

@push('styles')
<style>
.cart-page {
    padding: 60px 0 120px;
    min-height: 80vh;
    background-color: var(--bg);
    color: var(--text);
}
.cart-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}
.cart-header-title {
    text-align: center;
    margin-bottom: 30px;
}
.cart-header-title h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: var(--primary);
}

/* TABLE LAYOUT */
.cart-table-wrapper {
    background: var(--card);
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    border: 1px solid var(--border);
    margin-bottom: 20px;
    overflow: hidden;
}
.cart-table-header {
    display: grid;
    grid-template-columns: 40px 3fr 1.5fr 1.5fr 1.5fr 1fr;
    padding: 15px 20px;
    background: var(--bg);
    border-bottom: 1px solid var(--border);
    font-weight: 600;
    color: var(--text-muted);
    font-size: 0.95rem;
    align-items: center;
}
.cart-item {
    display: grid;
    grid-template-columns: 40px 3fr 1.5fr 1.5fr 1.5fr 1fr;
    padding: 20px;
    border-bottom: 1px solid var(--border);
    align-items: center;
    transition: background 0.2s;
}
.cart-item:last-child {
    border-bottom: none;
}
.cart-item:hover {
    background: rgba(124, 58, 237, 0.02);
}

/* COLUMNS */
.col-check {
    display: flex;
    justify-content: flex-start;
}
.col-product {
    display: flex;
    align-items: center;
    gap: 15px;
}
.cart-item-img {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--border);
}
.cart-item-img.default-img {
    object-fit: contain;
    padding: 10px;
    background: linear-gradient(135deg, var(--card), var(--bg));
}
.cart-item-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--text);
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.col-price {
    font-weight: 500;
    color: var(--text);
}
.col-total {
    font-weight: 700;
    color: var(--primary);
}

/* CONTROLS */
.item-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: var(--primary);
}
.qty-controls {
    display: flex;
    align-items: center;
    border: 1px solid var(--border);
    border-radius: 4px;
    overflow: hidden;
    width: max-content;
}
.qty-btn {
    background: var(--bg);
    color: var(--text);
    border: none;
    padding: 5px 12px;
    cursor: pointer;
    font-weight: bold;
    font-size: 1rem;
    transition: all 0.2s;
}
.qty-btn:hover {
    background: var(--border);
}
.qty-input {
    width: 40px;
    text-align: center;
    background: transparent;
    border: none;
    border-left: 1px solid var(--border);
    border-right: 1px solid var(--border);
    color: var(--text);
    font-weight: 600;
    font-size: 0.95rem;
    padding: 5px 0;
    -moz-appearance: textfield;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.btn-remove-text {
    color: #ef4444;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    padding: 0;
}
.btn-remove-text:hover {
    text-decoration: underline;
}

/* STICKY BOTTOM BAR */
.cart-summary-sticky {
    position: sticky;
    bottom: 0;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
    z-index: 100;
    margin-top: 20px;
}
.summary-left {
    display: flex;
    align-items: center;
    gap: 20px;
}
.summary-right {
    display: flex;
    align-items: center;
    gap: 25px;
}
.summary-total {
    font-size: 1.2rem;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 10px;
}
.summary-total span {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--primary);
}
.btn-checkout {
    background: var(--primary);
    color: white;
    border: none;
    padding: 12px 40px;
    border-radius: 6px; /* Rectangular like Shopee */
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}
.btn-checkout:disabled {
    background: var(--border);
    color: var(--text-muted);
    cursor: not-allowed;
}
.btn-checkout:hover:not(:disabled) {
    background: var(--primary-dark);
}

/* GUEST FORM */
.guest-form {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
}

.empty-cart {
    text-align: center;
    padding: 60px 0;
    background: var(--card);
    border-radius: 12px;
    border: 1px solid var(--border);
    color: var(--text-muted);
}
.empty-cart svg {
    margin-bottom: 20px;
    opacity: 0.5;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .cart-table-header {
        display: none;
    }
    .cart-item {
        grid-template-columns: 40px 1fr;
        gap: 15px;
        padding: 15px;
    }
    .col-product {
        grid-column: 2;
    }
    .col-price {
        grid-column: 2;
        font-size: 1.1rem;
    }
    .col-qty {
        grid-column: 2;
    }
    .col-total {
        display: none; /* Hide total per item on mobile to save space */
    }
    .col-action {
        grid-column: 2;
        text-align: right;
    }
    .cart-summary-sticky {
        flex-direction: column;
        gap: 15px;
        padding: 15px;
    }
    .summary-left, .summary-right {
        width: 100%;
        justify-content: space-between;
    }
    .summary-right {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>
@endpush

@section('content')
<div class="cart-page">
    <div class="cart-container">
        
        <div style="margin-bottom: 20px;">
            <a href="{{ route('learn-more') }}#jendela-dunia" style="color: var(--primary); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali Belanja
            </a>
        </div>

        <div class="cart-header-title">
            <h1>Keranjang Belanja</h1>
            <p style="color:var(--text-muted)">Selesaikan pembelian Anda untuk segera mengakses materi Guruverse.</p>
        </div>

        @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(16,185,129,0.2);">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(239,68,68,0.2);">
            {{ session('error') }}
        </div>
        @endif

        @if(!$cart || $cart->items->isEmpty())
        <div class="empty-cart">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h2>Keranjang belanja Anda kosong</h2>
            <p style="margin-top: 10px; margin-bottom: 20px;">Silakan jelajahi produk menarik kami terlebih dahulu.</p>
            <a href="{{ route('learn-more') }}#jendela-dunia" class="btn-checkout" style="text-decoration:none; display:inline-block; border-radius: 50px;">Jelajahi Produk</a>
        </div>
        @else
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="cart-table-wrapper">
                <div class="cart-table-header">
                    <div class="col-check">
                        <input type="checkbox" id="select-all-header" class="item-checkbox" checked>
                    </div>
                    <div class="col-product">Produk</div>
                    <div class="col-price">Harga Satuan</div>
                    <div class="col-qty">Kuantitas</div>
                    <div class="col-total">Total Harga</div>
                    <div class="col-action">Aksi</div>
                </div>

                <div class="cart-table-body">
                    @php 
                        $isAuth = auth('web')->check();
                    @endphp
                    @foreach($cart->items as $item)
                    @php 
                        $price = $isAuth && $item->product->member_price !== null ? $item->product->member_price : $item->product->price;
                    @endphp
                    <div class="cart-item" id="item-row-{{ $item->id }}">
                        <div class="col-check">
                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox product-checkbox" data-price="{{ $price }}" checked>
                        </div>
                        
                        <div class="col-product">
                            <img src="{{ $item->product->image ?: asset('images/default-product.png') }}" alt="{{ $item->product->name }}" class="cart-item-img {{ $item->product->image ? '' : 'default-img' }}">
                            <div class="cart-item-title">{{ $item->product->name }}</div>
                        </div>
                        
                        <div class="col-price">
                            {{ $price == 0 ? 'Gratis' : 'Rp ' . number_format($price, 0, ',', '.') }}
                        </div>
                        
                        <div class="col-qty">
                            <div class="qty-controls">
                                <button type="button" class="qty-btn btn-minus" data-id="{{ $item->id }}">-</button>
                                <input type="number" class="qty-input" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" readonly>
                                <button type="button" class="qty-btn btn-plus" data-id="{{ $item->id }}">+</button>
                            </div>
                        </div>

                        <div class="col-total" id="row-total-{{ $item->id }}">
                            {{ $price == 0 ? 'Gratis' : 'Rp ' . number_format($price * $item->quantity, 0, ',', '.') }}
                        </div>
                        
                        <div class="col-action">
                            <button type="button" class="btn-remove-text" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();">Hapus</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if(!$isAuth)
            <div class="guest-form">
                <h3 style="margin-top: 0; color: var(--primary); font-size: 1.1rem; margin-bottom: 8px;">Informasi Pengiriman (Tamu)</h3>
                <p style="font-size: 0.9rem; margin-bottom: 20px; color: var(--text-muted); line-height: 1.5;">Silakan isi data Anda untuk pengiriman produk. Atau <a href="{{ route('login') }}" style="color:var(--primary); font-weight:bold; text-decoration:none;">Login</a> untuk mendapatkan harga spesial Member!</p>
                
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.9rem;">Nama Lengkap</label>
                    <input type="text" name="guest_name" required style="width: 100%; padding: 10px 12px; border-radius: 6px; border: 1px solid var(--border); background:var(--bg); color:var(--text); box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.9rem;">Email (Untuk akses E-Book/Webinar)</label>
                    <input type="email" name="guest_email" required style="width: 100%; padding: 10px 12px; border-radius: 6px; border: 1px solid var(--border); background:var(--bg); color:var(--text); box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:0.9rem;">No WhatsApp</label>
                    <input type="text" name="guest_phone" required style="width: 100%; padding: 10px 12px; border-radius: 6px; border: 1px solid var(--border); background:var(--bg); color:var(--text); box-sizing: border-box;">
                </div>
            </div>
            @endif

            <div class="cart-summary-sticky">
                <div class="summary-left">
                    <label style="cursor:pointer; display:flex; align-items:center; gap:8px; font-weight:600;">
                        <input type="checkbox" id="select-all-footer" class="item-checkbox" checked>
                        Pilih Semua
                    </label>
                </div>
                <div class="summary-right">
                    <div class="summary-total">
                        Total (<span id="total-items-text">0</span> Produk): <span id="total-price">Rp 0</span>
                    </div>
                    <button type="submit" class="btn-checkout" id="btn-checkout">Checkout</button>
                </div>
            </div>
        </form>

        @foreach($cart->items as $item)
        <form id="delete-form-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endforeach
        
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const headerCheckbox = document.getElementById('select-all-header');
    const footerCheckbox = document.getElementById('select-all-footer');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const totalPriceEl = document.getElementById('total-price');
    const totalItemsTextEl = document.getElementById('total-items-text');
    const btnCheckout = document.getElementById('btn-checkout');

    function formatRupiah(angka) {
        if (angka === 0) return 'Gratis';
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function calculateTotal() {
        let total = 0;
        let count = 0;
        let allChecked = true;

        productCheckboxes.forEach(cb => {
            if (cb.checked) {
                const price = parseFloat(cb.dataset.price);
                const qtyInput = document.getElementById('qty-' + cb.value);
                const qty = parseInt(qtyInput.value);
                
                total += (price * qty);
                count++;
            } else {
                allChecked = false;
            }
        });

        if (headerCheckbox) headerCheckbox.checked = productCheckboxes.length > 0 ? allChecked : false;
        if (footerCheckbox) footerCheckbox.checked = productCheckboxes.length > 0 ? allChecked : false;

        if (totalPriceEl) totalPriceEl.textContent = formatRupiah(total);
        if (totalItemsTextEl) totalItemsTextEl.textContent = count;
        
        if (btnCheckout) {
            btnCheckout.disabled = count === 0;
        }
    }

    function handleSelectAll(e) {
        const isChecked = e.target.checked;
        if (headerCheckbox) headerCheckbox.checked = isChecked;
        if (footerCheckbox) footerCheckbox.checked = isChecked;
        
        productCheckboxes.forEach(cb => {
            cb.checked = isChecked;
        });
        calculateTotal();
    }

    if (headerCheckbox) headerCheckbox.addEventListener('change', handleSelectAll);
    if (footerCheckbox) footerCheckbox.addEventListener('change', handleSelectAll);

    productCheckboxes.forEach(cb => {
        cb.addEventListener('change', calculateTotal);
    });

    function updateQtyAjax(cartItemId, newQty) {
        fetch('{{ route("cart.update_quantity") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                cart_item_id: cartItemId,
                quantity: newQty
            })
        }).catch(err => console.error('Error updating quantity:', err));
    }

    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const input = document.getElementById('qty-' + id);
            let val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                
                // Update row total text
                const cb = document.querySelector(`.product-checkbox[value="${id}"]`);
                const rowTotalEl = document.getElementById('row-total-' + id);
                if(cb && rowTotalEl) {
                    rowTotalEl.textContent = formatRupiah(parseFloat(cb.dataset.price) * (val - 1));
                }

                updateQtyAjax(id, val - 1);
                calculateTotal();
            }
        });
    });

    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const input = document.getElementById('qty-' + id);
            let val = parseInt(input.value);
            input.value = val + 1;
            
            // Update row total text
            const cb = document.querySelector(`.product-checkbox[value="${id}"]`);
            const rowTotalEl = document.getElementById('row-total-' + id);
            if(cb && rowTotalEl) {
                rowTotalEl.textContent = formatRupiah(parseFloat(cb.dataset.price) * (val + 1));
            }

            updateQtyAjax(id, val + 1);
            calculateTotal();
        });
    });

    // Initial calculation
    if (productCheckboxes.length > 0) {
        calculateTotal();
    }
});
</script>
@endpush
@endsection
