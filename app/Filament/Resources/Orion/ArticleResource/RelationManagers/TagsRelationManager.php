<?php

namespace App\Filament\Resources\Orion\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Filament\Resources\Orion\TagResource;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Traits\LatestRelationResourcesTrait;
use Filament\Resources\RelationManagers\RelationManager;

class TagsRelationManager extends RelationManager
{
    use LatestRelationResourcesTrait, TranslatableResource;

    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'name';

    public static string $translateIdentifier = 'tags';

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
            ->columns(TagResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->form(TagResource::getForm()),

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
