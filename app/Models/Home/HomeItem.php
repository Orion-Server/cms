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
        'currency_type' => CurrencyType::class,
        'enabled' => 'boolean'
    ];

    public function homeCategory(): BelongsTo
    {
        return $this->belongsTo(HomeCategory::class);
    }

    public function exceededPurchaseLimit(): bool
    {
        return $this->total_bought >= $this->limit;
    }

    public function getDefaultTheme(): ?string
    {
        if($this->type == 'n') {
            return 'note';
        }

        if($this->type == 'w') {
            return 'widget';
        }

        return null;
    }
}
