<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class EnsureEmployeeExists
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            // cek keberadaan employee terkait (sesuaikan kolom jika perlu)
            $employeeExists = Employee::where('email', $user->email)->exists();

            if (! $employeeExists) {
                // pastikan logout dan invalidate session
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // gunakan kunci session 'status' (umum dipakai di view Laravel)
                return redirect()->route('login')
                    ->with('status', 'Akun Anda tidak lagi terhubung ke data pegawai. Silakan hubungi administrator.');
            }
        }

        return $next($request);
    }
}