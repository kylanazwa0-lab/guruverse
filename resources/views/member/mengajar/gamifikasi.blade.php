@extends('layouts.mengajar')

@section('title', 'Gamifikasi Pembelajaran')

@section('styles')
<style>
@keyframes gamifikasiStripes {
  from { background-position: 0 0; }
  to { background-position: 20px 0; }
}
@keyframes floatTrophy {
  0% { transform: translateY(0); }
  50% { transform: translateY(-8px); box-shadow:0 12px 30px rgba(245,158,11,.6); }
  100% { transform: translateY(0); }
}
.katalog-card {
  border-radius:14px;
  padding:20px;
  border:1px solid #e2e8f0;
  background:#fff;
  transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor:pointer;
  position:relative;
  top:0;
}
.katalog-card:hover {
  border-color:#cbd5e1;
  box-shadow:0 15px 30px rgba(0,0,0,0.08);
  top:-6px;
}
.katalog-card .locked-btn {
  transition:all 0.3s;
}
.katalog-card:hover .locked-btn {
  animation: shakeAlert 0.4s ease-in-out;
}
@keyframes shakeAlert {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-3px); }
  40%, 80% { transform: translateX(3px); }
}

/* ADMIN DESIGN SYSTEM PORTED TO MEMBER */
.admin-panel {
  background: var(--c-card,#ffffff);
  border-radius: 14px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.04);
  border: 1px solid var(--c-border,#e2e8f0);
  margin-bottom: 2rem;
  overflow: hidden;
}
.admin-panel-head {
  padding: 18px 24px;
  border-bottom: 1px solid var(--c-border,#e2e8f0);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: var(--c-bg,#f8fafc);
}
.admin-panel-title {
  font-weight: 800;
  font-size: 1.1rem;
  color: var(--c-text,#0f172a);
}
.admin-tbl-wrap {
  width: 100%;
  overflow-x: auto;
}
.admin-tbl-wrap table {
  width: 100%;
  border-collapse: collapse;
}
.admin-tbl-wrap th, .admin-tbl-wrap td {
  padding: 14px 24px;
  text-align: left;
  border-bottom: 1px solid var(--c-border-light,#f1f5f9);
  vertical-align: middle;
}
.admin-tbl-wrap th {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--c-text-muted,#64748b);
  font-weight: 700;
  background: rgba(0,0,0,0.015);
}
.admin-tbl-wrap tbody tr:hover {
  background: rgba(0,0,0,0.01);
}
.admin-btn-sm {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 700;
  cursor: pointer;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
}
.admin-btn-sm:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.admin-badge {
  font-size: 0.65rem;
  font-weight: 800;
  padding: 4px 10px;
  border-radius: 20px;
  text-transform: uppercase;
}
.admin-mono {
  font-family: monospace;
  font-weight: 700;
  color: var(--c-text-muted,#94a3b8);
}
</style>
@endsection

@section('content')
<div class="page active" id="page-gamifikasi">

  <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">
    <!-- KARTU STATS ALA ADMIN -->
    <div class="admin-panel" style="margin-bottom:0;">
        <div class="admin-panel-head">
            <span class="admin-panel-title">Statistik Anda</span>
        </div>
        <div style="padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div style="padding:16px; border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
                <div style="font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase;">Level Mengajar</div>
                <div style="font-size:1.8rem; font-weight:900; color:#4f46e5; margin:4px 0;">{{ $stats['level_saat_ini'] ?? 1 }}</div>
                <div style="font-size:0.75rem; color:#94a3b8; font-weight:600;">{{ $stats['total_xp'] ?? 0 }} XP Terkumpul</div>
            </div>
            <div style="padding:16px; border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
                <div style="font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase;">Streak Belajar</div>
                <div style="font-size:1.8rem; font-weight:900; color:#f59e0b; margin:4px 0;">{{ $stats['hari_streak'] ?? 0 }} Hari</div>
                <div style="font-size:0.75rem; color:#94a3b8; font-weight:600;">Konsistensi berturut-turut</div>
            </div>
        </div>
    </div>

    <!-- TANTANGAN KELAS (ADMIN TABLE STYLE) -->
    <div class="admin-panel" style="margin-bottom:0;">
        <div class="admin-panel-head">
            <span class="admin-panel-title">Tantangan Kelas Aktif</span>
        </div>
        <div class="admin-tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Tantangan</th>
                        <th style="text-align:center;">Progress</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($challenges as $i => $ch)
                    <tr>
                        <td><span class="admin-mono">{{ $i+1 }}</span></td>
                        <td>
                            <div style="font-weight:800; font-size:0.85rem; color:#1e293b;">{{ $ch['icon'] }} {{ htmlspecialchars($ch['name']) }}</div>
                            <div style="font-size:0.7rem; color:#64748b; margin-top:2px; font-weight:700; color:#4f46e5;">{{ $ch['xp'] }}</div>
                        </td>
                        <td style="text-align:center;">
                            <div style="font-size:0.75rem; font-weight:700; color:#475569; margin-bottom:4px;">{{ $ch['progress'] }} / {{ $ch['total'] }}</div>
                            <div style="width:100px; height:6px; background:#e2e8f0; border-radius:99px; overflow:hidden; margin:0 auto;">
                                <div style="height:100%; width:{{ $ch['total']>0 ? round($ch['progress']/$ch['total']*100) : 0 }}%; background:#10b981;"></div>
                            </div>
                        </td>
                        <td style="text-align:center;">
                            @if($ch['done'])
                            <span class="admin-badge" style="background:rgba(16,185,129,0.1); color:#10b981;">SELESAI</span>
                            @else
                            <span class="admin-badge" style="background:rgba(245,158,11,0.1); color:#f59e0b;">BERJALAN</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>

  <!-- KOMPETISI INOVASI PENDIDIK -->
  <div class="admin-panel" style="margin-top:24px;">
      <div class="admin-panel-head" style="background:linear-gradient(90deg, rgba(79,70,229,0.05), transparent);">
          <div style="display:flex; align-items:center; gap:12px;">
              <span class="admin-panel-title">Kompetisi Inovasi Pendidik</span>
          </div>
          <button onclick="window.location.href='{{ route('member.mengajar.gamifikasi.kirim-karya') }}'" class="admin-btn-sm" style="background:#10b981; color:#fff;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
              Kirim Karya Saya
          </button>
      </div>
      
      <div style="padding:24px;">
          <p style="color:#64748b; font-size:0.85rem; margin-top:0; margin-bottom:20px;">Bagikan karya terbaikmu (RPP, Modul Ajar, Rubrik) dan dapatkan dukungan dari guru lainnya. 3 Karya teratas akan mendapatkan hadiah spesial!</p>
          
          <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
              @php $rank=1; @endphp
              @foreach($karya_list as $k)
              @php
                  $medal = '';
                  if($rank == 1) $medal = '🥇';
                  else if($rank == 2) $medal = '🥈';
                  else if($rank == 3) $medal = '🥉';
                  $is_mine = ($k['member_id'] == $member->id);
              @endphp
              @if($rank <= 3)
              <div style="border:1px solid {{ $rank<=3 ? '#f59e0b' : '#e2e8f0' }}; border-radius:12px; padding:16px; background:{{ $rank<=3 ? 'rgba(245,158,11,0.02)' : '#fff' }}; position:relative; display:flex; flex-direction:column; justify-content:space-between;">
                  @if($rank<=3)
                  <div style="position:absolute; top:-12px; right:16px; font-size:24px; filter:drop-shadow(0 4px 6px rgba(0,0,0,0.1));">{{ $medal }}</div>
                  @endif
                  <div>
                      <div style="font-size:0.65rem; font-weight:800; color:#4f46e5; text-transform:uppercase; margin-bottom:4px;">{{ htmlspecialchars($k['jenis']) }}</div>
                      <div style="font-weight:800; font-size:1rem; color:#0f172a; margin-bottom:6px; line-height:1.3;">{{ htmlspecialchars($k['judul']) }}</div>
                      <div style="font-size:0.75rem; color:#64748b; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ htmlspecialchars($k['deskripsi']) }}</div>
                  </div>
                  
                  <div style="display:flex; justify-content:space-between; align-items:flex-end; border-top:1px dashed #e2e8f0; padding-top:12px; margin-top:auto;">
                      <div style="display:flex; align-items:center; gap:8px;">
                          <div style="width:24px; height:24px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:800; color:#64748b;">
                              {{ substr(htmlspecialchars($k['full_name']), 0, 1) }}
                          </div>
                          <div style="font-size:0.75rem; font-weight:700; color:#475569;">{{ htmlspecialchars($k['full_name']) }}</div>
                      </div>
                      <button onclick="voteKarya({{ $k['id'] }}, this)" {{ ($k['is_voted'] || $is_mine) ? 'disabled' : '' }} class="admin-btn-sm" style="padding:6px 12px; font-size:0.75rem; background:{{ ($k['is_voted'] || $is_mine) ? '#f8fafc' : '#fef3c7' }}; color:{{ ($k['is_voted'] || $is_mine) ? '#94a3b8' : '#f59e0b' }}; border:1px solid {{ ($k['is_voted'] || $is_mine) ? '#e2e8f0' : '#fcd34d' }}; gap:4px;">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $k['is_voted'] ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                          <span class="vote-count">{{ $k['vote_count'] }}</span>
                      </button>
                  </div>
              </div>
              @endif
              @php $rank++; @endphp
              @endforeach
          </div>
      </div>
  </div>

  <!-- FLOATING CART BUTTON -->
  <div id="floating-cart" style="position:fixed; bottom:100px; right:30px; background:#4f46e5; color:#fff; width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 10px 25px rgba(79,70,229,0.4); z-index:999; transition:transform 0.2s;" onclick="window.location.href='{{ route('member.mengajar.cart') }}'">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
      <div id="cart-badge" style="position:absolute; top:-5px; right:-5px; background:#ef4444; color:#fff; font-size:12px; font-weight:800; width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #fff;">0</div>
  </div>

  <!-- BANK MATERI GAMIFIKASI (CARD GRID) -->
  <div style="margin-top: 30px; margin-bottom: 20px;">
      <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 5px;">Bank Materi Gamifikasi</h2>
      <p style="color: #64748b; font-size: 0.9rem;">Eksplorasi kumpulan game, kuis, dan ice breaking untuk kelasmu.</p>
  </div>
  
  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
      @foreach($katalog as $item)
      @php
          $item_is_premium = isset($item['is_premium']) ? filter_var($item['is_premium'], FILTER_VALIDATE_BOOLEAN) : true;
          $price = $item_is_premium ? 25000 : 0;
          $gameId = $item['id'] ?? $item['path'];
          $tipe_label = strtoupper($item['tipe']);
          
          // Generate background based on category
          $bg_color = "linear-gradient(135deg, #1e293b, #0f172a)"; 
          if(stripos($item['kategori'], 'Ice') !== false) {
              $bg_color = "linear-gradient(135deg, #1e3a8a, #172554)"; 
          } else if(stripos($item['kategori'], 'Kuis') !== false) {
              $bg_color = "linear-gradient(135deg, #312e81, #1e1b4b)"; 
          } else if(stripos($item['kategori'], 'Buku') !== false) {
              $bg_color = "linear-gradient(135deg, #064e3b, #022c22)"; 
          }
      @endphp
      <div class="card-item" data-game-id="{{ $gameId }}" data-price="{{ $price }}" data-title="{{ htmlspecialchars($item['judul']) }}" data-path="{{ $item['path'] }}" style="background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.02); transition: all 0.3s; display: flex; flex-direction: column; height: 100%;">
          
          <!-- Card Cover -->
          <div style="height: 140px; background: {{ $bg_color }}; position: relative; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #fff;">
              {{ $item['ikon'] ?? '🎮' }}
              <div style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.5px;">
                  {{ $tipe_label }}
              </div>
          </div>
          
          <!-- Card Body -->
          <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                  <div style="font-size: 0.7rem; font-weight: 800; color: #8b2fc9; text-transform: uppercase; margin-bottom: 6px;">
                      {{ htmlspecialchars($item['kategori']) }}
                  </div>
                  <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                      {{ htmlspecialchars($item['judul']) }}
                  </h3>
                  <p style="font-size: 0.8rem; color: #64748b; line-height: 1.6; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;">
                      {{ htmlspecialchars($item['deskripsi']) }}
                  </p>
              </div>
              
              <!-- Card Footer -->
              <div style="padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: auto;">
                  <div class="card-price" style="flex-shrink: 0;">
                      @if($price === 0)
                          <span style="display:inline-flex; align-items:center; gap:5px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#059669; font-size:0.78rem; font-weight:800; padding:5px 12px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">
                              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                              Gratis
                          </span>
                      @else
                          <span style="font-size: 1.05rem; font-weight: 900; color: #0f172a;">Rp {{ number_format($price, 0, ',', '.') }}</span>
                      @endif
                  </div>
                  <div class="card-action" style="flex-shrink: 0;">
                      @if($price === 0)
                          @if(strtolower($item['tipe']) === 'json')
                              <button class="admin-btn-sm" style="background:#4f46e5; color:#fff;" onclick="playGame('{{ $item['path'] }}')">Mainkan</button>
                          @else
                              <a href="{{ $item['path'] }}" download class="admin-btn-sm" style="background:#10b981; color:#fff; text-decoration:none;">Unduh</a>
                          @endif
                      @else
                          <!-- Premium logic -->
                          <button class="btn-lock admin-btn-sm" data-game-id="{{ $gameId }}" data-price="{{ $price }}" data-title="{{ htmlspecialchars($item['judul']) }}" style="background:#f59e0b; color:#fff; border:none; display:flex; align-items:center; gap:4px;" onclick="handlePremiumClick(this)">
                              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                              Beli
                          </button>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      @endforeach
  </div>

</div>

<!-- PREMIUM LOCK DIALOG MODAL -->
<div id="premiumModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#fff; border-radius:20px; width:90%; max-width:400px; padding:24px; box-shadow:0 20px 40px rgba(0,0,0,0.3); text-align:center; position:relative;">
      <div style="width:72px; height:72px; border-radius:50%; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:2rem;">🔒</div>
      <h3 style="margin:0 0 8px 0; font-size:1.2rem; font-weight:800; color:#0f172a;" id="premiumModalTitle">Materi Terkunci</h3>
      <p style="color:#64748b; font-size:0.875rem; line-height:1.5; margin-bottom:24px;">
          Materi ini termasuk kategori Premium. Anda dapat membelinya secara satuan seharga <strong id="premiumModalPrice">Rp25.000</strong> atau berlangganan <strong>Premium Gamifikasi</strong> untuk akses tanpa batas.
      </p>
      
      <div style="display:flex; flex-direction:column; gap:10px;">
          <button id="btnBuySingle" class="btn btn-primary" style="width:100%; font-weight:700; padding:12px;" onclick="addToCartAndCheckout()">Masukkan Keranjang &amp; Bayar</button>
          <button class="btn btn-outline" style="width:100%; font-weight:700; padding:12px; border-color:#d97706; color:#d97706;" onclick="upgradeToPremiumSystem()">Langganan Premium Tanpa Batas</button>
          <button class="btn" style="width:100%; background:#f1f5f9; color:#475569; font-weight:700; padding:10px; border:none;" onclick="closePremiumModal()">Batal</button>
      </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
const GVG_CART_KEY = 'gv_gamifikasi_cart';
const GVG_OWNED_KEY = 'gv_owned_games';

// Update cart counter on load
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
    const badge = document.getElementById('cart-badge');
    if(badge) {
        badge.innerText = cart.length;
        badge.style.display = cart.length > 0 ? 'flex' : 'none';
    }
}

let activePremiumItem = null;

function handlePremiumClick(btn) {
    const gameId = btn.dataset.gameId;
    const price = btn.dataset.price;
    const title = btn.dataset.title;
    
    // Cek apakah game sudah dibeli sebelumnya
    const owned = JSON.parse(localStorage.getItem(GVG_OWNED_KEY) || '[]');
    if(owned.includes(gameId)) {
        // Jika owned, mainkan / download langsung
        const card = btn.closest('.card-item');
        const path = card.dataset.path;
        playGame(path);
        return;
    }

    activePremiumItem = { id: gameId, price: price, title: title };
    
    document.getElementById('premiumModalTitle').innerText = title;
    document.getElementById('premiumModalPrice').innerText = 'Rp ' + parseInt(price).toLocaleString('id-ID');
    document.getElementById('premiumModal').style.display = 'flex';
}

function closePremiumModal() {
    document.getElementById('premiumModal').style.display = 'none';
    activePremiumItem = null;
}

function addToCartAndCheckout() {
    if(!activePremiumItem) return;
    
    let cart = JSON.parse(localStorage.getItem(GVG_CART_KEY) || '[]');
    
    // Check if item already in cart
    const exists = cart.some(i => i.id === activePremiumItem.id);
    if(!exists) {
        cart.push(activePremiumItem);
        localStorage.setItem(GVG_CART_KEY, JSON.stringify(cart));
    }
    
    closePremiumModal();
    updateCartCount();
    window.location.href = "{{ route('member.mengajar.cart') }}";
}

async function upgradeToPremiumSystem() {
    if(!confirm("Apakah Anda yakin ingin mengupgrade akun menjadi Premium Gamifikasi? (Simulasi)")) return;
    
    try {
        const res = await fetch("{{ route('member.mengajar.gamifikasi.upgrade') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await res.json();
        if(data.status === 'success') {
            alert("Upgrade premium berhasil! Menyelaraskan platform...");
            window.location.reload();
        } else {
            alert("Upgrade gagal.");
        }
    } catch (err) {
        alert("Kesalahan jaringan.");
    }
}

function playGame(path) {
    window.location.href = "{{ route('member.mengajar.gamifikasi.play') }}?file=" + encodeURIComponent(path);
}

async function voteKarya(id, btn) {
    if(btn.disabled) return;
    btn.disabled = true;
    
    const fd = new FormData();
    fd.append('karya_id', id);

    try {
        const res = await fetch("{{ route('member.mengajar.gamifikasi.karya.vote') }}", {
            method: 'POST',
            body: fd,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await res.json();
        if(data.status === 'success') {
            const countSpan = btn.querySelector('.vote-count');
            if(countSpan) {
                countSpan.innerText = parseInt(countSpan.innerText) + 1;
            }
            btn.style.background = '#f8fafc';
            btn.style.color = '#94a3b8';
            btn.style.borderColor = '#e2e8f0';
            btn.querySelector('svg').setAttribute('fill', 'currentColor');
            alert(data.message);
        } else {
            alert(data.message);
            btn.disabled = false;
        }
    } catch(err) {
        alert("Kesalahan jaringan.");
        btn.disabled = false;
    }
}

// Fetch owned games on load to dynamically change "Beli" buttons to "Mainkan/Unduh"
async function fetchOwnedGames() {
    try {
        const res = await fetch("{{ route('member.mengajar.gamifikasi.owned') }}");
        const data = await res.json();
        if(data.status === 'success' && data.owned.length > 0) {
            localStorage.setItem(GVG_OWNED_KEY, JSON.stringify(data.owned));
            
            // Update UI
            data.owned.forEach(gid => {
                const btn = document.querySelector(`.btn-lock[data-game-id="${gid}"]`);
                if(btn) {
                    btn.className = 'admin-btn-sm';
                    btn.style.background = '#10b981';
                    btn.style.color = '#fff';
                    btn.style.boxShadow = 'none';
                    
                    const card = btn.closest('.card-item');
                    const path = card.dataset.path;
                    const isJson = path.endsWith('.json');
                    
                    if(isJson) {
                        btn.innerHTML = 'Mainkan';
                        btn.onclick = () => playGame(path);
                    } else {
                        btn.innerHTML = 'Unduh';
                        btn.onclick = () => window.location.href = path;
                    }
                }
            });
        }
    } catch(err) {
        console.error("Failed fetching owned games status", err);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    fetchOwnedGames();
});
</script>
@endsection
