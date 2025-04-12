<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user login sekarang
        $user = Auth::user();

        // Cek apakah role user cocok
        if (!in_array($user->role, $roles)) {
            return redirect('/')->with('error', 'Kamu tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}
