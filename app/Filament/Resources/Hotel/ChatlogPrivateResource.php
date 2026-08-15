<?php

namespace App\Filament\Resources\Hotel;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use App\Filament\Resources\Hotel\ChatlogPrivateResource\Pages\ManageChatlogPrivates;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ChatlogPrivate;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Hotel\ChatlogPrivateResource\Pages;

class ChatlogPrivateResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = ChatlogPrivate::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string | \UnitEnum | null $navigationGroup = 'Logs';

    public static string $translateIdentifier = 'chatlog-private';

    protected static ?string $slug = 'hotel/chatlog-private';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sender.username')
                    ->disabled()
                    ->label(__('filament::resources.inputs.sender')),

                TextInput::make('receiver.username')
                    ->disabled()
                    ->label(__('filament::resources.inputs.receiver')),

                Textarea::make('message')
                    ->label(__('filament::resources.inputs.message'))
                    ->columnSpanFull()
                    ->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('timestamp', 'desc')
            ->columns(self::getTable())
            ->filters([])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getTable(): array
    {
        return [
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
            'index' => ManageChatlogPrivates::route('/'),
        ];
    }
}
