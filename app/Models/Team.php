<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Relations\HasMany,
    Factories\HasFactory,
    Collection
};

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public static function forIndex(): Collection
    {
        return Team::query()
            ->select('id', 'name', 'badge', 'description')
            ->where('is_hidden', false)
            ->with([
                'users:id,username,look,rank,online,team_id',
                'users.activeBadges'
            ])->orderBy('order')
            ->get();
    }

    public function getBadgePath(): string
    {
        return getSetting('badges_path') . $this->badge . '.gif';
    }
}
