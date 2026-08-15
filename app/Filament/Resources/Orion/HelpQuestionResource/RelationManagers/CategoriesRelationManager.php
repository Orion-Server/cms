<?php

namespace App\Filament\Resources\Orion\HelpQuestionResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\EditAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Traits\TranslatableResource;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource;

class CategoriesRelationManager extends RelationManager
{
    use TranslatableResource;

    protected static string $relationship = 'categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static string $translateIdentifier = 'help-question-categories';

    protected static ?string $inverseRelationship = 'questions';

    public function form(Schema $schema): Schema
    {
        return $schema->components(HelpQuestionCategoryResource::getForm());
    }

    public function table(Table $table): Table
    {
        return $table->columns(HelpQuestionCategoryResource::getTable())
            ->modifyQueryUsing(fn ($query) => $query->latest('id'))
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                DetachBulkAction::make(),
            ]);
    }
}
