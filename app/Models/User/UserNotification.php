<?php

namespace App\Models\User;

use App\Enums\NotificationState;
use App\Enums\NotificationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => NotificationType::class,
        'state' => NotificationState::class
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('state', NotificationState::Unread);
    }
}
