<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camera extends Model
{
    use HasFactory;

    protected $table = 'camera_web';

    public $timestamsp = false;

    public static function latestWith(int $limit = 6): Builder
    {
        return Camera::query()
            ->latest('id')
            ->limit($limit)
            ->with(['user:id,username,look']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
