<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use App\Models\Article;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Forms\Components\CKEditor;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Orion\ArticleResource\Pages;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Article title')
                            ->maxLength(255)
                            ->required()
                            ->autocomplete('title')
                            ->columnSpan('full'),

                        TextInput::make('description')
                            ->label('Description')
                            ->placeholder('Article description')
                            ->maxLength(255)
                            ->required()
                            ->autocomplete('description')
                            ->columnSpan('full'),

                        TextInput::make('image')
                            ->label('Image')
                            ->required()
                            ->placeholder('Image link')
                            ->helperText('Eg: https://example.com/image.jpg')
                            ->maxLength(255)
                            ->columnSpan('full'),

                        CKEditor::make('content')
                            ->label('Article content')
                            ->required()
                            ->columnSpan('full'),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
