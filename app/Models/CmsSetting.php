<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Factories\HasFactory
};

class CmsSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
}
