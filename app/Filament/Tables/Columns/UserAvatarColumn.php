<?php

namespace App\Tables\Columns;

use App\Models\User;
use Filament\Tables\Columns\Column;

class UserAvatarColumn extends Column
{
    protected ?string $avatarOptions = null;

    protected string $view = 'filament.tables.columns.user-avatar';

    public function getAvatarUrl(): string
    {
        $record = $this->getRecord();
        $figureImagerUrl = getSetting('figure_imager');

        if(!$figureImagerUrl) return '';

        if($this->recordInstanceOf(User::class)) {
            $figure = $record->look;
        }

        return "{$figureImagerUrl}{$figure}{$this->avatarOptions}";
    }

    private function recordInstanceOf(string $class): bool
    {
        return $this->getRecord() instanceof $class;
    }

    public function options(string $avatarOptions): UserAvatarColumn
    {
        $this->avatarOptions = $avatarOptions;

        return $this;
    }
}
