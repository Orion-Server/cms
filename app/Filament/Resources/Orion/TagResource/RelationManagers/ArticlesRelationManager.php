<?php

namespace App\Filament\Resources\Orion\TagResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\ArticleResource;
use App\Filament\Traits\LatestRelationResourcesTrait;
use Filament\Resources\RelationManagers\RelationManager;

class ArticlesRelationManager extends RelationManager
{
    use LatestRelationResourcesTrait, TranslatableResource;

    protected static string $relationship = 'articles';

    protected static ?string $recordTitleAttribute = 'title';

    public static string $translateIdentifier = 'article';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ArticleResource::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ArticleResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
