<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ── Member Login ──────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('member.portal');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // ── Rate Limiting ─────────────────────────────────────────────────────
        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('username'));
        }

        // ── Cari Member ───────────────────────────────────────────────────────
        // Support login via username ATAU email
        $member = Member::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        // ── Verifikasi Password ───────────────────────────────────────────────
        $authenticated = false;
        if ($member) {
            try {
                $authenticated = Hash::check($request->password, $member->password);
            } catch (\Throwable $e) {
                // Fallback: plaintext match untuk data legacy
                $authenticated = ($member->password === $request->password);
            }
        }

        if (!$authenticated) {
            RateLimiter::hit($throttleKey, 60); // lock 60 detik per percobaan gagal
            \Log::warning('[AUTH] Login gagal', [
                'username_input' => $request->username,
                'ip'             => $request->ip(),
                'user_agent'     => $request->userAgent(),
            ]);
            return back()->withErrors([
                'username' => 'Username atau kata sandi salah.',
            ])->withInput($request->only('username'));
        }

        RateLimiter::clear($throttleKey);

        // ── Upgrade plaintext password ke bcrypt (one-time fix legacy data) ──
        if (!str_starts_with($member->password, '$2y$') && !str_starts_with($member->password, '$2a$')) {
            $member->password = Hash::make($request->password);
            $member->save();
        }

        // ── SESSION SECURITY: Invalidate session lama SEBELUM login ──────────
        // Ini mencegah Session Fixation Attack — session ID lama dibuang dulu
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ── Login via guard web (member) ──────────────────────────────────────
        Auth::guard('web')->login($member, $request->boolean('remember'));

        // Regenerate session ID baru setelah login (anti session fixation)
        $request->session()->regenerate();

        // Simpan fingerprint sesi untuk validasi berikutnya
        $request->session()->put('auth.fingerprint', hash('sha256',
            $request->userAgent() . '|' . $request->ip()
        ));
        $request->session()->put('auth.user_id_verify', $member->id);

        // ── Audit Log ─────────────────────────────────────────────────────────
        \Log::info('[AUTH] Login berhasil', [
            'user_id'    => $member->id,
            'username'   => $member->username,
            'full_name'  => $member->full_name,
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // ── Redirect ──────────────────────────────────────────────────────────
        $adminRoles = ['super_admin', 'admin_kelas', 'admin_member', 'admin_konten'];
        if (in_array($member->role, $adminRoles)) {
            Auth::guard('admin')->login($member, $request->boolean('remember'));
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('member.portal');
    }

    public function logout(Request $request)
    {
        try {
            \Log::info('[AUTH] Logout', [
                'user_id' => Auth::guard('web')->id(),
                'ip'      => $request->ip(),
            ]);
            Auth::guard('web')->logout();
            Auth::guard('admin')->logout();
        } catch (\Throwable $e) {
            // Abaikan error jika session sudah expired
        }

        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Throwable $e) {
            // Session mungkin sudah tidak ada
        }

        return redirect()->route('login');
    }

    // ── Member Register ───────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('member.portal');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name'   => 'required|string|max:255',
            'username'    => 'required|string|max:50|unique:members,username',
            'phone'       => 'required|string|max:20',
            'institution' => 'nullable|string|max:255',
            'password'    => 'required|string|min:8|confirmed',
            'photo'       => 'nullable|image|max:2048',
        ], [
            'full_name.required'  => 'Nama lengkap wajib diisi.',
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username sudah digunakan.',
            'phone.required'      => 'Nomor HP wajib diisi.',
            'password.required'   => 'Kata sandi wajib diisi.',
            'password.min'        => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $photoBase64 = null;
        if ($request->hasFile('photo')) {
            $photoBase64 = base64_encode(file_get_contents($request->file('photo')->getRealPath()));
        }

        $member = Member::create([
            'member_id'   => Member::generateMemberId(),
            'full_name'   => $request->full_name,
            'username'    => $request->username,
            'phone'       => $request->phone,
            'institution' => $request->institution ?? '',
            'password'    => Hash::make($request->password),
            'photo_base64' => $photoBase64,
        ]);

        Auth::guard('web')->login($member);

        // Session security: invalidate lama → login → regenerate
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::guard('web')->login($member);
        $request->session()->regenerate();

        $request->session()->put('auth.fingerprint', hash('sha256',
            $request->userAgent() . '|' . $request->ip()
        ));
        $request->session()->put('auth.user_id_verify', $member->id);

        \Log::info('[AUTH] Registrasi berhasil', [
            'user_id'   => $member->id,
            'username'  => $member->username,
            'full_name' => $member->full_name,
            'ip'        => $request->ip(),
        ]);

        return redirect()->route('member.portal')
            ->with('success', 'Selamat datang, ' . $member->full_name . '!');
    }
}
