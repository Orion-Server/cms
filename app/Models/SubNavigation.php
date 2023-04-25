<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubNavigation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function navigation()
    {
        return $this->belongsTo(Navigation::class);
    }
}
