<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfBetaCodeMissing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!getSetting('beta_period') || !Auth::check()) return $next($request);

        $user = Auth::user();

        if($user->rank >= getSetting('min_rank_to_bypass_beta_period')) return $next($request);

        if(!$user->betaCode || $user->betaCode->valid_at->lte(now())) {
            Auth::logout();

            return to_route('index');
        }

        return $next($request);
    }
}
