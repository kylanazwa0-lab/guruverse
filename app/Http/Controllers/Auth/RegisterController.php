<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        // Validasi input super ketat
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'username' => 'required|string|max:50|unique:members',
            'password' => 'required|string|min:8|confirmed',
            'institution' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Enkripsi password menggunakan Bcrypt
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        // Atur status perubahan password menjadi false
        $validatedData['must_change_pass'] = false;
        
        // Generate member_id unik
        $validatedData['member_id'] = Member::generateMemberId();

        // Buat member baru
        $member = Member::create($validatedData);

        // Langsung login-kan setelah mendaftar
        Auth::login($member);

        // Set session kompatibilitas legacy
        $request->session()->put('member_id', $member->member_id);
        $request->session()->put('member_int_id', (int) $member->id);
        $request->session()->put('member_logged_in', true);
        $request->session()->put('member_login_at', time());

        // Redirect ke dashboard
        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Guruverse.');
    }
}
