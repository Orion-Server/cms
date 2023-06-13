<?php

namespace App\Models;

use App\Models\Compositions\HasBadge;
use Illuminate\Database\Eloquent\{
    Model,
    Factories\HasFactory
};

class Achievement extends Model implements HasBadge
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function getBadgePath(): string
    {
        return sprintf('%sACH_%s.gif', getSetting('badges_path'), $this->getBadgeName());
    }

    public function getBadgeName(): string
    {
        return sprintf('%s%s', $this->name, (string) $this->level);
    }
}
