<?php

namespace App\Filament\Resources\Profile\HomeCategoryResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Filament\Resources\Profile\HomeItemResource;
use Filament\Resources\RelationManagers\RelationManager;

class HomeItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'homeItems';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form->schema(HomeItemResource::getForm());
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
