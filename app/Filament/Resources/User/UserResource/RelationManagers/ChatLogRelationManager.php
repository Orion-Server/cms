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
                    ->label(__('Room ID'))
					->toggleable(),

                TextColumn::make('sender.username')
                    ->label(__('From User'))
					->toggleable(),

                TextColumn::make('receiver.username')
                    ->label(__('To User'))
					->toggleable(),

                TextColumn::make('message')
                    ->label(__('Message'))
					->toggleable(),

                TextColumn::make('timestamp')
                    ->label(__('filament::resources.columns.executed_at'))
                    ->dateTime('Y-m-d H:i')
					->toggleable(),
            ]);
    }
}
