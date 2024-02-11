<?php

namespace App\Filament\Resources\Shop\ShopOrderResource\Widgets;

use App\Models\User\UserOrder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {
        return [
            Stat::make(__('filament::resources.widgets.canceled_orders'), UserOrder::where('status', 'canceled')->count())
                ->description(__('filament::resources.widgets.were_canceled'))
                ->descriptionIcon('heroicon-s-arrow-trending-down')
                ->color('danger'),

            Stat::make(__('filament::resources.widgets.pending_orders'), UserOrder::where('status', 'pending')->count())
                ->description(__('filament::resources.widgets.are_pending_payment'))
                ->descriptionIcon('heroicon-s-minus')
                ->color('warning'),

            Stat::make(__('filament::resources.widgets.completed_orders'), UserOrder::where('status', 'completed')->count())
                ->description(__('filament::resources.widgets.were_completed'))
                ->descriptionIcon('heroicon-s-arrow-trending-up')
                ->color('success'),
        ];
    }
}
