<?php

namespace App\Models;

use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\{
    Casts\Attribute,
    Factories\HasFactory
};
use App\Models\{
    User\UserBadge,
    User\UserItem,
    User\UserOrder,
    Article\ArticleComment
};
use App\Models\Compositions\User\{
    HasCurrency,
    HasItems,
    HasSettings,
    HasProfile,
    HasRoles
};
use Illuminate\Database\Eloquent\Relations\{
    HasMany,
    BelongsTo,
    HasManyThrough,
    HasOne
};
use Filament\Models\Contracts\{
    HasName,
    FilamentUser,
    HasAvatar
};

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;
    use HasCurrency, HasSettings, HasProfile, HasItems, HasRoles;

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
        'referrer_code',
        'avatar_background',
        'team_id',
        'provider_id',
        'account_day_of_birth',
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

        static::created(function (User $user) {
            $user->generateInitialCurrencies();
            $user->generateInitialSettings();
            $user->generateInitialHomeItems();

            if(!empty($user->provider_id)) {
                $user->settings->can_change_name = '1';
                $user->settings->save();
            }
        });
    }

    public static function getAllStaffsId(): array
    {
        return User::where('rank', '>=', getSetting('min_list_rank'))
            ->pluck('id')
            ->toArray();
    }

    public static function getCreditsRanking(int $limit = 10): Builder
    {
        return User::where('rank', '<', getSetting('min_list_rank'))
            ->select(['id', 'username', 'look', 'credits as value'])
            ->orderByDesc('credits')
            ->limit($limit);
    }

    public static function forIndex(int $limit = 16): Builder
    {
        return User::select(['id', 'username', 'look'])
            ->limit($limit)
            ->latest('id');
    }

    public static function createFromData(array $data)
    {
        return self::create([
            ...$data,
            'account_created' => time(),
            'last_login' => time(),
            'motto' => getSetting('start_motto'),
            'look' => $data['look'] ?? getSetting('start_male_look'),
            'credits' => getSetting('start_credits'),
            'home_room' => getSetting('start_room_id'),
            'referral_code' => \Str::random(15),
            'avatar_background' => isset($data['avatar_background']) ? $data['avatar_background'] : getSetting('default_avatar_background'),
        ]);
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_code', 'referral_code');
    }

    public function referredUsers(): HasMany
    {
        return $this->hasMany(User::class, 'referrer_code', 'referral_code');
    }

    public function getOnlineFriends(int $limit = 20)
    {
        return $this->friends()
            ->select('user_two_id', 'users.id', 'users.username', 'users.look', 'users.motto', 'users.last_online')
            ->join('users', 'users.id', '=', 'user_two_id')
            ->selectRaw('user_two_id')
            ->where('users.online', '1')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function recentlyCommentedOnArticle(int $minutes = 2): bool
    {
        return $this->articleComments()
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->exists();
    }

    public function isFemale(): bool
    {
        return $this->gender === 'F';
    }

    public function isMale(): bool
    {
        return $this->gender === 'M';
    }

    public function articleComments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'owner_id');
    }

    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(
            PermissionRole::class,
            Permission::class,
            'id',
            'permission_id',
            'rank',
            'id'
        );
    }

    public function activeBadges(): HasMany
    {
        return $this->badges()
            ->where('slot_id', '<>', 0)
            ->orderBy('slot_id');
    }

    public function badges(): HasMany
    {
        return $this->hasMany(UserBadge::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(UserOrder::class);
    }

    public function friends(): HasMany
    {
        return $this->hasMany(MessengerFriendship::class, 'user_one_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(UserItem::class);
    }

    public function ownerGuilds(): HasMany
    {
        return $this->hasMany(Guild::class);
    }

    public function guilds(): HasMany
    {
        return $this->hasMany(GuildMember::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasHighPermissions();
    }

    public function hasHighPermissions(): bool
    {
        return $this->rank >= getSetting('min_rank_to_housekeeping_login');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getAvatarBackground();
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'rank');
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Camera::class);
    }

    public function photoLikes(): HasMany
    {
        return $this->hasMany(CameraLike::class)->whereLiked(true);
    }

    public function photoViews(): HasMany
    {
        return $this->hasMany(CameraView::class);
    }

    public function getFilamentName(): string
    {
        return $this->username;
    }

    public function figurePath(): Attribute
    {
        return new Attribute(
            get: fn() => getSetting('figure_imager') . $this->look
        );
    }

    public function getAvatarBackground(): string
    {
        if(! empty($this->avatar_background)) {
            return $this->avatar_background;
        }

        return getSetting('default_avatar_background');
    }

    public function needsEnableTwoFactorAuthentication(): bool
    {
        return is_null($this->two_factor_secret);
    }

    public function hasIncompleteTwoFactorAuthentication(): bool
    {
        return $this->two_factor_secret && !$this->hasEnabledTwoFactorAuthentication();
    }
}
