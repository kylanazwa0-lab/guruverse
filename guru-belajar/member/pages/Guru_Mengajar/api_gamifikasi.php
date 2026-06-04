<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['member_int_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$uid = (int)$_SESSION['member_int_id'];
require_once '../../../../database/config.php';
$conn = getConnection();

$action = $_GET['action'] ?? '';

if ($action == 'use_free_play') {
    // Cek stats
    $res = $conn->query("SELECT free_gamification_left, is_premium_gamifikasi FROM gb_mengajar_stats WHERE member_id = $uid");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $left = (int)$row['free_gamification_left'];
        $premium = (int)$row['is_premium_gamifikasi'];
        
        if ($premium == 1) {
            echo json_encode(['status' => 'success', 'premium' => true]);
            exit;
        }
        
        if ($left > 0) {
            // Kurangi 1
            $conn->query("UPDATE gb_mengajar_stats SET free_gamification_left = free_gamification_left - 1 WHERE member_id = $uid");
            echo json_encode(['status' => 'success', 'premium' => false, 'left' => $left - 1]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Jatah gratis habis', 'code' => 'OUT_OF_FREE_PLAYS']);
            exit;
        }
    }
}

if ($action == 'upgrade_premium') {
    // Simulasi upgrade premium
    $conn->query("UPDATE gb_mengajar_stats SET is_premium_gamifikasi = 1 WHERE member_id = $uid");
    echo json_encode(['status' => 'success']);
    exit;
}

if ($action == 'checkout_cart') {
    // Process JSON POST
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['game_ids']) || !is_array($input['game_ids'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }
    
    // Create table if not exists
    $conn->query("CREATE TABLE IF NOT EXISTS gb_mengajar_games_owned (
        id INT AUTO_INCREMENT PRIMARY KEY,
        member_id INT NOT NULL,
        game_id VARCHAR(100) NOT NULL,
        purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
    )");
    
    $purchased = [];
    foreach($input['game_ids'] as $gid) {
        $gid_clean = $conn->real_escape_string($gid);
        // Check if already owned
        $chk = $conn->query("SELECT id FROM gb_mengajar_games_owned WHERE member_id = $uid AND game_id = '$gid_clean'");
        if ($chk && $chk->num_rows == 0) {
            $conn->query("INSERT INTO gb_mengajar_games_owned (member_id, game_id) VALUES ($uid, '$gid_clean')");
            $purchased[] = $gid;
        }
    }
    
    echo json_encode(['status' => 'success', 'purchased' => $purchased]);
    exit;
}

if ($action == 'get_owned_games') {
    $owned = [];
    $res = $conn->query("SELECT game_id FROM gb_mengajar_games_owned WHERE member_id = $uid");
    if ($res) {
        while($r = $res->fetch_assoc()) {
            $owned[] = $r['game_id'];
        }
    }
    echo json_encode(['status' => 'success', 'owned' => $owned]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
