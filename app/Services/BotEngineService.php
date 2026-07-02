<?php

namespace App\Services;

use App\Models\Diskusi;
use App\Models\DiskusiReply;
use Illuminate\Support\Facades\DB;

class BotEngineService
{
    /**
     * Guruverse Bot Engine (Rule-Based)
     * Fungsi ini digunakan untuk merespons pesan secara otomatis berdasarkan kata kunci.
     */
    public static function trigger($discussion_id, $user_message)
    {
        $lower_body = strtolower($user_message);
        $bot_reply = "";

        // Fetch dynamic knowledge from database
        $rules = DB::table('gb_bot_rules')->get();
        $bot_knowledge = [];
        
        foreach ($rules as $row) {
            $bot_knowledge[] = [
                'keywords' => array_map('trim', explode(',', $row->keywords)),
                'answer' => $row->answer
            ];
        }

        // Cek setiap kata kunci di dalam pesan pengguna
        foreach ($bot_knowledge as $knowledge) {
            foreach ($knowledge['keywords'] as $keyword) {
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

            // user_id = -99 adalah ID penanda khusus untuk Guruverse Bot
            DiskusiReply::create([
                'discussion_id' => $discussion_id,
                'user_id' => -99,
                'body' => $bot_reply,
                'attachment_path' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Diskusi::where('id', $discussion_id)->increment('replies_count');
        }
    }
}
