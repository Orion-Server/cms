<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class SettingsRelationManager extends RelationManager
{
    protected static string $relationship = 'settings';

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->schema([
                        Tabs\Tab::make('Account Data')
                            ->schema([
                                TextInput::make('achievement_score')
                                    ->disabled()
                                    ->required(),

                                TextInput::make('respects_received')
                                    ->disabled()
                                    ->required(),

                                Select::make('can_trade')
                                    ->disablePlaceholderSelection()
                                    ->placeholder('User can trade?')
                                    ->options([
                                        '0' => 'No',
                                        '1' => 'Yes',
                                    ])
                                    ->required(),

                                Select::make('block_following')
                                    ->disablePlaceholderSelection()
                                    ->placeholder('Block friends of the following user')
                                    ->options([
                                        '0' => 'No',
                                        '1' => 'Yes',
                                    ])
                                    ->required(),

                                Select::make('block_friendrequests')
                                    ->disablePlaceholderSelection()
                                    ->placeholder('Block user friend requests')
                                    ->options([
                                        '0' => 'No',
                                        '1' => 'Yes',
                                    ])
                                    ->required(),

                                Select::make('block_roominvites')
                                    ->disablePlaceholderSelection()
                                    ->placeholder('Block user room invites')
                                    ->options([
                                        '0' => 'No',
                                        '1' => 'Yes',
                                    ])
                                    ->required(),

                                TextInput::make('max_rooms')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('max_friends')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(['sm' => 2]),

                            Tabs\Tab::make('Extra Settings')
                                ->schema([
                                    Select::make('old_chat')
                                        ->disablePlaceholderSelection()
                                        ->placeholder('Using old chat')
                                        ->options([
                                            '0' => 'No',
                                            '1' => 'Yes',
                                        ])
                                        ->required(),

                                    Select::make('block_camera_follow')
                                        ->disablePlaceholderSelection()
                                        ->placeholder('Block camera following user')
                                        ->options([
                                            '0' => 'No',
                                            '1' => 'Yes',
                                        ])
                                        ->required(),

                                    Select::make('ignore_bots')
                                        ->disablePlaceholderSelection()
                                        ->placeholder('Ignore bots')
                                        ->options([
                                            '0' => 'No',
                                            '1' => 'Yes',
                                        ])
                                        ->required(),

                                    Select::make('ignore_pets')
                                        ->disablePlaceholderSelection()
                                        ->placeholder('Ignore pets')
                                        ->options([
                                            '0' => 'No',
                                            '1' => 'Yes',
                                        ])
                                        ->required(),
                                ])->columns(['sm' => 2]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('achievement_score')
                    ->toggleable(),

                TextColumn::make('respects_received')
                    ->toggleable(),

                TextColumn::make('online_time')
                    ->formatStateUsing(fn (string $state) => __(':m minutes', ['m' => round(\CarbonInterval::seconds($state)->totalMinutes)]))
                    ->toggleable(),

                IconColumn::make('can_trade')
                    ->options([
                        'heroicon-o-check-circle' => '1',
                        'heroicon-o-x-circle' => '0',
                    ])
                    ->colors([
                        'success' => '1',
                        'danger' => '0',
                    ]),

                IconColumn::make('can_change_name')
                    ->options([
                        'heroicon-o-check-circle' => '1',
                        'heroicon-o-x-circle' => '0',
                    ])
                    ->colors([
                        'success' => '1',
                        'danger' => '0',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
