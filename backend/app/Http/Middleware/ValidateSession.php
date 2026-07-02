<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ValidateSession Middleware
 *
 * Memastikan bahwa user yang terautentikasi di session
 * benar-benar sesuai dengan data di database.
 *
 * Mencegah:
 * - Session yang "tertukar" antar user
 * - Session fixation (jika masih lolos)
 * - Akun yang sudah dihapus tapi session-nya masih aktif
 */
class ValidateSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            // ── Cek 1: Verifikasi user_id_verify di session cocok dengan user aktif ──
            $sessionUserId = $request->session()->get('auth.user_id_verify');

            if ($sessionUserId !== null && (int) $sessionUserId !== (int) $user->id) {
                // Session user_id tidak cocok — paksa logout
                \Log::critical('[SECURITY] Session user_id mismatch — forced logout', [
                    'session_user_id' => $sessionUserId,
                    'auth_user_id'    => $user->id,
                    'ip'              => $request->ip(),
                    'url'             => $request->fullUrl(),
                    'user_agent'      => $request->userAgent(),
                ]);

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'username' => 'Sesi Anda tidak valid. Silakan login kembali.',
                ]);
            }

            // ── Cek 2: Verifikasi user masih ada di database ──────────────────────
            $dbUser = \App\Models\Member::find($user->id);
            if (!$dbUser) {
                \Log::warning('[SECURITY] User tidak ditemukan di DB — forced logout', [
                    'auth_user_id' => $user->id,
                    'ip'           => $request->ip(),
                ]);

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'username' => 'Akun tidak ditemukan. Silakan login kembali.',
                ]);
            }

            // ── Cek 3: Sinkronkan data user jika ada perubahan di DB ──────────────
            // Ini memastikan jika admin mengupdate nama/data user,
            // perubahan langsung tercermin tanpa perlu re-login
            if ($dbUser->full_name !== $user->full_name ||
                $dbUser->institution !== $user->institution ||
                $dbUser->photo_base64 !== $user->photo_base64) {
                Auth::guard('web')->setUser($dbUser);
            }
        }

        return $next($request);
    }
}
