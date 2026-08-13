<?php

namespace App\Filament\Resources\Hotel;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\Hotel\AchievementResource\Pages\ListAchievements;
use App\Filament\Resources\Hotel\AchievementResource\Pages\CreateAchievement;
use App\Filament\Resources\Hotel\AchievementResource\Pages\ViewAchievement;
use App\Filament\Resources\Hotel\AchievementResource\Pages\EditAchievement;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\CurrencyType;
use App\Models\Achievement;
use Filament\Resources\Resource;
use App\Enums\AchievementCategory;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Tables\Columns\HabboBadgeColumn;
use App\Filament\Resources\Hotel\AchievementResource\Pages;

class AchievementResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Achievement::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string | \UnitEnum | null $navigationGroup = 'Hotel';

    public static string $translateIdentifier = 'achievements';

    protected static ?string $slug = 'hotel/achievements';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Main')
                    ->tabs([
                        Tab::make(__('filament::resources.tabs.Home'))
                            ->icon('heroicon-o-home')
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament::resources.inputs.name'))
                                    ->required()
                                    ->maxLength(64)
                                    ->autocomplete()
                                    ->columnSpan('full'),

                                TextInput::make('level')
                                    ->label(__('filament::resources.inputs.level'))
                                    ->numeric()
                                    ->required()
                                    ->autocomplete()
                                    ->columnSpan('full'),

                                Select::make('category')
                                    ->native(false)
                                    ->label(__('filament::resources.inputs.category'))
                                    ->options(AchievementCategory::toInput())
                            ]),

                        Tab::make(__('filament::resources.tabs.Configurations'))
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Select::make('visible')
                                    ->native(false)
                                    ->label(__('filament::resources.inputs.visible'))
                                    ->options([
                                        '1' => __('filament::resources.common.Yes'),
                                        '0' => __('filament::resources.common.No'),
                                    ]),

                                Select::make('reward_type')
                                    ->native(false)
                                    ->label(__('filament::resources.inputs.reward_type'))
                                    ->options(CurrencyType::toInput()),

                                TextInput::make('reward_amount')
                                    ->label(__('filament::resources.inputs.reward_amount'))
                                    ->numeric()
                                    ->required(),

                                TextInput::make('points')
                                    ->label(__('filament::resources.inputs.points'))
                                    ->helperText(__('filament::resources.helpers.achievement_points'))
                                    ->numeric()
                                    ->required(),

                                TextInput::make('progress_needed')
                                    ->label(__('filament::resources.inputs.progress_needed'))
                                    ->helperText(__('filament::resources.helpers.achievement_progress_needed'))
                                    ->numeric()
                                    ->required()
                            ])
                    ])->columnSpanFull()
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
                    ->label(__('filament::resources.columns.name'))
                    ->searchable(),

                TextColumn::make('level')
                    ->label(__('filament::resources.columns.level')),

                TextColumn::make('category')
                    ->badge()
                    ->searchable()
                    ->label(__('filament::resources.columns.category'))
                    ->toggleable(),

                ToggleColumn::make('visible')
                    ->label(__('filament::resources.columns.visible'))
                    ->disabled()
                    ->toggleable()
            ])
            ->filters([
                SelectFilter::make('visible')
                    ->options([
                        '1' => __('filament::resources.common.Yes'),
                        '0' => __('filament::resources.common.No'),
                    ])
                    ->label(__('filament::resources.columns.visible'))
                    ->placeholder(__('filament::resources.common.All')),

                SelectFilter::make('category')
                    ->options(AchievementCategory::toInput())
                    ->label(__('filament::resources.columns.category'))
                    ->placeholder(__('filament::resources.common.All')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([]);
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
            'index' => ListAchievements::route('/'),
            'create' => CreateAchievement::route('/create'),
            'view' => ViewAchievement::route('/{record}'),
            'edit' => EditAchievement::route('/{record}/edit'),
        ];
    }
}
