<?php

namespace App\Http\Middleware;

// Artisan: php artisan make:middleware AdminMiddleware
// Path: app/Http/Middleware/AdminMiddleware.php

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Izinkan akses hanya untuk user dengan role admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini khusus Admin.');
        }

        return $next($request);
    }
}
