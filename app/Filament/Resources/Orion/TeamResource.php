<?php

namespace App\Filament\Resources\Orion;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Orion\TeamResource\Pages\ListTeams;
use App\Filament\Resources\Orion\TeamResource\Pages\CreateTeam;
use App\Filament\Resources\Orion\TeamResource\Pages\EditTeam;
use App\Models\Team;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Tables\Columns\HabboBadgeColumn;
use App\Filament\Resources\Orion\TeamResource\Pages;

class TeamResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Team::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static ?string $slug = 'website/teams';

    public static string $translateIdentifier = 'teams';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
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
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
