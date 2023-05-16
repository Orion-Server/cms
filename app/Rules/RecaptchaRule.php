<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(! config('hotel.recaptcha.enabled')) return;

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'remoteip' => request()->ip(),
            'secret' => config('hotel.recaptcha.secret_key'),
            'response' => $value,
        ])->json();

        if(! $response['success']) $fail(__('auth.recaptcha_failed'));
    }
}
