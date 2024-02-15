<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Navigation;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\NavigationResource\Pages;
use App\Filament\Resources\Orion\NavigationResource\RelationManagers;

class NavigationResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Navigation::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/navigations';

    public static string $translateIdentifier = 'navigations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('label')
                            ->autofocus()
                            ->required()
                            ->maxLength(255)
                            ->label(__('filament::resources.inputs.name')),

                        TextInput::make('icon')
                            ->maxLength(255)
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
            ->defaultSort('id', 'desc')
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
