<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use App\Models\CmsSetting;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Orion\CmsSettingResource\Pages;

class CmsSettingResource extends Resource
{
    protected static ?string $model = CmsSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-chip';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/cms-settings';

    protected static ?string $label = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('key')
                            ->maxLength(50)
                            ->autocomplete()
                            ->unique(ignoreRecord: true)
                            ->required(),

                        TextInput::make('value')
                            ->required()
                            ->autocomplete(),

                        TextInput::make('comment')
                            ->nullable()
                            ->autocomplete()
                            ->columnSpanFull()
                    ])
                    ->columns([
                        'sm' => 2
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable(),

                TextColumn::make('value')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('comment')
                    ->toggleable()
                    ->searchable()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getLimit()) return null;

                        return $state;
                    })
                    ->limit(25)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCmsSettings::route('/'),
        ];
    }
}
