<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Compositions\User\{
    HasCurrency,
    HasSettings
};
use Illuminate\Database\Eloquent\Relations\{
    HasMany,
    BelongsTo,
    HasOne
};
use Filament\Models\Contracts\{
    HasName,
    FilamentUser,
    HasAvatar
};

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
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
        'rank',
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
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'online' => 'boolean',
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

    public function canAccessFilament(): bool
    {
        return $this->rank >= getSetting('min_rank_to_housekeeping_login');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return sprintf(
            '%s%s&size=m&head_direction=3&gesture=sml&headonly=1',
            getSetting('figure_imager'),
            $this->look
        );
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'rank');
    }

    public function getFilamentName(): string
    {
        return $this->username;
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
