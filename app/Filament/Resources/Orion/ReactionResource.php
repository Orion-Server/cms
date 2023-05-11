<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use App\Models\Reaction;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\ColorPicker;
use App\Filament\Resources\Orion\ReactionResource\Pages;
use App\Filament\Resources\Orion\ReactionResource\RelationManagers;
use Filament\Tables\Columns\ColorColumn;

class ReactionResource extends Resource
{
    protected static ?string $model = Reaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-badge-check';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $slug = 'administration/reactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ReactionResource::getForm());
    }

    public static function getForm(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(30),

                    TextInput::make('icon')
                        ->label('Icon URL')
                        ->maxLength(100)
                        ->helperText('Recommended size 20x20 or smaller')
                        ->required(),

                    ColorPicker::make('color')
                        ->label('Background Color')
                        ->required()
                        ->hex()
                ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ReactionResource::getTable())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

            ImageColumn::make('completeIconPath')
                ->label('Icon')
                ->size(20)
                ->toggleable()
                ->extraAttributes(['style' => 'image-rendering: pixelated']),

            TextColumn::make('name')
                ->searchable(),

            ColorColumn::make('color')
                ->toggleable(),

            TextColumn::make('articles_count')
                ->label('Used in Articles')
                ->counts('articles')
                ->toggleable()
                ->searchable(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReactions::route('/'),
        ];
    }
}
