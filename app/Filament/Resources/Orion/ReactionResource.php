<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use App\Models\Reaction;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Orion\ReactionResource\Pages;
use App\Filament\Resources\Orion\ReactionResource\RelationManagers;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;

class ReactionResource extends Resource
{
    protected static ?string $model = Reaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-badge-check';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $slug = 'administration/reactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReactions::route('/'),
        ];
    }
}
