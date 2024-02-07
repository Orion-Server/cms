<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\User\UserOrder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(UserOrder::latest())
            ->paginated([3, 5, 8])
            ->columns(OrderResource::getTable())
            ->actions([
                Tables\Actions\ViewAction::make()->form(OrderResource::getForm()),
            ]);
    }
}
