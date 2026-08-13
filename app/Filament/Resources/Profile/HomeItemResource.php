<?php

namespace App\Filament\Resources\Profile;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\Profile\HomeItemResource\Pages\ListHomeItems;
use App\Filament\Resources\Profile\HomeItemResource\Pages\CreateHomeItem;
use App\Filament\Resources\Profile\HomeItemResource\Pages\EditHomeItem;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Enums\CurrencyType;
use App\Models\Home\HomeItem;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Profile\HomeItemResource\Pages;

class HomeItemResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = HomeItem::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static string | \UnitEnum | null $navigationGroup = 'Profile Management';

    protected static ?string $slug = 'profile-management/items';

    public static string $translateIdentifier = 'home-items';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema(self::getForm())
                    ->columns([
                        'sm' => 2
                    ])
            ]);
    }

    public static function getForm(): array
    {
        return [
            Select::make('type')
                ->native(false)
                ->label(__('filament::resources.inputs.type'))
                ->options([
                    's' => __('filament::resources.common.Sticker'),
                    'w' => __('filament::resources.common.Widget'),
                    'n' => __('filament::resources.common.Note'),
                    'b' => __('filament::resources.common.Background'),
                ])
                ->reactive()
                ->default('s')
                ->required(),

            Select::make('home_category_id')
                ->native(false)
                ->label(__('filament::resources.inputs.category'))
                ->relationship('homeCategory', 'name')
                ->hidden(fn (Get $get) => $get('type') != 's')
                ->nullable(),

            TextInput::make('name')
                ->label(__('filament::resources.inputs.name'))
                ->required()
                ->columnSpanFull()
                ->maxLength(255),

            TextInput::make('image')
                ->label(__('filament::resources.inputs.image'))
                ->required()
                ->columnSpanFull()
                ->maxLength(255),

            Select::make('currency_type')
                ->native(false)
                ->label(__('filament::resources.inputs.currency_type'))
                ->default(-1)
                ->options(CurrencyType::toInput()),

            TextInput::make('price')
                ->label(__('filament::resources.inputs.price'))
                ->required()
                ->maxLength(255),

            TextInput::make('limit')
                ->numeric()
                ->columnSpanFull()
                ->label(__('filament::resources.inputs.limit'))
                ->helperText(__('filament::resources.helpers.home_item_limit_helper'))
                ->nullable(),

            Toggle::make('enabled')
                    ->label(__('filament::resources.inputs.visible'))
                    ->default(true),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns(self::getTable())
            ->filters([
                SelectFilter::make('type')
                    ->label(__('filament::resources.columns.type'))
                    ->options([
                        's' => __('filament::resources.common.Sticker'),
                        'w' => __('filament::resources.common.Widget'),
                        'n' => __('filament::resources.common.Note'),
                        'b' => __('filament::resources.common.Background'),
                    ]),

                SelectFilter::make('category')
                    ->label(__('filament::resources.columns.category'))
                    ->relationship('homeCategory', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTable(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('filament::resources.columns.id'))
                ->visible(fn (Component $livewire) => ! $livewire->isTableReordering),

            TextColumn::make('order')
                ->label(__('filament::resources.columns.order'))
                ->visible(fn (Component $livewire) => $livewire->isTableReordering),

            ImageColumn::make('image')
                ->size('auto')
                ->extraImgAttributes(['style' => 'max-width: 200px'])
                ->label(__('filament::resources.columns.image')),

            TextColumn::make('name')
                ->label(__('filament::resources.columns.name'))
                ->searchable(),

            TextColumn::make('type')
                ->label(__('filament::resources.columns.type'))
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    's' => __('filament::resources.common.Sticker'),
                    'w' => __('filament::resources.common.Widget'),
                    'n' => __('filament::resources.common.Note'),
                    'b' => __('filament::resources.common.Background'),
                })
                ->color(fn (string $state): string => match ($state) {
                    's' => 'primary',
                    'w' => 'success',
                    'n' => 'primary',
                    'b' => 'danger',
                }),

            TextColumn::make('price')
                ->label(__('filament::resources.columns.price'))
                ->searchable(),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomeItems::route('/'),
            'create' => CreateHomeItem::route('/create'),
            'edit' => EditHomeItem::route('/{record}/edit'),
        ];
    }
}
