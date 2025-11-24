<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
            return redirect()->route('departments.index');
        } elseif ($user->role === 'staff') {
            return redirect()->route('staff.dashboard');
        }
        return redirect()->route('home');
    }

    // tampilkan form register (dapat menerima ?email=... untuk prefill)
    public function showRegister(Request $request)
    {
        $email = $request->get('email', null);
        return view('auth.register', compact('email'));
    }

    public function register(Request $request)
    {
        // cari apakah sudah ada user dengan email tersebut
        $existing = User::where('email', $request->input('email'))->first();

        // rules dasar
        $rules = [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'password' => ['required','string','min:8','confirmed'],
        ];

        if ($existing) {
            // Jika masih placeholder (belum punya password)
            if (empty($existing->password)) {
                $existing->update([
                    'username' => $request->username,
                    'password' => Hash::make($request->password)
                ]);

                return redirect('/login')->with('success', 'Akun berhasil diaktifkan. Silakan login.');
            }

            // Sudah aktif → tolak
            return back()->withErrors(['email' => 'Email ini sudah memiliki akun aktif.']);
        }

        $validated = $request->validate($rules);

        if ($existing) {
            // update placeholder user: set name & password
            $existing->name = $validated['name'];
            $existing->password = Hash::make($validated['password']);
            $existing->save();

            Auth::login($existing);

            return redirect()->intended('/'); // atau route dashboard
        }

        // buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->intended('/');
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
