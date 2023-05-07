<?php

namespace App\Filament\Resources\User;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\User\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\User\UserResource\RelationManagers;
use Filament\Forms\Components\Toggle;

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
                                    ->disabled()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(25),

                                TextInput::make('motto')
                                    ->required()
                                    ->maxLength(127),

                                Select::make('gender')
                                    ->options([
                                        'M' => 'Male',
                                        'F' => 'Female'
                                    ])
                                    ->required(),

                                DateTimePicker::make('account_created')
                                    ->displayFormat('Y-m-d H:i:s')
                                    ->dehydrateStateUsing(fn (Model $record) => $record->account_created)
                                    ->disabled()
                                    ->label('Account created at'),

                                DateTimePicker::make('last_login')
                                    ->displayFormat('Y-m-d H:i:s')
                                    ->dehydrateStateUsing(fn (Model $record) => $record->last_login)
                                    ->disabled()
                                    ->label('Last login at'),

                                DateTimePicker::make('last_online')
                                    ->displayFormat('Y-m-d H:i:s')
                                    ->dehydrateStateUsing(fn (Model $record) => $record->last_online)
                                    ->disabled()
                                    ->label('Last online at'),

                                TextInput::make('ip_register')
                                    ->label('Registration IP')
                                    ->disabled(),

                                TextInput::make('ip_current')
                                    ->label('Current IP')
                                    ->disabled(),

                                TextInput::make('referral_code')
                                    ->disabled(),

                                TextInput::make('referrer_code')
                                    ->nullable()
                                    ->maxLength(15),
                            ])->columns(['sm' => 2]),

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
                                Section::make('Username')
                                    ->description('Allow this user to change their username (inside the client)')
                                    ->schema([
                                        Toggle::make('allow_change_username')
                                            ->label('Allow change username')
                                    ])->collapsible()->collapsed(),

                                Section::make('Email')
                                    ->schema([
                                        TextInput::make('mail')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                    ])->collapsible()->collapsed(),

                                Section::make('Password')
                                    ->description('Leave empty to keep the current password')
                                    ->schema([
                                        TextInput::make('password')
                                            ->label('New password')
                                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                            ->dehydrated(fn ($state) => filled($state))
                                            ->password()
                                            ->confirmed(),

                                        TextInput::make('password_confirmation')
                                            ->dehydrated(false)
                                            ->password(),
                                    ])->collapsible()
                                    ->columns(['sm' => 2])
                                    ->collapsed(),
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
