<?php
// controllers/NotifikasiController.php - Kirim notifikasi ke member
require_once __DIR__ . '/../../database/config.php';

function notif_get_all($conn, $limit = 50) {
    $res = $conn->query("SELECT n.*, m.full_name as member_name 
                         FROM gb_notifications n 
                         LEFT JOIN members m ON n.user_id = m.id 
                         ORDER BY n.created_at DESC LIMIT $limit");
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}

function notif_send($conn, $data) {
    $title    = $conn->real_escape_string($data['title'] ?? '');
    $message  = $conn->real_escape_string($data['message'] ?? '');
    $target   = $data['target'] ?? 'all'; // 'all' or specific user_id
    $link     = $conn->real_escape_string($data['link'] ?? '');

    if ($target === 'all') {
        // Kirim ke semua member
        $res = $conn->query("SELECT id FROM members");
        $count = 0;
        while ($m = $res->fetch_assoc()) {
            $uid = (int)$m['id'];
            $conn->query("INSERT INTO gb_notifications (user_id,title,message,link,is_read,created_at) 
                          VALUES ($uid,'$title','$message','$link',0,NOW())");
            $count++;
        }
        return $count;
    } else {
        $uid = (int)$target;
        $conn->query("INSERT INTO gb_notifications (user_id,title,message,link,is_read,created_at) 
                      VALUES ($uid,'$title','$message','$link',0,NOW())");
        return 1;
    }
}

function notif_delete($conn, $id) {
    $id = (int)$id;
    $conn->query("DELETE FROM gb_notifications WHERE id=$id");
    return $conn->affected_rows;
}
