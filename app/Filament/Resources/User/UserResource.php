<?php

namespace App\Filament\Resources\User;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\User\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\User\UserResource\RelationManagers;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $slug = 'user-management/users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Main')
                    ->tabs([
                        Tab::make('General Information')
                            ->schema([
                                TextInput::make('username')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(25),
                            ]),

                        Tab::make('Currencies')
                            ->schema([
                                TextInput::make('credits')
                                    ->numeric()
                                    ->minValue(0)
                                    ->columnSpanFull(),

                                TextInput::make('currency_0')
                                    ->label('Duckets')
                                    ->numeric()
                                    ->minValue(0)
                                    ->columnSpanFull(),

                                TextInput::make('currency_5')
                                    ->label('Diamonds')
                                    ->numeric()
                                    ->minValue(0)
                                    ->columnSpanFull(),

                                TextInput::make('currency_101')
                                    ->label('Points')
                                    ->numeric()
                                    ->minValue(0)
                                    ->columnSpanFull(),
                            ])
                            ->columns(['sm' => 2]),

                        Tab::make('Security')
                            ->schema([
                                TextInput::make('mail')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                            ])
                    ])->columnSpanFull()
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query();
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
