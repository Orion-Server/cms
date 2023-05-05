<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        $cacheableTime = App::isLocal() ? 0 : 300;

        return \Cache::remember('navigations', $cacheableTime, function() use ($withSubNavigations) {
            $navigation = Navigation::defaultQuery();

            if($withSubNavigations) {
                $navigation->with(['subNavigations' => fn ($query) => $query->whereVisible(true)->orderBy('order')]);
            }

            return $navigation->get();
        });
    }
}
