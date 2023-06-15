<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Models\HelpQuestion\HelpQuestionCategory;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\Pages;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class HelpQuestionCategoryResource extends Resource
{
    protected static ?string $model = HelpQuestionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-s-menu';

    protected static ?string $navigationGroup = 'Help Center';

    protected static ?string $slug = 'help/help-question-categories';

    protected static ?string $label = 'Help Questions Category';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm());
    }

    public static function getForm(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('name')
                        ->placeholder('Category name')
                        ->required(),

                    TextInput::make('icon')
                        ->label('Icon URL (optional)')
                        ->nullable()
                ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTable())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTable(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            TextColumn::make('order')
                ->sortable(),

            ImageColumn::make('icon')
                ->extraAttributes(['style' => 'image-rendering: pixelated'])
                ->label('icon'),

            TextColumn::make('name')
                ->searchable(),

            TextColumn::make('questions_count')
                ->counts('questions'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHelpQuestionCategories::route('/'),
            'create' => Pages\CreateHelpQuestionCategory::route('/create'),
            'edit' => Pages\EditHelpQuestionCategory::route('/{record}/edit'),
        ];
    }
}
