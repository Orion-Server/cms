<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Tables\Columns\HabboBadgeColumn;
use App\Filament\Traits\LatestRelationResourcesTrait;
use Filament\Resources\RelationManagers\RelationManager;

class BadgesRelationManager extends RelationManager
{
    use LatestRelationResourcesTrait;

    protected static string $relationship = 'badges';

    protected static ?string $recordTitleAttribute = 'badge_code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('badge_code')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),

                HabboBadgeColumn::make('badge'),

                IconColumn::make('slot_id')
                    ->label('Equipped')
                    ->options([
                        'heroicon-o-check-circle' => fn (string $state) => $state > 0 ,
                        'heroicon-o-x-circle' => fn (string $state) => $state <= 0,
                    ])
                    ->colors([
                        'success' => fn (string $state) => $state > 0 ,
                        'danger' => fn (string $state) => $state <= 0,
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
