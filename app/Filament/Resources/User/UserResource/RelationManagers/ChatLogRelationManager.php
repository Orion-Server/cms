<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\Hotel\ChatlogRoomResource;
use Filament\Resources\RelationManagers\RelationManager;

class ChatLogRelationManager extends RelationManager
{
    protected static string $relationship = 'chatLogs';

    protected static $targetResource = ChatlogRoomResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema;
    }

    public function table(Table $table): Table
    {
        return $table->columns(ChatlogRoomResource::getTable())
            ->defaultSort('timestamp', 'desc');
    }
}
