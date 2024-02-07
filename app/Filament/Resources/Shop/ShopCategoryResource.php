<?php

namespace App\Filament\Resources\Shop;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ShopCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Shop\ShopCategoryResource\Pages;

class ShopCategoryResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = ShopCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $slug = 'shop/categories';

    public static string $translateIdentifier = 'shop-categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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
            ->defaultSort('id', 'desc')
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
