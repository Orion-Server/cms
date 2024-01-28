<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Traits\LatestResourcesTrait;
use App\Filament\Resources\Shop\OrderResource;

class ManageOrders extends ManageRecords
{
    use LatestResourcesTrait;
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderResource\Widgets\OrderOverviewWidget::class,
        ];
    }
}
