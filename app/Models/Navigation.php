<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Navigation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public static function defaultQuery()
    {
        return Navigation::whereVisible(true)
            ->orderBy('order')
            ->orderByDesc('id');
    }

    public function subNavigations()
    {
        return $this->hasMany(SubNavigation::class);
    }

    public static function getNavigations(bool $withSubNavigations = true)
    {
        $cacheableTime = App::isLocal() ? 0 : 300;

        return \Cache::remember('navigations', $cacheableTime, function() use ($withSubNavigations) {
            $navigation = Navigation::defaultQuery();

            if($withSubNavigations) {
                $navigation->with(['subNavigations' => fn ($query) => $query->whereVisible(true)]);
            }

            return $navigation->get();
        });
    }
}
