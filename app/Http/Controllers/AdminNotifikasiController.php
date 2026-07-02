<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class AdminNotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $msg = session('success', '');

        $notif_list = Notification::orderBy('created_at', 'desc')->get()->map(function($n) {
            $arr = $n->toArray();
            $arr['message'] = $n->body; // map for view
            if ($n->user_id == 0) {
                $arr['member_name'] = 'Semua Member';
            } else {
                $member = Member::find($n->user_id);
                $arr['member_name'] = $member ? $member->full_name : 'Unknown';
            }
            return $arr;
        })->toArray();

        return view('admin.notifikasi', compact('admin', 'msg', 'notif_list'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action');

        if ($action === 'create') {
            $target = $request->input('target');
            $title = $request->input('title');
            $body = $request->input('message');
            $link = $request->input('link', '');

            if ($target === 'all') {
                $members = Member::all(['id']);
                $inserts = [];
                foreach ($members as $m) {
                    $inserts[] = [
                        'user_id' => $m->id,
                        'title' => $title,
                        'body' => $body,
                        'link' => $link,
                        'icon' => 'bell',
                        'is_read' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                
                if (!empty($inserts)) {
                    // Split into chunks to avoid too many placeholders
                    foreach (array_chunk($inserts, 500) as $chunk) {
                        Notification::insert($chunk);
                    }
                }
            } else {
                Notification::create([
                    'user_id' => $target,
                    'title' => $title,
                    'body' => $body,
                    'link' => $link,
                    'icon' => 'bell',
                    'is_read' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            return redirect()->route('admin.notifikasi')->with('success', 'Notifikasi berhasil dikirim!');
        } elseif ($action === 'delete') {
            $id = (int)$request->input('id');
            Notification::where('id', $id)->delete();
            return redirect()->route('admin.notifikasi')->with('success', 'Notifikasi berhasil dihapus!');
        }

        return redirect()->route('admin.notifikasi');
    }
}
