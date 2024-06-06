<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetaCode extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'valid_at' => 'datetime',
        'rescued_at' => 'datetime'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'beta_code', 'code');
    }
}
