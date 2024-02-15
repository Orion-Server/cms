<?php

namespace App\Filament\Resources\Orion;

use App\Models\Team;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Tables\Columns\HabboBadgeColumn;
use App\Filament\Resources\Orion\TeamResource\Pages;

class TeamResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/teams';

    public static string $translateIdentifier = 'teams';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->autofocus()
                            ->maxLength(255)
                            ->required()
                            ->label(__('filament::resources.inputs.name')),

                        TextInput::make('description')
                            ->maxLength(255)
                            ->label(__('filament::resources.inputs.description')),

                        TextInput::make('badge')
                            ->maxLength(255)
                            ->label(__('filament::resources.inputs.badge_code')),

                        TextInput::make('order')
                            ->default(0)
                            ->numeric()
                            ->label(__('filament::resources.inputs.order')),

                        Toggle::make('is_hidden')
                            ->label(__('filament::resources.inputs.is_hidden')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources.columns.id')),

                HabboBadgeColumn::make('badge')
                    ->label(__('filament::resources.columns.badge')),

                TextColumn::make('name')
                    ->label(__('filament::resources.columns.name')),

                TextColumn::make('order')
                    ->label(__('filament::resources.columns.order')),
            ])
            ->reorderable('order')
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
