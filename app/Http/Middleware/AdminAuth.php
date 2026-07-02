<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     * Memastikan user sudah login sebagai admin dan memiliki role admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $member = Auth::guard('admin')->user();
        $adminRoles = ['super_admin', 'admin_kelas', 'admin_member', 'admin_konten'];

        if (!in_array($member->role, $adminRoles)) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Akses ditolak. Anda tidak memiliki hak akses admin.');
        }

        return $next($request);
    }
}
