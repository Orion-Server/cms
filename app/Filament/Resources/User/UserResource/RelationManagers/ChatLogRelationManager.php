<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;


class ChatLogRelationManager extends RelationManager
{
    protected static string $relationship = 'chatLogs';

    protected static $targetResource = ChatlogRoomResource::class;

    public function form(Form $form): Form
    {
        return $form;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room_id')
                    ->label(__('filament::resources.columns.room'))
					->toggleable(),
                      
                TextColumn::make('sender.username')
                    ->label(__('filament::resources.columns.sender'))
					->toggleable(),

                TextColumn::make('receiver.username')
                    ->label(__('filament::resources.inputs.receiver'))
					->toggleable(),

                TextColumn::make('message')
                    ->label(__('filament::resources.inputs.message'))
					->toggleable(),

                TextColumn::make('timestamp')
                    ->label(__('filament::resources.columns.executed_at'))
                    ->dateTime('Y-m-d H:i')
					->toggleable(),
            ]);
    }
}
