<?php

namespace App\Filament\Resources\Orion;

use Filament\Tables;
use App\Models\CmsTag;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\Orion\CmsTagResource\Pages;

class CmsTagResource extends Resource
{
    protected static ?string $model = CmsTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $slug = 'administration/cms-tags';

    protected static ?string $label = 'Tag';

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
            'index' => Pages\ListCmsTags::route('/'),
            'create' => Pages\CreateCmsTag::route('/create'),
            'edit' => Pages\EditCmsTag::route('/{record}/edit'),
        ];
    }
}
