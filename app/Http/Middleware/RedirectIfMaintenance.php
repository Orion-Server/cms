<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! getSetting('maintenance')) {
            return $this->redirectTo($request, $next);
        }

        if ($request->isMethod('POST')) {
            return $next($request);
        }

        if (!$user) {
            if ($request->routeIs('maintenance')) return $next($request);

            return to_route('maintenance');
        }

        if ($user->rank < getSetting('min_rank_to_maintenance_login')) {
            Auth::logout();

            return to_route('maintenance');
        }

        return $this->redirectTo($request, $next);
    }

    public function redirectTo(Request $request, Closure $next)
    {
        return $request->routeIs('maintenance') ? redirect()->route('index') : $next($request);
    }
}
