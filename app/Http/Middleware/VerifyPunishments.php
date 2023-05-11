<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyPunishments
{
    /**
     * You can put what types of bans you consider an IP ban, in this case, I chose to leave ip/machine.
     * You have free and spontaneous will to put whatever you want.
     *
     * @var string[]
     */
    private array $validIpPunishments = ['ip', 'machine'];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $validPunishments = Ban::from($request->ip(), Auth::check());

        if($validPunishments->isEmpty()) {
            return $this->returnToIndex($request, $next);
        }

        $ipBan = $validPunishments->whereIn('type', $this->validIpPunishments)->first();
        $accountBan = $validPunishments->where('type', 'account')
            ->where('user_id', Auth::id())
            ->first();

        if(!$ipBan && !$accountBan) {
            return $this->returnToIndex($request, $next);
        }

        $request->attributes->add(['ban' => $ipBan ?? $accountBan]);

        $requestIsNotFor = fn(...$params) => !$request->routeIs(...$params);

        if(($ipBan && $requestIsNotFor('jail')) || ($accountBan && Auth::check() && $requestIsNotFor('jail', 'logout'))) {
            return to_route('jail');
        }

        return $next($request);
    }

    public function returnToIndex(Request $request, Closure $next)
    {
        return $request->routeIs('jail') ? redirect()->route('index') : $next($request);
    }
}
