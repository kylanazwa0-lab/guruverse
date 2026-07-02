<?php
/**
 * API: Get notifications for authenticated member
 * GET  → returns notifications for logged-in user
 * POST → marks notifications as pushed/read
 * 
 * SECURITY: user_id SELALU diambil dari session, TIDAK dari parameter GET/POST
 */
header('Content-Type: application/json; charset=utf-8');

// Cegah cache
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// Pastikan sesi dimulai
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    session_start();
}

// Wajib login — jika tidak ada sesi valid, kembalikan error 401
if (empty($_SESSION['member_int_id']) || empty($_SESSION['member_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Sesi tidak valid.', 'notifications' => [], 'count' => 0]);
    exit;
}

require_once __DIR__ . '/../../../database/config.php';

$conn = getConnection();

// user_id SELALU dari session — tidak bisa dimanipulasi dari luar
$user_id = (int)$_SESSION['member_int_id'];

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $action = $_GET['action'] ?? 'unpushed';
    
    if ($action === 'unpushed') {
        $stmt = $conn->prepare("SELECT id, title, body, icon, link, created_at FROM gb_notifications WHERE user_id = ? AND is_pushed = 0 ORDER BY created_at DESC LIMIT 10");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifs = [];
        while ($row = $result->fetch_assoc()) {
            $notifs[] = $row;
        }
        $stmt->close();
        echo json_encode(['success' => true, 'notifications' => $notifs]);
    }
    elseif ($action === 'unread_count') {
        $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM gb_notifications WHERE user_id = ? AND is_read = 0");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        echo json_encode(['success' => true, 'count' => (int)$row['cnt']]);
    }
    elseif ($action === 'all') {
        $stmt = $conn->prepare("SELECT id, title, body, icon, link, is_read, created_at FROM gb_notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 20");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifs = [];
        while ($row = $result->fetch_assoc()) {
            $notifs[] = $row;
        }
        $stmt->close();
        echo json_encode(['success' => true, 'notifications' => $notifs]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Action tidak dikenal.']);
    }
}
elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        echo json_encode(['success' => false, 'message' => 'Body tidak valid.']);
        exit;
    }
    $action = $input['action'] ?? '';
    
    if ($action === 'mark_pushed') {
        $ids = $input['ids'] ?? [];
        // Validasi: pastikan semua ID adalah integer positif
        $ids = array_filter(array_map('intval', $ids), fn($id) => $id > 0);
        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $types = str_repeat('i', count($ids));
            // Tambahkan user_id di WHERE untuk memastikan user hanya bisa update notif miliknya
            $stmt = $conn->prepare("UPDATE gb_notifications SET is_pushed = 1 WHERE id IN ($placeholders) AND user_id = ?");
            $params = array_merge(array_values($ids), [$user_id]);
            $stmt->bind_param($types . 'i', ...$params);
            $stmt->execute();
            $stmt->close();
        }
        echo json_encode(['success' => true]);
    }
    elseif ($action === 'mark_read') {
        $stmt = $conn->prepare("UPDATE gb_notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
    }
    elseif ($action === 'mark_one_read') {
        $id = (int)($input['id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE gb_notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Action tidak dikenal.']);
    }
}
else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan.']);
}

$conn->close();
