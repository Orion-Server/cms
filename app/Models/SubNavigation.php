<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Factories\HasFactory
};

class SubNavigation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (SubNavigation $subNavigation) {
            if(!str_starts_with($subNavigation->slug, '/')) {
                $subNavigation->slug = "/{$subNavigation->slug}";
            }
        });

        static::updating(function (SubNavigation $subNavigation) {
            if(!str_starts_with($subNavigation->slug, '/')) {
                $subNavigation->slug = "/{$subNavigation->slug}";
            }
        });
    }

    public function navigation()
    {
        return $this->belongsTo(Navigation::class);
    }
}
