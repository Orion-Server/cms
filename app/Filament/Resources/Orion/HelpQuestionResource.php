<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use App\Models\HelpQuestion;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Orion\HelpQuestionResource\Pages;
use App\Filament\Resources\Orion\HelpQuestionResource\RelationManagers;

class HelpQuestionResource extends Resource
{
    protected static ?string $model = HelpQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-support';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/help-questions';

    protected static ?string $label = 'Help Questions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListHelpQuestions::route('/'),
            'create' => Pages\CreateHelpQuestion::route('/create'),
            'edit' => Pages\EditHelpQuestion::route('/{record}/edit'),
        ];
    }
}
