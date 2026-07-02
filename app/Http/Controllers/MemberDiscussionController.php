<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Diskusi;

class MemberDiscussionController extends Controller
{
    public function index(Request $request)
    {
        $member = Auth::guard('web')->user();
        
        $discussions = Diskusi::with(['member', 'replies'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('member.diskusi', compact('member', 'discussions'));
    }

    public function store(Request $request)
    {
        $member = Auth::guard('web')->user();
        $title = $request->input('title');
        $category = $request->input('category');
        $content = $request->input('content');

        if (!$title || !$content) {
            return response()->json(['success' => false, 'message' => 'Judul dan isi tidak boleh kosong']);
        }

        $discussion = Diskusi::create([
            'user_id' => $member->id,
            'title' => $title,
            'body' => $content,
            'category' => $category,
            'replies_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Diskusi berhasil dibuat', 'data' => $discussion]);
    }

    public function storeReply(Request $request)
    {
        $member = Auth::guard('web')->user();
        $discussion_id = $request->input('discussion_id');
        $body = $request->input('body');

        if (!$discussion_id || !$body) {
            return response()->json(['success' => false, 'message' => 'Isi balasan tidak boleh kosong']);
        }

        \App\Models\DiskusiReply::create([
            'discussion_id' => $discussion_id,
            'user_id' => $member->id,
            'body' => $body,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Diskusi::where('id', $discussion_id)->increment('replies_count');

        // TRIGGER BOT (AUTO-RESPONDER)
        \App\Services\BotEngineService::trigger($discussion_id, $body);

        return response()->json(['success' => true, 'message' => 'Balasan berhasil ditambahkan']);
    }

    public function destroy($id)
    {
        $member = Auth::guard('web')->user();
        $discussion = Diskusi::find($id);

        if (!$discussion) {
            return response()->json(['success' => false, 'message' => 'Diskusi tidak ditemukan']);
        }

        if ($discussion->user_id !== $member->id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus diskusi ini']);
        }

        $discussion->delete();
        // Also delete replies
        \App\Models\DiskusiReply::where('discussion_id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Diskusi berhasil dihapus']);
    }

    public function show($id)
    {
        $discussion = Diskusi::with(['member'])->find($id);
        if (!$discussion) {
            return response()->json(['success' => false, 'message' => 'Not found']);
        }

        $replies = \App\Models\DiskusiReply::with(['member'])
            ->where('discussion_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'id' => $discussion->id,
            'title' => $discussion->title,
            'body' => $discussion->body,
            'category' => $discussion->category,
            'author_name' => $discussion->member ? $discussion->member->full_name : 'Member',
            'created_at' => $discussion->created_at->format('Y-m-d H:i:s'),
            'replies_count' => $discussion->replies_count,
            'replies' => $replies->map(function($r) {
                return [
                    'id' => $r->id,
                    'body' => $r->body,
                    'author_name' => $r->user_id == -99 ? 'Guruverse Bot' : ($r->member ? $r->member->full_name : 'Member'),
                    'is_bot' => $r->user_id == -99,
                    'created_at' => $r->created_at->format('Y-m-d H:i:s'),
                ];
            })
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}
