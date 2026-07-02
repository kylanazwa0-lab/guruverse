<?php
/**
 * GURUVERSE.ID - Member Update Profile API
 * Path: guru-belajar/member/api/update_profile.php
 */

ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

function sendJsonResponse(bool $success, string $message = '', array $extra = [], int $httpCode = 200): void {
    if (ob_get_length()) ob_clean();
    http_response_code($httpCode);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Method tidak diizinkan.', [], 405);
}

// Cek apakah member sedang login
if (!isset($_SESSION['member_int_id'])) {
    sendJsonResponse(false, 'Sesi Anda telah berakhir. Silakan login kembali.', [], 401);
}

require_once __DIR__ . '/../../../database/config.php';

$userId = (int)$_SESSION['member_int_id'];
$conn   = getConnection();
$action = $_GET['action'] ?? 'profile';

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // ── Avatar Upload ─────────────────────────────
    if ($action === 'avatar') {
        if (empty($_FILES['avatar']['tmp_name'])) {
            sendJsonResponse(false, 'Tidak ada file yang diunggah.');
        }
        $file = $_FILES['avatar'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed)) {
            sendJsonResponse(false, 'Format file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WebP.');
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            sendJsonResponse(false, 'Ukuran file maksimal 2MB.');
        }

        $uploadDir = __DIR__ . '/../../../../uploads/avatars/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
        $dest = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            sendJsonResponse(false, 'Gagal menyimpan file.');
        }

        // Delete old avatar
        $stmt = $conn->prepare("SELECT avatar FROM members WHERE id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!empty($old['avatar'])) {
            $oldPath = $uploadDir . $old['avatar'];
            if (file_exists($oldPath)) @unlink($oldPath);
        }

        $stmt = $conn->prepare("UPDATE members SET avatar = ? WHERE id = ?");
        $stmt->bind_param('si', $filename, $userId);
        $stmt->execute();
        $stmt->close();
        sendJsonResponse(true, 'Foto profil berhasil diperbarui.', ['avatar' => $filename]);
    }

    // ── Avatar Delete ─────────────────────────────
    if ($action === 'avatar_delete') {
        $stmt = $conn->prepare("SELECT avatar FROM members WHERE id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!empty($old['avatar'])) {
            $uploadDir = __DIR__ . '/../../../../uploads/avatars/';
            $oldPath = $uploadDir . $old['avatar'];
            if (file_exists($oldPath)) @unlink($oldPath);
        }
        $stmt = $conn->prepare("UPDATE members SET avatar = NULL WHERE id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->close();
        sendJsonResponse(true, 'Foto profil dihapus.');
    }

    // ── Change Password ─────────────────────────────
    if ($action === 'password') {
        $oldPass = $_POST['old_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        if (empty($oldPass) || empty($newPass) || strlen($newPass) < 8) {
            sendJsonResponse(false, 'Data tidak valid atau password baru kurang dari 8 karakter.');
        }
        $stmt = $conn->prepare("SELECT password FROM members WHERE id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!password_verify($oldPass, $row['password'] ?? '')) {
            sendJsonResponse(false, 'Password lama tidak sesuai.');
        }
        $hashed = password_hash($newPass, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE members SET password = ? WHERE id = ?");
        $stmt->bind_param('si', $hashed, $userId);
        $stmt->execute();
        $stmt->close();
        sendJsonResponse(true, 'Password berhasil diperbarui.');
    }

    // ── Save Notif Prefs ─────────────────────────────
    if ($action === 'notif') {
        // Store as JSON in a meta column or just return success (DB schema may vary)
        $prefs = $_POST['notif_prefs'] ?? '{}';
        $stmt = $conn->prepare("UPDATE members SET notif_prefs = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param('si', $prefs, $userId);
            $stmt->execute();
            $stmt->close();
        }
        sendJsonResponse(true, 'Preferensi notifikasi disimpan.');
    }

    // ── Default: Update Profile ─────────────────────
    $fullName    = trim($_POST['fullName'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $city        = trim($_POST['city'] ?? '');
    $institution = trim($_POST['institution'] ?? '');
    $subject     = trim($_POST['subject'] ?? '');

    if (empty($fullName)) {
        sendJsonResponse(false, 'Nama lengkap wajib diisi.');
    }

    // Cek jika email sudah digunakan oleh member lain
    if (!empty($email)) {
        $stmt_check = $conn->prepare("SELECT id FROM members WHERE email = ? AND id != ?");
        $stmt_check->bind_param('si', $email, $userId);
        $stmt_check->execute();
        $res = $stmt_check->get_result();
        if ($res->num_rows > 0) {
            $stmt_check->close();
            sendJsonResponse(false, 'Alamat email ini sudah digunakan oleh akun lain.');
        }
        $stmt_check->close();
    }

    $stmt = $conn->prepare("UPDATE members SET full_name = ?, email = ?, phone = ?, city = ?, institution = ?, subject = ? WHERE id = ?");
    $stmt->bind_param('ssssssi', $fullName, $email, $phone, $city, $institution, $subject, $userId);
    
    if ($stmt->execute()) {
        sendJsonResponse(true, 'Profil Anda berhasil diperbarui.');
    } else {
        sendJsonResponse(false, 'Gagal menyimpan perubahan profil.');
    }
    $stmt->close();

} catch (Exception $e) {
    sendJsonResponse(false, 'Terjadi kesalahan sistem: ' . $e->getMessage());
} finally {
    $conn->close();
}
