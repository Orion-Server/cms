<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CameraView extends Model
{
    use HasFactory;

    protected $table = 'camera_web_views';

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Camera::class, 'camera_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
