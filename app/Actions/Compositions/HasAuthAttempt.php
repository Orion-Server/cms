<?php

namespace App\Actions\Compositions;

use App\Models\User;
use Illuminate\Validation\ValidationException;

trait HasAuthAttempt
{
    private function treatRegistrationsStatus(): self
    {
        if(! getSetting('disable_registrations')) return $this;

        throw ValidationException::withMessages([
            'error' => __('auth.registration_disabled')
        ]);
    }

    private function validateClientIp(string $ip): self
    {
        $flags = \App::isProduction()
            ? FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
            : FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6;

        if(!! filter_var($ip, FILTER_VALIDATE_IP, $flags)) return $this;

        throw ValidationException::withMessages([
            'error' => __('auth.invalid_ip')
        ]);
    }

    private function interceptRegistrationsOverflowAttempts(string $ip): self
    {
        $accountsCount = User::where('ip_register', $ip)
            ->orWhere('ip_current', $ip)
            ->count();

        if(!$accountsCount) return $this;

        $maxAccountsPerIp = getSetting('max_accounts_per_ip');

        if($accountsCount <= $maxAccountsPerIp) return $this;

        throw ValidationException::withMessages([
            'error' => __('auth.max_accounts_per_ip', ['max' => $maxAccountsPerIp])
        ]);
    }
}
