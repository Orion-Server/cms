<?php

namespace App\Filament\Resources\Orion\ArticleResource\RelationManagers;

use App\Filament\Resources\Orion\CmsTagResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'cmsTags';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Tags';

    protected static ?string $modelLabel = 'Tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(CmsTagResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->form(CmsTagResource::getForm()),

                Tables\Actions\AttachAction::make()->preloadRecordSelect()
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
