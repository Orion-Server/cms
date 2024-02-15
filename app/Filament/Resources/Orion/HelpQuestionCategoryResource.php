<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Traits\TranslatableResource;
use App\Models\HelpQuestion\HelpQuestionCategory;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\Pages;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\RelationManagers;

class HelpQuestionCategoryResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = HelpQuestionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-s-bars-2';

    protected static ?string $navigationGroup = 'Help Center';

    protected static ?string $slug = 'help/help-question-categories';

    public static string $translateIdentifier = 'help-question-categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm());
    }

    public static function getForm(): array
    {
        return [
            Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label(__('filament::resources.inputs.name'))
                        ->maxLength(255)
                        ->required(),

                    TextInput::make('icon')
                        ->label(__('filament::resources.inputs.icon'))
                        ->maxLength(255)
                        ->helperText(__('filament::resources.helpers.help_questions_category_icon'))
                        ->nullable()
                ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns(static::getTable())
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

    public static function getTable(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('filament::resources.columns.id'))
                ->sortable(),

            TextColumn::make('order')
                ->label(__('filament::resources.columns.order'))
                ->sortable(),

            ImageColumn::make('icon')
                ->extraAttributes(['style' => 'image-rendering: pixelated'])
                ->size('auto')
                ->label(__('filament::resources.columns.icon')),

            TextColumn::make('name')
                ->label(__('filament::resources.columns.name'))
                ->searchable(),

            TextColumn::make('questions_count')
                ->label(__('filament::resources.columns.questions_count'))
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
            'view' => Pages\ViewHelpQuestionCategory::route('/{record}'),
            'edit' => Pages\EditHelpQuestionCategory::route('/{record}/edit'),
        ];
    }
}
