<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Compositions\User\{
    HasCurrency,
    HasSettings
};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasCurrency, HasSettings;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'mail',
        'account_created',
        'last_login',
        'motto',
        'look',
        'credits',
        'ip_register',
        'ip_current',
        'home_room',
        'auth_ticket',
        'gender',
        'referral_code',
        'referrer_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::created(function ($user) {
            $user->generateInitialCurrencies();
            $user->generateInitialSettings();
        });
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_code', 'referral_code');
    }

    public function referredUsers(): HasMany
    {
        return $this->hasMany(User::class, 'referrer_code', 'referral_code');
    }

    public function isBoy(): bool
    {
        return $this->gender == 'M';
    }

    public function isGirl(): bool
    {
        return $this->gender == 'F';
    }
}
