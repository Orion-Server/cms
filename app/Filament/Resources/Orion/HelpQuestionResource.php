<?php

namespace App\Filament\Resources\Orion;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Orion\HelpQuestionResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages\ListHelpQuestions;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages\CreateHelpQuestion;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages\ViewHelpQuestion;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages\EditHelpQuestion;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\HelpQuestion;
use Filament\Resources\Resource;
use App\Forms\Components\CKEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages;
use App\Filament\Resources\Orion\HelpQuestionResource\RelationManagers;

class HelpQuestionResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = HelpQuestion::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-s-question-mark-circle';

    protected static string | \UnitEnum | null $navigationGroup = 'Help Center';

    protected static ?string $slug = 'help/help-questions';

    public static string $translateIdentifier = 'help-questions';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getForm());
    }

    public static function getForm(): array
    {
        return [
            Section::make()
                ->schema([
                    TextInput::make('title')
                        ->label(__('filament::resources.inputs.title'))
                        ->required()
                        ->maxLength(255)
                        ->autocomplete()
                        ->columnSpan('full'),

                    Select::make('categories')
                        ->native(false)
                        ->label(__('filament::resources.inputs.categories'))
                        ->multiple()
                        ->visibleOn('create')
                        ->relationship('categories', 'name'),

                    CKEditor::make('content')
                        ->label(__('filament::resources.inputs.content'))
                        ->required()
                        ->columnSpan('full'),

                    Toggle::make('visible')
                        ->label(__('filament::resources.inputs.visible'))
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
                ->label(__('filament::resources.columns.id')),

            TextColumn::make('title')
                ->label(__('filament::resources.columns.title'))
                ->searchable()
                ->limit(50),

            TextColumn::make('user.username')
                ->label(__('filament::resources.columns.by'))
                ->searchable()
        ];
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHelpQuestions::route('/'),
            'create' => CreateHelpQuestion::route('/create'),
            'view' => ViewHelpQuestion::route('/{record}'),
            'edit' => EditHelpQuestion::route('/{record}/edit'),
        ];
    }
}
