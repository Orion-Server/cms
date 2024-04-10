<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Qirolab\Theme\Theme;
use Symfony\Component\HttpFoundation\Response;

class HandleTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeTheme = getSetting('active_cms_theme', 'default');

        if($activeTheme != Theme::active()) {
            Theme::set($activeTheme);
        }

        return $next($request);
    }
}
