<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Diskusi;
use App\Models\DiskusiReply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminDiskusiController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $q = $request->query('q', '');
        $topic_id = (int)$request->query('topic_id', 0);

        $query = Diskusi::with('member')->orderBy('created_at', 'desc');
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhereHas('member', function($qMember) use ($q) {
                        $qMember->where('full_name', 'like', "%{$q}%");
                    });
            });
        }
        
        $disks = $query->get()->map(function($d) {
            $arr = $d->toArray();
            $arr['author_name'] = $d->member ? $d->member->full_name : 'Anonim';
            if ($d->user_id == 0) $arr['author_name'] = 'Admin Guruverse';
            return $arr;
        })->toArray();

        $active_topic = null;
        $replies = [];

        if ($topic_id > 0) {
            $active_topic = collect($disks)->firstWhere('id', $topic_id);
            if ($active_topic) {
                $replies = DiskusiReply::with('member')
                    ->where('discussion_id', $topic_id)
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->map(function($r) {
                        $arr = $r->toArray();
                        $arr['replier_name'] = $r->member ? $r->member->full_name : 'Anonim';
                        if ($r->user_id == 0) $arr['replier_name'] = 'Admin Guruverse';
                        return $arr;
                    })->toArray();
            }
        }

        return view('admin.diskusi', compact('admin', 'q', 'disks', 'active_topic', 'replies', 'topic_id'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action');

        if ($action === 'delete') {
            $id = (int)$request->input('id');
            DiskusiReply::where('discussion_id', $id)->delete();
            Diskusi::where('id', $id)->delete();
            return redirect()->route('admin.diskusi');
        } elseif ($action === 'reply') {
            $did = (int)$request->input('discussion_id');
            $body = $request->input('body');
            
            $attachment_path = null;
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                $filename = 'reply_' . time() . '_' . rand(1000,9999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/discussions'), $filename);
                $attachment_path = '/uploads/discussions/' . $filename;
            }

            DiskusiReply::create([
                'discussion_id' => $did,
                'user_id' => 0, // Admin
                'body' => $body,
                'attachment_path' => $attachment_path,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Diskusi::where('id', $did)->increment('replies_count');

            // Bot Engine Trigger
            \App\Services\BotEngineService::trigger($did, $body);

            return redirect()->route('admin.diskusi', ['topic_id' => $did]);
        } elseif ($action === 'new_topic') {
            $topic = Diskusi::create([
                'user_id' => 0,
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'category' => $request->input('category'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->route('admin.diskusi', ['topic_id' => $topic->id]);
        }

        return redirect()->route('admin.diskusi');
    }
}
