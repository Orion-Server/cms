<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camera extends Model
{
    use HasFactory;

    protected $table = 'camera_web';

    public $timestamps = false;

    public static function latestWith(bool $includesRoom = false): Builder
    {
        $query = Camera::query()->latest('id');

        $includes = [
            'user:id,look,username',
            'likes' => fn ($query) => $query->whereLiked(true)
        ];

        if ($includesRoom) {
            array_push($includes, 'room:id,name');
        }

        return $query->with($includes);
    }

    public function scopeFilter($query, $filter)
    {
        $user = \Auth::user();

        if($filter == 'only_my_friends') {
            $friendsId = $user->friends()->pluck('id')->toArray();
        }

        if($filter == 'liked_by_me') {
            $likedPhotoIds = $user->photoLikes()->pluck('camera_id')->toArray();
        }

        $query = match ($filter) {
            'only_my_friends' => $query->whereIn('user_id', $friendsId),
            'liked_by_me' => $query->whereIn('id', $likedPhotoIds),
            default => $query
        };

        return $query;
    }

    public function scopePeriod($query, $period)
    {
        $query = match ($period) {
            'today' => $query->where('timestamp', '>=', Carbon::today()->timestamp),
            'last_week' => $query->whereBetween('timestamp', [now()->subWeek()->timestamp, now()->timestamp]),
            'last_month' => $query->whereBetween('timestamp', [now()->subMonth()->timestamp, now()->timestamp]),
            default => $query
        };

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CameraLike::class);
    }

    public function formattedDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->timestamp)->format('Y-m-d H:i')
        );
    }
}
