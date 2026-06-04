<?php
// includes/bot_engine.php

/**
 * Guruverse Bot Engine (Rule-Based)
 * Fungsi ini digunakan untuk merespons pesan secara otomatis berdasarkan kata kunci.
 */
function trigger_guruverse_bot($discussion_id, $user_message, $conn) {
    $lower_body = strtolower($user_message);
    $bot_reply = "";
    
    // Fetch dynamic knowledge from database
    $bot_knowledge = [];
    $res = $conn->query("SELECT * FROM gb_bot_rules");
    if ($res) {
        while($row = $res->fetch_assoc()) {
            // keywords are stored as comma-separated string
            $bot_knowledge[] = [
                'keywords' => array_map('trim', explode(',', $row['keywords'])),
                'answer' => $row['answer']
            ];
        }
    }

    // Cek setiap kata kunci di dalam pesan pengguna
    foreach($bot_knowledge as $knowledge) {
        foreach($knowledge['keywords'] as $keyword) {
            if (strpos($lower_body, $keyword) !== false) {
                $bot_reply = $knowledge['answer'];
                break 2; // Berhenti mencari jika sudah ada kecocokan
            }
        }
    }

    // Jika ada jawaban yang cocok, kirimkan balasan
    if ($bot_reply !== "") {
        // Jeda 1 detik agar simulasi mengetik terasa natural
        sleep(1);
        
        $bot_body = $conn->real_escape_string($bot_reply);
        // user_id = -99 adalah ID penanda khusus untuk Guruverse Bot
        $conn->query("INSERT INTO gb_discussion_replies (discussion_id, user_id, body, attachment_path, created_at) VALUES ($discussion_id, -99, '$bot_body', NULL, NOW())");
        
        // Update jumlah balasan pada tabel diskusi utama
        $conn->query("UPDATE gb_discussions SET replies_count = replies_count + 1 WHERE id=$discussion_id");
    }
}
