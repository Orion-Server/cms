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
                        Tabs\Tab::make(__('filament::resources.tabs.Home'))
                            ->icon('heroicon-o-home')
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament::resources.inputs.name'))
                                    ->required()
                                    ->autocomplete()
                                    ->columnSpan('full'),

                                TextInput::make('level')
                                    ->label(__('filament::resources.inputs.level'))
                                    ->numeric()
                                    ->required()
                                    ->autocomplete()
                                    ->columnSpan('full'),

                                Select::make('category')
                                    ->label(__('filament::resources.inputs.category'))
                                    ->disablePlaceholderSelection()
                                    ->options(AchievementCategory::toInput())
                            ]),

                        Tabs\Tab::make(__('filament::resources.tabs.Configurations'))
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Select::make('visible')
                                    ->label(__('filament::resources.inputs.visible'))
                                    ->disablePlaceholderSelection()
                                    ->options([
                                        '1' => __('filament::resources.common.Yes'),
                                        '0' => __('filament::resources.common.No'),
                                    ]),

                                Select::make('reward_type')
                                    ->label(__('filament::resources.inputs.reward_type'))
                                    ->disablePlaceholderSelection()
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
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament::resources.columns.id')),

                HabboBadgeColumn::make('badge')
                    ->label(__('filament::resources.columns.badge'))
                    ->searchable(),

                TextColumn::make('name')
                    ->label(__('filament::resources.columns.name'))
                    ->searchable(),

                TextColumn::make('level')
                    ->label(__('filament::resources.columns.level')),

                BadgeColumn::make('category')
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
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewAchievement::route('/{record}'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
