<?php
// controllers/MengajarGamifikasiController.php - CRUD gb_mengajar_tantangan & stats
require_once __DIR__ . '/../../database/config.php';

function gamifikasi_get_stats($conn) {
    $res = $conn->query("SELECT s.*, m.name as member_name FROM gb_mengajar_stats s JOIN members m ON s.member_id = m.id ORDER BY s.total_xp DESC LIMIT 50");
    $rows = [];
    if ($res) {
        while ($r = $res->fetch_assoc()) $rows[] = $r;
    }
    return $rows;
}

function gamifikasi_get_tantangan($conn, $search = '') {
    $where = $search ? "AND (t.nama_tantangan LIKE '%" . $conn->real_escape_string($search) . "%' OR m.name LIKE '%" . $conn->real_escape_string($search) . "%')" : '';
    $res = $conn->query("SELECT t.*, m.name as member_name FROM gb_mengajar_tantangan t JOIN members m ON t.member_id = m.id WHERE 1=1 $where ORDER BY t.tanggal DESC, t.id DESC");
    $rows = [];
    if ($res) {
        while ($r = $res->fetch_assoc()) $rows[] = $r;
    }
    return $rows;
}

function gamifikasi_get_members($conn) {
    $res = $conn->query("SELECT id, name FROM members ORDER BY name ASC");
    $rows = [];
    if ($res) {
        while ($r = $res->fetch_assoc()) $rows[] = $r;
    }
    return $rows;
}

