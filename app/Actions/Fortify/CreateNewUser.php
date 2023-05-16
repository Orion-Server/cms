<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\RecaptchaRule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $this->treatRegistrationsStatus()
            ->validateForm($input);

        $userIp = request()->ip();

        $this->validateClientIp($userIp)
            ->interceptRegistrationsOverflowAttempts($userIp);

        return DB::transaction(function () use ($input, $userIp) {
            return tap(User::create([
                'username' => $input['username'],
                'password' => Hash::make($input['password']),
                'mail' => $input['email'],
                'gender' => $input['gender'],
                'account_created' => time(),
                'last_login' => time(),
                'motto' => getSetting('start_motto'),
                'look' => getSetting($input['gender'] == 'M' ? 'start_male_look' : 'start_female_look'),
                'credits' => getSetting('start_credits'),
                'home_room' => getSetting('start_room_id'),
                'ip_register' => $userIp,
                'ip_current' => $userIp,
                'referral_code' => \Str::random(15)
            ]), function (User $user) use ($input) {
                if(!isset($input['referrer_code'])) return;

                $this->setReferrer($user, $input['referrer_code']);
            });
        });
    }

    private function treatRegistrationsStatus(): CreateNewUser
    {
        if(! getSetting('disable_registrations')) return $this;

        throw ValidationException::withMessages([
            'error' => __('auth.registration_disabled')
        ]);
    }

    private function validateClientIp(string $ip): CreateNewUser
    {
        $flags = \App::isProduction()
            ? FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
            : FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6;

        if(!! filter_var($ip, FILTER_VALIDATE_IP, $flags)) return $this;

        throw ValidationException::withMessages([
            'error' => __('auth.invalid_ip')
        ]);
    }

    private function interceptRegistrationsOverflowAttempts(string $ip): CreateNewUser
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

    private function setReferrer(User $user, string $referrerCode): void
    {
        $referrerCodeOwner = User::where('referral_code', $referrerCode)
            ->where(
                fn ($query) => $query->whereNot('ip_register', $user->ip_register)
                    ->whereNot('ip_current', $user->ip_current)
            )->first();

        if(!$referrerCodeOwner) return;

        $user->update([
            'referrer_code' => $referrerCodeOwner->referral_code
        ]);
    }

    /**
     * Validate all user data provided from the form.
     *
     * @param array<string, string> $input
     */
    private function validateForm(array $input)
    {
        $validations = [
            'username' => ['required', 'string', 'max:25', sprintf('regex:%s', getSetting('register_username_regex')), 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'mail')],
            'gender' => ['required', 'string', 'max:1', Rule::in(['M', 'F'])],
            'referral_code' => ['sometimes', 'string', 'size:15'],
            'password' => $this->passwordRules()
        ];

        if(config('hotel.recaptcha.enabled')) {
            $validations['recaptcha'] = ['required', 'string', new RecaptchaRule];
        }

        return Validator::make($input, $validations)
            ->stopOnFirstFailure()
            ->validate();
    }
}
