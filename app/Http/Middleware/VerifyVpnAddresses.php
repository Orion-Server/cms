<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\IpDataList;
use Illuminate\Http\Request;
use App\Enums\AddressCondition;
use Illuminate\Support\Facades\Auth;
use Kielabokkie\LaravelIpdata\Facades\Ipdata;
use Symfony\Component\HttpFoundation\Response;

class VerifyVpnAddresses
{
    /**
     * The bypass addresses.
     */
    private array $bypassAddresses = [
        '127.0.0.1',
        'localhost'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!getSetting('vpn_checker_enabled', false)) return $next($request);

        $ip = $request->ip();

        if ($this->isBypassAddress($ip) || $this->hasSufficientRankToBypass()) {
            return $next($request);
        }

        $ipAddressSituation = $this->getAddressSituation('ip', $ip);

        return match ($ipAddressSituation) {
            'whitelisted' => $next($request),
            'blacklisted' => $this->redirectToIndexWithVpnError(),
            default => $this->handleAsn($request, $next, $ip),
        };
    }

    private function handleAsn(Request $request, Closure $next, string $ip): Response
    {
        $ipData = Ipdata::lookup($ip);
        $asnData = $ipData->asn ?? null;

        if(!$asnData || !$asnData->asn) return $next($request);

        $asnAddressSituation = $this->getAddressSituation('asn', $asnData->asn);

        return match ($asnAddressSituation) {
            'whitelisted' => $next($request),
            'blacklisted' => $this->redirectToIndexWithVpnError(),
            default => $this->handleAsnThreat($request, $next, $ipData),
        };
    }

    private function handleAsnThreat(Request $request, Closure $next, object $ipData): Response
    {
        if(!$ipData->threat) return $next($request);

        $fieldsToValidate = explode(',',
            getSetting('vpn_threat_data_fields', '')
        );

        if(empty($fieldsToValidate)) return $next($request);

        foreach ($fieldsToValidate as $field) {
            if(property_exists($ipData->threat, $field) && $ipData->threat->{$field}) {
                IpDataList::create([
                    'ip' => $ipData->ip,
                    'asn' => $ipData->asn->asn,
                    'ip_condition' => AddressCondition::Blacklist,
                    'asn_condition' => AddressCondition::Whitelist
                ]);

                return $this->redirectToIndexWithVpnError();
            }
        }

        return $next($request);
    }

    private function isBypassAddress(string $ip): bool
    {
        return in_array($ip, $this->bypassAddresses);
    }

    private function hasSufficientRankToBypass(): bool
    {
        $minRankToBypass = getSetting('min_rank_to_bypass_vpn_checker', null);

        return Auth::check() && is_numeric($minRankToBypass) && Auth::user()->rank >= $minRankToBypass;
    }

    private function getAddressSituation(string $type, string $address): ?string
    {
        return tap(IpDataList::where($type, $address)->first(), function (?IpDataList $ipDataList) {
            if (!$ipDataList) return 'allow';
            if ($ipDataList->ip_condition === AddressCondition::Whitelist) return 'whitelisted';
            if ($ipDataList->ip_condition === AddressCondition::Blacklist) return 'blacklisted';
        });
    }

    private function redirectToIndexWithVpnError(): Response
    {
        return to_route('index')->with('vpnError', __('You are not allowed to access this page from a VPN or a proxy.'));
    }
}
