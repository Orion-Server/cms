<?php

namespace App\Filament\Resources\Shop\ShopProductResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament::resources.inputs.name'))
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->required()
                    ->label(__('filament::resources.inputs.type'))
                    ->reactive()
                    ->options([
                        'badge' => __('filament::resources.options.badge'),
                        'furniture' => __('filament::resources.options.furniture'),
                        'room' => __('filament::resources.options.room'),
                        'currency' => __('filament::resources.options.currency'),
                    ]),

                TextInput::make('data')
                    ->label(__('filament::resources.inputs.item_data'))
                    ->columnSpanFull()
                    ->hint(fn (Closure $get) => $get('type') ? __("filament::resources.helpers.{$get('type')}_item_data_helper") : __("filament::resources.helpers.empty_item_data_helper"))
                    ->required()
                    ->maxLength(255),

                TextInput::make('quantity')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->columnSpanFull()
                    ->label(__('filament::resources.inputs.quantity'))
                    ->required(),

                Toggle::make('is_active')
                    ->columnSpanFull()
                    ->label(__('filament::resources.inputs.item_is_active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),

                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'badge',
                        'secondary' => 'furniture',
                        'success' => 'room',
                        'warning' => 'currency'
                    ])
                    ->label(__('filament::resources.columns.type'))
                    ->formatStateUsing(fn (string $state): string => __("filament::resources.options.{$state}")),

                Tables\Columns\TextColumn::make('data')
                    ->label(__('filament::resources.columns.item_data')),

                Tables\Columns\TextColumn::make('data')
                    ->label(__('filament::resources.columns.item_data'))
            ])
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DissociateBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
