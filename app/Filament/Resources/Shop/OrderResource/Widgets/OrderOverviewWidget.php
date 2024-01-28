<?php

namespace App\Filament\Resources\Shop\OrderResource\Widgets;

use App\Models\User\UserOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class OrderOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {
        return [
            Card::make(__('filament::resources.widgets.canceled_orders'), UserOrder::where('status', 'canceled')->count())
                ->description(__('filament::resources.widgets.were_canceled'))
                ->descriptionIcon('heroicon-s-trending-down')
                ->color('danger'),

            Card::make(__('filament::resources.widgets.pending_orders'), UserOrder::where('status', 'pending')->count())
                ->description(__('filament::resources.widgets.are_pending_payment'))
                ->descriptionIcon('heroicon-s-minus-sm')
                ->color('warning'),

            Card::make(__('filament::resources.widgets.completed_orders'), UserOrder::where('status', 'completed')->count())
                ->description(__('filament::resources.widgets.were_completed'))
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
