<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use App\Models\Article;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Forms\Components\CKEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\Orion\ArticleResource\Pages;
use App\Filament\Resources\Orion\ArticleResource\RelationManagers;
use Filament\Resources\RelationManagers\RelationManager;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $slug = 'administration/articles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm());
    }

    public static function getForm(): array
    {
        return [
            Tabs::make('Main')
                ->tabs([
                    Tabs\Tab::make('Home')
                        ->icon('heroicon-o-home')
                        ->schema([
                            TextInput::make('title')
                                ->placeholder('Article title')
                                ->required()
                                ->autocomplete()
                                ->columnSpan('full'),

                            TextInput::make('description')
                                ->placeholder('Article description')
                                ->required()
                                ->autocomplete()
                                ->columnSpan('full'),

                            TextInput::make('image')
                                ->required()
                                ->placeholder('Image link')
                                ->columnSpan('full'),

                            CKEditor::make('content')
                                ->label('Article content')
                                ->required()
                                ->columnSpan('full'),
                        ]),

                    Tabs\Tab::make('Configurations')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Toggle::make('visible')
                                ->onIcon('heroicon-s-check')
                                ->label('Mark as visible article')
                                ->default(false)
                                ->offIcon('heroicon-s-x'),

                            Toggle::make('fixed')
                                ->onIcon('heroicon-s-check')
                                ->label('Mark as fixed article')
                                ->default(false)
                                ->offIcon('heroicon-s-x'),

                            Toggle::make('allow_comments')
                                ->onIcon('heroicon-s-check')
                                ->label('Allow comments on this article')
                                ->default(true)
                                ->offIcon('heroicon-s-x'),

                            Toggle::make('is_promotion')
                                ->label('Article is a Promotion')
                                ->onIcon('heroicon-s-check')
                                ->default(false)
                                ->reactive()
                                ->offIcon('heroicon-s-x'),

                            DateTimePicker::make('promotion_ends_at')
                                ->displayFormat('Y-m-d H:i')
                                ->withoutSeconds()
                                ->hidden(fn (\Closure $get) => !$get('is_promotion'))
                                ->label('Promotion ends at')
                                ->required()
                                ->columnSpan('full'),
                        ]),
                ])->columnSpanFull()
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
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

    public static function getTable(bool $isRelationManager = false): array
    {
        return [
            TextColumn::make('id')
                ->label('ID'),

            ImageColumn::make('image')
                ->circular()
                ->extraAttributes(['style' => 'image-rendering: pixelated'])
                ->size(50)
                ->label('Image'),

            TextColumn::make('title')->searchable()->limit(50),
            TextColumn::make('user.username')->searchable()->label('Posted by'),

            ToggleColumn::make('visible')
                ->onIcon('heroicon-s-check')
                ->toggleable()
                ->disabled($isRelationManager),

            ToggleColumn::make('fixed')
                ->onIcon('heroicon-s-check')
                ->toggleable()
                ->disabled($isRelationManager),

            ToggleColumn::make('allow_comments')
                ->onIcon('heroicon-s-check')
                ->toggleable()
                ->disabled($isRelationManager),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TagsRelationManager::class,
            RelationManagers\ReactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
