<?php

namespace App\Filament\Resources\Profile;

use Filament\Tables;
use App\Enums\CurrencyType;
use Filament\Resources\Form;
use App\Models\Home\HomeItem;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\Profile\HomeItemResource\Pages;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class HomeItemResource extends Resource
{
    protected static ?string $model = HomeItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle';

    protected static ?string $navigationGroup = 'Profile Management';

    protected static ?string $slug = 'profile-management/items';

    public static string $translateIdentifier = 'home-items';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
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
                ->label(__('filament::resources.inputs.home_category_id'))
                ->relationship('homeCategory', 'name')
                ->hidden(fn (\Closure $get) => $get('type') != 's')
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
                ->label(__('filament::resources.inputs.currency_type'))
                ->disablePlaceholderSelection()
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
                ->width(40)
                ->label(__('filament::resources.columns.image')),

            TextColumn::make('name')
                ->label(__('filament::resources.columns.name'))
                ->searchable(),

            BadgeColumn::make('type')
                ->label(__('filament::resources.columns.type'))
                ->enum([
                    's' => __('filament::resources.common.Sticker'),
                    'w' => __('filament::resources.common.Widget'),
                    'n' => __('filament::resources.common.Note'),
                    'b' => __('filament::resources.common.Background'),
                ])
                ->colors([
                    'primary' => 's',
                    'success' => 'w',
                    'primary' => 'n',
                    'danger' => 'b',
                ]),

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
            'index' => Pages\ListHomeItems::route('/'),
            'create' => Pages\CreateHomeItem::route('/create'),
            'edit' => Pages\EditHomeItem::route('/{record}/edit'),
        ];
    }
}
