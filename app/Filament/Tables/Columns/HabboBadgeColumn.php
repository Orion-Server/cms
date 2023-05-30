<?php

namespace App\Tables\Columns;

use Filament\Tables\Columns\Column;
use App\Models\Compositions\HasBadge;

class HabboBadgeColumn extends Column
{
    protected string $view = 'filament.tables.columns.habbo-badge-column';

    public function getBadgePath(): string
    {
        $record = $this->getRecord();

        if(!in_array(HasBadge::class, class_uses($record))) return '';

        return $record->getBadgePath();
    }

    public function getBadgeName(): string
    {
        $record = $this->getRecord();

        if(!in_array(HasBadge::class, class_uses($record))) return '';

        return $record->getBadgeName();
    }
}
