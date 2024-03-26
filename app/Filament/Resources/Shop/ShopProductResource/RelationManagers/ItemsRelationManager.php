<?php

namespace App\Filament\Resources\Shop\ShopProductResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\ShopProductItemType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    use TranslatableResource;

    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $translateIdentifier = 'product-item';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament::resources.inputs.name'))
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->native(false)
                    ->required()
                    ->label(__('filament::resources.inputs.type'))
                    ->reactive()
                    ->options([
                        'badge' => __('filament::resources.options.badge'),
                        'furniture' => __('filament::resources.options.furniture'),
                        'room' => __('filament::resources.options.room'),
                        'currency' => __('filament::resources.options.currency'),
                        'rank' => __('filament::resources.options.rank'),
                    ]),

                TextInput::make('data')
                    ->label(__('filament::resources.inputs.item_data'))
                    ->columnSpanFull()
                    ->hint(fn (Get $get) => $get('type') ? __("filament::resources.helpers.{$get('type')}_item_data_helper") : __("filament::resources.helpers.empty_item_data_helper"))
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

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->latest())
            ->columns([
                Tables\Columns\TextColumn::make('name'),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (ShopProductItemType $state): string => match ($state) {
                        ShopProductItemType::Badge => 'primary',
                        ShopProductItemType::Furniture => 'secondary',
                        ShopProductItemType::Room => 'success',
                        ShopProductItemType::Currency => 'warning',
                        ShopProductItemType::Rank => 'danger',
                    })
                    ->label(__('filament::resources.columns.type'))
                    ->formatStateUsing(fn (ShopProductItemType $state): string => __("filament::resources.options.{$state->value}")),

                Tables\Columns\TextColumn::make('data')
                    ->label(__('filament::resources.columns.item_data')),

                Tables\Columns\TextColumn::make('data')
                    ->label(__('filament::resources.columns.item_data')),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('filament::resources.columns.quantity')),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('filament::resources.columns.visible')),
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
