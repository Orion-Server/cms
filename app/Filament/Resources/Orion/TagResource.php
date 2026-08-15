<?php

namespace App\Filament\Resources\Orion;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Orion\TagResource\RelationManagers\ArticlesRelationManager;
use App\Filament\Resources\Orion\TagResource\Pages\ListTags;
use App\Filament\Resources\Orion\TagResource\Pages\CreateTag;
use App\Filament\Resources\Orion\TagResource\Pages\ViewTag;
use App\Filament\Resources\Orion\TagResource\Pages\EditTag;
use App\Models\Tag;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Forms\Components\ColorPicker;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\TagResource\Pages;
use App\Filament\Resources\Orion\TagResource\RelationManagers;

class TagResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Tag::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static ?string $slug = 'website/tags';

    public static string $translateIdentifier = 'tags';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(static::getForm());
    }

    public static function getForm(): array {
        return [
            Tabs::make('Main')
                ->tabs([
                    Tab::make(__('filament::resources.tabs.Home'))
                        ->icon('heroicon-o-home')
                        ->schema([
                            TextInput::make('name')
                                ->label(__('filament::resources.inputs.name'))
                                ->required()
                                ->maxLength(255)
                                ->autocomplete()
                                ->columnSpan('full'),

                            ColorPicker::make('background_color')
                                ->label(__('filament::resources.inputs.background_color'))
                                ->required()
                                ->columnSpan('full'),
                        ]),
                ])->columnSpanFull()
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns(static::getTable())
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getTable(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('filament::resources.columns.id')),

            TextColumn::make('name')
                ->label(__('filament::resources.columns.name'))
                ->searchable()
                ->limit(50),

            ColorColumn::make('background_color')
                ->label(__('filament::resources.columns.background_color'))
                ->searchable()
                ->copyable()
                ->copyMessage(__('filament::resources.common.Sucessfull'))
                ->copyMessageDuration(1500)
        ];
    }

    public static function getRelations(): array
    {
        return [
            ArticlesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'view' => ViewTag::route('/{record}'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
