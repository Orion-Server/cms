<?php

namespace App\Filament\Resources\Orion;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Orion\ArticleResource\RelationManagers\TagsRelationManager;
use App\Filament\Resources\Orion\ArticleResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\Orion\ArticleResource\Pages\ListArticles;
use App\Filament\Resources\Orion\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\Orion\ArticleResource\Pages\ViewArticle;
use App\Filament\Resources\Orion\ArticleResource\Pages\EditArticle;
use Filament\Tables;
use App\Models\Article;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Forms\Components\CKEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Traits\TranslatableResource;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\Orion\ArticleResource\Pages;
use App\Filament\Resources\Orion\ArticleResource\RelationManagers;

class ArticleResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Article::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static ?string $slug = 'website/articles';

    public static string $translateIdentifier = 'articles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(static::getForm());
    }

    public static function getForm(): array
    {
        return [
            Tabs::make('Main')
                ->tabs([
                    Tab::make(__('filament::resources.tabs.Home'))
                        ->icon('heroicon-o-home')
                        ->schema([
                            TextInput::make('title')
                                ->label(__('filament::resources.inputs.title'))
                                ->required()
                                ->autocomplete()
                                ->maxLength(255)
                                ->columnSpan('full'),

                            TextInput::make('description')
                                ->label(__('filament::resources.inputs.description'))
                                ->required()
                                ->maxLength(255)
                                ->autocomplete()
                                ->columnSpan('full'),

                            TextInput::make('image')
                                ->label(__('filament::resources.inputs.image'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpan('full'),

                            CKEditor::make('content')
                                ->label(__('filament::resources.inputs.content'))
                                ->required()
                                ->columnSpan('full'),
                        ]),

                    Tab::make(__('filament::resources.tabs.Configurations'))
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Toggle::make('visible')
                                ->onIcon('heroicon-s-check')
                                ->label(__('filament::resources.inputs.visible'))
                                ->default(true)
                                ->offIcon('heroicon-s-x-mark'),

                            Toggle::make('fixed')
                                ->onIcon('heroicon-s-check')
                                ->label(__('filament::resources.inputs.fixed'))
                                ->default(false)
                                ->offIcon('heroicon-s-x-mark'),

                            Toggle::make('allow_comments')
                                ->onIcon('heroicon-s-check')
                                ->label(__('filament::resources.inputs.allow_comments'))
                                ->default(true)
                                ->offIcon('heroicon-s-x-mark'),

                            Toggle::make('is_promotion')
                                ->label(__('filament::resources.inputs.is_promotion'))
                                ->onIcon('heroicon-s-check')
                                ->default(false)
                                ->reactive()
                                ->offIcon('heroicon-s-x-mark'),

                            DateTimePicker::make('promotion_ends_at')
                                ->displayFormat('Y-m-d H:i')
                                ->native(false)
                                ->withoutSeconds()
                                ->hidden(fn (Get $get) => !$get('is_promotion'))
                                ->label(__('filament::resources.inputs.promotion_ends_at'))
                                ->required()
                                ->columnSpan('full'),
                        ]),
                ])->columnSpanFull()
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->poll('60s')
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

            ImageColumn::make('image')
                ->circular()
                ->extraAttributes(['style' => 'image-rendering: pixelated'])
                ->size(50)
                ->label(__('filament::resources.columns.image')),

            TextColumn::make('title')
                ->label(__('filament::resources.columns.title'))
                ->searchable()
                ->limit(50),

            TextColumn::make('user.username')
                ->searchable()
                ->label(__('filament::resources.columns.by')),

            ToggleColumn::make('visible')
                ->label(__('filament::resources.columns.visible'))
                ->onIcon('heroicon-s-check')
                ->toggleable()
                ->disabled(),

            ToggleColumn::make('fixed')
                ->label(__('filament::resources.columns.fixed'))
                ->onIcon('heroicon-s-check')
                ->toggleable()
                ->disabled(),

            ToggleColumn::make('allow_comments')
                ->label(__('filament::resources.columns.allow_comments'))
                ->onIcon('heroicon-s-check')
                ->toggleable()
                ->disabled(),
        ];
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'view' => ViewArticle::route('/{record}'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