function gamifikasi_create_tantangan($conn, $data) {
    $member_id = (int)$data['member_id'];
    $tanggal = $conn->real_escape_string($data['tanggal'] ?? date('Y-m-d'));
    $ikon = $conn->real_escape_string($data['ikon'] ?? '🎯');
    $nama = $conn->real_escape_string($data['nama_tantangan']);
    $xp = (int)($data['xp_reward'] ?? 100);
    $target = (int)($data['target'] ?? 1);
    
    $conn->query("INSERT INTO gb_mengajar_tantangan (member_id, tanggal, ikon, nama_tantangan, xp_reward, target, progress, is_done) 
                  VALUES ($member_id, '$tanggal', '$ikon', '$nama', $xp, $target, 0, 0)");
    return $conn->insert_id;
}

function gamifikasi_update_tantangan($conn, $id, $data) {
    $id = (int)$id;
    $nama = $conn->real_escape_string($data['nama_tantangan']);
    $xp = (int)($data['xp_reward'] ?? 100);
    $target = (int)($data['target'] ?? 1);
    $progress = (int)($data['progress'] ?? 0);
    $is_done = ($progress >= $target) ? 1 : 0;
    
    $conn->query("UPDATE gb_mengajar_tantangan SET nama_tantangan='$nama', xp_reward=$xp, target=$target, progress=$progress, is_done=$is_done WHERE id=$id");
    return $conn->affected_rows;
}

function gamifikasi_delete_tantangan($conn, $id) {
    $id = (int)$id;
    $conn->query("DELETE FROM gb_mengajar_tantangan WHERE id=$id");
    return $conn->affected_rows;
}

function gamifikasi_delete_tantangan_bulk($conn, $ids) {
    if (empty($ids) || !is_array($ids)) return 0;
    $ids = array_map('intval', $ids);
    $idsStr = implode(',', $ids);
    $conn->query("DELETE FROM gb_mengajar_tantangan WHERE id IN ($idsStr)");
    return $conn->affected_rows;
}

function gamifikasi_upload_definition($file, $postData = []) {
    $uploadDir = __DIR__ . '/../../asset/docs/gamifikasi/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $tmpPath = $file['tmp_name'];
    $originalName = basename($file['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'ppt', 'pptx', 'doc', 'docx'];
    
    if (in_array($ext, $allowed)) {
        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName); // sanitize filename
        $destPath = $uploadDir . $safeName;
        if (move_uploaded_file($tmpPath, $destPath)) {
            
            // Append to catalog
            $catalogPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
            $catalog = [];
            if (file_exists($catalogPath)) {
                $catalog = json_decode(file_get_contents($catalogPath), true) ?: [];
            }
            
            $ikon = '📚';
            if ($ext === 'pdf') $ikon = '📕';
            if ($ext === 'ppt' || $ext === 'pptx') $ikon = '📽️';
            if ($ext === 'doc' || $ext === 'docx') $ikon = '📝';

            $status_akses = $postData['status_akses'] ?? 'gratis';
            $is_premium = ($status_akses === 'premium');
            $link_pembelian = $postData['link_pembelian'] ?? '';

            $newEntry = [
                'id' => 'up_' . time(),
                'kategori' => $postData['kategori_materi'] ?? 'Materi Tambahan',
                'judul' => $postData['judul_materi'] ?? $originalName,
                'deskripsi' => $postData['deskripsi_materi'] ?? 'Materi gamifikasi baru',
                'tipe' => $ext,
                'path' => '/guruverse/asset/docs/gamifikasi/uploads/' . $safeName,
                'ikon' => $ikon,
                'is_premium' => $is_premium,
                'link_pembelian' => $link_pembelian
            ];
            
            $catalog[] = $newEntry;
            file_put_contents($catalogPath, json_encode($catalog, JSON_PRETTY_PRINT));

            return ['success' => true, 'message' => "Materi berhasil diunggah: " . ($postData['judul_materi'] ?? $originalName)];
        } else {
            return ['success' => false, 'message' => "Gagal memindahkan file yang diunggah."];
        }
    } else {
        return ['success' => false, 'message' => "Format tidak valid. Hanya menerima PDF, PPT/PPTX, atau DOC/DOCX."];
    }
}

function gamifikasi_generate_json($postData) {
    $judul = $postData['game_judul'] ?? 'Untitled Game';
    $deskripsi = $postData['game_deskripsi'] ?? '';
    
    // Structure the JSON data
    $gameData = [
        'judul' => $judul,
        'tipe_game' => 'kuis_pilihan_ganda',
        'deskripsi' => $deskripsi,
        'pertanyaan' => []
    ];
    
    // Process dynamic questions
    $questions = $postData['q_soal'] ?? [];
    $opsiA = $postData['q_opsiA'] ?? [];
    $opsiB = $postData['q_opsiB'] ?? [];
    $opsiC = $postData['q_opsiC'] ?? [];
    $opsiD = $postData['q_opsiD'] ?? [];
    $kunci = $postData['q_kunci'] ?? [];
    
    foreach ($questions as $i => $soal) {
        if (trim($soal) === '') continue;
        
        $opsi = [
            $opsiA[$i] ?? '',
            $opsiB[$i] ?? '',
            $opsiC[$i] ?? '',
            $opsiD[$i] ?? ''
        ];
        // Remove empty options
        $opsi = array_values(array_filter($opsi, function($o) { return trim($o) !== ''; }));
        
        $kunciVal = $kunci[$i] ?? 'A';
        $jawaban_benar = $opsiA[$i] ?? '';
        if ($kunciVal === 'B') $jawaban_benar = $opsiB[$i] ?? '';
        if ($kunciVal === 'C') $jawaban_benar = $opsiC[$i] ?? '';
        if ($kunciVal === 'D') $jawaban_benar = $opsiD[$i] ?? '';
        
        $gameData['pertanyaan'][] = [
            'soal' => $soal,
            'opsi' => $opsi,
            'jawaban_benar' => $jawaban_benar
        ];
    }
    
    // Save to file
    $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', strtolower($judul)) . '.json';
    $uploadDir = __DIR__ . '/../../asset/docs/gamifikasi/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    
    $destPath = $uploadDir . $safeName;
    file_put_contents($destPath, json_encode($gameData, JSON_PRETTY_PRINT));
    
    // Update catalog
    $catalogPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
    $catalog = [];
    if (file_exists($catalogPath)) {
        $catalog = json_decode(file_get_contents($catalogPath), true) ?: [];
    }
    
    $status_akses = $postData['status_akses'] ?? 'gratis';
    $is_premium = ($status_akses === 'premium');
    $link_pembelian = $postData['link_pembelian'] ?? '';

    $catalog[] = [
        'id' => 'game_' . time(),
        'kategori' => 'Kuis & Teka-teki',
        'judul' => $judul,
        'deskripsi' => $deskripsi,
        'tipe' => 'json',
        'path' => '/guruverse/asset/docs/gamifikasi/uploads/' . $safeName,
        'ikon' => '🎮',
        'is_premium' => $is_premium,
        'link_pembelian' => $link_pembelian
    ];
    file_put_contents($catalogPath, json_encode($catalog, JSON_PRETTY_PRINT));
    return ['success' => true, 'message' => "Game Interaktif '$judul' berhasil dibuat!"];
}

function gamifikasi_delete_game($gameId) {
    if (empty($gameId)) return ['success' => false, 'message' => "ID tidak ditemukan."];
    
    $catalogPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
    if (!file_exists($catalogPath)) return ['success' => false, 'message' => "Katalog tidak ditemukan."];
    
    $catalog = json_decode(file_get_contents($catalogPath), true) ?: [];
    $newCatalog = [];
    $fileToDelete = '';
    $deletedTitle = '';
    
    foreach ($catalog as $k) {
        if (($k['id'] ?? '') === $gameId || ($k['path'] ?? '') === $gameId) { // Fallback to path if id doesn't exist
            $deletedTitle = $k['judul'];
            $fileToDelete = str_replace('/guruverse/asset/', __DIR__ . '/../../asset/', $k['path']);
        } else {
            $newCatalog[] = $k;
        }
    }
    
    if ($deletedTitle) {
        // Hapus file fisik jika ada
        if ($fileToDelete && file_exists($fileToDelete)) {
            @unlink($fileToDelete);
        }
        
        file_put_contents($catalogPath, json_encode($newCatalog, JSON_PRETTY_PRINT));
        return ['success' => true, 'message' => "Materi '$deletedTitle' berhasil dihapus!"];
    }
    
    return ['success' => false, 'message' => "Materi tidak ditemukan di katalog."];
}

function gamifikasi_delete_game_bulk($gameIds) {
    if (empty($gameIds) || !is_array($gameIds)) return ['success' => false, 'message' => "Tidak ada ID yang dipilih."];
    
    $catalogPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
    if (!file_exists($catalogPath)) return ['success' => false, 'message' => "Katalog tidak ditemukan."];
    
    $catalog = json_decode(file_get_contents($catalogPath), true) ?: [];
    $newCatalog = [];
    $deletedCount = 0;
    
    foreach ($catalog as $k) {
        $id = $k['id'] ?? $k['path'];
        if (in_array($id, $gameIds)) {
            $fileToDelete = str_replace('/guruverse/asset/', __DIR__ . '/../../asset/', $k['path']);
            if ($fileToDelete && file_exists($fileToDelete)) {
                @unlink($fileToDelete);
            }
            $deletedCount++;
        } else {
            $newCatalog[] = $k;
        }
    }
    
    if ($deletedCount > 0) {
        file_put_contents($catalogPath, json_encode($newCatalog, JSON_PRETTY_PRINT));
        return ['success' => true, 'message' => "$deletedCount materi berhasil dihapus!"];
    }
    
    return ['success' => false, 'message' => "Materi tidak ditemukan di katalog."];
}

function gamifikasi_update_game($postData) {
    $gameId = $postData['game_id'] ?? '';
    if (empty($gameId)) return ['success' => false, 'message' => "ID tidak ditemukan."];
    
    $catalogPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
    if (!file_exists($catalogPath)) return ['success' => false, 'message' => "Katalog tidak ditemukan."];
    
    $catalog = json_decode(file_get_contents($catalogPath), true) ?: [];
    $updated = false;
    
    foreach ($catalog as &$k) {
        $id = $k['id'] ?? $k['path'];
        if ($id === $gameId) {
            $k['judul'] = $postData['judul_materi'] ?? $k['judul'];
            $k['deskripsi'] = $postData['deskripsi_materi'] ?? $k['deskripsi'];
            $k['kategori'] = $postData['kategori_materi'] ?? $k['kategori'];
            
            $status_akses = $postData['status_akses'] ?? 'gratis';
            $k['is_premium'] = ($status_akses === 'premium');
            $k['link_pembelian'] = $postData['link_pembelian'] ?? '';
            
            $updated = true;
            break;
        }
    }
    
    if ($updated) {
        file_put_contents($catalogPath, json_encode($catalog, JSON_PRETTY_PRINT));
        return ['success' => true, 'message' => "Materi berhasil diperbarui!"];
    }
    
    return ['success' => false, 'message' => "Materi tidak ditemukan di katalog."];
}
?>
