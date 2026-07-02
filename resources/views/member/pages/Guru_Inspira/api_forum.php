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

// Helper for time ago
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',
        'w' => 'minggu',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}

function getInitials($name) {
    $parts = explode(' ', $name);
    $in = strtoupper(substr($parts[0], 0, 1));
    if(count($parts) > 1) $in .= strtoupper(substr($parts[1], 0, 1));
    return $in;
}

if ($action === 'get_all') {
    $data = ['categories' => [], 'threads' => [], 'popular' => [], 'active_gurus' => [], 'agenda' => []];
    
    // Categories
    $resC = $conn->query("SELECT f.*, (SELECT COUNT(*) FROM gb_inspira_forum_threads WHERE forum_id = f.id) as thread_count FROM gb_inspira_forum f ORDER BY f.id ASC");
    if($resC) while($r = $resC->fetch_assoc()) $data['categories'][] = $r;
    
    // Threads
    $resT = $conn->query("
        SELECT t.*, m.full_name as author_name, m.jabatan as author_role, f.judul as forum_name, f.warna_bg as forum_bg, f.icon as forum_icon,
        (SELECT COUNT(*) FROM gb_inspira_forum_replies WHERE thread_id = t.id) as reply_count
        FROM gb_inspira_forum_threads t
        JOIN members m ON t.author_id = m.id
        JOIN gb_inspira_forum f ON t.forum_id = f.id
        ORDER BY t.created_at DESC
    ");
    if($resT) {
        while($r = $resT->fetch_assoc()) {
            $r['time_ago'] = time_elapsed_string($r['created_at']);
            $r['author_initials'] = getInitials($r['author_name']);
            // Fallback for role
            if(empty($r['author_role'])) $r['author_role'] = 'Guru SD'; 
            $data['threads'][] = $r;
        }
    }
    
    // Widget: Topik Populer (top 5 by views/likes)
    $resP = $conn->query("
        SELECT t.id, t.judul, t.views 
        FROM gb_inspira_forum_threads t
        ORDER BY t.views DESC, t.likes DESC 
        LIMIT 5
    ");
    if($resP) while($r = $resP->fetch_assoc()) $data['popular'][] = $r;
    
    // Widget: Guru Aktif (top 3 by posts+replies)
    $resG = $conn->query("
        SELECT m.id, m.full_name, m.jabatan,
        (SELECT COUNT(*) FROM gb_inspira_forum_threads WHERE author_id = m.id) + 
        (SELECT COUNT(*) FROM gb_inspira_forum_replies WHERE author_id = m.id) as total_kontribusi
        FROM members m
        HAVING total_kontribusi > 0
        ORDER BY total_kontribusi DESC
        LIMIT 3
    ");
    if($resG) {
        while($r = $resG->fetch_assoc()) {
            $r['initials'] = getInitials($r['full_name']);
            if(empty($r['jabatan'])) $r['jabatan'] = 'Guru SD'; 
            $data['active_gurus'][] = $r;
        }
    }
    
    // Widget: Agenda Komunitas
    $resA = $conn->query("
        SELECT id, judul, event_date, icon, warna_bg, warna_text 
        FROM gb_inspira_event 
        WHERE event_date >= NOW() 
        ORDER BY event_date ASC 
        LIMIT 3
    ");
    if($resA) {
        while($r = $resA->fetch_assoc()) {
            $dt = new DateTime($r['event_date']);
            $r['tanggal_formatted'] = $dt->format('d M Y') . ' &bull; ' . $dt->format('H:i') . ' WIB';
            $data['agenda'][] = $r;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

if ($action === 'create_thread') {
    $forum_id = (int)$_POST['forum_id'];
    $judul = trim($_POST['judul'] ?? '');
    $konten = trim($_POST['konten'] ?? '');
    
    if(!$judul || !$konten || !$forum_id) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_forum_threads (forum_id, author_id, judul, konten) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $forum_id, $uid, $judul, $konten);
    if($stmt->execute()) {
        $conn->query("UPDATE gb_inspira_forum SET total_postingan = total_postingan + 1 WHERE id = $forum_id");
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan']);
    }
    exit;
}

if ($action === 'view_thread') {
    $id = (int)$_GET['id'];
    $conn->query("UPDATE gb_inspira_forum_threads SET views = views + 1 WHERE id = $id");
    echo json_encode(['status' => 'success']);
    exit;
}

if ($action === 'get_thread_detail') {
    $id = (int)$_GET['id'];
    
    $resT = $conn->query("
        SELECT t.*, m.full_name as author_name, f.judul as forum_name, f.warna_bg, f.icon
        FROM gb_inspira_forum_threads t
        JOIN members m ON t.author_id = m.id
        JOIN gb_inspira_forum f ON t.forum_id = f.id
        WHERE t.id = $id
    ");
    $thread = $resT->fetch_assoc();
    if(!$thread) {
        echo json_encode(['status' => 'error', 'message' => 'Thread not found']);
        exit;
    }
    $thread['time_ago'] = time_elapsed_string($thread['created_at']);
    $thread['author_initials'] = getInitials($thread['author_name']);
    $thread['konten'] = nl2br(htmlspecialchars($thread['konten']));
    
    // Replies
    $replies = [];
    $resR = $conn->query("
        SELECT r.*, m.full_name as author_name 
        FROM gb_inspira_forum_replies r
        JOIN members m ON r.author_id = m.id
        WHERE r.thread_id = $id
        ORDER BY r.created_at ASC
    ");
    if($resR) {
        while($r = $resR->fetch_assoc()) {
            $r['time_ago'] = time_elapsed_string($r['created_at']);
            $r['author_initials'] = getInitials($r['author_name']);
            $r['konten'] = nl2br(htmlspecialchars($r['konten']));
            $replies[] = $r;
        }
    }
    
    echo json_encode([
        'status' => 'success', 
        'data' => [
            'thread' => $thread,
            'replies' => $replies
        ]
    ]);
    exit;
}

if ($action === 'create_reply') {
    $thread_id = (int)$_POST['thread_id'];
    $konten = trim($_POST['konten'] ?? '');
    
    if(!$konten || !$thread_id) {
        echo json_encode(['status' => 'error', 'message' => 'Komentar tidak boleh kosong']);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO gb_inspira_forum_replies (thread_id, author_id, konten) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $thread_id, $uid, $konten);
    if($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal membalas']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
