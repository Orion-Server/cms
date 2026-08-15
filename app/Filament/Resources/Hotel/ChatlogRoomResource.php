<?php

namespace App\Filament\Resources\Hotel;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use App\Filament\Resources\Hotel\ChatlogRoomResource\Pages\ManageChatlogRooms;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ChatlogRoom;
use Filament\Resources\Resource;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Hotel\ChatlogRoomResource\Pages;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class ChatlogRoomResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = ChatlogRoom::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string | \UnitEnum | null $navigationGroup = 'Logs';

    public static string $translateIdentifier = 'chatlog-rooms';

    protected static ?string $slug = 'hotel/chatlog-room';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('room.name')
                    ->label(__('filament::resources.inputs.room'))
                    ->columnSpanFull()
                    ->disabled(),

                    TextInput::make('sender.username')
                    ->label(__('filament::resources.inputs.sender'))
                    ->disabled(),

                    TextInput::make('receiver.username')
                    ->label(__('filament::resources.inputs.receiver'))
                    ->disabled(),

                    Textarea::make('message')
                    ->label(__('filament::resources.inputs.message'))
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('timestamp', 'desc')
        ->columns(self::getTable())
        ->filters([
            //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getTable(): array
    {
        return [
            TextColumn::make('room.name')
                ->label(__('filament::resources.columns.room'))
                ->toggleable()
                ->searchable(isIndividual: true),

            TextColumn::make('sender.username')
                ->label(__('filament::resources.columns.sender'))
                ->toggleable()
                ->searchable(isIndividual: true),

            TextColumn::make('receiver.username')
                ->label(__('filament::resources.columns.receiver'))
                ->toggleable()
                ->searchable(isIndividual: true),

            TextColumn::make('message')
                ->label(__('filament::resources.columns.message'))
                ->limit(40)
                ->searchable(isIndividual: true),

            TextColumn::make('timestamp')
                ->label(__('filament::resources.columns.executed_at'))
                ->dateTime('Y-m-d H:i')
                ->toggleable(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageChatlogRooms::route('/'),
        ];
    }
}
