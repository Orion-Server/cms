<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use App\Services\RconService;
use Filament\Resources\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Tables\Columns\HabboBadgeColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
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

                TextColumn::make('badge_code')
                    ->label('Code')
                    ->searchable(),

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
                CreateAction::make()
                    ->before(function(CreateAction $action, RelationManager $livewire): void {
                        $user = $livewire->ownerRecord;
                        $hasRconEnabled = config('hotel.rcon.enabled');

                        if(!$user->online) return;

                        if(!$hasRconEnabled) {
                            Notification::make()
                                ->danger()
                                ->title('RCON is not enabled!')
                                ->body("You can't send badges to online users if RCON is not enabled.")
                                ->persistent()
                                ->send();
                        } else {
                            $rcon = app(RconService::class);
                            $data = $action->getFormData();

                            $rcon->sendSafelyFromDashboard('sendBadge', [$user, $data['badge_code']], 'RCON: Failed to send the badge');
                        }

                        $action->cancel();
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
