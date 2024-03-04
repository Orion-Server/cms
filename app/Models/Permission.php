<?php

namespace App\Models;

use App\Models\Compositions\HasBadge;
use Illuminate\Database\Eloquent\{
    Collection,
    Model,
    Factories\HasFactory,
    Relations\HasMany
};

class Permission extends Model implements HasBadge
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($permission) {
            if(blank($permission->prefix)) $permission->prefix = '';
            if(blank($permission->prefix_color)) $permission->prefix_color = '';
        });

        static::updating(function ($permission) {
            if(blank($permission->prefix)) $permission->prefix = '';
            if(blank($permission->prefix_color)) $permission->prefix_color = '';
        });
    }

    public static function forIndex(): Collection
    {
        return Permission::query()
            ->select('id', 'rank_name as name', 'badge', 'description')
            ->where('id', '>=', getSetting('min_list_rank'))
            ->where('is_hidden', false)
            ->with([
                'users:id,username,look,rank,online',
                'users.activeBadges'
            ])->orderByDesc('id')
            ->get();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rank');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(PermissionRole::class);
    }

    public function getBadgePath(): string
    {
        return getSetting('badges_path') . $this->badge . '.gif';
    }

    public function getBadgeName(): string
    {
        return $this->badge;
    }
}
