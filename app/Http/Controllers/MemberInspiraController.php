<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MemberInspiraController extends Controller
{
    /**
     * Dashboard Guru Inspira
     */
    public function index()
    {
        $member = Auth::guard('web')->user();
        
        $forums = DB::table('gb_inspira_forum')->get();
        $proyeks = DB::table('gb_inspira_proyek')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();
            
        $ceritas = DB::table('gb_inspira_cerita')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
            
        $events = DB::table('gb_inspira_event')
            ->orderBy('event_date', 'asc')
            ->limit(3)
            ->get();

        // Separate user's first name
        $parts = explode(' ', $member->full_name ?? 'Member');
        $user_first = $parts[0];

        return view('member.inspira.dashboard', compact('member', 'forums', 'proyeks', 'ceritas', 'events', 'user_first'));
    }

    /**
     * List Forum Diskusi
     */
    public function forum(Request $request)
    {
        $member = Auth::guard('web')->user();
        $forumId = $request->query('forum_id');

        $forums = DB::table('gb_inspira_forum')->get();
        
        $threadsQuery = DB::table('gb_inspira_forum_threads')
            ->join('members', 'gb_inspira_forum_threads.author_id', '=', 'members.id')
            ->select('gb_inspira_forum_threads.*', 'members.full_name as author_name', 'members.institution as author_institution');
            
        if ($forumId) {
            $threadsQuery->where('forum_id', $forumId);
        }
        
        $threads = $threadsQuery->orderBy('created_at', 'desc')->get();
        $activeForum = $forumId ? DB::table('gb_inspira_forum')->where('id', $forumId)->first() : null;

        return view('member.inspira.forum', compact('member', 'forums', 'threads', 'activeForum', 'forumId'));
    }

    /**
     * Detail Thread & Balasan
     */
    public function forumThread($id)
    {
        $member = Auth::guard('web')->user();
        
        $thread = DB::table('gb_inspira_forum_threads')
            ->join('members', 'gb_inspira_forum_threads.author_id', '=', 'members.id')
            ->join('gb_inspira_forum', 'gb_inspira_forum_threads.forum_id', '=', 'gb_inspira_forum.id')
            ->select('gb_inspira_forum_threads.*', 'members.full_name as author_name', 'members.institution as author_institution', 'gb_inspira_forum.judul as forum_name', 'gb_inspira_forum.warna_bg as forum_warna')
            ->where('gb_inspira_forum_threads.id', $id)
            ->first();
            
        if (!$thread) {
            abort(404, 'Thread tidak ditemukan.');
        }

        // Increment view count
        DB::table('gb_inspira_forum_threads')->where('id', $id)->increment('views');

        $replies = DB::table('gb_inspira_forum_replies')
            ->join('members', 'gb_inspira_forum_replies.author_id', '=', 'members.id')
            ->select('gb_inspira_forum_replies.*', 'members.full_name as author_name', 'members.institution as author_institution')
            ->where('thread_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('member.inspira.forum_thread', compact('member', 'thread', 'replies'));
    }

    /**
     * Buat Thread Baru (POST)
     */
    public function createThread(Request $request)
    {
        $request->validate([
            'forum_id' => 'required|integer',
            'judul'    => 'required|string|max:255',
            'konten'   => 'required|string',
        ]);

        $member = Auth::guard('web')->user();

        DB::table('gb_inspira_forum_threads')->insert([
            'forum_id'   => $request->forum_id,
            'author_id'  => $member->id,
            'judul'      => $request->judul,
            'konten'     => $request->konten,
            'created_at' => now(),
        ]);

        DB::table('gb_inspira_forum')->where('id', $request->forum_id)->increment('total_postingan');

        return redirect()->route('member.inspira.forum', ['forum_id' => $request->forum_id])
            ->with('success', 'Topik diskusi berhasil diterbitkan!');
    }

    /**
     * Kirim Balasan (POST)
     */
    public function createReply(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|integer',
            'konten'    => 'required|string',
        ]);

        $member = Auth::guard('web')->user();

        DB::table('gb_inspira_forum_replies')->insert([
            'thread_id' => $request->thread_id,
            'author_id' => $member->id,
            'konten'    => $request->konten,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }

    /**
     * Kolaborasi Proyek
     */
    public function proyek()
    {
        $member = Auth::guard('web')->user();
        
        $proyeks = DB::table('gb_inspira_proyek')
            ->join('members', 'gb_inspira_proyek.author_id', '=', 'members.id')
            ->select('gb_inspira_proyek.*', 'members.full_name as author_name', 'members.institution as author_institution')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.inspira.proyek', compact('member', 'proyeks'));
    }

    /**
     * Detail Proyek
     */
    public function proyekDetail($id)
    {
        $member = Auth::guard('web')->user();
        
        $proyek = DB::table('gb_inspira_proyek')
            ->join('members', 'gb_inspira_proyek.author_id', '=', 'members.id')
            ->select('gb_inspira_proyek.*', 'members.full_name as author_name', 'members.institution as author_role')
            ->where('gb_inspira_proyek.id', $id)
            ->first();
            
        if (!$proyek) {
            abort(404, 'Proyek tidak ditemukan.');
        }

        $project_members = DB::table('gb_inspira_proyek_members')
            ->join('members', 'gb_inspira_proyek_members.user_id', '=', 'members.id')
            ->select('gb_inspira_proyek_members.*', 'members.full_name', 'members.institution')
            ->where('proyek_id', $id)
            ->where('status', 'accepted')
            ->get();

        $is_author = ($proyek->author_id == $member->id);
        
        $is_member = DB::table('gb_inspira_proyek_members')
            ->where('proyek_id', $id)
            ->where('user_id', $member->id)
            ->where('status', 'accepted')
            ->exists();
            
        $has_requested = DB::table('gb_inspira_proyek_members')
            ->where('proyek_id', $id)
            ->where('user_id', $member->id)
            ->where('status', 'pending')
            ->exists();

        $applicants = [];
        if ($is_author) {
            $applicants = DB::table('gb_inspira_proyek_members')
                ->join('members', 'gb_inspira_proyek_members.user_id', '=', 'members.id')
                ->select('gb_inspira_proyek_members.*', 'members.full_name', 'members.institution')
                ->where('proyek_id', $id)
                ->where('status', 'pending')
                ->get();
        }

        return view('member.inspira.proyek_detail', compact('member', 'proyek', 'project_members', 'is_author', 'is_member', 'has_requested', 'applicants'));
    }

    /**
     * Buat Proyek Kolaborasi Baru (POST)
     */
    public function createProyek(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'kebutuhan_anggota' => 'required|integer|min:1',
            'label'             => 'required|string|max:100',
        ]);

        $member = Auth::guard('web')->user();

        $warna = ['#4f46e5', '#059669', '#d97706', '#be123c', '#0284c7'];
        $bg = $warna[array_rand($warna)];

        $pid = DB::table('gb_inspira_proyek')->insertGetId([
            'author_id'         => $member->id,
            'judul'             => $request->judul,
            'deskripsi'         => $request->deskripsi,
            'kebutuhan_anggota' => $request->kebutuhan_anggota,
            'warna_bg'          => $bg,
            'label'             => $request->label,
            'status'            => 'Mencari Anggota',
            'created_at'        => now(),
        ]);

        // Creator automatically becomes first member
        DB::table('gb_inspira_proyek_members')->insert([
            'proyek_id'  => $pid,
            'user_id'    => $member->id,
            'status'     => 'accepted',
            'created_at' => now(),
        ]);

        return redirect()->route('member.inspira.proyek')->with('success', 'Proyek kolaborasi berhasil dibuat!');
    }

    /**
     * Gabung Proyek (POST)
     */
    public function joinProyek(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required|integer',
            'pesan'     => 'required|string',
        ]);

        $member = Auth::guard('web')->user();

        // Check if already registered
        $existing = DB::table('gb_inspira_proyek_members')
            ->where('proyek_id', $request->proyek_id)
            ->where('user_id', $member->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mendaftar pada proyek ini.');
        }

        DB::table('gb_inspira_proyek_members')->insert([
            'proyek_id'  => $request->proyek_id,
            'user_id'    => $member->id,
            'pesan'      => $request->pesan,
            'status'     => 'pending',
            'created_at' => now(),
        ]);

        return back()->with('success', 'Permintaan bergabung berhasil dikirim! Menunggu persetujuan pemilik proyek.');
    }

    /**
     * Kelola Pendaftar Proyek (POST)
     */
    public function manageApplicant(Request $request)
    {
        $request->validate([
            'proyek_id'     => 'required|integer',
            'applicant_id'  => 'required|integer',
            'status_update' => 'required|string|in:accepted,rejected',
        ]);

        $member = Auth::guard('web')->user();

        // Check ownership
        $proyek = DB::table('gb_inspira_proyek')
            ->where('id', $request->proyek_id)
            ->where('author_id', $member->id)
            ->first();

        if (!$proyek) {
            return back()->with('error', 'Anda tidak berhak mengelola proyek ini.');
        }

        if ($request->status_update === 'accepted') {
            // Check quota
            $currentCount = DB::table('gb_inspira_proyek_members')
                ->where('proyek_id', $request->proyek_id)
                ->where('status', 'accepted')
                ->count();

            if ($currentCount >= $proyek->kebutuhan_anggota) {
                return back()->with('error', 'Kuota proyek sudah penuh.');
            }
        }

        DB::table('gb_inspira_proyek_members')
            ->where('proyek_id', $request->proyek_id)
            ->where('user_id', $request->applicant_id)
            ->update([
                'status' => $request->status_update,
            ]);

        if ($request->status_update === 'accepted') {
            // Check if full now
            $currentCount = DB::table('gb_inspira_proyek_members')
                ->where('proyek_id', $request->proyek_id)
                ->where('status', 'accepted')
                ->count();

            if ($currentCount >= $proyek->kebutuhan_anggota) {
                DB::table('gb_inspira_proyek')
                    ->where('id', $request->proyek_id)
                    ->update(['status' => 'Berjalan']);
            }
        }

        $msg = $request->status_update === 'accepted' ? 'Permintaan bergabung disetujui!' : 'Permintaan bergabung ditolak.';
        return back()->with('success', $msg);
    }

    /**
     * Cerita Inspiratif
     */
    public function cerita()
    {
        $member = Auth::guard('web')->user();
        
        $ceritas = DB::table('gb_inspira_cerita')
            ->join('members', 'gb_inspira_cerita.author_id', '=', 'members.id')
            ->select('gb_inspira_cerita.*', 'members.full_name as author_name', 'members.institution as author_institution')
            ->where('gb_inspira_cerita.status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.inspira.cerita', compact('member', 'ceritas'));
    }

    /**
     * Detail Cerita Inspiratif
     */
    public function ceritaDetail($id)
    {
        $member = Auth::guard('web')->user();
        
        $cerita = DB::table('gb_inspira_cerita')
            ->join('members', 'gb_inspira_cerita.author_id', '=', 'members.id')
            ->select('gb_inspira_cerita.*', 'members.full_name as author_name', 'members.institution as author_institution')
            ->where('gb_inspira_cerita.id', $id)
            ->first();
            
        if (!$cerita) {
            abort(404, 'Cerita tidak ditemukan.');
        }

        DB::table('gb_inspira_cerita')->where('id', $id)->increment('views');

        return view('member.inspira.cerita_detail', compact('member', 'cerita'));
    }

    /**
     * Bagikan Kisah Inspiratif (POST)
     */
    public function createCerita(Request $request)
    {
        $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
        ]);

        $member = Auth::guard('web')->user();

        DB::table('gb_inspira_cerita')->insert([
            'author_id'  => $member->id,
            'judul'      => $request->judul,
            'konten'     => $request->konten,
            'gambar'     => 'default_cerita.png',
            'status'     => 'published',
            'created_at' => now(),
        ]);

        return redirect()->route('member.inspira.cerita')->with('success', 'Cerita inspiratif Anda berhasil dibagikan!');
    }

    /**
     * Agenda & Event
     */
    public function agenda()
    {
        $member = Auth::guard('web')->user();
        
        $events = DB::table('gb_inspira_event as e')
            ->join('members as m', 'e.author_id', '=', 'm.id')
            ->select('e.*', 'm.full_name as author_name',
                DB::raw("(SELECT COUNT(*) FROM gb_inspira_event_rsvp WHERE event_id = e.id) as peserta_count"))
            ->orderBy('e.event_date', 'asc')
            ->get();

        // Get user RSVP status
        $rsvps = DB::table('gb_inspira_event_rsvp')
            ->where('user_id', $member->id)
            ->pluck('event_id')
            ->toArray();

        return view('member.inspira.agenda', compact('member', 'events', 'rsvps'));
    }

    /**
     * Jadwalkan Event Baru (POST)
     */
    public function createEvent(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|string|max:100',
            'event_date' => 'required|date',
            'link_meeting' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $member = Auth::guard('web')->user();

        $icons = [
            'Webinar' => 'ti ti-video',
            'Lokakarya' => 'ti ti-briefcase',
            'Diskusi Santai' => 'ti ti-coffee',
        ];
        $icon = $icons[$request->tipe] ?? 'ti ti-calendar';

        $warna_bgs = [
            'Webinar' => 'var(--c-primary-pale)',
            'Lokakarya' => 'rgba(245, 158, 11, 0.1)',
            'Diskusi Santai' => 'rgba(16, 185, 129, 0.1)',
        ];
        $warna_bg = $warna_bgs[$request->tipe] ?? 'var(--c-primary-pale)';

        $warna_texts = [
            'Webinar' => 'var(--c-primary)',
            'Lokakarya' => '#d97706',
            'Diskusi Santai' => '#10b981',
        ];
        $warna_text = $warna_texts[$request->tipe] ?? 'var(--c-primary)';

        DB::table('gb_inspira_event')->insert([
            'author_id' => $member->id,
            'judul' => $request->judul,
            'tipe' => $request->tipe,
            'event_date' => $request->event_date,
            'link_meeting' => $request->link_meeting ?? '',
            'deskripsi' => $request->deskripsi,
            'icon' => $icon,
            'warna_bg' => $warna_bg,
            'warna_text' => $warna_text,
            'created_at' => now(),
        ]);

        return redirect()->route('member.inspira.agenda')->with('success', 'Event berhasil dijadwalkan!');
    }

    /**
     * RSVP Event (POST)
     */
    public function rsvpEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
        ]);

        $member = Auth::guard('web')->user();

        $existing = DB::table('gb_inspira_event_rsvp')
            ->where('event_id', $request->event_id)
            ->where('user_id', $member->id)
            ->first();

        if ($existing) {
            DB::table('gb_inspira_event_rsvp')
                ->where('event_id', $request->event_id)
                ->where('user_id', $member->id)
                ->delete();
                
            return back()->with('success', 'RSVP dibatalkan.');
        }

        DB::table('gb_inspira_event_rsvp')->insert([
            'event_id'   => $request->event_id,
            'user_id'    => $member->id,
            'created_at' => now(),
        ]);

        return back()->with('success', 'RSVP berhasil terkirim! Sampai jumpa di event.');
    }

    /**
     * Jendela Dunia
     */
    public function jendela()
    {
        $member = Auth::guard('web')->user();
        
        $jendelas = DB::table('gb_inspira_jendela')
            ->join('members', 'gb_inspira_jendela.author_id', '=', 'members.id')
            ->select('gb_inspira_jendela.*', 'members.full_name as author_name')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.inspira.jendela', compact('member', 'jendelas'));
    }

    /**
     * Detail Jendela Dunia
     */
    public function jendelaDetail($id)
    {
        $member = Auth::guard('web')->user();
        
        $jendela = DB::table('gb_inspira_jendela')
            ->join('members', 'gb_inspira_jendela.author_id', '=', 'members.id')
            ->select('gb_inspira_jendela.*', 'members.full_name as author_name')
            ->where('gb_inspira_jendela.id', $id)
            ->first();
            
        if (!$jendela) {
            abort(404, 'Artikel tidak ditemukan.');
        }

        return view('member.inspira.jendela_detail', compact('member', 'jendela'));
    }

    /**
     * Tambah Artikel Jendela Dunia (POST)
     */
    public function createJendela(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'sumber'   => 'nullable|string|max:255',
            'konten'   => 'required|string',
        ]);

        $member = Auth::guard('web')->user();

        DB::table('gb_inspira_jendela')->insert([
            'author_id'  => $member->id,
            'judul'      => $request->judul,
            'kategori'   => $request->kategori,
            'sumber'     => $request->sumber ?? '',
            'konten'     => $request->konten,
            'gambar'     => 'default_jendela.png',
            'created_at' => now(),
        ]);

        return redirect()->route('member.inspira.jendela')->with('success', 'Artikel berhasil diterbitkan!');
    }

    /**
     * Rekan Kolaborasi
     */
    public function diskusi()
    {
        $member = Auth::guard('web')->user();
        
        $rekans = DB::table('gb_inspira_rekan')
            ->join('members', 'gb_inspira_rekan.user_id', '=', 'members.id')
            ->select('gb_inspira_rekan.*', 'members.full_name', 'members.institution', 'members.phone')
            ->where('status_open', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $user_rekan = DB::table('gb_inspira_rekan')
            ->where('user_id', $member->id)
            ->first();

        return view('member.inspira.diskusi', compact('member', 'rekans', 'user_rekan'));
    }

    /**
     * Daftarkan Diri Rekan Kolaborasi (POST)
     */
    public function registerRekan(Request $request)
    {
        $request->validate([
            'bidang_minat' => 'required|string|max:255',
            'deskripsi'    => 'required|string',
            'status_open'  => 'required|integer|in:0,1',
        ]);

        $member = Auth::guard('web')->user();

        $existing = DB::table('gb_inspira_rekan')
            ->where('user_id', $member->id)
            ->first();

        if ($existing) {
            DB::table('gb_inspira_rekan')
                ->where('user_id', $member->id)
                ->update([
                    'bidang_minat' => $request->bidang_minat,
                    'deskripsi'    => $request->deskripsi,
                    'status_open'  => $request->status_open,
                ]);
        } else {
            DB::table('gb_inspira_rekan')->insert([
                'user_id'      => $member->id,
                'bidang_minat' => $request->bidang_minat,
                'deskripsi'    => $request->deskripsi,
                'status_open'  => $request->status_open,
                'created_at'   => now(),
            ]);
        }

        return redirect()->route('member.inspira.diskusi')->with('success', 'Profil kolaborasi Anda berhasil diperbarui!');
    }
}
