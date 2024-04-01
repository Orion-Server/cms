<?php

namespace App\Models\User;

use App\Models\User;
use App\Enums\NotificationType;
use App\Enums\NotificationState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => NotificationType::class,
        'state' => NotificationState::class,
        'read_at' => 'datetime'
    ];

    protected $appends = [
        'formatted_date'
    ];

    public function sender(): null|BelongsTo
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

    public function scopeStaff($query)
    {
        return $query->where('recipient_id', 0);
    }

    public function scopeWithSender($query)
    {
        $query->with([
            'sender:id,username,look,gender'
        ]);
    }

    public function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
