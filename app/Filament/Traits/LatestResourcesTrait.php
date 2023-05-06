<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;

trait LatestResourcesTrait
{
    protected function getTableQuery(): Builder
    {
        $primaryKey = 'id';

        if(method_exists(static::class, 'getPrimaryKey')) {
            $primaryKey = static::getPrimaryKey();
        }

        return static::getModel()::query()
            ->latest($primaryKey);
    }
}
