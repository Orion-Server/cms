<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Collection,
    Model,
    Factories\HasFactory,
    Relations\HasMany
};
use Illuminate\Database\Eloquent\Casts\Attribute;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    public static function forIndex(): Collection
    {
        return Permission::query()
            ->select('id', 'rank_name as name', 'badge', 'description')
            ->where('id', '>=', getSetting('min_list_rank'))
            ->where('is_hidden', false)
            ->with([
                'users:id,username,look,rank,online',
                'users.activeBadges'
            ])->orderByDesc('level')
            ->get();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rank');
    }

    public function badgePath(): Attribute
    {
        return new Attribute(
            get: fn () => getSetting('badges_path') . $this->badge . '.gif'
        );
    }
}
