@extends('layouts.admin')

@section('title', 'Perpustakaan & E-Book')
@section('page_title', 'Perpustakaan & E-Book')

@section('content')
@php /**
 * Admin View - Manajemen Produk & E-Book (High Fidelity Overhaul)
 */

// Handle Form Submissions (CRUD)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ADD PRODUCT
    if (isset($_POST['add_product'])) {
        $title = $_POST['title'];
        $price = str_replace('.', '', $_POST['price']);
        $member_price = !empty($_POST['member_price']) ? str_replace('.', '', $_POST['member_price']) : NULL;
        $original_price = !empty($_POST['original_price']) ? str_replace('.', '', $_POST['original_price']) : NULL;
        $checkout_url = !empty($_POST['checkout_url']) ? $_POST['checkout_url'] : NULL;
        $type = $_POST['type'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $is_free = isset($_POST['is_free']) ? 1 : 0;
        
        $image_url = $_POST['image_url'];
        // Handle File Upload
        if (!empty($_FILES['image_file']['name'])) {
            $target_dir = "../asset/img/products/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $file_ext = pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . "." . $file_ext;
            $target_file = $target_dir . $new_filename;
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                $image_url = "asset/img/products/" . $new_filename;
            }
        }
        $pdf_url = !empty($_POST['pdf_url']) ? $_POST['pdf_url'] : NULL;
        // Handle PDF File Upload
        if (!empty($_FILES['pdf_file']['name'])) {
            $target_dir = "../asset/docs/products/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $file_ext = pathinfo($_FILES["pdf_file"]["name"], PATHINFO_EXTENSION);
            if (strtolower($file_ext) === 'pdf') {
                $new_filename = uniqid() . ".pdf";
                $target_file = $target_dir . $new_filename;
                if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
                    $pdf_url = "asset/docs/products/" . $new_filename;
                }
            }
        }

        $stmt = $conn->prepare("INSERT INTO products (title, price, member_price, original_price, checkout_url, type, author, category, description, image_url, pdf_url, status, is_free) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sdddssssssssi', $title, $price, $member_price, $original_price, $checkout_url, $type, $author, $category, $description, $image_url, $pdf_url, $status, $is_free);
        $stmt->execute();
        $stmt->close();
        echo "<script>window.location.href='/admin/module/produk?status=success';</script>";
    }

    // EDIT PRODUCT
    if (isset($_POST['edit_product'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $price = str_replace('.', '', $_POST['price']);
        $member_price = !empty($_POST['member_price']) ? str_replace('.', '', $_POST['member_price']) : NULL;
        $original_price = !empty($_POST['original_price']) ? str_replace('.', '', $_POST['original_price']) : NULL;
        $checkout_url = !empty($_POST['checkout_url']) ? $_POST['checkout_url'] : NULL;
        $type = $_POST['type'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $is_free = isset($_POST['is_free']) ? 1 : 0;
        $pdf_url = !empty($_POST['pdf_url']) ? $_POST['pdf_url'] : NULL;
        
        $image_url = $_POST['image_url'];
        // Handle File Upload
        if (!empty($_FILES['image_file']['name'])) {
            $target_dir = "../asset/img/products/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $file_ext = pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION);
            $new_filename = uniqid() . "." . $file_ext;
            $target_file = $target_dir . $new_filename;
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                $image_url = "asset/img/products/" . $new_filename;
            }
        }
        // Handle PDF File Upload
        if (!empty($_FILES['pdf_file']['name'])) {
            $target_dir = "../asset/docs/products/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $file_ext = pathinfo($_FILES["pdf_file"]["name"], PATHINFO_EXTENSION);
            if (strtolower($file_ext) === 'pdf') {
                $new_filename = uniqid() . ".pdf";
                $target_file = $target_dir . $new_filename;
                if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
                    $pdf_url = "asset/docs/products/" . $new_filename;
                }
            }
        }

        $stmt = $conn->prepare("UPDATE products SET title=?, price=?, member_price=?, original_price=?, checkout_url=?, type=?, author=?, category=?, description=?, image_url=?, pdf_url=?, status=?, is_free=? WHERE id=?");
        $stmt->bind_param('sdddssssssssii', $title, $price, $member_price, $original_price, $checkout_url, $type, $author, $category, $description, $image_url, $pdf_url, $status, $is_free, $id);
        $stmt->execute();
        $stmt->close();
        echo "<script>window.location.href='/admin/module/produk?status=updated';</script>";
    }

    // DELETE PRODUCT
    if (isset($_POST['delete_product'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        echo "<script>window.location.href='/admin/module/produk?status=deleted';</script>";
    }
}

// Fetch Filters Data
$categories_res = $conn->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
$all_categories = [];
while($c = $categories_res->fetch_assoc()) $all_categories[] = $c['category'];

// Fetch All Products with Advanced Filtering
$q = $_GET['q'] ?? '';
$active_type = $_GET['type'] ?? 'all';
$active_cat = $_GET['cat'] ?? 'all';

$sql = "SELECT * FROM products WHERE 1=1";
if ($q) {
    $sql .= " AND (title LIKE '%$q%' OR author LIKE '%$q%' OR category LIKE '%$q%' OR description LIKE '%$q%')";
}
if ($active_type !== 'all') {
    $sql .= " AND type = '$active_type'";
}
if ($active_cat !== 'all') {
    $sql .= " AND category = '$active_cat'";
}
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
$products = [];
while ($row = $result->fetch_assoc()) $products[] = $row;

// Statistics for Dashboard
$stat_total = count($products);
$stat_published = 0;
$stat_free = 0;
foreach($products as $p) {
    if($p['status'] === 'published') $stat_published++;
    if($p['is_free'] == 1) $stat_free++;
} @endphp

@php if(isset($_GET['status'])): 
    $msg = "Operasi Berhasil!";
    $type = "success";
    $icon_color = "#10b981";
    $title = "Berhasil!";
    
    if($_GET['status'] === 'deleted') $msg = "Produk telah dihapus secara permanen.";
    if($_GET['status'] === 'updated') $msg = "Perubahan data produk berhasil disimpan.";
    if($_GET['status'] === 'success') $msg = "Produk baru berhasil ditambahkan ke katalog.";
    if($_GET['status'] === 'error') { 
        $msg = "Terjadi kesalahan saat memproses data."; 
        $type = "error"; 
        $icon_color = "#ef4444";
        $title = "Gagal!";
    } @endphp
<!-- Status Popup Modal -->
<div id="modal-status" class="overlay" style="display:flex;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:20000;padding:2rem 1rem;align-items:center;justify-content:center; backdrop-filter:blur(6px);">
    <div class="modal" style="width:100%;max-width:380px;background:#fff;border-radius:28px;overflow:hidden;animation:fadeUp .4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); text-align:center; padding:2.5rem 2rem;">
        <div style="width:72px; height:72px; background:{{ $icon_color }}15; color:{{ $icon_color }}; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem; border:2px solid {{ $icon_color }}10;">
            @if ($type === 'success')
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            @else
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            @endif
        </div>
        <h3 style="font-weight:900; color:var(--t); font-size:1.4rem; margin-bottom:10px;">{{ $title }}</h3>
        <p style="color:var(--muted); font-size:.9rem; line-height:1.6; margin-bottom:2rem;">{{ $msg }}</p>
        
        <button onclick="closeStatusModal()" style="width:100%; background:{{ $icon_color }}; color:#fff; border:none; padding:.9rem; border-radius:14px; font-weight:900; cursor:pointer; font-size:.9rem; box-shadow:0 8px 16px {{ $icon_color }}30; transition:all .2s;">
            Oke, Mengerti
        </button>
    </div>
</div>
<script>
    function closeStatusModal() {
        const modal = document.getElementById('modal-status');
        modal.style.opacity = '0';
        modal.style.transition = 'opacity .3s ease';
        setTimeout(() => {
            modal.remove();
            // Clean URL status
            const url = new URL(window.location);
            url.searchParams.delete('status');
            window.history.replaceState({}, '', url);
        }, 300);
    }
</script>
@endif

<style>
@keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
.stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:0.85rem; flex:1; min-width:180px; display:flex; align-items:center; gap:12px; transition:all .3s ease; }
.stat-card:hover { border-color:var(--v1); transform: translateY(-2px); }
.p-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; display:flex; flex-direction:column; transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position:relative; }
.p-card:hover { transform: translateY(-4px); box-shadow: 0 15px 20px -5px rgba(0,0,0,0.05); border-color:var(--v1); }
.price-tag { background:rgba(248,250,252,0.8); backdrop-filter:blur(4px); padding:8px 10px; border-radius:10px; border:1px solid #f1f5f9; }
.btn-action-icon { width:28px; height:28px; border-radius:6px; display:flex; align-items:center; justify-content:center; transition:all .2s; border:none; cursor:pointer; }
</style>

<div class="p-4" style="max-width:1400px; margin:0 auto;">
    <!-- PAGE HEADER -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1.5rem;">
        <div>
            <h1 style="font-size:1.5rem;font-weight:900;color:var(--t);letter-spacing:-.03em;margin-bottom:6px">Katalog Produk & E-Book</h1>
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="width:8px; height:8px; background:#10b981; border-radius:50%"></span>
                <p style="font-size:.8rem;color:var(--muted); font-weight:600;">Pusat pengelolaan aset digital Guruverse</p>
            </div>
        </div>
        
        <div style="display:flex; gap:.75rem;">
            <button onclick="document.getElementById('import-ebook-input').click()" class="btn-sm"
                style="background:#fff;color:var(--v1);border:1px solid rgba(139,47,201,.3);padding:.6rem 1.25rem;font-size:.8rem;border-radius:10px;display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:700; box-shadow:0 2px 4px rgba(0,0,0,0.02)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Import E-book
            </button>
            <input type="file" id="import-ebook-input" style="display:none" accept=".pdf" onchange="handleImportEbook(this)">

            <button onclick="openModal()" class="btn-sm"
                style="background:linear-gradient(135deg,var(--v1),var(--v2));color:#fff;border:none;padding:.6rem 1.5rem;font-size:.8rem;border-radius:10px;display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:700; box-shadow:0 4px 12px rgba(139,47,201,0.3)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah
            </button>
        </div>
    </div>

    <!-- QUICK STATS -->
    <div style="display:flex; gap:1rem; margin-bottom:2rem; flex-wrap:wrap;">
        <div class="stat-card">
            <div style="width:38px; height:38px; border-radius:10px; background:rgba(124,58,237,0.1); color:#7c3aed; display:flex; align-items:center; justify-content:center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/><path d="M3 9h18"/></svg>
            </div>
            <div>
                <div style="font-size:.65rem; font-weight:800; color:var(--muted); text-transform:uppercase;">Total</div>
                <div style="font-size:1.1rem; font-weight:900; color:var(--t);">{{ $stat_total }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div style="width:38px; height:38px; border-radius:10px; background:rgba(16,185,129,0.1); color:#10b981; display:flex; align-items:center; justify-content:center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div style="font-size:.65rem; font-weight:800; color:var(--muted); text-transform:uppercase;">Live</div>
                <div style="font-size:1.1rem; font-weight:900; color:var(--t);">{{ $stat_published }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div style="width:38px; height:38px; border-radius:10px; background:rgba(14,165,233,0.1); color:#0ea5e9; display:flex; align-items:center; justify-content:center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            </div>
            <div>
                <div style="font-size:.65rem; font-weight:800; color:var(--muted); text-transform:uppercase;">Gratis</div>
                <div style="font-size:1.1rem; font-weight:900; color:var(--t);">{{ $stat_free }}</div>
            </div>
        </div>
    </div>

    <!-- ADVANCED FILTER BAR -->
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:1.25rem; margin-bottom:2.5rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.02)">
        <form method="GET" style="display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;">
            <input type="hidden" name="mod" value="produk">
            
            <div style="flex:2; min-width:300px;">
                <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase; letter-spacing:.5px;">Pencarian Pintar</label>
                <div class="search-wrap" style="background:#f1f5f9;border:1px solid transparent;border-radius:10px;display:flex;align-items:center; transition:all .2s;">
                    <span style="padding-left:14px;color:#94a3b8">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input name="q" placeholder="Cari judul, penulis, kategori..." value="{{ htmlspecialchars($q) }}" style="background:transparent;border:none;padding:.75rem 1rem;font-size:.85rem;width:100%;outline:none; color:var(--t); font-weight:600;">
                </div>
            </div>

            <div style="flex:1; min-width:180px;">
                <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase; letter-spacing:.5px;">Jenis Produk</label>
                <select name="type" style="width:100%;background:#f1f5f9;border:1px solid transparent;border-radius:10px;padding:.75rem 1rem;font-size:.85rem;outline:none;font-weight:700; color:var(--t); cursor:pointer;">
                    <option value="all">Semua Jenis</option>
                    <option value="ebook" {{ $active_type==='ebook'?'selected':'' }}>📄 E-Book</option>
                    <option value="physical" {{ $active_type==='physical'?'selected':'' }}>📦 Produk Fisik</option>
                </select>
            </div>

            <div style="flex:1; min-width:180px;">
                <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase; letter-spacing:.5px;">Kategori</label>
                <select name="cat" style="width:100%;background:#f1f5f9;border:1px solid transparent;border-radius:10px;padding:.75rem 1rem;font-size:.85rem;outline:none;font-weight:700; color:var(--t); cursor:pointer;">
                    <option value="all">Semua Kategori</option>
                    @foreach ($all_categories as $cat)
                        <option value="{{ htmlspecialchars($cat) }}" {{ $active_cat===$cat?'selected':'' }}>{{ htmlspecialchars($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;align-items:flex-end; gap:1.25rem;">
                <button type="submit" class="btn-sm" style="background:var(--v1);color:#fff;border:none;padding:.75rem 2rem;font-weight:800;border-radius:10px; cursor:pointer; transition:all .2s; box-shadow:0 4px 10px rgba(139,47,201,0.2)">
                    Filter
                </button>
                @if ($q !== '' || $active_type !== 'all' || $active_cat !== 'all')
                    <a href="/admin/module/produk" style="text-decoration:none;font-size:.75rem;font-weight:800;color:#ef4444; border-bottom:2px solid #fee2e2; padding:4px 0;">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- PRODUCT GRID -->
    @if (empty($products))
        <div style="padding:4rem;background:#fff;border-radius:16px;border:2px dashed #e2e8f0;text-align:center;">
            <div style="width:60px; height:60px; background:#f8fafc; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <h3 style="font-weight:900;color:var(--t); font-size:.95rem; margin-bottom:6px;">Belum ada item</h3>
            <p style="color:var(--muted); font-size:.75rem; max-width:250px; margin:0 auto;">Mulai bangun katalog Anda dengan menambahkan produk.</p>
        </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
        @foreach ($products as $p)
        <div class="p-card" style="flex-direction:row; min-height:125px; height:auto; opacity: {{ $p['status']==='draft'?'0.8':'' }}; border-radius:14px; box-shadow:0 2px 4px rgba(0,0,0,0.02);">
            <!-- Image Area (Left) -->
            <div style="width:90px; min-width:90px; position:relative; background:#f8fafc; overflow:hidden;">
                <img src="{{ asset($p['image_url']) }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('asset/img/placeholder.png') }}'">
                
                <span style="position:absolute;top:5px;left:5px;font-size:.45rem;font-weight:900;padding:2px 6px;border-radius:4px;background:{{ $p['type']==='ebook'?'#7c3aed':'#0ea5e9' }};color:#fff; z-index:2;">
                    {{ strtoupper($p['type']) }}
                </span>
                
                @if ($p['checkout_url'])
                <div onclick="copyLink('{{ $p['checkout_url'] }}')" style="position:absolute; bottom:5px; left:5px; width:24px; height:24px; background:#10b981; color:#fff; border-radius:6px; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 4px 10px rgba(16,185,129,0.2); z-index:2;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                </div>
                @endif
            </div>

            <!-- Info & Action Area (Right) -->
            <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; background:#fff;">
                <!-- Content Area -->
                <div style="padding:12px; flex:1; display:flex; flex-direction:column; justify-content:space-between;">
                    <div style="margin-bottom:8px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                            <span style="font-size:.55rem;color:var(--v1);font-weight:900;text-transform:uppercase;letter-spacing:.3px;">{{ htmlspecialchars($p['category'] ?: 'Umum') }}</span>
                        </div>
                        <h3 style="font-weight:800;font-size:.85rem;color:var(--t);line-height:1.4;margin:0; overflow:hidden; display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                            {{ htmlspecialchars($p['title']) }}
                        </h3>
                    </div>

                    <div class="price-tag" style="display:flex; align-items:center; gap:8px; justify-content:space-between; background:#f8fafc; padding:6px 10px; border-radius:8px; border:1px solid #f1f5f9;">
                        @if ($p['is_free'])
                            <span style="color:#10b981; font-weight:900; font-size:.7rem; width:100%; text-align:center;">FREE ACCESS</span>
                        @else
                            <div style="display:flex; flex-direction:column; gap:1px;">
                                <span style="font-size:.45rem;color:var(--muted);font-weight:800;text-transform:uppercase;">Reg</span>
                                <span style="font-size:.75rem;font-weight:900;color:var(--t);">Rp{{ number_format($p['price']/1000, 0) }}k</span>
                            </div>
                            <div style="width:1px; height:15px; background:#e2e8f0;"></div>
                            <div style="display:flex; flex-direction:column; gap:1px; text-align:right;">
                                <span style="font-size:.45rem;color:#7c3aed;font-weight:900;text-transform:uppercase;">Mbr</span>
                                <span style="font-size:.8rem;font-weight:950;color:#7c3aed;">Rp{{ number_format($p['member_price']/1000 ?: $p['price']/1000, 0) }}k</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div style="padding:8px 12px; border-top:1px solid #f1f5f9; background:#fafbfc; display:flex; align-items:center; gap:10px;">
                    <button onclick='openModal({{ json_encode($p) }})'
                        style="flex:1; background:#fff; color:var(--v1); border:1px solid rgba(139,47,201,.15); padding:6px; font-weight:800; font-size:.7rem; border-radius:8px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:5px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </button>
                    <button type="button" onclick="openDeleteModal({{ $p['id'] }}, '{{ addslashes($p['title']) }}')" style="background:#fee2e2; color:#ef4444; border:none; border-radius:8px; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .2s;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Modal Add/Edit -->
<div id="modal-product" class="overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;padding:1rem;align-items:center;justify-content:center; backdrop-filter:blur(4px);">
    <div class="modal modal-md" style="width:100%; max-width:680px; max-height:92vh; background:#fff; border-radius:28px; display:flex; flex-direction:column; overflow:hidden; animation:fadeUp .3s ease; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
        
        <!-- Modal Header -->
        <div class="modal-header" style="padding:1.5rem 2rem; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; background:#fff;">
            <div>
                <div id="modal-title" style="font-weight:900;font-size:1.25rem;color:var(--t)">Produk & Harga</div>
                <div style="font-size:.75rem; color:var(--muted); font-weight:600; margin-top:2px;">Konfigurasi detail item dan strategi harga</div>
            </div>
            <button type="button" onclick="closeModal()" style="background:#f1f5f9;border:none;width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--muted); transition:all .2s;">✕</button>
        </div>

        <form id="product-form" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
            <input type="hidden" name="id" id="form-id">
            
            <!-- Modal Body (Scrollable) -->
            <div class="modal-body" style="padding:2rem; overflow-y:auto; flex:1; background:linear-gradient(to bottom, #fff, #fafbfc);">
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.75rem">
                    <div class="fg">
                        <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase; letter-spacing:.5px;">Visibilitas</label>
                        <select name="status" id="form-status" class="fi" style="width:100%;padding:.8rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:700; color:var(--t); cursor:pointer;">
                            <option value="published">🚀 Published (Live)</option>
                            <option value="draft">📝 Draft (Internal)</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase; letter-spacing:.5px;">Tipe Item</label>
                        <select name="type" id="form-type" class="fi" style="width:100%;padding:.8rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:700; color:var(--t); cursor:pointer;">
                            <option value="ebook">📄 E-Book (Digital)</option>
                            <option value="physical">📦 Produk Fisik</option>
                        </select>
                    </div>
                </div>

                <div class="fg" style="margin-bottom:1.75rem">
                    <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase; letter-spacing:.5px;">Nama / Judul Produk</label>
                    <input type="text" name="title" id="form-title" required placeholder="Contoh: E-book Strategi Mengajar..." class="fi" style="width:100%;padding:.8rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:600; color:var(--t);">
                </div>

                <div style="background:#fff; padding:1.75rem; border-radius:24px; margin-bottom:1.75rem; border:1px solid #e2e8f0; box-shadow:0 4px 12px rgba(0,0,0,0.02)">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px; background:#f8fafc; padding:14px 18px; border-radius:14px; border:1px solid #e2e8f0;">
                        <input type="checkbox" name="is_free" id="form-free" onchange="togglePrice(this.checked)" style="width:20px; height:20px; cursor:pointer;">
                        <label for="form-free" style="font-size:.85rem;font-weight:800;color:var(--t); cursor:pointer;">Jadikan Item Gratis (Free for All)</label>
                    </div>
                    
                    <div id="price-section">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem; margin-bottom:1.5rem;">
                            <div class="fg">
                                <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase;">Harga Reguler</label>
                                <div style="position:relative;">
                                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:800; color:var(--muted); font-size:.85rem;">Rp</span>
                                    <input type="text" name="price" id="form-price" oninput="formatPrice(this)" class="fi" style="width:100%;padding:.8rem 1rem .8rem 2.5rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:700;">
                                </div>
                            </div>
                            <div class="fg">
                                <label style="display:block;font-size:.65rem;font-weight:800;color:#7c3aed;margin-bottom:8px;text-transform:uppercase;">Harga Member</label>
                                <div style="position:relative;">
                                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:800; color:#7c3aed; font-size:.85rem;">Rp</span>
                                    <input type="text" name="member_price" id="form-member" oninput="formatPrice(this)" placeholder="..." class="fi" style="width:100%;padding:.8rem 1rem .8rem 2.5rem;border-radius:12px;border:1px solid #ddd; border-color:rgba(124,58,237,0.3); font-weight:900; color:#7c3aed;">
                                </div>
                            </div>
                        </div>
                        <div class="fg">
                            <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase;">Harga Coret (Opsi Diskon)</label>
                            <div style="position:relative;">
                                <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:800; color:var(--muted); font-size:.85rem;">Rp</span>
                                <input type="text" name="original_price" id="form-original" oninput="formatPrice(this)" placeholder="MSRP / Harga Pasar" class="fi" style="width:100%;padding:.8rem 1rem .8rem 2.5rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:600; color:var(--muted);">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="checkout-section" style="margin-bottom:1.75rem">
                    <label style="display:block;font-size:.65rem;font-weight:800;color:#10b981;margin-bottom:8px;text-transform:uppercase;">Payment Link (Mayar / Checkout URL)</label>
                    <div style="background:#fff; border:1px solid rgba(16,185,129,0.3); border-radius:12px; display:flex; align-items:center; padding:0 14px;">
                        <span style="color:#10b981">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </span>
                        <input type="url" name="checkout_url" id="form-checkout" placeholder="https://mayar.id/checkout/..." class="fi" style="width:100%;padding:.85rem 1.1rem;border:none;background:transparent;outline:none;font-size:.9rem; font-weight:600; color:#10b981;">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.75rem">
                    <div class="fg">
                        <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase;">Penulis / Brand</label>
                        <input type="text" name="author" id="form-author" placeholder="Nama Author" class="fi" style="width:100%;padding:.8rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:600;">
                    </div>
                    <div class="fg">
                        <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase;">Kategori</label>
                        <input type="text" name="category" id="form-category" placeholder="E.g. Pedagogi" class="fi" style="width:100%;padding:.8rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:600;">
                    </div>
                </div>

                <div class="fg" style="margin-bottom:1.75rem">
                    <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:8px;text-transform:uppercase;">Deskripsi / Detail Item</label>
                    <textarea name="description" id="form-desc" rows="5" placeholder="Tuliskan detail produk di sini..." class="fi" style="width:100%;padding:.9rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0;resize:vertical;font-family:inherit;font-size:.85rem; line-height:1.6; color:var(--t);"></textarea>
                </div>

                <div class="fg" style="background:#f1f5f9; padding:1.5rem; border-radius:20px; border:2px dashed #cbd5e1; margin-bottom:1rem;">
                    <label style="display:block;font-size:.65rem;font-weight:800;color:var(--muted);margin-bottom:12px;text-transform:uppercase; letter-spacing:.5px;">Cover Produk (File atau Link)</label>
                    
                    <div style="margin-bottom:12px;">
                        <input type="file" name="image_file" accept="image/*" class="fi" style="width:100%; font-size:.85rem; background:#fff; padding:10px; border-radius:10px; border:1px solid #e2e8f0;">
                        <p style="font-size:.65rem; color:var(--muted); margin-top:6px; font-weight:600;">* Upload PNG, JPG, atau JPEG (Disarankan Rasio 1:1)</p>
                    </div>

                    <div style="display:flex; align-items:center; gap:12px; margin:15px 0;">
                        <div style="flex:1; height:1px; background:#cbd5e1;"></div>
                        <span style="font-size:.65rem; font-weight:900; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">Atau Masukkan Link</span>
                        <div style="flex:1; height:1px; background:#cbd5e1;"></div>
                    </div>

                    <input type="text" name="image_url" id="form-image" placeholder="https://link-gambar.com/cover.png" class="fi" style="width:100%;padding:.85rem 1.1rem;border-radius:12px;border:1px solid #e2e8f0; font-weight:600;">
                </div>

                <div id="pdf-section" class="fg" style="background:rgba(124,58,237,0.04); padding:1.5rem; border-radius:20px; border:1px solid rgba(124,58,237,0.1); margin-bottom:1rem; display:none;">
                    <label style="display:block;font-size:.65rem;font-weight:800;color:var(--v1);margin-bottom:12px;text-transform:uppercase; letter-spacing:.5px;">Link File PDF (Untuk E-book Gratis)</label>
                    
                    <div style="margin-bottom:12px;">
                        <input type="file" name="pdf_file" accept=".pdf" class="fi" style="width:100%; font-size:.85rem; background:#fff; padding:10px; border-radius:10px; border:1px solid #e2e8f0;">
                    </div>

                    <div style="display:flex; align-items:center; gap:12px; margin:15px 0;">
                        <div style="flex:1; height:1px; background:#e2e8f0;"></div>
                        <span style="font-size:.65rem; font-weight:900; color:#94a3b8; text-transform:uppercase;">Atau Masukkan Link</span>
                        <div style="flex:1; height:1px; background:#e2e8f0;"></div>
                    </div>

                    <div style="display:flex; align-items:center; background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:0 12px;">
                        <span style="color:var(--v1)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </span>
                        <input type="text" name="pdf_url" id="form-pdf" placeholder="https://drive.google.com/file/..." class="fi" style="width:100%;padding:.85rem 1.1rem;border:none;background:transparent;outline:none;font-size:.9rem; font-weight:600; color:var(--v1);">
                    </div>
                    <p style="font-size:.65rem; color:var(--muted); margin-top:8px; font-weight:600;">* Link ini akan muncul sebagai tombol download di Jendela Dunia jika item diset GRATIS.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="padding:1.5rem 2rem; background:#fff; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:12px; flex-shrink:0;">
                <button type="button" onclick="closeModal()" style="background:#f1f5f9; color:var(--muted); border:none; padding:.85rem 1.5rem; border-radius:14px; font-weight:800; cursor:pointer; font-size:.85rem; transition:all .2s;">Batal</button>
                <button type="submit" id="submit-btn" name="add_product" style="background:var(--v1); color:#fff; border:none; padding:.85rem 2rem; border-radius:14px; font-weight:900; cursor:pointer; font-size:.85rem; box-shadow:0 10px 20px rgba(139,47,201,0.25); transition:all .2s;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div id="modal-delete" class="overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:10000;padding:2rem 1rem;align-items:center;justify-content:center; backdrop-filter:blur(4px);">
    <div class="modal" style="width:100%;max-width:400px;background:#fff;border-radius:24px;overflow:hidden;animation:fadeUp .3s ease; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); text-align:center; padding:2.5rem 2rem;">
        <div style="width:64px; height:64px; background:#fee2e2; color:#ef4444; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        </div>
        <h3 style="font-weight:900; color:var(--t); font-size:1.25rem; margin-bottom:8px;">Hapus Item?</h3>
        <p style="color:var(--muted); font-size:.85rem; line-height:1.6; margin-bottom:2rem;">Anda akan menghapus <br><b id="delete-item-title" style="color:var(--t)"></b><br> Tindakan ini tidak dapat dibatalkan.</p>
        
        <form method="POST" id="delete-form">
            <input type="hidden" name="id" id="delete-id">
            <input type="hidden" name="delete_product" value="1">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <button type="button" onclick="closeDeleteModal()" style="background:#f1f5f9; color:var(--muted); border:none; padding:.85rem; border-radius:12px; font-weight:800; cursor:pointer;">Batal</button>
                <button type="submit" style="background:#ef4444; color:#fff; border:none; padding:.85rem; border-radius:12px; font-weight:900; cursor:pointer; box-shadow:0 4px 12px rgba(239,68,68,0.2);">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal(id, title) {
    document.getElementById('delete-id').value = id;
    document.getElementById('delete-item-title').innerText = title;
    document.getElementById('modal-delete').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('modal-delete').style.display = 'none';
}

function formatPrice(input) {
    let value = input.value.replace(/[^0-9]/g, "");
    if (value) {
        input.value = new Intl.NumberFormat('id-ID').format(value);
    } else {
        input.value = '';
    }
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function copyLink(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Optional: Trigger a toast or alert
        alert('Link pembayaran disalin ke clipboard!');
    });
}

function togglePrice(isFree) {
    const section = document.getElementById('price-section');
    const checkoutSec = document.getElementById('checkout-section');
    const priceInp = document.getElementById('form-price');
    const memberInp = document.getElementById('form-member');
    const checkoutInp = document.getElementById('form-checkout');

    if(isFree) {
        section.style.opacity = '0.4';
        section.style.pointerEvents = 'none';
        checkoutSec.style.display = 'none';
        priceInp.value = '0';
        memberInp.value = '0';
        checkoutInp.value = '';
    } else {
        section.style.opacity = '1';
        section.style.pointerEvents = 'auto';
        checkoutSec.style.display = 'block';
    }

    // Toggle PDF section based on type and free status
    const type = document.getElementById('form-type').value;
    const pdfSec = document.getElementById('pdf-section');
    if (type === 'ebook' && isFree) {
        pdfSec.style.display = 'block';
    } else {
        pdfSec.style.display = 'none';
    }
}

function openModal(data = null) {
    const modal = document.getElementById('modal-product');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');
    
    if(data) {
        title.innerText = 'Edit Produk #' + data.id;
        submitBtn.name = 'edit_product';
        document.getElementById('form-id').value = data.id;
        document.getElementById('form-title').value = data.title;
        
        // Format prices with dots on load
        document.getElementById('form-price').value = formatNumber(data.price);
        if(document.getElementById('form-member')) document.getElementById('form-member').value = data.member_price ? formatNumber(data.member_price) : '';
        if(document.getElementById('form-original')) document.getElementById('form-original').value = data.original_price ? formatNumber(data.original_price) : '';
        
        if(document.getElementById('form-checkout')) document.getElementById('form-checkout').value = data.checkout_url || '';
        document.getElementById('form-type').value = data.type;
        document.getElementById('form-author').value = data.author;
        document.getElementById('form-category').value = data.category;
        document.getElementById('form-desc').value = data.description || '';
        document.getElementById('form-image').value = data.image_url;
        document.getElementById('form-status').value = data.status || 'published';
        document.getElementById('form-pdf').value = data.pdf_url || '';
        document.getElementById('form-free').checked = data.is_free == 1;
        togglePrice(data.is_free == 1);
    } else {
        title.innerText = 'Tambah Produk Baru';
        submitBtn.name = 'add_product';
        document.getElementById('product-form').reset();
        document.getElementById('form-id').value = '';
        togglePrice(false);
    }
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal-product').style.display = 'none';
}

function handleImportEbook(input) {
    if (!input.files || input.files.length === 0) return;
    const file = input.files[0];
    openModal();
    const titleInput = document.getElementById('form-title');
    const authorInput = document.getElementById('form-author');
    const categoryInput = document.getElementById('form-category');
    const descInput = document.getElementById('form-desc');
    const typeInput = document.getElementById('form-type');
    typeInput.value = 'ebook';
    const formData = new FormData();
    formData.append('pdf_file', file);
    const submitBtn = document.getElementById('submit-btn');
    const originalBtnText = submitBtn.innerText;
    submitBtn.innerText = 'Menganalisis E-book...';
    submitBtn.disabled = true;

    fetch('/guruverse/api/parse_pdf.php', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(data => {
        submitBtn.innerText = originalBtnText;
        submitBtn.disabled = false;
        if (data.success && data.data) {
            titleInput.value = data.data.title || file.name.replace(/\.[^/.]+$/, "");
            authorInput.value = data.data.author || '';
            categoryInput.value = data.data.category || '';
            descInput.value = data.data.description || '';
        } else {
            titleInput.value = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, " ");
        }
    })
    .catch(err => {
        submitBtn.innerText = originalBtnText;
        submitBtn.disabled = false;
        titleInput.value = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, " ");
    });
    input.value = '';
}
</script>

@endsection