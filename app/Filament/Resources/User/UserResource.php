<?php

namespace App\Filament\Resources\User;

use App\Models\User;
use Filament\Tables;
use App\Models\Permission;
use App\Enums\CurrencyType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Traits\TranslatableResource;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Tables\Columns\UserAvatarColumn;
use App\Filament\Resources\User\UserResource\Pages;
use App\Filament\Resources\User\UserResource\RelationManagers;

class UserResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $slug = 'user-management/users';

    public static string $translateIdentifier = 'users';

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

                                Section::make('Rank & Permissions')
                                    ->schema([
                                        Select::make('rank')
                                            ->options(Permission::all()->pluck('rank_name', 'id'))
                                    ])->collapsible()
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
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),

                UserAvatarColumn::make('avatar')
                    ->toggleable()
                    ->label('Avatar')
                    ->options('&size=m&head_direction=3&gesture=sml&headonly=1'),

                TextColumn::make('username')
                    ->searchable(),

                TextColumn::make('mail')
                    ->label('Email')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('motto')
                    ->toggleable()
                    ->limit(30)
                    ->searchable(),

                IconColumn::make('online')
                    ->label('Online')
                    ->options([
                        'heroicon-o-x-circle' => fn ($state, $record): bool => ! $record->online,
                        'heroicon-o-check-circle' => fn ($state, $record): bool => !! $record->online,
                    ])
                    ->colors([
                        'danger' => false,
                        'success' => true,
                    ]),

                TextColumn::make('account_created')
                    ->toggleable()
                    ->date('Y-m-d H:i')
                    ->label('Account created')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SettingsRelationManager::class,
            RelationManagers\BadgesRelationManager::class,
        ];
    }

    public static function fillWithOutsideData(Model $record, array $formData): array
    {
        $formData['currency_0'] = $record->currency(CurrencyType::Duckets);
        $formData['currency_5'] = $record->currency(CurrencyType::Diamonds);
        $formData['currency_101'] = $record->currency(CurrencyType::Points);

        if($record->settings) {
            $formData['allow_change_username'] = $record->settings->can_change_name;
        }

        return $formData;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
