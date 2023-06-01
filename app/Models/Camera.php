<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camera extends Model
{
    use HasFactory;

    protected $table = 'camera_web';

    public $timestamsp = false;

    public static function latestWith(int $limit = 6, bool $includesRoom = false): Builder
    {
        $query = Camera::query()
            ->latest('id')
            ->limit($limit);

        $includes = ['user:id,look,username'];

        if($includesRoom) {
            array_push($includes, 'room:id,name');
        }

        return $query->with($includes);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function formattedDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->timestamp)->format('Y-m-d H:i')
        );
    }
}
