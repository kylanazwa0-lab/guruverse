<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AdminAuthController extends Controller
{
    protected array $adminRoles = ['super_admin', 'admin_kelas', 'admin_member', 'admin_konten'];

    // ── Show Admin Login Page ─────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // ── Handle Admin Login ────────────────────────────────────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'pass' => 'required|string',
        ], [
            'user.required' => 'Username wajib diisi.',
            'pass.required' => 'Kata sandi wajib diisi.',
        ]);

        // Rate Limiting — max 5 attempts per 15 minutes
        $key = 'admin-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."], 429);
            }
            return back()->withErrors(['user' => "Terlalu banyak percobaan. Coba dalam {$seconds} detik."]);
        }

        $username = $request->input('user');
        $password = $request->input('pass');

        // Cari member berdasarkan username atau email
        $member = Member::where('username', $username)
            ->orWhere('email', $username)
            ->first();

        $authenticated = false;
        if ($member) {
            try {
                if (Hash::check($password, $member->password)) {
                    $authenticated = true;
                }
            } catch (\Throwable $e) {
                // PHP 8+ melempar ValueError jika hash null/plaintext
            }
            // Fallback plain-text (legacy) — akan dihapus setelah semua hash
            if (!$authenticated && $member->password === $password) {
                $authenticated = true;
            }
        }

        if (!$authenticated) {
            RateLimiter::hit($key, 900);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kredensial tidak valid.'], 401);
            }
            return back()->withErrors(['user' => 'Kredensial tidak valid atau akun tidak ditemukan.']);
        }

        // Cek role admin
        if (!in_array($member->role, $this->adminRoles)) {
            RateLimiter::hit($key, 900);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Anda tidak memiliki hak akses admin.'], 403);
            }
            return back()->withErrors(['user' => 'Anda tidak memiliki hak akses admin.']);
        }

        RateLimiter::clear($key);

        // Login via guard admin
        Auth::guard('admin')->login($member);
        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Login berhasil!']);
        }
        return redirect()->route('admin.dashboard');
    }

    // ── Handle Admin Logout ───────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
