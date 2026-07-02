<?php
session_start();
require_once __DIR__ . '/../../../database/config.php';

if (!isset($_SESSION['member_id']) && !isset($_SESSION['member_int_id'])) {
    echo json_encode(['success' => false, 'message' => 'Harap login terlebih dahulu']);
    exit;
}

$conn = getConnection();
// Resolve user ID
$user_id = $_SESSION['member_int_id'] ?? null;
if (!$user_id && isset($_SESSION['member_id'])) {
    $stmt = $conn->prepare("SELECT id FROM members WHERE member_id = ?");
    $stmt->bind_param("s", $_SESSION['member_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $user_id = $row['id'];
        $_SESSION['member_int_id'] = $user_id;
    }
    $stmt->close();
}
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

$action = $_GET['action'] ?? '';
$message = trim($_POST['message'] ?? '');

if ($action === 'init') {
    // Cari sesi aktif
    $stmt = $conn->prepare("SELECT id, status FROM gb_chat_sessions WHERE user_id = ? AND status != 'closed' ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $session = $res->fetch_assoc();
    $stmt->close();

    if (!$session) {
        $stmt = $conn->prepare("INSERT INTO gb_chat_sessions (user_id, status) VALUES (?, 'bot')");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $session_id = $stmt->insert_id;
        $stmt->close();
        
        $session = ['id' => $session_id, 'status' => 'bot'];
        
        // Kirim pesan selamat datang
        $welcome_msg = "Halo! Saya dari tim Guruverse. Ada yang bisa saya bantu hari ini?";
        $stmt = $conn->prepare("INSERT INTO gb_chat_messages (session_id, sender_type, message) VALUES (?, 'bot', ?)");
        $stmt->bind_param("is", $session_id, $welcome_msg);
        $stmt->execute();
        $stmt->close();
    }
    
    echo json_encode(['success' => true, 'session_id' => $session['id'], 'status' => $session['status']]);
    exit;
}

if ($action === 'send') {
    $session_id = intval($_POST['session_id'] ?? 0);
    if (!$session_id || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    // Insert user message
    $stmt = $conn->prepare("INSERT INTO gb_chat_messages (session_id, sender_type, message) VALUES (?, 'user', ?)");
    $stmt->bind_param("is", $session_id, $message);
    $stmt->execute();
    $user_msg_id = $stmt->insert_id;
    $stmt->close();

    // Check session status
    $stmt = $conn->prepare("SELECT status FROM gb_chat_sessions WHERE id = ?");
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $session = $res->fetch_assoc();
    $stmt->close();
    
    $status = $session['status'] ?? 'bot';
    
    // Switch to admin requested?
    if (stripos($message, 'admin') !== false || stripos($message, 'bantuan') !== false || stripos($message, 'manusia') !== false || stripos($message, 'tanya') !== false) {
        if ($status === 'bot') {
            $stmt = $conn->prepare("UPDATE gb_chat_sessions SET status = 'waiting_admin' WHERE id = ?");
            $stmt->bind_param("i", $session_id);
            $stmt->execute();
            $stmt->close();
            
            $reply = "Mohon tunggu sebentar ya, saya akan meneruskan obrolan ini ke tim Admin kami. 👩‍💼 Mereka akan segera membalas di sini.";
            $stmt = $conn->prepare("INSERT INTO gb_chat_messages (session_id, sender_type, message) VALUES (?, 'bot', ?)");
            $stmt->bind_param("is", $session_id, $reply);
            $stmt->execute();
            
            echo json_encode(['success' => true, 'status' => 'waiting_admin', 'reply' => $reply]);
            exit;
        }
    }

    if ($status === 'bot') {
        // Simple NLP: bot rules
        $stmt = $conn->prepare("SELECT keywords, answer FROM gb_bot_rules");
        $stmt->execute();
        $res = $stmt->get_result();
        $rules = [];
        while($r = $res->fetch_assoc()) $rules[] = $r;
        $stmt->close();

        $matched_answer = null;
        $msg_lower = strtolower($message);
        foreach ($rules as $rule) {
            $keywords = explode(',', strtolower($rule['keywords']));
            foreach ($keywords as $kw) {
                if (trim($kw) !== '' && strpos($msg_lower, trim($kw)) !== false) {
                    $matched_answer = $rule['answer'];
                    break 2;
                }
            }
        }
        
        if (!$matched_answer) {
            $matched_answer = "Maaf, saya belum memahami pertanyaan Anda. 😅\n\nJika ini masalah penting, ketik 'Admin' untuk mengobrol langsung dengan tim kami.";
        }

        $stmt = $conn->prepare("INSERT INTO gb_chat_messages (session_id, sender_type, message) VALUES (?, 'bot', ?)");
        $stmt->bind_param("is", $session_id, $matched_answer);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true, 'reply' => $matched_answer, 'status' => 'bot']);
    } else {
        // waiting_admin or active
        echo json_encode(['success' => true, 'status' => $status]); // no bot reply
    }
}
