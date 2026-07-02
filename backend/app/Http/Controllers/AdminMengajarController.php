<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminMengajarController extends Controller
{
    private function checkRole(array $allowed): bool
    {
        $role = Auth::guard('admin')->user()->role ?? '';
        return in_array($role, $allowed);
    }

    // --- JADWAL ---
    public function jadwal(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_kelas'])) {
            abort(403, 'Akses ditolak.');
        }

        // Jadwal is currently mocked in blade, we can leave it as a static view for now or fetch if needed
        $admin = Auth::guard('admin')->user();
        return view('admin.mengajar_jadwal', compact('admin'));
    }

    // --- GAMIFIKASI ---
    public function gamifikasi(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_kelas'])) {
            abort(403, 'Akses ditolak.');
        }

        $search = $request->query('search', '');
        
        $tantangan_list = [];
        $stats_list = [];
        $members_list = [];

        try {
            $query = DB::table('gb_mengajar_tantangan as t')
                ->select('t.*', 'm.full_name as member_name')
                ->leftJoin('members as m', 't.member_id', '=', 'm.id');
            
            if ($search) {
                $query->where('t.nama_tantangan', 'like', "%{$search}%")
                      ->orWhere('m.full_name', 'like', "%{$search}%");
            }

            $tantangan_list = $query->orderBy('t.id', 'desc')->get()->map(function($t) {
                return (array) $t;
            })->toArray();

            $stats_list = DB::table('gb_mengajar_stats as s')
                ->select('s.*', 'm.full_name as member_name')
                ->leftJoin('members as m', 's.member_id', '=', 'm.id')
                ->orderBy('s.total_xp', 'desc')
                ->get()->map(function($s) {
                    return (array) $s;
                })->toArray();

            $members_list = DB::table('members')->select('id', 'full_name as name')->get()->map(function($m) {
                return (array) $m;
            })->toArray();
        } catch (\Exception $e) {
            // Tables might not exist
        }

        return view('admin.mengajar_gamifikasi', compact('admin', 'tantangan_list', 'stats_list', 'members_list', 'search'));
    }

    public function storeGamifikasi(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_kelas'])) abort(403);

        $action = $request->input('action');
        
        try {
            if ($action === 'create') {
                DB::table('gb_mengajar_tantangan')->insert([
                    'member_id' => $request->input('member_id'),
                    'nama_tantangan' => $request->input('nama_tantangan'),
                    'tanggal' => $request->input('tanggal'),
                    'ikon' => $request->input('ikon', '🎯'),
                    'xp_reward' => $request->input('xp_reward', 100),
                    'target' => $request->input('target', 1),
                    'progress' => 0,
                    'is_done' => 0
                ]);
                return redirect()->back()->with('msg', 'Tantangan berhasil ditambahkan!');
            } elseif ($action === 'update') {
                $target = (int) $request->input('target', 1);
                $progress = (int) $request->input('progress', 0);
                DB::table('gb_mengajar_tantangan')->where('id', $request->input('id'))->update([
                    'nama_tantangan' => $request->input('nama_tantangan'),
                    'xp_reward' => $request->input('xp_reward'),
                    'target' => $target,
                    'progress' => $progress,
                    'is_done' => ($progress >= $target) ? 1 : 0
                ]);
                return redirect()->back()->with('msg', 'Tantangan berhasil diperbarui!');
            } elseif ($action === 'delete') {
                DB::table('gb_mengajar_tantangan')->where('id', $request->input('id'))->delete();
                return redirect()->back()->with('msg', 'Tantangan berhasil dihapus!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('msg', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
