<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** Tampilkan halaman login */
    public function showLogin()
    {
        return view('auth.login');
    }

    /** Proses login */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Cari user by email atau username
        $user = User::where('email', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();

        // Validasi user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Email/Username atau Password salah']);
        }

        // Login menggunakan Auth - sekarang harusnya work
        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/departments');
        } elseif ($user->role === 'staff') {
            return redirect('/dashboard');
        }

        return redirect('/');
    }

    /** Logout user */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Berhasil logout.');
    }

    /** Tampilkan halaman lupa password */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /** (Placeholder) Proses lupa password */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Misal nanti pakai Mail, sekarang cukup simulasi
        return back()->with('status', 'Link reset password telah dikirim ke email Anda (simulasi).');
    }
}
