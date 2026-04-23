<?php

namespace App\Http\Middleware;

// Artisan: php artisan make:middleware StaffMiddleware
// Path: app/Http/Middleware/StaffMiddleware.php

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Izinkan akses hanya untuk user dengan role staff.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isStaff()) {
            abort(403, 'Akses ditolak. Halaman ini khusus Staff.');
        }

        return $next($request);
    }
}
