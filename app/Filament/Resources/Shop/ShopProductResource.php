<?php

namespace App\Filament\Resources\Shop;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Shop\ShopProductResource\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\Shop\ShopProductResource\Pages\ListShopProducts;
use App\Filament\Resources\Shop\ShopProductResource\Pages\CreateShopProduct;
use App\Filament\Resources\Shop\ShopProductResource\Pages\ViewShopProduct;
use App\Filament\Resources\Shop\ShopProductResource\Pages\EditShopProduct;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ShopProduct;
use Filament\Resources\Resource;
use App\Forms\Components\CKEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Shop\ShopProductResource\Pages;
use App\Filament\Resources\Shop\ShopProductResource\RelationManagers;

class ShopProductResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = ShopProduct::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string | \UnitEnum | null $navigationGroup = 'Shop';

    protected static ?string $slug = 'shop/products';

    public static string $translateIdentifier = 'shop-products';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Main')
                    ->tabs([
                        Tab::make(__('filament::resources.tabs.Home'))
                            ->icon('heroicon-o-home')
                            ->schema([
                                Select::make('category_id')
                                    ->native(false)
                                    ->label(__('filament::resources.inputs.category'))
                                    ->relationship('category', 'name'),

                                TextInput::make('name')
                                    ->label(__('filament::resources.inputs.name'))
                                    ->required(),

                                TextInput::make('description')
                                    ->label(__('filament::resources.inputs.description'))
                                    ->nullable()
                                    ->columnSpan('full'),

                                CKEditor::make('content')
                                    ->label(__('filament::resources.inputs.content'))
                                    ->nullable()
                                    ->columnSpan('full'),

                                TextInput::make('image')
                                    ->label(__('filament::resources.inputs.image'))
                                    ->required(),

                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefixIcon('heroicon-s-currency-dollar')
                                    ->label(__('filament::resources.inputs.price')),
                            ]),

                        Tab::make(__('filament::resources.tabs.Configurations'))
                            ->icon('heroicon-o-cog')
                            ->schema([
                                TextInput::make('limit_per_user')
                                    ->numeric()
                                    ->label(__('filament::resources.inputs.limit_per_user'))
                                    ->helperText(__('filament::resources.helpers.limit_per_user_helper')),

                                Toggle::make('is_active')
                                    ->onIcon('heroicon-s-check')
                                    ->label(__('filament::resources.inputs.visible'))
                                    ->default(false)
                                    ->offIcon('heroicon-s-x-mark'),

                                Toggle::make('is_featured')
                                    ->onIcon('heroicon-s-check')
                                    ->label(__('filament::resources.inputs.is_featured'))
                                    ->default(false)
                                    ->offIcon('heroicon-s-x-mark'),
                            ]),

                        Tab::make(__('filament::resources.tabs.Metrics'))
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                TextInput::make('sales_count')
                                    ->numeric()
                                    ->disabled()
                                    ->default(0)
                                    ->helperText(__('filament::resources.helpers.sales_count_helper'))
                                    ->label(__('filament::resources.inputs.sales_count')),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->label(__('filament::resources.columns.id')),

                ImageColumn::make('image')
                    ->circular()
                    ->size(60)
                    ->label(__('filament::resources.columns.image')),

                TextColumn::make('name')
                    ->searchable()
                    ->label(__('filament::resources.columns.name')),

                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament::resources.columns.category')),

                TextColumn::make('price')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament::resources.columns.price')),

                ToggleColumn::make('is_active')
                    ->label(__('filament::resources.columns.visible')),

                ToggleColumn::make('is_featured')
                    ->label(__('filament::resources.columns.is_featured')),

                TextColumn::make('sales_count')
                    ->searchable()
                    ->sortable()
                    ->label(__('filament::resources.columns.sales_count')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShopProducts::route('/'),
            'create' => CreateShopProduct::route('/create'),
            'view' => ViewShopProduct::route('/{record}'),
            'edit' => EditShopProduct::route('/{record}/edit'),
        ];
    }
}
