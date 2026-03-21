<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pozwól na logout dla wszystkich użytkowników
        if ($request->path() === 'admin/logout' || $request->routeIs('filament.admin.auth.logout')) {
            return $next($request);
        }

        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'it'])) {
            return $next($request);
        }

        return redirect('/session')->with('error', 'Nie masz uprawnień do dostępu do tego panelu.');
    }
}
