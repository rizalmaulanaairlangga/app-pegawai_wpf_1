<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['login' => 'Silakan login terlebih dahulu']);
        }

        $user = Auth::user();

        // Jika role user tidak masuk dalam daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            $errorMessage = "Anda tidak memiliki akses ke halaman ini.";

            return match ($user->role) {
                'admin' => redirect('/departments')->with('error', $errorMessage),
                'staff' => redirect('/dashboard')->with('error', $errorMessage),
                default => redirect('/')->with('error', $errorMessage),
            };
        }

        return $next($request);
    }

}