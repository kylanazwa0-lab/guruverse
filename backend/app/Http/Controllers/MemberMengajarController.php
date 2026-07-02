<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberMengajarController extends Controller
{
    /**
     * Helper to get user initials
     */
    private function getUserInitials($fullName)
    {
        $parts = explode(' ', trim($fullName ?? 'Member'));
        $initials = strtoupper(substr($parts[0] ?? 'M', 0, 1));
        if (count($parts) > 1 && isset($parts[1][0])) {
            $initials .= strtoupper(substr($parts[1], 0, 1));
        } else {
            $initials .= strtoupper(substr($parts[0] ?? 'M', 1, 1));
        }
        return $initials;
    }

    /**
     * Play Gamifikasi Game (GET)
     */
    public function play(Request $request)
    {
        $fileParam = $request->query('file') ?? $request->query('id') ?? '';
        if (empty($fileParam)) {
            abort(404, 'File game tidak ditemukan.');
        }

        // Security: Prevent directory traversal
        if (strpos($fileParam, '..') !== false) {
            abort(403, 'Akses ditolak.');
        }

        // Resolve absolute path in public
        $absolutePath = public_path(ltrim(str_replace('/guruverse/', '', $fileParam), '/'));

        if (!file_exists($absolutePath)) {
            // Try fallback if path is relative or under storage
            $absolutePath = public_path('asset/docs/gamifikasi/uploads/' . basename($fileParam));
            if (!file_exists($absolutePath)) {
                // Return fallback mock questions if JSON not found
                $game = [
                    'judul' => 'Kuis Pengetahuan Umum Kelas',
                    'deskripsi' => 'Asah otak dengan kuis seru interaktif ini!',
                    'tipe_game' => 'kuis_pilihan_ganda',
                    'pertanyaan' => [
                        [
                            'soal' => 'Siapakah pencipta lagu kebangsaan Indonesia Raya?',
                            'opsi' => ['W.R. Supratman', 'C. Simanjuntak', 'Ibu Sud', 'L. Manik'],
                            'jawaban_benar' => 'W.R. Supratman'
                        ],
                        [
                            'soal' => 'Berapakah jumlah sila dalam Pancasila?',
                            'opsi' => ['3 Sila', '4 Sila', '5 Sila', '6 Sila'],
                            'jawaban_benar' => '5 Sila'
                        ],
                        [
                            'soal' => 'Apa lambang sila ke-3 Pancasila?',
                            'opsi' => ['Bintang', 'Rantai', 'Pohon Beringin', 'Kepala Banteng'],
                            'jawaban_benar' => 'Pohon Beringin'
                        ]
                    ]
                ];
                $title = $game['judul'];
                $desc = $game['deskripsi'];
                $jsonQuestions = json_encode($game['pertanyaan']);
                return view('member.mengajar.gamifikasi_play', compact('title', 'desc', 'jsonQuestions'));
            }
        }

        $jsonData = file_get_contents($absolutePath);
        if (!$jsonData) {
            abort(500, 'Gagal membaca file game.');
        }

        $game = json_decode($jsonData, true);
        if (!$game) {
            abort(500, 'Format file JSON tidak valid.');
        }

        $title = $game['judul'] ?? 'Kuis Interaktif';
        $desc = $game['deskripsi'] ?? 'Mari bermain dan belajar!';
        $questions = $game['pertanyaan'] ?? [];
        $jsonQuestions = json_encode($questions);

        return view('member.mengajar.gamifikasi_play', compact('title', 'desc', 'jsonQuestions'));
    }

    /**
     * Dashboard Personal Guru Mengajar
     */
    public function index()
    {
        $member = Auth::guard('web')->user();
        $uid = $member->id;

        // Fetch stats
        $stats = DB::table('gb_mengajar_stats')->where('member_id', $uid)->first();
        if (!$stats) {
            DB::table('gb_mengajar_stats')->insert([
                'member_id' => $uid,
                'total_xp' => 0,
                'level_saat_ini' => 1,
                'hari_streak' => 0,
                'badge_diraih' => 0,
                'free_gamification_left' => 3,
                'is_premium_gamifikasi' => 0
            ]);
            $stats = DB::table('gb_mengajar_stats')->where('member_id', $uid)->first();
        }

        // Convert object to array for easier compatibility with legacy template syntax
        $stats = (array)$stats;

        // Fetch challenges
        $tantangan_db = DB::table('gb_mengajar_tantangan')
            ->where('member_id', $uid)
            ->where(function($query) {
                $query->where('tanggal', '=', now()->toDateString())
                      ->orWhere('is_done', '=', 0);
            })
            ->get()
            ->map(function($item) {
                return (array)$item;
            })
            ->toArray();

        // Fetch recent activities
        $aktivitas_db = DB::table('gb_mengajar_aktivitas')
            ->where('member_id', $uid)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return (array)$item;
            })
            ->toArray();

        // Get user name
        $parts = explode(' ', $member->full_name ?? 'Guru');
        $user_name = $parts[0];

        return view('member.mengajar.dashboard', compact('member', 'stats', 'tantangan_db', 'aktivitas_db', 'user_name'));
    }

    /**
     * Simpan Skor dan Tambah Poin Gamifikasi
     */
    public function saveScore(Request $request)
    {
        $member = Auth::guard('web')->user();
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'score' => 'required|numeric',
            'game_id' => 'required|string',
        ]);

        $score = (int) $request->score;
        
        // Poin yang didapat misalnya 10% dari skor (atau sesuaikan dengan kebutuhan)
        // Skor 100 => 10 poin
        $earned_points = floor($score / 10);

        if ($earned_points > 0) {
            DB::table('members')
                ->where('id', $member->id)
                ->increment('poin_gamifikasi', $earned_points);
                
            // (Opsional) Rekam aktivitas
            DB::table('gb_mengajar_aktivitas')->insert([
                'member_id' => $member->id,
                'judul' => 'Menyelesaikan Game',
                'deskripsi' => 'Mendapatkan ' . $earned_points . ' poin dari game ' . $request->game_id,
                'created_at' => now(),
            ]);
        }

        $new_total = DB::table('members')->where('id', $member->id)->value('poin_gamifikasi');

        return response()->json([
            'success' => true,
            'earned_points' => $earned_points,
            'total_points' => $new_total
        ]);
    }

    /**
     * Gamifikasi & Catalog
     */
    public function gamifikasi()
    {
        $member = Auth::guard('web')->user();
        $uid = $member->id;

        // Fetch stats
        $stats = DB::table('gb_mengajar_stats')->where('member_id', $uid)->first();
        if (!$stats) {
            DB::table('gb_mengajar_stats')->insert([
                'member_id' => $uid,
                'total_xp' => 0,
                'level_saat_ini' => 1,
                'hari_streak' => 0,
                'badge_diraih' => 0,
                'free_gamification_left' => 3,
                'is_premium_gamifikasi' => 0
            ]);
            $stats = DB::table('gb_mengajar_stats')->where('member_id', $uid)->first();
        }
        $stats = (array)$stats;

        // Fetch challenges
        $challenges = DB::table('gb_mengajar_tantangan')
            ->where('member_id', $uid)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function($r) {
                return [
                    'icon' => $r->ikon,
                    'name' => $r->nama_tantangan,
                    'desc' => 'Tantangan kelas',
                    'xp' => '+' . $r->xp_reward . ' XP',
                    'done' => (bool)$r->is_done,
                    'progress' => $r->progress,
                    'total' => $r->target
                ];
            })
            ->toArray();

        if (empty($challenges)) {
            DB::table('gb_mengajar_tantangan')->insert([
                'member_id' => $uid,
                'tanggal' => now()->toDateString(),
                'ikon' => '🎯',
                'nama_tantangan' => 'Bagikan 1 Game ke Murid',
                'xp_reward' => 50,
                'progress' => 0,
                'target' => 1,
                'is_done' => 0
            ]);
            $challenges = [
                ['icon' => '🎯', 'name' => 'Bagikan 1 Game ke Murid', 'desc' => 'Tantangan kelas', 'xp' => '+50 XP', 'done' => false, 'progress' => 0, 'total' => 1]
            ];
        }

        // Fetch leaderboards
        $leaders = DB::table('gb_mengajar_stats')
            ->join('members', 'gb_mengajar_stats.member_id', '=', 'members.id')
            ->select('gb_mengajar_stats.*', 'members.full_name as member_name', 'members.institution')
            ->orderBy('gb_mengajar_stats.total_xp', 'desc')
            ->limit(10)
            ->get()
            ->map(function($r, $idx) use ($uid) {
                return [
                    'rank' => $idx + 1,
                    'name' => $r->member_name,
                    'inst' => $r->institution ?? 'Guruverse',
                    'level' => 'Level ' . $r->level_saat_ini,
                    'xp' => $r->total_xp,
                    'streak' => $r->hari_streak,
                    'badges' => $r->badge_diraih,
                    'you' => ($r->member_id == $uid)
                ];
            })
            ->toArray();

        // Fetch karya list
        $karya_list = DB::table('gb_mengajar_karya')
            ->join('members', 'gb_mengajar_karya.member_id', '=', 'members.id')
            ->select('gb_mengajar_karya.*', 'members.full_name', 'members.institution',
                DB::raw("(SELECT COUNT(*) FROM gb_mengajar_karya_votes v WHERE v.karya_id = gb_mengajar_karya.id AND v.member_id = {$uid}) as is_voted")
            )
            ->orderBy('gb_mengajar_karya.vote_count', 'desc')
            ->get()
            ->map(function($item) {
                return (array)$item;
            })
            ->toArray();

        // Read catalog from JSON
        $katalogPath = public_path('asset/docs/gamifikasi/gamifikasi_katalog.json');
        $katalog = [];
        if (file_exists($katalogPath)) {
            $katalog = json_decode(file_get_contents($katalogPath), true) ?: [];
        } else {
            // Seed a few default catalog items if the file does not exist
            $katalog = [
                [
                    'id' => 'game_1',
                    'kategori' => 'Ice Breaking',
                    'judul' => 'Teka-Teki Silang Pancasila',
                    'deskripsi' => 'Game edukasi mencocokkan sila Pancasila dengan lambangnya untuk kelas SD/MI.',
                    'tipe' => 'json',
                    'path' => '/asset/docs/gamifikasi/uploads/game_1.json',
                    'ikon' => '🎮',
                    'is_premium' => false,
                    'link_pembelian' => ''
                ],
                [
                    'id' => 'game_2',
                    'kategori' => 'Kuis & Teka-teki',
                    'judul' => 'Kuis Matematika Aritmatika Sosial',
                    'deskripsi' => 'Kuis seru interaktif pilihan ganda mengenai diskon, untung, rugi untuk tingkat SMP.',
                    'tipe' => 'json',
                    'path' => '/asset/docs/gamifikasi/uploads/game_2.json',
                    'ikon' => '🎮',
                    'is_premium' => true,
                    'link_pembelian' => 'https://mayar.id/buy/kuis-matematika-smp'
                ],
                [
                    'id' => 'game_3',
                    'kategori' => 'Buku Panduan',
                    'judul' => 'Panduan Gamifikasi Pembelajaran Kelas',
                    'deskripsi' => 'E-book panduan implementasi mechanics point, badge, dan leaderboard di kelas secara offline.',
                    'tipe' => 'pdf',
                    'path' => '/asset/docs/gamifikasi/uploads/panduan_gamifikasi.pdf',
                    'ikon' => '📕',
                    'is_premium' => false,
                    'link_pembelian' => ''
                ]
            ];
            // Ensure directory exists
            $dir = dirname($katalogPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($katalogPath, json_encode($katalog, JSON_PRETTY_PRINT));
        }

        return view('member.mengajar.gamifikasi', compact('member', 'stats', 'challenges', 'leaders', 'karya_list', 'katalog'));
    }

    /**
     * Submit Karya (POST)
     */
    public function submitKarya(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|string',
            'deskripsi' => 'required|string',
            'link_karya' => 'nullable|url',
        ]);

        $uid = Auth::guard('web')->user()->id;

        $file_path = null;
        if ($request->hasFile('file_karya') && $request->file('file_karya')->isValid()) {
            $file = $request->file('file_karya');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/karya'), $file_name);
            $file_path = '/uploads/karya/' . $file_name;
        }

        $inserted = DB::table('gb_mengajar_karya')->insert([
            'member_id' => $uid,
            'judul' => $request->judul,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'file_path' => $file_path,
            'link_karya' => $request->link_karya,
            'vote_count' => 0,
            'created_at' => now()
        ]);

        if ($inserted) {
            // Give XP reward (+100 XP)
            DB::table('gb_mengajar_stats')->where('member_id', $uid)->increment('total_xp', 100);
            return response()->json([
                'status' => 'success',
                'message' => 'Karya berhasil dikirim! (+100 XP)'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan sistem.'
        ], 500);
    }

    /**
     * Vote Karya (POST)
     */
    public function voteKarya(Request $request)
    {
        $request->validate([
            'karya_id' => 'required|integer'
        ]);

        $uid = Auth::guard('web')->user()->id;
        $karya_id = $request->karya_id;

        $karya = DB::table('gb_mengajar_karya')->where('id', $karya_id)->first();
        if (!$karya) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karya tidak ditemukan.'
            ], 404);
        }

        if ($karya->member_id == $uid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak bisa mem-vote karya sendiri.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            DB::table('gb_mengajar_karya_votes')->insert([
                'karya_id' => $karya_id,
                'member_id' => $uid,
                'created_at' => now()
            ]);

            DB::table('gb_mengajar_karya')->where('id', $karya_id)->increment('vote_count');
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memberikan dukungan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah memberikan vote untuk karya ini sebelumnya.'
            ], 400);
        }
    }

    /**
     * Use Free Play (POST)
     */
    public function useFreePlay()
    {
        $uid = Auth::guard('web')->user()->id;

        $stats = DB::table('gb_mengajar_stats')->where('member_id', $uid)->first();
        if (!$stats) {
            return response()->json(['status' => 'error', 'message' => 'Stats not found'], 404);
        }

        if ($stats->is_premium_gamifikasi == 1) {
            return response()->json(['status' => 'success', 'premium' => true]);
        }

        if ($stats->free_gamification_left > 0) {
            DB::table('gb_mengajar_stats')
                ->where('member_id', $uid)
                ->decrement('free_gamification_left');

            return response()->json([
                'status' => 'success',
                'premium' => false,
                'left' => $stats->free_gamification_left - 1
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Jatah gratis habis',
                'code' => 'OUT_OF_FREE_PLAYS'
            ], 400);
        }
    }

    /**
     * Upgrade Premium (POST)
     */
    public function upgradePremium()
    {
        $uid = Auth::guard('web')->user()->id;

        DB::table('gb_mengajar_stats')
            ->where('member_id', $uid)
            ->update(['is_premium_gamifikasi' => 1]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Checkout Cart (POST)
     */
    public function checkoutCart(Request $request)
    {
        $request->validate([
            'game_ids' => 'required|array'
        ]);

        $uid = Auth::guard('web')->user()->id;
        $game_ids = $request->game_ids;

        // Ensure owned table exists
        // Note: SQLite/MySQL compatible table creation is handled here
        $schema = DB::getSchemaBuilder();
        if (!$schema->hasTable('gb_mengajar_games_owned')) {
            $schema->create('gb_mengajar_games_owned', function ($table) {
                $table->increments('id');
                $table->integer('member_id');
                $table->string('game_id', 100);
                $table->timestamp('purchased_at')->useCurrent();
                $table->unique(['member_id', 'game_id']);
            });
        }

        $purchased = [];
        foreach ($game_ids as $gid) {
            $exists = DB::table('gb_mengajar_games_owned')
                ->where('member_id', $uid)
                ->where('game_id', $gid)
                ->exists();

            if (!$exists) {
                DB::table('gb_mengajar_games_owned')->insert([
                    'member_id' => $uid,
                    'game_id' => $gid,
                    'purchased_at' => now()
                ]);
                $purchased[] = $gid;
            }
        }

        return response()->json([
            'status' => 'success',
            'purchased' => $purchased
        ]);
    }

    /**
     * Get Owned Games (GET)
     */
    public function getOwnedGames()
    {
        $uid = Auth::guard('web')->user()->id;

        $schema = DB::getSchemaBuilder();
        if (!$schema->hasTable('gb_mengajar_games_owned')) {
            return response()->json(['status' => 'success', 'owned' => []]);
        }

        $owned = DB::table('gb_mengajar_games_owned')
            ->where('member_id', $uid)
            ->pluck('game_id')
            ->toArray();

        return response()->json([
            'status' => 'success',
            'owned' => $owned
        ]);
    }

    /**
     * Kirim Karya Page
     */
    public function kirimKarya()
    {
        $member = Auth::guard('web')->user();
        $uid = $member->id;

        $karyas = DB::table('gb_mengajar_karya')
            ->join('members', 'gb_mengajar_karya.member_id', '=', 'members.id')
            ->select('gb_mengajar_karya.*', 'members.full_name', 'members.institution',
                DB::raw("(SELECT COUNT(*) FROM gb_mengajar_karya_votes v WHERE v.karya_id = gb_mengajar_karya.id AND v.member_id = {$uid}) as sudah_vote")
            )
            ->orderBy('gb_mengajar_karya.vote_count', 'desc')
            ->orderBy('gb_mengajar_karya.created_at', 'desc')
            ->get()
            ->map(function($item) {
                return (array)$item;
            })
            ->toArray();

        $total_karya = count($karyas);
        $top_votes = $total_karya > 0 ? max(array_column($karyas, 'vote_count')) : 0;
        $my_karya = count(array_filter($karyas, fn($k) => $k['member_id'] == $uid));
        $top3 = array_slice($karyas, 0, 3);

        return view('member.mengajar.kirim_karya', compact('member', 'uid', 'karyas', 'total_karya', 'top_votes', 'my_karya', 'top3'));
    }

    /**
     * Impact Tracker / System Feedback
     */
    public function impact()
    {
        $member = Auth::guard('web')->user();
        $uid = $member->id;

        // Ambil semua feedback
        $feedbacks = DB::table('gb_mengajar_system_feedback')
            ->join('members', 'gb_mengajar_system_feedback.member_id', '=', 'members.id')
            ->select('gb_mengajar_system_feedback.*', 'members.full_name', 'members.institution')
            ->orderBy('gb_mengajar_system_feedback.created_at', 'desc')
            ->get()
            ->map(function($item) {
                return (array)$item;
            })
            ->toArray();

        $total_rating = 0;
        $rating_counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        foreach ($feedbacks as $fb) {
            $r = (int)$fb['rating'];
            $total_rating += $r;
            if (isset($rating_counts[$r])) {
                $rating_counts[$r]++;
            }
        }

        $total_reviews = count($feedbacks);
        $avg_rating = $total_reviews > 0 ? round($total_rating / $total_reviews, 1) : 0;

        return view('member.mengajar.impact', compact('member', 'feedbacks', 'rating_counts', 'total_reviews', 'avg_rating'));
    }

    /**
     * Submit Feedback (POST)
     */
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'kategori' => 'nullable|string',
            'ulasan' => 'required|string',
        ]);

        $uid = Auth::guard('web')->user()->id;

        $inserted = DB::table('gb_mengajar_system_feedback')->insert([
            'member_id' => $uid,
            'rating' => $request->rating,
            'kategori' => $request->kategori,
            'ulasan' => $request->ulasan,
            'created_at' => now()
        ]);

        if ($inserted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Terima kasih! Ulasan Anda sangat berarti bagi pengembangan GuruVerse.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan sistem.'
        ], 500);
    }

    /**
     * Pelatihan Offline
     */
    public function pelatihan()
    {
        $member = Auth::guard('web')->user();
        $uid = $member->id;

        // Ensure tables exist or seed
        // We will make sure the table has seed records if empty
        $has_pelatihan = DB::table('gb_mengajar_pelatihan')->exists();
        if (!$has_pelatihan) {
            // Seed base pelatihan
            DB::table('gb_mengajar_pelatihan')->insert([
                ['id' => 1, 'title' => 'Workshop Implementasi Kurikulum Merdeka', 'tags' => 'Pedagogik,IKM', 'warna' => '#4f46e5', 'ada_sertifikat' => 1, 'fasilitas' => '["ATK","Snack & Coffee Break","Materi Soft File","Buku & Name Tag","Pouch","Sertifikat Pelatihan"]'],
                ['id' => 2, 'title' => 'Bimbingan Teknis Pembuatan Modul Ajar AI', 'tags' => 'Teknologi,Modul', 'warna' => '#10b981', 'ada_sertifikat' => 1, 'fasilitas' => '["ATK","Snack & Coffee Break","Materi Soft File","Name Tag","Goodie Bag","Sertifikat Pelatihan"]'],
                ['id' => 3, 'title' => 'Seminar Nasional Guru Penggerak 2026', 'tags' => 'Kepemimpinan,Seminar', 'warna' => '#f59e0b', 'ada_sertifikat' => 1, 'fasilitas' => '["ATK","Snack & Coffee Break","Materi Soft File","Tumbler Eksklusif","Sertifikat Pelatihan"]']
            ]);
            DB::table('gb_mengajar_pelatihan_batch')->insert([
                ['id' => 1, 'pelatihan_id' => 1, 'nama_batch' => 'Batch 1 - Gelombang Awal', 'harga' => 150000, 'tanggal' => '2026-06-15', 'waktu' => '08:00 - 15:00 WIB', 'lokasi' => 'Aula Dinas Pendidikan, Jakarta', 'sisa_kursi' => 45],
                ['id' => 2, 'pelatihan_id' => 1, 'nama_batch' => 'Batch 2 - Gelombang Akhir', 'harga' => 175000, 'tanggal' => '2026-06-16', 'waktu' => '08:00 - 15:00 WIB', 'lokasi' => 'Aula Dinas Pendidikan, Jakarta', 'sisa_kursi' => 50],
                ['id' => 3, 'pelatihan_id' => 2, 'nama_batch' => 'Batch Eksklusif', 'harga' => 250000, 'tanggal' => '2026-06-20', 'waktu' => '09:00 - 14:00 WIB', 'lokasi' => 'Hotel Sahid Jaya, Yogyakarta', 'sisa_kursi' => 20],
                ['id' => 4, 'pelatihan_id' => 3, 'nama_batch' => 'Batch Spesial', 'harga' => 0, 'tanggal' => '2026-07-05', 'waktu' => '08:30 - 16:00 WIB', 'lokasi' => 'Gedung PGRI, Bandung', 'sisa_kursi' => 100]
            ]);
        }

        // Ambil pelatihan yang sudah didaftar user (via batch)
        $registered_pelatihan_ids = DB::table('gb_mengajar_peserta_pelatihan')
            ->join('gb_mengajar_pelatihan_batch', 'gb_mengajar_peserta_pelatihan.batch_id', '=', 'gb_mengajar_pelatihan_batch.id')
            ->where('gb_mengajar_peserta_pelatihan.member_id', $uid)
            ->pluck('gb_mengajar_pelatihan_batch.pelatihan_id')
            ->toArray();

        $upcoming = DB::table('gb_mengajar_pelatihan')
            ->get()
            ->map(function($r) use ($registered_pelatihan_ids) {
                $item = (array)$r;
                $item['tags'] = explode(',', $item['tags']);
                $item['sertifikat'] = (bool)$item['ada_sertifikat'];
                $item['fasilitas_arr'] = json_decode($item['fasilitas'] ?? '[]', true) ?: [];
                $item['color'] = $item['warna'];
                $item['status'] = in_array((int)$item['id'], $registered_pelatihan_ids) ? 'Terdaftar' : 'Akan Datang';
                $item['total_batch'] = DB::table('gb_mengajar_pelatihan_batch')->where('pelatihan_id', $item['id'])->count();
                return $item;
            })
            ->toArray();

        // Riwayat & Sertifikat
        $history = [];
        $certs = [];

        // Check if history table exists, if not, mock some data for premium look
        $schema = DB::getSchemaBuilder();
        if ($schema->hasTable('gb_mengajar_riwayat_pelatihan')) {
            $history_db = DB::table('gb_mengajar_riwayat_pelatihan')->where('member_id', $uid)->get();
            foreach ($history_db as $r) {
                $history[] = [
                    'emoji' => $r->emoji ?? '🎓',
                    'title' => $r->title,
                    'date' => $r->tanggal,
                    'hours' => $r->jam ?? 8,
                    'cert' => (bool)$r->ada_sertifikat
                ];
                if ($r->ada_sertifikat && !empty($r->cert_id)) {
                    $certs[] = [
                        'title' => $r->title,
                        'issuer' => $r->cert_issuer ?? 'GuruVerse',
                        'date' => $r->tanggal,
                        'id' => $r->cert_id
                    ];
                }
            }
        }

        if (empty($history)) {
            // Mocking for premium look when empty
            $history = [
                ['emoji' => '🎓', 'title' => 'Pemanfaatan Canva Pro untuk Guru Kreatif', 'date' => '2026-03-10', 'hours' => 6, 'cert' => true],
                ['emoji' => '🏫', 'title' => 'Pengelolaan Kelas Menyenangkan Terintegrasi Ice Breaking', 'date' => '2026-04-18', 'hours' => 8, 'cert' => true],
                ['emoji' => '🧠', 'title' => 'Neuroscience dalam Pembelajaran Anak Usia Sekolah', 'date' => '2026-05-02', 'hours' => 4, 'cert' => false]
            ];
            $certs = [
                ['title' => 'Pemanfaatan Canva Pro untuk Guru Kreatif', 'issuer' => 'GuruVerse', 'date' => '2026-03-10', 'id' => 'CERT-2026-003921'],
                ['title' => 'Pengelolaan Kelas Menyenangkan Terintegrasi Ice Breaking', 'issuer' => 'GuruVerse', 'date' => '2026-04-18', 'id' => 'CERT-2026-004812']
            ];
        }

        return view('member.mengajar.pelatihan', compact('member', 'upcoming', 'history', 'certs'));
    }

    /**
     * Get Batches (GET API)
     */
    public function getBatches($id)
    {
        $batches = DB::table('gb_mengajar_pelatihan_batch')
            ->where('pelatihan_id', $id)
            ->orderBy('tanggal', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $batches
        ]);
    }

    /**
     * Register Pelatihan (POST)
     */
    public function registerPelatihan(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|integer',
            'voucher_code' => 'nullable|string'
        ]);

        $uid = Auth::guard('web')->user()->id;
        $batch_id = $request->batch_id;

        // Cek batch
        $batch = DB::table('gb_mengajar_pelatihan_batch')->where('id', $batch_id)->first();
        if (!$batch) {
            return response()->json(['status' => 'error', 'message' => 'Batch pelatihan tidak ditemukan.'], 404);
        }

        if ((int)$batch->sisa_kursi <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Kuota batch sudah penuh.'], 400);
        }

        // Cek double registration
        $exists = DB::table('gb_mengajar_peserta_pelatihan')
            ->where('batch_id', $batch_id)
            ->where('member_id', $uid)
            ->exists();

        if ($exists) {
            return response()->json(['status' => 'error', 'message' => 'Anda sudah terdaftar di angkatan ini.'], 400);
        }

        // Voucher validation
        $voucher_valid = false;
        $discount_msg = '';
        if ($request->filled('voucher_code')) {
            $voucher_code = trim(strtoupper($request->voucher_code));
            $voucher = DB::table('gb_vouchers')
                ->where('voucher_code', $voucher_code)
                ->where('is_used', 0)
                ->where('owner_id', $uid)
                ->first();

            if ($voucher) {
                $voucher_valid = true;
                $discount_msg = " Anda mendapatkan diskon {$voucher->discount_percent}%.";
            }
        }

        $ticket_code = 'TIX-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 5));

        DB::beginTransaction();
        try {
            DB::table('gb_mengajar_peserta_pelatihan')->insert([
                'batch_id' => $batch_id,
                'member_id' => $uid,
                'ticket_code' => $ticket_code,
                'status' => 'terdaftar',
                'created_at' => now()
            ]);

            DB::table('gb_mengajar_pelatihan_batch')
                ->where('id', $batch_id)
                ->decrement('sisa_kursi');

            if ($voucher_valid) {
                DB::table('gb_vouchers')
                    ->where('voucher_code', $request->voucher_code)
                    ->update([
                        'is_used' => 1,
                        'used_at' => now()
                    ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil!' . $discount_msg,
                'ticket_code' => $ticket_code
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan pendaftaran.'], 500);
        }
    }

    /**
     * Get Ticket (GET API)
     */
    public function getTicket($pelatihan_id)
    {
        $uid = Auth::guard('web')->user()->id;

        $ticket = DB::table('gb_mengajar_peserta_pelatihan')
            ->join('gb_mengajar_pelatihan_batch', 'gb_mengajar_peserta_pelatihan.batch_id', '=', 'gb_mengajar_pelatihan_batch.id')
            ->join('gb_mengajar_pelatihan', 'gb_mengajar_pelatihan_batch.pelatihan_id', '=', 'gb_mengajar_pelatihan.id')
            ->select('gb_mengajar_peserta_pelatihan.*', 'gb_mengajar_pelatihan_batch.nama_batch', 'gb_mengajar_pelatihan_batch.tanggal', 'gb_mengajar_pelatihan_batch.waktu', 'gb_mengajar_pelatihan_batch.lokasi', 'gb_mengajar_pelatihan.title')
            ->where('gb_mengajar_pelatihan.id', $pelatihan_id)
            ->where('gb_mengajar_peserta_pelatihan.member_id', $uid)
            ->first();

        if ($ticket) {
            return response()->json([
                'status' => 'success',
                'data' => $ticket
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Tiket tidak ditemukan.'], 404);
    }

    /**
     * Download Certificate PDF
     */
    public function unduhSertifikat($id)
    {
        $member = Auth::guard('web')->user();

        $title = "Pelatihan Offline";
        $date = date('Y-m-d');
        
        // Try fetching from DB
        $peserta = DB::table('gb_mengajar_peserta_pelatihan')
            ->join('gb_mengajar_pelatihan_batch', 'gb_mengajar_peserta_pelatihan.batch_id', '=', 'gb_mengajar_pelatihan_batch.id')
            ->join('gb_mengajar_pelatihan', 'gb_mengajar_pelatihan_batch.pelatihan_id', '=', 'gb_mengajar_pelatihan.id')
            ->where('gb_mengajar_peserta_pelatihan.cert_id', $id)
            ->where('gb_mengajar_peserta_pelatihan.member_id', $member->id)
            ->select('gb_mengajar_pelatihan.title', 'gb_mengajar_pelatihan_batch.tanggal')
            ->first();
        
        if ($peserta) {
            $title = $peserta->title;
            $date = $peserta->tanggal;
        } else {
            // Fallback for mock data (prevent breaking if DB is empty but UI shows mock certs)
            if ($id == 'CERT-2026-003921') {
                $title = 'Pemanfaatan Canva Pro untuk Guru Kreatif';
                $date = '2026-03-10';
            } elseif ($id == 'CERT-2026-004812') {
                $title = 'Pengelolaan Kelas Menyenangkan Terintegrasi Ice Breaking';
                $date = '2026-04-18';
            } else {
                return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificate.template', [
            'studentName' => $member->name,
            'courseName' => $title,
            'completionDate' => \Carbon\Carbon::parse($date)->isoFormat('D MMMM Y')
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat-Pelatihan-'.$id.'.pdf');
    }

    /**
     * Referral Page & Code Generation
     */
    public function referral()
    {
        $member = Auth::guard('web')->user();
        return view('member.mengajar.referral', compact('member'));
    }

    /**
     * Cart Page
     */
    public function cart()
    {
        $member = Auth::guard('web')->user();
        return view('member.mengajar.cart', compact('member'));
    }

    /**
     * Get Referral Data (GET API)
     */
    public function getReferralData()
    {
        $member = Auth::guard('web')->user();
        $uid = $member->id;

        // 1. Get/Create user referral code
        $ref_code = $member->referral_code;
        if (empty($ref_code)) {
            $ref_code = 'GURU-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
            DB::table('members')->where('id', $uid)->update(['referral_code' => $ref_code]);
        }

        // 2. Get referred users
        $referred = DB::table('gb_referrals')
            ->join('members', 'gb_referrals.referred_id', '=', 'members.id')
            ->select('members.full_name', 'gb_referrals.created_at')
            ->where('gb_referrals.referrer_id', $uid)
            ->orderBy('gb_referrals.created_at', 'desc')
            ->get()
            ->map(function($r) {
                return [
                    'full_name' => $r->full_name,
                    'initials' => $this->getUserInitials($r->full_name),
                    'created_at' => date('d M Y', strtotime($r->created_at))
                ];
            })
            ->toArray();

        // 3. Get vouchers
        $vouchers = DB::table('gb_vouchers')
            ->where('owner_id', $uid)
            ->orderBy('is_used', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($v) {
                return [
                    'voucher_code' => $v->voucher_code,
                    'discount_percent' => $v->discount_percent,
                    'is_used' => (bool)$v->is_used
                ];
            })
            ->toArray();

        // 4. Update Tiers (Auto-generate vouchers if reached target)
        $total_ref = count($referred);
        $new_voucher = false;

        $checkAndGenerateVoucher = function($uid, $discount, $code_prefix) use (&$new_voucher) {
            $exists = DB::table('gb_vouchers')
                ->where('owner_id', $uid)
                ->where('discount_percent', $discount)
                ->exists();

            if (!$exists) {
                $code = $code_prefix . strtoupper(substr(md5(uniqid()), 0, 6));
                DB::table('gb_vouchers')->insert([
                    'owner_id' => $uid,
                    'voucher_code' => $code,
                    'discount_percent' => $discount,
                    'is_used' => 0,
                    'created_at' => now()
                ]);
                $new_voucher = true;
            }
        };

        if ($total_ref >= 1) $checkAndGenerateVoucher($uid, 20, 'DISC20-');
        if ($total_ref >= 3) $checkAndGenerateVoucher($uid, 50, 'DISC50-');
        if ($total_ref >= 5) $checkAndGenerateVoucher($uid, 100, 'FREE-');

        // Reload vouchers if generated new
        if ($new_voucher) {
            $vouchers = DB::table('gb_vouchers')
                ->where('owner_id', $uid)
                ->orderBy('is_used', 'asc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($v) {
                    return [
                        'voucher_code' => $v->voucher_code,
                        'discount_percent' => $v->discount_percent,
                        'is_used' => (bool)$v->is_used
                    ];
                })
                ->toArray();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'referral_code' => $ref_code,
                'total_referrals' => $total_ref,
                'referred_users' => $referred,
                'vouchers' => $vouchers
            ]
        ]);
    }
}
