<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../../database/config.php';
$conn = getConnection();

if (!isset($_SESSION['member_int_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$uid = (int)$_SESSION['member_int_id'];
$action = $_GET['action'] ?? '';

if ($action === 'get_batches') {
    $pelatihan_id = (int)($_GET['pelatihan_id'] ?? 0);
    $batches = [];
    $res = $conn->query("SELECT * FROM gb_mengajar_pelatihan_batch WHERE pelatihan_id = $pelatihan_id ORDER BY tanggal ASC");
    if ($res) {
        while($r = $res->fetch_assoc()) {
            $batches[] = $r;
        }
    }
    echo json_encode(['status' => 'success', 'data' => $batches]);
    exit;
}

if ($action === 'register') {
    $batch_id = (int)($_POST['batch_id'] ?? 0);
    
    // Cek keberadaan batch
    $res = $conn->query("SELECT * FROM gb_mengajar_pelatihan_batch WHERE id = $batch_id");
    if (!$res || $res->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Batch pelatihan tidak ditemukan.']);
        exit;
    }
    
    $batch = $res->fetch_assoc();
    if ((int)$batch['sisa_kursi'] <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Kuota batch sudah penuh.']);
        exit;
    }
    
    // Cek apakah user sudah daftar di batch ini
    $check = $conn->query("SELECT id FROM gb_mengajar_peserta_pelatihan WHERE batch_id = $batch_id AND member_id = $uid");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Anda sudah terdaftar di angkatan ini.']);
        exit;
    }
    
    // Validasi Voucher (opsional)
    $voucher_code = trim($_POST['voucher_code'] ?? '');
    $discount_msg = '';
    $voucher_valid = false;
    if ($voucher_code !== '') {
        $v_res = $conn->prepare("SELECT id, discount_percent FROM gb_vouchers WHERE voucher_code = ? AND is_used = 0 AND owner_id = ?");
        $v_res->bind_param("si", $voucher_code, $uid);
        $v_res->execute();
        $v_data = $v_res->get_result();
        if ($v_row = $v_data->fetch_assoc()) {
            $voucher_valid = true;
            $discount_msg = " Anda mendapatkan diskon {$v_row['discount_percent']}%.";
        }
        $v_res->close();
    }
    
    // Generate Unique Ticket
    $ticket_code = 'TIX-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 5));
    
    $stmt = $conn->prepare("INSERT INTO gb_mengajar_peserta_pelatihan (batch_id, member_id, ticket_code) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $batch_id, $uid, $ticket_code);
    
    if ($stmt->execute()) {
        $conn->query("UPDATE gb_mengajar_pelatihan_batch SET sisa_kursi = sisa_kursi - 1 WHERE id = $batch_id");
        
        // Tandai voucher sudah dipakai
        if ($voucher_valid) {
            $uv_stmt = $conn->prepare("UPDATE gb_vouchers SET is_used = 1, used_at = NOW() WHERE voucher_code = ?");
            $uv_stmt->bind_param("s", $voucher_code);
            $uv_stmt->execute();
            $uv_stmt->close();
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil!' . $discount_msg, 'ticket_code' => $ticket_code]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pendaftaran.']);
    }
    exit;
}

if ($action === 'get_ticket') {
    $pelatihan_id = (int)($_GET['pelatihan_id'] ?? 0);
    
    // Cari pendaftaran yang relevan dengan pelatihan ini
    $query = "SELECT pt.*, b.nama_batch, b.tanggal, b.waktu, b.lokasi, p.title 
              FROM gb_mengajar_peserta_pelatihan pt
              JOIN gb_mengajar_pelatihan_batch b ON pt.batch_id = b.id
              JOIN gb_mengajar_pelatihan p ON b.pelatihan_id = p.id
              WHERE p.id = $pelatihan_id AND pt.member_id = $uid LIMIT 1";
              
    $res = $conn->query($query);
    if ($res && $res->num_rows > 0) {
        $data = $res->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tiket tidak ditemukan.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
