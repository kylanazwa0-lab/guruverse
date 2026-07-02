<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    protected array $adminRoles = ['super_admin', 'admin_kelas', 'admin_member', 'admin_konten'];

    private function checkRole(array $allowed): bool
    {
        $role = Auth::guard('admin')->user()->role ?? '';
        return in_array($role, $allowed);
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        $stats = [];
        $stats['total_member']     = \App\Models\Member::count();
        $stats['total_kelas']      = \App\Models\Course::count();
        $stats['total_modul']      = \App\Models\Module::count();
        $stats['total_sertifikat'] = \App\Models\Certificate::count();
        $stats['new_today']        = \App\Models\Member::whereDate('joined_at', \Carbon\Carbon::today())->count();
        
        try {
            $stats['total_jam_mengajar'] = \Illuminate\Support\Facades\DB::table('gb_mengajar_stats')->sum('jam_mengajar') ?? 0;
        } catch (\Exception $e) {
            $stats['total_jam_mengajar'] = 0;
        }
        
        try {
            $stats['total_cerita'] = \Illuminate\Support\Facades\DB::table('gb_inspira_cerita')->count();
        } catch (\Exception $e) {
            $stats['total_cerita'] = 0;
        }

        $stats['recent_members'] = \App\Models\Member::orderBy('joined_at', 'desc')
            ->limit(5)
            ->get(['id', 'full_name', 'institution', 'joined_at as created_at'])
            ->toArray();

        $stats['recent_kelas'] = \App\Models\Course::orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'category', 'status', 'created_at'])
            ->toArray();

        return view('admin.dashboard', compact('admin', 'stats'));
    }

    public function members(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_member'])) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }
            abort(403, 'Akses ditolak.');
        }

        $query = \App\Models\Member::query();
        if ($s = $request->query('q')) {
            $query->where('full_name', 'like', "%$s%")
                  ->orWhere('username', 'like', "%$s%");
        }

        if ($request->ajax() || $request->wantsJson()) {
            $members = $query->orderBy('id', 'desc')->get()->map(function ($m) {
                return [
                    'id' => $m->id,
                    'memberId' => $m->member_id,
                    'fullName' => $m->full_name,
                    'username' => $m->username,
                    'institution' => $m->institution,
                    'phone' => $m->phone,
                    'photo' => $m->photo,
                    'joinedAt' => $m->joined_at
                ];
            });
            return response()->json([
                'success' => true,
                'members' => $members
            ]);
        }

        $members = $query->orderBy('id', 'desc')->paginate(20);
        $admin = Auth::guard('admin')->user();
        return view('admin.members', compact('admin', 'members'));
    }

    // ── CRUD Member API ───────────────────────────────────────────────────────

    public function storeMember(Request $request)
    {
        if (!$this->checkRole(['super_admin', 'admin_member'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $data = $request->validate([
            'full_name'   => 'required|string|max:255',
            'username'    => 'required|string|max:50|unique:members,username',
            'institution' => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'password'    => 'required|string|min:6',
        ]);

        $data['member_id'] = \App\Models\Member::generateMemberId();
        $data['password']  = \Illuminate\Support\Facades\Hash::make($data['password']);

        $member = \App\Models\Member::create($data);

        return response()->json(['success' => true, 'message' => 'Anggota berhasil ditambahkan.', 'member' => $member]);
    }

    public function destroyMember(int $id)
    {
        if (!$this->checkRole(['super_admin', 'admin_member'])) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        \App\Models\Member::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Anggota berhasil dihapus.']);
    }

    protected array $permissions = [
        'member' => ['super_admin', 'admin_member'],
        'kelas' => ['super_admin', 'admin_kelas', 'admin_konten'],
        'modul' => ['super_admin', 'admin_kelas', 'admin_konten'],
        'produk' => ['super_admin', 'admin_kelas', 'admin_konten'],
        'sertifikat' => ['super_admin', 'admin_kelas', 'admin_konten'],
        'inspira_cerita' => ['super_admin', 'admin_konten'],
        'inspira_agenda' => ['super_admin', 'admin_konten'],
        'mengajar_jadwal' => ['super_admin', 'admin_kelas'],
        'mengajar_gamifikasi' => ['super_admin', 'admin_kelas'],
        'diskusi' => ['super_admin', 'admin_konten'],
        'live_chat' => ['super_admin', 'admin_konten'],
        'notifikasi' => ['super_admin', 'admin_konten'],
        'bot_settings' => ['super_admin']
    ];

    public function showModule($module)
    {
        if (!array_key_exists($module, $this->permissions)) {
            abort(404);
        }
        
        if (!$this->checkRole($this->permissions[$module])) {
            abort(403, 'Akses ditolak.');
        }

        // Redirect if there is a dedicated controller/route
        $redirects = [
            'kelas' => 'admin.kelas',
            'modul' => 'admin.modul',
            'diskusi' => 'admin.diskusi',
            'notifikasi' => 'admin.notifikasi',
            'mengajar_gamifikasi' => 'admin.mengajar_gamifikasi',
            'mengajar_jadwal' => 'admin.mengajar_jadwal',
            'inspira_agenda' => 'admin.inspira_agenda',
            'inspira_cerita' => 'admin.inspira_cerita',
            'member' => 'admin.members',
        ];

        if (array_key_exists($module, $redirects)) {
            return redirect()->route($redirects[$module]);
        }

        // Establish connection $conn for legacy views
        $host = config('database.connections.mysql.host', '127.0.0.1');
        $username = config('database.connections.mysql.username', 'root');
        $password = config('database.connections.mysql.password', '');
        $database = config('database.connections.mysql.database', 'guruverse');
        $port = config('database.connections.mysql.port', '3306');

        $conn = new \mysqli($host, $username, $password, $database, $port);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Make $conn globally accessible for views
        $GLOBALS['conn'] = $conn;
        \View::share('conn', $conn);

        $q = request()->query('q', '');

        $admin = Auth::guard('admin')->user();
        
        if (view()->exists("admin.{$module}")) {
            return view("admin.{$module}", compact('admin', 'conn'));
        }
    }
}
