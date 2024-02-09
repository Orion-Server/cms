<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
