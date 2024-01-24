<?php

namespace App\Filament\Resources\Shop;

use Filament\Forms;
use Filament\Tables;
use App\Models\ShopCategory;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Traits\TranslatableResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Shop\ShopCategoryResource\Pages;
use App\Filament\Resources\Shop\ShopCategoryResource\RelationManagers;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class ShopCategoryResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = ShopCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-menu';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $slug = 'shop/categories';

    public static string $translateIdentifier = 'shop-categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament::resources.inputs.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('icon')
                            ->label(__('filament::resources.inputs.icon'))
                            ->required()
                            ->maxLength(255),

                        Toggle::make('is_visible')
                            ->default(true)
                            ->label(__('filament::resources.inputs.visible')),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->sortable()
                    ->label(__('filament::resources.columns.name'))
                    ->searchable(),

                ImageColumn::make('icon')
                    ->size('auto')
                    ->label(__('filament::resources.columns.icon')),

                ToggleColumn::make('is_visible')
                    ->label(__('filament::resources.columns.visible')),
            ])
            ->reorderable('order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShopCategories::route('/'),
            'create' => Pages\CreateShopCategory::route('/create'),
            'view' => Pages\ViewShopCategory::route('/{record}'),
            'edit' => Pages\EditShopCategory::route('/{record}/edit'),
        ];
    }
}
