<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminInspiraController extends Controller
{
    private function checkRole(array $allowed): bool
    {
        $role = Auth::guard('admin')->user()->role ?? '';
        return in_array($role, $allowed);
    }

    // --- CERITA ---
    public function cerita(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_konten'])) {
            abort(403, 'Akses ditolak.');
        }

        $query = DB::table('gb_inspira_cerita');
        if ($search = $request->query('search')) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
        }

        $cerita_list = $query->orderBy('created_at', 'desc')->get()->map(function($c) {
            return (array) $c;
        })->toArray();

        // Inject author_name placeholder for now
        foreach ($cerita_list as &$c) {
            $c['author_name'] = 'Admin';
        }

        $search = $request->query('search', '');
        $admin = Auth::guard('admin')->user();
        return view('admin.inspira_cerita', compact('admin', 'cerita_list', 'search'));
    }

    public function storeCerita(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_konten'])) abort(403);

        $action = $request->input('action');
        if ($action === 'create') {
            DB::table('gb_inspira_cerita')->insert([
                'author_id' => 1,
                'judul' => $request->input('judul'),
                'konten' => $request->input('konten'),
                'status' => $request->input('status', 'draft'),
                'created_at' => now(),
            ]);
            return redirect()->back()->with('msg', 'Cerita berhasil ditambahkan!');
        } elseif ($action === 'update') {
            DB::table('gb_inspira_cerita')->where('id', $request->input('id'))->update([
                'judul' => $request->input('judul'),
                'konten' => $request->input('konten'),
                'status' => $request->input('status', 'draft'),
            ]);
            return redirect()->back()->with('msg', 'Cerita berhasil diperbarui!');
        } elseif ($action === 'delete') {
            DB::table('gb_inspira_cerita')->where('id', $request->input('id'))->delete();
            return redirect()->back()->with('msg', 'Cerita berhasil dihapus!');
        }

        return redirect()->back();
    }

    // --- AGENDA ---
    public function agenda(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_konten'])) {
            abort(403, 'Akses ditolak.');
        }

        $query = DB::table('gb_inspira_event');
        if ($search = $request->query('search')) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        }

        $agenda_list = $query->orderBy('event_date', 'desc')->get()->map(function($a) {
            return (array) $a;
        })->toArray();

        $search = $request->query('search', '');
        $admin = Auth::guard('admin')->user();
        return view('admin.inspira_agenda', compact('admin', 'agenda_list', 'search'));
    }

    public function storeAgenda(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_konten'])) abort(403);

        $action = $request->input('action');
        if ($action === 'create') {
            DB::table('gb_inspira_event')->insert([
                'judul' => $request->input('nama_event'),
                'event_date' => $request->input('tanggal_event'),
                'lokasi' => $request->input('lokasi'),
                'deskripsi' => $request->input('deskripsi', ''),
                'created_at' => now(),
            ]);
            return redirect()->back()->with('msg', 'Agenda berhasil ditambahkan!');
        } elseif ($action === 'update') {
            DB::table('gb_inspira_event')->where('id', $request->input('id'))->update([
                'judul' => $request->input('nama_event'),
                'event_date' => $request->input('tanggal_event'),
                'lokasi' => $request->input('lokasi'),
                'deskripsi' => $request->input('deskripsi', ''),
            ]);
            return redirect()->back()->with('msg', 'Agenda berhasil diperbarui!');
        } elseif ($action === 'delete') {
            DB::table('gb_inspira_event')->where('id', $request->input('id'))->delete();
            return redirect()->back()->with('msg', 'Agenda berhasil dihapus!');
        }

        return redirect()->back();
    }
}
