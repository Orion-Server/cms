<?php

namespace App\Filament\Resources\Orion\ArticleResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Actions\CreateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Orion\TagResource;
use App\Filament\Traits\TranslatableResource;
use Filament\Resources\RelationManagers\RelationManager;

class TagsRelationManager extends RelationManager
{
    use TranslatableResource;

    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'name';

    public static string $translateIdentifier = 'tags';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns(TagResource::getTable())
            ->modifyQueryUsing(fn ($query) => $query->latest())
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema(TagResource::getForm()),

                AttachAction::make()->preloadRecordSelect()
            ])
            ->recordActions([
                ViewAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                DetachBulkAction::make(),
            ]);
    }
}
