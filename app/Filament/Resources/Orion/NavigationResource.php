<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use App\Models\Navigation;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\NavigationResource\Pages;
use App\Filament\Resources\Orion\NavigationResource\RelationManagers;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class NavigationResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Navigation::class;

    protected static ?string $navigationIcon = 'heroicon-o-menu-alt-2';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/navigations';

    public static string $translateIdentifier = 'navigations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('label')
                            ->autofocus()
                            ->required()
                            ->label(__('filament::resources.inputs.name')),

                        TextInput::make('icon')
                            ->label(__('filament::resources.inputs.image')),

                        TextInput::make('slug')
                            ->label(__('filament::resources.inputs.slug')),

                        TextInput::make('order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->label(__('filament::resources.inputs.order')),

                        Toggle::make('visible')
                            ->label(__('filament::resources.inputs.visible'))
                            ->default(false)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources.columns.id')),

                ImageColumn::make('icon')
                    ->extraAttributes(['style' => 'image-rendering: pixelated'])
                    ->size('auto')
                    ->label(__('filament::resources.columns.image')),

                TextColumn::make('label')
                    ->label(__('filament::resources.columns.name')),

                TextColumn::make('slug')
                    ->label(__('filament::resources.columns.slug')),

                ToggleColumn::make('visible')
                    ->label(__('filament::resources.columns.visible'))
                    ->onIcon('heroicon-s-check')
                    ->toggleable()
                    ->disabled(),
            ])
            ->reorderable('order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SubNavigationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigation::route('/create'),
            'edit' => Pages\EditNavigation::route('/{record}/edit'),
        ];
    }
}
