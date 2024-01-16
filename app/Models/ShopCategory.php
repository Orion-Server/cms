<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(ShopProduct::class);
    }
}
