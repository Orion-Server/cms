<?php

namespace App\Filament\Resources\Orion\HelpQuestionCategoryResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Traits\LatestRelationResourcesTrait;
use App\Filament\Resources\Orion\HelpQuestionResource;
use Filament\Resources\RelationManagers\RelationManager;

class QuestionsRelationManager extends RelationManager
{
    use LatestRelationResourcesTrait, TranslatableResource;

    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'title';

    public static string $translateIdentifier = 'help-questions';

    public static function form(Form $form): Form
    {
        return $form->schema(HelpQuestionResource::getForm(true));
    }

    public static function table(Table $table): Table
    {
        return $table->columns(HelpQuestionResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
