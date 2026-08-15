<?php

namespace App\Filament\Resources\Orion;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Orion\WriteableBoxResource\Pages\ManageWriteableBoxes;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\WriteableBox;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\WriteableBoxResource\Pages;

class WriteableBoxResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = WriteableBox::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static ?string $slug = 'website/writeable-boxes';

    public static string $translateIdentifier = 'writeable-boxes';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('filament::resources.inputs.name'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('icon')
                    ->label(__('filament::resources.inputs.icon'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('description')
                    ->label(__('filament::resources.inputs.description'))
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->nullable(),

                RichEditor::make('content')
                    ->label(__('filament::resources.inputs.content'))
                    ->columnSpanFull()
                    ->nullable(),

                Select::make('page_target')
                    ->native(false)
                    ->label(__('filament::resources.inputs.page_target'))
                    ->columnSpanFull()
                    ->options([
                        'staff' => __('filament::resources.options.staff'),
                        'shop' => __('filament::resources.options.shop'),
                        'teams' => __('filament::resources.options.teams'),
                    ]),

                Toggle::make('is_active')
                    ->label(__('filament::resources.inputs.is_active'))
                    ->columnSpanFull()
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources.columns.id')),

                ImageColumn::make('icon')
                    ->label(__('filament::resources.columns.icon'))
                    ->size('auto')
                    ->searchable(),

                TextColumn::make('name')
                    ->label(__('filament::resources.columns.name'))
                    ->description(fn (Model $record) => $record->description)
                    ->searchable(),

                TextColumn::make('page_target')
                    ->label(__('filament::resources.columns.page_target'))
                    ->formatStateUsing(fn (string $state): string => __("filament::resources.options.{$state}"))
                    ->searchable(),

                ToggleColumn::make('is_active')
                    ->disabled()
                    ->label(__('filament::resources.columns.visible')),
            ])
            ->filters([
                SelectFilter::make('page_target')
                    ->label(__('filament::resources.filters.page_target'))
                    ->options([
                        'staff' => __('filament::resources.options.staff'),
                        'shop' => __('filament::resources.options.shop'),
                        'teams' => __('filament::resources.options.teams'),
                    ]),

                SelectFilter::make('is_active')
                    ->label(__('filament::resources.filters.visible'))
                    ->options([
                        1 => __('filament::resources.options.yes'),
                        0 => __('filament::resources.options.no'),
                    ])
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWriteableBoxes::route('/'),
        ];
    }
}
