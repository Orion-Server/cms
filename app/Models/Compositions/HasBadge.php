<?php

namespace App\Models\Compositions;

trait HasBadge
{
    public function getBadgePath(): string
    {
        return '';
    }

    public function getBadgeName(): string
    {
        return '';
    }
}
