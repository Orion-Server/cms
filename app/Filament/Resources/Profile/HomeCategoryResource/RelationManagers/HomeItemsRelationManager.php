<?php

namespace App\Filament\Resources\Profile\HomeCategoryResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Profile\HomeItemResource;
use Filament\Resources\RelationManagers\RelationManager;

class HomeItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'homeItems';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema->components(HomeItemResource::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns(HomeItemResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
