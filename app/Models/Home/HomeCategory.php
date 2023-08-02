<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\HasMany
};

class HomeCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function homeItems(): HasMany
    {
        return $this->hasMany(HomeItem::class);
    }
}
