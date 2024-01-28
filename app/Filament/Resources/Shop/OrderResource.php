<?php

namespace App\Filament\Resources\Shop;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\User\UserOrder;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Traits\TranslatableResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Shop\OrderResource\Pages;
use App\Filament\Resources\Shop\OrderResource\Widgets;
use App\Filament\Resources\Shop\OrderResource\RelationManagers;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class OrderResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = UserOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-alt';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $slug = 'shop/orders';

    public static string $translateIdentifier = 'shop-orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('order_id')
                            ->label(__('filament::resources.inputs.order_id'))
                            ->disabled(),

                        Select::make('status')
                            ->options([
                                'pending' => __('filament::resources.options.pending'),
                                'completed' => __('filament::resources.options.completed'),
                                'cancelled' => __('filament::resources.options.cancelled'),
                            ])
                            ->label(__('filament::resources.inputs.status')),

                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->columnSpanFull()
                            ->label(__('filament::resources.inputs.name'))
                            ->disabled(),

                        TextInput::make('price')
                            ->suffixIcon('heroicon-o-currency-dollar')
                            ->prefix(fn (Closure $get) => $get('currency'))
                            ->columnSpanFull()
                            ->label(__('filament::resources.inputs.price'))
                            ->disabled(),

                        TextInput::make('paypal_fee')
                            ->label(__('filament::resources.inputs.paypal_fee'))
                            ->columnSpanFull()
                            ->disabled(),

                        Textarea::make('details')
                            ->columnSpanFull()
                            ->label(__('filament::resources.inputs.details')),

                        Toggle::make('is_delivered')
                            ->label(__('filament::resources.inputs.is_delivered')),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources.columns.id')),

                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'cancelled'
                    ])
                    ->searchable()
                    ->label(__('filament::resources.columns.type'))
                    ->formatStateUsing(fn (string $state): string => __("filament::resources.options.{$state}")),

                TextColumn::make('order_id')
                    ->searchable()
                    ->label(__('filament::resources.columns.order_id')),

                TextColumn::make('user.username')
                    ->searchable()
                    ->label(__('filament::resources.columns.username')),

                TextColumn::make('product.name')
                    ->searchable()
                    ->label(__('filament::resources.columns.name')),

                ToggleColumn::make('is_delivered')
                    ->disabled()
                    ->label(__('filament::resources.columns.is_delivered')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrders::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\OrderOverviewWidget::class,
        ];
    }
}
