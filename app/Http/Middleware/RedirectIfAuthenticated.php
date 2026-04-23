<?php

namespace App\Http\Middleware;

// Path: app/Http/Middleware/RedirectIfAuthenticated.php
// GANTI ISI FILE YANG SUDAH ADA dengan kode berikut

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Redirect user yang sudah login sesuai rolenya.
     * Middleware 'guest' menggunakan class ini.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Redirect berdasarkan role
                if ($user->isAdmin()) {
                    return redirect('/admin/dashboard');
                }

                return redirect('/staff/dashboard');
            }
        }

        return $next($request);
    }
}
