<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WriteableBox extends Model
{
    use HasFactory;

    protected $table = 'cms_writeable_boxes';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    public static function getForPage(string $page): Collection
    {
        return self::active()->wherePageTarget($page)->get();
    }
}
