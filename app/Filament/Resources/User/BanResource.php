<?php

namespace App\Filament\Resources\User;

use App\Models\Ban;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Traits\TranslatableResource;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Tables\Columns\UserAvatarColumn;
use App\Filament\Resources\User\BanResource\Pages;

class BanResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Ban::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $slug = 'user-management/bans';

    protected static ?int $navigationSort = 1;

    public static string $translateIdentifier = 'bans';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('ban_reason')
                    ->label('Reason')
                    ->columnSpanFull(),

                Select::make('type')
                    ->label('Ban Type')
                    ->columnSpanFull()
                    ->options([
                        'account' => 'Account',
                        'ip' => 'IP',
                        'machine' => 'MachineBan',
                        'super' => 'SuperBan'
                    ]),

                DateTimePicker::make('ban_expire')
                    ->label('Expires at')
                    ->displayFormat('Y-m-d H:i')
                    ->format('U')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                UserAvatarColumn::make('avatar')
                    ->toggleable()
                    ->pointer('user.look')
                    ->label('User')
                    ->options('&size=m&head_direction=3&gesture=sml&headonly=1'),

                TextColumn::make('user.username')
                    ->label('Username')
                    ->searchable(),

                TextColumn::make('staff.username')
                    ->label('Staff')
                    ->searchable(),

                TextColumn::make('ban_reason')
                    ->label('Reason')
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getLimit()) return null;

                        return $state;
                    })
                    ->limit(15)
                    ->searchable(),

                BadgeColumn::make('type')
                    ->label('Ban Type')
                    ->enum([
                        'account' => 'Account',
                        'ip' => 'IP',
                        'machine' => 'MachineBan',
                        'super' => 'SuperBan'
                    ])
                    ->colors([
                        'primary' => 'account',
                        'success' => 'ip',
                        'primary' => 'machine',
                        'danger' => 'super',
                    ]),

                TextColumn::make('timestamp')
                    ->label('Banned at')
                    ->date('Y-m-d H:i'),

                TextColumn::make('ban_expire')
                    ->label('Expires at')
                    ->formatStateUsing(fn (string $state): string => $state == 0 ? 'Never' : date('Y-m-d H:i', $state)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit or View'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBans::route('/'),
        ];
    }
}
