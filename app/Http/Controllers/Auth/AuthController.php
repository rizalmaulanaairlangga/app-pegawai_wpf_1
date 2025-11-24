<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

        // Login menggunakan Auth 
        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('departments.index')->with('success', 'Berhasil login sebagai Admin.');
        } elseif ($user->role === 'staff') {
            return redirect()->route('staff.dashboard')->with('success', 'Berhasil login sebagai Staff');
        }
        return redirect()->route('home')->with('info', 'Role user tidak dikenali.');
    }

    // tampilkan form register (dapat menerima ?email=... untuk prefill)
    public function showRegister(Request $request)
    {
        $email = $request->get('email', null);
        return view('auth.register', compact('email'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'], // Harus sudah ada!
            'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\-_.]+$/'],
            'password' => ['required', 'string', 'min:6', 'confirmed'], // Min 6 karakter
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem. Hubungi admin.',
            'password.min' => 'Password minimal 6 karakter.',
            'username.regex' => 'Username hanya boleh huruf, angka, spasi, garis bawah, titik, dan strip.'
        ]);

        // cek existing user
        $existing = User::where('email', $validated['email'])->first();

        // jika sudah pernah aktif → tolak
        if (!empty($existing->password)) {
            return back()->withErrors(['email' => 'Email ini sudah memiliki akun aktif.'])->withInput();
        }

        // aktivasi akun placeholder
        $existing->update([
            'name'     => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil diaktifkan. Silakan login.');
    }

    /** Logout user */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
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
