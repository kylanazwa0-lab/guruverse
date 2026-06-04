<?php
$file = 'd:/laragon/www/guruverse/guru-belajar/member/pages/Guru_Mengajar/gamifikasi.php';
$content = file_get_contents($file);

// 1. Change toggleCartModal to redirect
$content = str_replace('onclick="toggleCartModal()"', 'onclick="window.location.href=\'?page=Guru_Mengajar/cart_gamifikasi\'"', $content);

// 2. Remove the modal-cart entirely
$modal_start = strpos($content, '<!-- CART MODAL -->');
$modal_end = strpos($content, '<!-- BANK MATERI GAMIFIKASI (EXACTLY LIKE ADMIN) -->');
if ($modal_start !== false && $modal_end !== false) {
    $content = substr($content, 0, $modal_start) . substr($content, $modal_end);
}

// 3. Change gv_cart to gv_gamifikasi_cart
$content = str_replace("getItem('gv_cart')", "getItem('gv_gamifikasi_cart')", $content);
$content = str_replace("setItem('gv_cart'", "setItem('gv_gamifikasi_cart'", $content);

// 4. In renderTableButtons, remove the disabled "Dalam Keranjang" state to point to keranjang page
$old_dalam_keranjang = '<button class="admin-btn-sm" style="background:#f1f5f9; color:#64748b; cursor:not-allowed;" disabled>Dalam Keranjang</button>';
$new_dalam_keranjang = '<button class="admin-btn-sm" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1;" onclick="window.location.href=\'?page=Guru_Mengajar/cart_gamifikasi\'">Buka Keranjang</button>';
$content = str_replace($old_dalam_keranjang, $new_dalam_keranjang, $content);

file_put_contents($file, $content);
echo "Berhasil update gamifikasi.php.";
