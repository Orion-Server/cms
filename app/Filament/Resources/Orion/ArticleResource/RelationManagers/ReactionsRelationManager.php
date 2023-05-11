<?php

namespace App\Filament\Resources\Orion\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Orion\ReactionResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ReactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'reactions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ReactionResource::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ReactionResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\AttachAction::make()->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
