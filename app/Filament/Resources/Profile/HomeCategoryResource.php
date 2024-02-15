<?php

namespace App\Filament\Resources\Profile;

use Filament\Tables;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Home\HomeCategory;
use Filament\Forms\Components\Section;
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

    protected static ?string $navigationIcon = 'heroicon-o-bars-2';

    protected static ?string $navigationGroup = 'Profile Management';

    protected static ?string $slug = 'profile-management/categories';

    public static string $translateIdentifier = 'home-categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\HomeItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeCategories::route('/'),
            'create' => Pages\CreateHomeCategory::route('/create'),
            'edit' => Pages\EditHomeCategory::route('/{record}/edit'),
        ];
    }
}
