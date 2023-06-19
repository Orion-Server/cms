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
use App\Filament\Traits\TranslatableResource;
use App\Filament\Resources\Orion\CmsSettingResource\Pages;

class CmsSettingResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = CmsSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-chip';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/cms-settings';

    public static string $translateIdentifier = 'cms-settings';

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
                    ->limit(30),

                TextColumn::make('comment')
                    ->toggleable()
                    ->searchable()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getLimit()) return null;

                        return $state;
                    })
                    ->limit(60)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
