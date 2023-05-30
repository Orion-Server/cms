<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;

trait LatestRelationResourcesTrait
{
    protected function getTableQuery(): Builder
    {
        $primaryKey = 'id';

        if(method_exists(static::class, 'getPrimaryKey')) {
            $primaryKey = static::getPrimaryKey();
        }

        return parent::getTableQuery()->latest($primaryKey);
    }
}
