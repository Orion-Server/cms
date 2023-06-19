<?php

namespace App\Filament\Resources\Hotel;

use Filament\Tables;
use App\Enums\CurrencyType;
use App\Models\Achievement;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Enums\AchievementCategory;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Tables\Columns\HabboBadgeColumn;
use App\Filament\Resources\Hotel\AchievementResource\Pages;

class AchievementResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Hotel';

    public static string $translateIdentifier = 'achievements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Main')
                    ->tabs([
                        Tabs\Tab::make('Home')
                            ->icon('heroicon-o-home')
                            ->schema([
                                TextInput::make('name')
                                    ->placeholder('Achievement Name')
                                    ->required()
                                    ->autocomplete()
                                    ->columnSpan('full'),

                                TextInput::make('level')
                                    ->placeholder('Achievement Level')
                                    ->numeric()
                                    ->required()
                                    ->autocomplete()
                                    ->columnSpan('full'),

                                Select::make('category')
                                    ->placeholder('Achievement Category')
                                    ->disablePlaceholderSelection()
                                    ->options(AchievementCategory::toInput())
                            ]),

                        Tabs\Tab::make('Configurations')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Select::make('visible')
                                    ->disablePlaceholderSelection()
                                    ->options([
                                        '1' => 'Yes',
                                        '0' => 'No',
                                    ]),

                                Select::make('reward_type')
                                    ->disablePlaceholderSelection()
                                    ->options(CurrencyType::toInput()),

                                TextInput::make('reward_amount')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('points')
                                    ->helperText('Achievement Points to be rewarded')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('progress_needed')
                                    ->helperText('Progress needed to complete the achievement')
                                    ->numeric()
                                    ->required()
                            ])
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                HabboBadgeColumn::make('badge')
                    ->searchable()
                    ->label('Badge'),

                TextColumn::make('name')
                    ->searchable()
                    ->label('Name'),

                TextColumn::make('level')
                    ->label('Level'),

                BadgeColumn::make('category')
                    ->searchable()
                    ->label('Category')
                    ->toggleable(),

                ToggleColumn::make('visible')
                    ->label('Visible')
                    ->disabled()
                    ->toggleable()
            ])
            ->filters([
                SelectFilter::make('visible')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No',
                    ])
                    ->label('Visible')
                    ->placeholder('All'),

                SelectFilter::make('category')
                    ->options(AchievementCategory::toInput())
                    ->label('Category')
                    ->placeholder('All'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
