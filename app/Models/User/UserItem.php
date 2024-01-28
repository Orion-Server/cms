<?php

namespace App\Models\User;

use App\Models\User;
use App\Models\ItemDefinition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserItem extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $guarded = [];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function itemDefinition(): BelongsTo
    {
        return $this->belongsTo(ItemDefinition::class, 'item_id');
    }
}
