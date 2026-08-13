<?php

namespace App\Filament\Resources\Orion\HelpQuestionCategoryResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\HelpQuestionResource;
use Filament\Resources\RelationManagers\RelationManager;

class QuestionsRelationManager extends RelationManager
{
    use TranslatableResource;

    protected static string $relationship = 'questions';

    protected static ?string $recordTitleAttribute = 'title';

    public static string $translateIdentifier = 'help-questions';

    protected static ?string $inverseRelationship = 'categories';

    public function form(Schema $schema): Schema
    {
        return $schema->components(HelpQuestionResource::getForm(true));
    }

    public function table(Table $table): Table
    {
        return $table->columns(HelpQuestionResource::getTable())
            ->modifyQueryUsing(fn ($query) => $query->latest())
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                DetachBulkAction::make(),
            ]);
    }
}
