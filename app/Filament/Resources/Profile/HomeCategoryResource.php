<?php

namespace App\Filament\Resources\Profile;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Profile\HomeCategoryResource\RelationManagers\HomeItemsRelationManager;
use App\Filament\Resources\Profile\HomeCategoryResource\Pages\ListHomeCategories;
use App\Filament\Resources\Profile\HomeCategoryResource\Pages\CreateHomeCategory;
use App\Filament\Resources\Profile\HomeCategoryResource\Pages\EditHomeCategory;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Home\HomeCategory;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Profile\HomeCategoryResource\Pages;
use App\Filament\Resources\Profile\HomeCategoryResource\RelationManagers;

class HomeCategoryResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = HomeCategory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bars-2';

    protected static string | \UnitEnum | null $navigationGroup = 'Profile Management';

    protected static ?string $slug = 'profile-management/categories';

    public static string $translateIdentifier = 'home-categories';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255)
                            ->label(__('filament::resources.inputs.name'))
                            ->required(),

                        TextInput::make('icon')
                            ->maxLength(255)
                            ->label(__('filament::resources.inputs.icon'))
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources.columns.id'))
                    ->visible(fn (Component $livewire) => ! $livewire->isTableReordering),

                TextColumn::make('order')
                    ->label(__('filament::resources.columns.order'))
                    ->visible(fn (Component $livewire) => $livewire->isTableReordering),

                ImageColumn::make('icon')
                    ->label(__('filament::resources.columns.icon'))
                    ->size('auto'),

                TextColumn::make('name')
                    ->label(__('filament::resources.columns.name'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            HomeItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomeCategories::route('/'),
            'create' => CreateHomeCategory::route('/create'),
            'edit' => EditHomeCategory::route('/{record}/edit'),
        ];
    }
}
