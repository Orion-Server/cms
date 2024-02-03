<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\WriteableBox;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Traits\TranslatableResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Orion\WriteableBoxResource\Pages;
use App\Filament\Resources\Orion\WriteableBoxResource\RelationManagers;
use App\Forms\Components\CKEditor;
use Closure;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class WriteableBoxResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = WriteableBox::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/writeable-boxes';

    public static string $translateIdentifier = 'writeable-boxes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament::resources.inputs.name'))
                    ->required(),

                TextInput::make('icon')
                    ->label(__('filament::resources.inputs.icon'))
                    ->required(),

                TextInput::make('description')
                    ->label(__('filament::resources.inputs.description'))
                    ->columnSpanFull()
                    ->nullable(),

                RichEditor::make('content')
                    ->label(__('filament::resources.inputs.content'))
                    ->columnSpanFull()
                    ->nullable(),

                Select::make('page_target')
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWriteableBoxes::route('/'),
        ];
    }
}
