<?php

namespace App\Filament\Resources\Profile\HomeCategoryResource\RelationManagers;

use App\Filament\Resources\Profile\HomeItemResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'homeItems';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(HomeItemResource::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(HomeItemResource::getTable())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
            ]);
    }
}
