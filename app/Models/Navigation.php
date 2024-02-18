<?php

namespace App\Models;

use App\Services\CacheTimeService;
use Illuminate\Support\{
    Collection
};
use Illuminate\Database\Eloquent\{
    Model,
    Builder,
    Relations\HasMany,
    Factories\HasFactory
};

class Navigation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public static function defaultQuery(): Builder
    {
        return Navigation::whereVisible(true)
            ->orderBy('order')
            ->orderByDesc('id');
    }

    public function subNavigations(): HasMany
    {
        return $this->hasMany(SubNavigation::class);
    }

    public static function getNavigations(bool $withSubNavigations = true): Collection
    {
        return \Cache::remember('navigations', CacheTimeService::getForNavigations(), function() use ($withSubNavigations) {
            $navigation = Navigation::defaultQuery();

            if($withSubNavigations) {
                $navigation->with(['subNavigations' => fn ($query) => $query->whereVisible(true)->orderBy('order')]);
            }

            return $navigation->get();
        });
    }
}
