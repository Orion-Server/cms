<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use App\Models\CmsTag;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Forms\Components\ColorPicker;
use App\Filament\Resources\Orion\CmsTagResource\Pages;
use App\Filament\Resources\Orion\CmsTagResource\RelationManagers;

class CmsTagResource extends Resource
{
    protected static ?string $model = CmsTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $slug = 'administration/cms-tags';

    protected static ?string $label = 'Tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm());
    }

    public static function getForm(): array {
        return [
            Tabs::make('Main')
                ->tabs([
                    Tab::make('Home')
                        ->icon('heroicon-o-home')
                        ->schema([
                            TextInput::make('name')
                                ->placeholder('Tag name')
                                ->required()
                                ->autocomplete('name')
                                ->columnSpan('full'),

                            ColorPicker::make('background_color')
                                ->required()
                                ->placeholder('The background color of the tag')
                                ->columnSpan('full'),
                        ]),
                ])->columnSpanFull()
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTable())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTable(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID'),

            TextColumn::make('name')
                ->searchable()
                ->limit(50),

            ColorColumn::make('background_color')
                ->searchable()
                ->copyable()
                ->copyMessage('Color code copied')
                ->copyMessageDuration(1500)
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ArticlesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsTags::route('/'),
            'create' => Pages\CreateCmsTag::route('/create'),
            'view' => Pages\ViewCmsTag::route('/{record}'),
            'edit' => Pages\EditCmsTag::route('/{record}/edit'),
        ];
    }
}
