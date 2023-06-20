<?php

namespace App\Filament\Resources\Orion\HelpQuestionResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Traits\LatestRelationResourcesTrait;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource;

class CategoriesRelationManager extends RelationManager
{
    use LatestRelationResourcesTrait, TranslatableResource;

    protected static string $relationship = 'categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static string $translateIdentifier = 'help-questions-categories';

    public static function form(Form $form): Form
    {
        return $form->schema(HelpQuestionCategoryResource::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table->columns(HelpQuestionCategoryResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
