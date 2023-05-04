<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        $this->validateForm($input);

        $userIp = request()->ip();

        return DB::transaction(function () use ($input, $userIp) {
            return tap(User::create([
                'username' => $input['username'],
                'password' => Hash::make($input['password']),
                'mail' => $input['email'],
                'gender' => $input['gender'],
                'account_created' => time(),
                'last_login' => time(),
                'motto' => 'I Love OrionCMS',
                'look' => 'fa-201407-1324.hr-828-1035.ch-3001-1261-1408.sh-3068-92-1408.cp-9032-1308.lg-270-1281.hd-209-3',
                'credits' => 50000,
                'ip_register' => $userIp,
                'ip_current' => $userIp,
                'referral_code' => \Str::random(15)
            ]), function (User $user) use ($input) {
                if(!isset($input['referrer_code'])) return;

                $this->setReferrer($user, $input['referrer_code']);
            });
        });
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
            'username' => ['required', 'string', 'max:25', 'regex:/^([À-üA-Za-z\.:_\-0-9\!]+)$/', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,mail'],
            'gender' => ['required', 'string', 'max:1', Rule::in(['M', 'F'])],
            'referral_code' => ['nullable', 'string', 'size:15'],
            'password' => $this->passwordRules()
        ];

        return Validator::make($input, $validations)
            ->stopOnFirstFailure()
            ->validate();
    }
}
