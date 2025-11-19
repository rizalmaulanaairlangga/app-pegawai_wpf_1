<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['login' => 'Silakan login terlebih dahulu']);
        }

        $user = Auth::user();
        
        // Jika role tidak sesuai, redirect ke halaman utama role user
        if ($user->role !== $role) {
            $errorMessage = "Anda tidak memiliki akses ke halaman ini. Role {$role} diperlukan.";
            
            // Redirect berdasarkan role user saat ini
            switch ($user->role) {
                case 'admin':
                    return redirect('/departments')->with('error', $errorMessage);
                case 'staff':
                    return redirect('/dashboard')->with('error', $errorMessage);
                default:
                    return redirect('/')->with('error', $errorMessage);
            }
        }

        return $next($request);
    }
}