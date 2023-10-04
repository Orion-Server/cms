<?php

namespace App\Filament\Resources\Orion\NavigationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubNavigationsRelationManager extends RelationManager
{
    protected static string $relationship = 'subNavigations';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')
                    ->label(__('filament::resources.inputs.label'))
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label(__('filament::resources.inputs.slug')),

                TextInput::make('order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label(__('filament::resources.columns.order')),

                Toggle::make('visible')
                    ->label(__('filament::resources.columns.visible')),

                Toggle::make('new_tab')
                    ->label(__('filament::resources.columns.new_tab')),
            ])
            ->columns([
                'sm' => 2
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label'),

                TextColumn::make('slug')
                    ->label(__('filament::resources.columns.slug')),

                ToggleColumn::make('visible')
                    ->label(__('filament::resources.columns.visible')),

                ToggleColumn::make('new_tab')
                    ->label(__('filament::resources.columns.new_tab')),

                TextColumn::make('order')
                    ->label(__('filament::resources.columns.order'))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
