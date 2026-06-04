<?php
// modules/member/login/set_first_password.php
header('Content-Type: application/json; charset=utf-8');

require_once '../../../database/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$action    = $_POST['action'] ?? '';
$member_id = trim($_POST['member_id'] ?? '');
$phone     = trim($_POST['phone'] ?? '');

if (!$member_id || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Member ID dan Nomor WhatsApp wajib diisi']);
    exit;
}

// Normalisasi nomor phone input (hapus karakter non-digit)
$clean_phone = preg_replace('/\D/', '', $phone);
if (str_starts_with($clean_phone, '62')) {
    $clean_phone = '0' . substr($clean_phone, 2);
}

$conn = getConnection();

if ($action === 'verify') {
    // Cari member berdasarkan member_id
    $stmt = $conn->prepare("SELECT id, phone FROM members WHERE member_id = ?");
    $stmt->bind_param('s', $member_id);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        $member = $res->fetch_assoc();
        // Bersihkan phone dari database untuk pencocokan yang fleksibel
        $db_phone = preg_replace('/\D/', '', $member['phone'] ?? '');
        if (str_starts_with($db_phone, '62')) {
            $db_phone = '0' . substr($db_phone, 2);
        }
        
        if ($clean_phone !== '' && ($clean_phone === $db_phone || str_contains($db_phone, $clean_phone) || str_contains($clean_phone, $db_phone))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nomor WhatsApp tidak cocok dengan data di sistem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Data Member ID tidak ditemukan.']);
    }
    $stmt->close();

} elseif ($action === 'save') {
    // Simpan password baru
    $password = $_POST['password'] ?? '';
    
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter']);
        exit;
    }

    // Cari member dulu untuk verifikasi phone lagi
    $stmt = $conn->prepare("SELECT id, phone FROM members WHERE member_id = ?");
    $stmt->bind_param('s', $member_id);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        $member = $res->fetch_assoc();
        $db_phone = preg_replace('/\D/', '', $member['phone'] ?? '');
        if (str_starts_with($db_phone, '62')) {
            $db_phone = '0' . substr($db_phone, 2);
        }
        
        if ($clean_phone !== '' && ($clean_phone === $db_phone || str_contains($db_phone, $clean_phone) || str_contains($clean_phone, $db_phone))) {
            // Hash password dengan BCRYPT
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            // Update password & username (isi username dengan member_id jika kosong)
            $stmt_up = $conn->prepare("UPDATE members SET password = ?, must_change_pass = 0, username = CASE WHEN username = '' OR username IS NULL THEN ? ELSE username END WHERE member_id = ?");
            $stmt_up->bind_param('sss', $hashed, $member_id, $member_id);
            
            if ($stmt_up->execute()) {
                echo json_encode(['success' => true, 'message' => 'Password berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui password.']);
            }
            $stmt_up->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Nomor WhatsApp tidak cocok.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Member ID tidak ditemukan.']);
    }
    $stmt->close();
}

$conn->close();
