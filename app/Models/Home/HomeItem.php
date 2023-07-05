<?php

namespace App\Models\Home;

use App\Enums\CurrencyType;
use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Factories\HasFactory
};

class HomeItem extends Model
{
    use HasFactory;

    protected $casts = [
        'currency_type' => CurrencyType::class
    ];

    public function homeCategory(): BelongsTo
    {
        return $this->belongsTo(HomeCategory::class);
    }
}