<?php

namespace App\Filament\Resources\Orion;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\Pages\ListHelpQuestionCategories;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\Pages\CreateHelpQuestionCategory;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\Pages\ViewHelpQuestionCategory;
use App\Filament\Resources\Orion\HelpQuestionCategoryResource\Pages\EditHelpQuestionCategory;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-s-bars-2';

    protected static string | \UnitEnum | null $navigationGroup = 'Help Center';

    protected static ?string $slug = 'help/help-question-categories';

    public static string $translateIdentifier = 'help-question-categories';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(static::getForm());
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
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
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
            QuestionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHelpQuestionCategories::route('/'),
            'create' => CreateHelpQuestionCategory::route('/create'),
            'view' => ViewHelpQuestionCategory::route('/{record}'),
            'edit' => EditHelpQuestionCategory::route('/{record}/edit'),
        ];
    }
}
