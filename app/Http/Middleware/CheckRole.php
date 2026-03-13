<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect('/login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan.']);
        }

        if ($role === 'administrator' && !auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak. Hanya Administrator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
