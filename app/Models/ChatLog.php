<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatLog extends Model
{
    use HasFactory;

    protected $table = 'chatlogs_room'; 

    protected $guarded = [];

    protected $fillable = [
        'room_id',
        'user_from_id',
        'user_to_id',
        'message',
        'timestamp'
    ];

    protected $primaryKey = 'timestamp'; 

    protected $casts = [
        'timestamp' => 'datetime'
    ];
	

    public function userFrom(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_from_id');
    }

    public function userTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_to_id'); 
    }
}
