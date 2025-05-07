<?php

namespace App\Filament\Resources\Orion\ArticleResource\RelationManagers;

use App\Models\Article\ArticleComment;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('content')
                    ->label(__('filament::resources.inputs.content'))
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'border rounded-lg p-2'])
                    ->content(fn (ArticleComment $record): HtmlString => new HtmlString(renderBBCodeText($record->content, true))),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->toggleable(),

                TextColumn::make('user.username')
                    ->searchable()
                    ->label(__('filament::resources.columns.by')),

                ToggleColumn::make('visible')
                    ->label(__('filament::resources.columns.visible')),

                ToggleColumn::make('fixed')
                    ->label(__('filament::resources.columns.fixed')),

                ToggleColumn::make('innapropriate')
                    ->label(__('filament::resources.columns.innapropriate')),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
