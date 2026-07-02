<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Jika IP pengguna sudah melampaui batas percobaan gagal, blokir mereka (15 menit = 900 detik)
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Cek login via Username, Email, atau Member ID
        $member = Member::where('username', $request->login)
                        ->orWhere('email', $request->login)
                        ->orWhere('member_id', $request->login)
                        ->first();

        if ($member) {
            // Jika password di database masih plain-text (belum di-hash), lakukan verifikasi & auto-upgrade
            if (!Hash::needsRehash($member->password) === false && Hash::check($request->password, $member->password) === false) {
                // Fallback: cek jika password plain-text cocok dengan yang di database
                if ($request->password === $member->password) {
                    // Update ke Bcrypt dan hilangkan flag must_change_pass jika ada
                    $member->password = Hash::make($request->password);
                    $member->must_change_pass = false;
                    $member->save();
                }
            }

            // Jika belum mengatur password sama sekali
            if (empty($member->password) || $member->must_change_pass) {
                return back()->withErrors([
                    'login' => 'Akun Anda belum memiliki kata sandi atau wajib diubah. Silakan atur password terlebih dahulu.',
                ]);
            }

            // Proses autentikasi dengan Auth bawaan Laravel menggunakan instance Guard default (members)
            if (Auth::attempt([
                'id' => $member->id,
                'password' => $request->password
            ], $request->boolean('remember'))) {
                
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);
                
                // Tambahkan sesi legacy agar sistem PHP native di public/ tetap berjalan
                $request->session()->put('member_id', $member->member_id);
                $request->session()->put('member_int_id', (int) $member->id);
                $request->session()->put('member_logged_in', true);
                $request->session()->put('member_login_at', time());

                return redirect()->intended('/dashboard');
            }
        }

        // Jika gagal
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), 5);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit($this->throttleKey($request), 900); // Kunci 15 menit
    }

    protected function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function fireLockoutEvent(Request $request)
    {
        // Event dapat ditambahkan di sini
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        $minutes = ceil($seconds / 60);

        throw ValidationException::withMessages([
            'login' => ["Terlalu banyak percobaan login gagal. Coba lagi dalam {$minutes} menit."],
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('login')).'|'.$request->ip());
    }
}
