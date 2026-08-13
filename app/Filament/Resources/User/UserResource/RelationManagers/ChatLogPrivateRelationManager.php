<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\Hotel\ChatlogPrivateResource;
use Filament\Resources\RelationManagers\RelationManager;

class ChatLogPrivateRelationManager extends RelationManager
{
    protected static string $relationship = 'chatLogsPrivate';

    protected static $targetResource = ChatlogPrivateResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema;
    }

    public function table(Table $table): Table
    {
        return $table->columns(ChatlogPrivateResource::getTable())
            ->defaultSort('timestamp', 'desc');
    }
}
