<?php

namespace App\Http\Middleware;

use App\Services\FindRetrosService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfVoteMissing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!getSetting('findretros_enabled', false)) {
            return $next($request);
        }

        if (app(FindRetrosService::class)->checkIpVote($request)) {
            return $next($request);
        }

        return redirect(sprintf(
            config('services.findretros.redirect_vote_uri'),
            getSetting('findretros_name')
        ));
    }
}
