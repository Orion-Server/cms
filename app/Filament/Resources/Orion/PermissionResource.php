<?php

namespace App\Filament\Resources\Orion;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Permission;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Traits\TranslatableResource;
use App\Filament\Tables\Columns\HabboBadgeColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Orion\PermissionResource\Pages;
use App\Filament\Resources\Orion\PermissionResource\RelationManagers;
use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Support\HtmlString;

class PermissionResource extends Resource
{
    use TranslatableResource;

    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $slug = 'website/permissions';

    public static string $translateIdentifier = 'permissions';

    protected static ?string $recordTitleAttribute = 'rank_name';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        /**
         * @param string $name
         * @param bool $needsSecondOption = false
         */
        $groupedToggleButton = fn (string $name, bool $needsSecondOption = false): ToggleButtons => ToggleButtons::make($name)
            ->label(__("filament::resources.permissions.{$name}"))
            ->options(function () use ($needsSecondOption) {
                $options = [
                    '0' => __('filament::resources.options.no'),
                    '1' => __('filament::resources.options.yes'),
                ];

                if ($needsSecondOption) $options['2'] = __('filament::resources.options.rights');

                return $options;
            })
            ->icons(['0' => 'heroicon-o-check', '1' => 'heroicon-o-x-mark', '2' => 'heroicon-o-sparkles'])
            ->colors(['0' => 'danger', '1' => 'success'])
            ->grouped();

        return $form
            ->schema([
                Tabs::make('Main')
                    ->tabs([
                        Tab::make(__('filament::resources.tabs.General Information'))
                            ->schema([
                                TextInput::make('rank_name')
                                    ->label(__('filament::resources.inputs.name'))
                                    ->maxLength(25)
                                    ->required(),

                                TextInput::make('badge')
                                    ->label(__('filament::resources.inputs.badge_code'))
                                    ->maxLength(12)
                                    ->required(),

                                TextInput::make('level')
                                    ->label(__('filament::resources.inputs.level'))
                                    ->required(),

                                TextInput::make('room_effect')
                                    ->label(__('filament::resources.inputs.room_effect'))
                                    ->required()
                            ]),

                        Tab::make(__('filament::resources.tabs.In-game Permissions'))
                            ->schema([
                                Section::make(__('filament::resources.sections.permissions.title'))
                                    ->description(new HtmlString(__('filament::resources.sections.permissions.description')))
                                    ->schema([
                                        Grid::make()
                                            ->columns([
                                                'sm' => 2,
                                                'md' => 3,
                                                'lg' => 3
                                            ])
                                            ->schema([
                                                $groupedToggleButton('cmd_about'),
                                                $groupedToggleButton('cmd_alert'),
                                                $groupedToggleButton('cmd_allow_trading'),
                                                $groupedToggleButton('cmd_badge'),
                                                $groupedToggleButton('cmd_ban'),
                                                $groupedToggleButton('cmd_blockalert'),
                                                $groupedToggleButton('cmd_bots', true),
                                                $groupedToggleButton('cmd_bundle'),
                                                $groupedToggleButton('cmd_calendar'),
                                                $groupedToggleButton('cmd_changename'),
                                                $groupedToggleButton('cmd_chatcolor'),
                                                $groupedToggleButton('cmd_commands'),
                                                $groupedToggleButton('cmd_connect_camera'),
                                                $groupedToggleButton('cmd_control', true),
                                                $groupedToggleButton('cmd_coords', true),
                                                $groupedToggleButton('cmd_credits'),
                                                $groupedToggleButton('cmd_subscription'),
                                                $groupedToggleButton('cmd_danceall', true),
                                                $groupedToggleButton('cmd_diagonal', true),
                                                $groupedToggleButton('cmd_disconnect'),
                                                $groupedToggleButton('cmd_duckets'),
                                                $groupedToggleButton('cmd_ejectall', true),
                                                $groupedToggleButton('cmd_empty'),
                                                $groupedToggleButton('cmd_empty_bots'),
                                                $groupedToggleButton('cmd_empty_pets'),
                                                $groupedToggleButton('cmd_enable', true),
                                                $groupedToggleButton('cmd_event'),
                                                $groupedToggleButton('cmd_faceless'),
                                                $groupedToggleButton('cmd_fastwalk', true),
                                                $groupedToggleButton('cmd_filterword'),
                                                $groupedToggleButton('cmd_freeze'),
                                                $groupedToggleButton('cmd_freeze_bots', true),
                                                $groupedToggleButton('cmd_gift'),
                                                $groupedToggleButton('cmd_give_rank'),
                                                $groupedToggleButton('cmd_ha'),
                                                $groupedToggleButton('acc_can_stalk'),
                                                $groupedToggleButton('cmd_hal'),
                                                $groupedToggleButton('cmd_invisible', true),
                                                $groupedToggleButton('cmd_ip_ban'),
                                                $groupedToggleButton('cmd_machine_ban'),
                                                $groupedToggleButton('cmd_hand_item', true),
                                                $groupedToggleButton('cmd_happyhour'),
                                                $groupedToggleButton('cmd_hidewired', true),
                                                $groupedToggleButton('cmd_kickall', true),
                                                $groupedToggleButton('cmd_softkick'),
                                                $groupedToggleButton('cmd_massbadge'),
                                                $groupedToggleButton('cmd_roombadge'),
                                                $groupedToggleButton('cmd_masscredits'),
                                                $groupedToggleButton('cmd_massduckets'),
                                                $groupedToggleButton('cmd_massgift'),
                                                $groupedToggleButton('cmd_masspoints'),
                                                $groupedToggleButton('cmd_moonwalk', true),
                                                $groupedToggleButton('cmd_mimic'),
                                                $groupedToggleButton('cmd_multi', true),
                                                $groupedToggleButton('cmd_mute'),
                                                $groupedToggleButton('cmd_pet_info', true),
                                                $groupedToggleButton('cmd_pickall'),
                                                $groupedToggleButton('cmd_plugins'),
                                                $groupedToggleButton('cmd_points'),
                                                $groupedToggleButton('cmd_promote_offer'),
                                                $groupedToggleButton('cmd_pull', true),
                                                $groupedToggleButton('cmd_push', true),
                                                $groupedToggleButton('cmd_redeem'),
                                                $groupedToggleButton('cmd_reload_room', true),
                                                $groupedToggleButton('cmd_roomalert', true),
                                                $groupedToggleButton('cmd_roomcredits'),
                                                $groupedToggleButton('cmd_roomeffect', true),
                                                $groupedToggleButton('cmd_roomgift'),
                                                $groupedToggleButton('cmd_roomitem', true),
                                                $groupedToggleButton('cmd_roommute'),
                                                $groupedToggleButton('cmd_roompixels'),
                                                $groupedToggleButton('cmd_roompoints'),
                                                $groupedToggleButton('cmd_say', true),
                                                $groupedToggleButton('cmd_say_all', true),
                                                $groupedToggleButton('cmd_setmax', true),
                                                $groupedToggleButton('cmd_set_poll'),
                                                $groupedToggleButton('cmd_setpublic'),
                                                $groupedToggleButton('cmd_setspeed', true),
                                                $groupedToggleButton('cmd_shout', true),
                                                $groupedToggleButton('cmd_shout_all', true),
                                                $groupedToggleButton('cmd_shutdown'),
                                                $groupedToggleButton('cmd_sitdown', true),
                                                $groupedToggleButton('cmd_staffalert'),
                                                $groupedToggleButton('cmd_staffonline'),
                                                $groupedToggleButton('cmd_summon'),
                                                $groupedToggleButton('cmd_summonrank'),
                                                $groupedToggleButton('cmd_super_ban'),
                                                $groupedToggleButton('cmd_stalk'),
                                                $groupedToggleButton('cmd_superpull', true),
                                                $groupedToggleButton('cmd_take_badge'),
                                                $groupedToggleButton('cmd_talk'),
                                                $groupedToggleButton('cmd_teleport', true),
                                                $groupedToggleButton('cmd_trash'),
                                                $groupedToggleButton('cmd_transform', true),
                                                $groupedToggleButton('cmd_unban'),
                                                $groupedToggleButton('cmd_unload', true),
                                                $groupedToggleButton('cmd_unmute'),
                                                $groupedToggleButton('cmd_update_achievements'),
                                                $groupedToggleButton('cmd_update_bots'),
                                                $groupedToggleButton('cmd_update_catalogue'),
                                                $groupedToggleButton('cmd_update_config'),
                                                $groupedToggleButton('cmd_update_guildparts'),
                                                $groupedToggleButton('cmd_update_hotel_view'),
                                                $groupedToggleButton('cmd_update_items'),
                                                $groupedToggleButton('cmd_update_navigator'),
                                                $groupedToggleButton('cmd_update_permissions'),
                                                $groupedToggleButton('cmd_update_pet_data'),
                                                $groupedToggleButton('cmd_update_plugins'),
                                                $groupedToggleButton('cmd_update_polls'),
                                                $groupedToggleButton('cmd_update_texts'),
                                                $groupedToggleButton('cmd_update_wordfilter'),
                                                $groupedToggleButton('cmd_userinfo'),
                                                $groupedToggleButton('cmd_word_quiz', true),
                                                $groupedToggleButton('cmd_warp'),
                                                $groupedToggleButton('acc_anychatcolor'),
                                                $groupedToggleButton('acc_anyroomowner'),
                                                $groupedToggleButton('acc_empty_others'),
                                                $groupedToggleButton('acc_enable_others'),
                                                $groupedToggleButton('acc_see_whispers'),
                                                $groupedToggleButton('acc_see_tentchat'),
                                                $groupedToggleButton('acc_superwired'),
                                                $groupedToggleButton('acc_supporttool'),
                                                $groupedToggleButton('acc_unkickable'),
                                                $groupedToggleButton('acc_guildgate'),
                                                $groupedToggleButton('acc_moverotate'),
                                                $groupedToggleButton('acc_placefurni'),
                                                $groupedToggleButton('acc_unlimited_bots', true),
                                                $groupedToggleButton('acc_unlimited_pets', true),
                                                $groupedToggleButton('acc_hide_ip'),
                                                $groupedToggleButton('acc_hide_mail'),
                                                $groupedToggleButton('acc_not_mimiced'),
                                                $groupedToggleButton('acc_chat_no_flood'),
                                                $groupedToggleButton('acc_staff_chat'),
                                                $groupedToggleButton('acc_staff_pick'),
                                                $groupedToggleButton('acc_enteranyroom'),
                                                $groupedToggleButton('acc_fullrooms'),
                                                $groupedToggleButton('acc_infinite_credits'),
                                                $groupedToggleButton('acc_infinite_pixels'),
                                                $groupedToggleButton('acc_infinite_points'),
                                                $groupedToggleButton('acc_ambassador'),
                                                $groupedToggleButton('acc_debug'),
                                                $groupedToggleButton('acc_chat_no_limit'),
                                                $groupedToggleButton('acc_chat_no_filter'),
                                                $groupedToggleButton('acc_nomute'),
                                                $groupedToggleButton('acc_guild_admin'),
                                                $groupedToggleButton('acc_catalog_ids'),
                                                $groupedToggleButton('acc_modtool_ticket_q'),
                                                $groupedToggleButton('acc_modtool_user_logs'),
                                                $groupedToggleButton('acc_modtool_user_alert'),
                                                $groupedToggleButton('acc_modtool_user_kick'),
                                                $groupedToggleButton('acc_modtool_user_ban'),
                                                $groupedToggleButton('acc_modtool_room_info'),
                                                $groupedToggleButton('acc_modtool_room_logs'),
                                                $groupedToggleButton('acc_trade_anywhere'),
                                                $groupedToggleButton('acc_update_notifications'),
                                                $groupedToggleButton('acc_helper_use_guide_tool'),
                                                $groupedToggleButton('acc_helper_give_guide_tours'),
                                                $groupedToggleButton('acc_helper_judge_chat_reviews'),
                                                $groupedToggleButton('acc_floorplan_editor'),
                                                $groupedToggleButton('acc_camera'),
                                                $groupedToggleButton('acc_ads_background'),
                                                $groupedToggleButton('cmd_wordquiz', true),
                                                $groupedToggleButton('acc_room_staff_tags'),
                                                $groupedToggleButton('acc_infinite_friends'),
                                                $groupedToggleButton('acc_mimic_unredeemed'),
                                                $groupedToggleButton('cmd_update_youtube_playlists'),
                                                $groupedToggleButton('cmd_add_youtube_playlist'),
                                                $groupedToggleButton('acc_mention', true),
                                                $groupedToggleButton('cmd_setstate', true),
                                                $groupedToggleButton('cmd_buildheight', true),
                                                $groupedToggleButton('cmd_setrotation', true),
                                                $groupedToggleButton('cmd_sellroom', true),
                                                $groupedToggleButton('cmd_buyroom', true),
                                                $groupedToggleButton('cmd_pay', true),
                                                $groupedToggleButton('cmd_kill', true),
                                                $groupedToggleButton('cmd_hoverboard', true),
                                                $groupedToggleButton('cmd_kiss', true),
                                                $groupedToggleButton('cmd_hug', true),
                                                $groupedToggleButton('cmd_welcome', true),
                                                $groupedToggleButton('cmd_disable_effects', true),
                                                $groupedToggleButton('cmd_brb', true),
                                                $groupedToggleButton('cmd_nuke', true),
                                                $groupedToggleButton('cmd_slime', true),
                                                $groupedToggleButton('cmd_explain', true),
                                                $groupedToggleButton('cmd_closedice', true),
                                                $groupedToggleButton('acc_closedice_room', true),
                                                $groupedToggleButton('cmd_set', true),
                                                $groupedToggleButton('cmd_furnidata'),
                                                $groupedToggleButton('kiss_cmd', true),
                                                $groupedToggleButton('acc_calendar_force'),
                                                $groupedToggleButton('cmd_update_calendar'),
                                            ])
                                    ]),

                            ]),

                        Tab::make(__('filament::resources.tabs.Configurations'))
                            ->schema([
                                Grid::make(['default' => 2])
                                    ->schema([
                                        Select::make('log_commands')
                                            ->label(__('filament::resources.inputs.log_commands'))
                                            ->columnSpanFull()
                                            ->options([
                                                '0' => __('filament::resources.options.no'),
                                                '1' => __('filament::resources.options.yes'),
                                            ]),

                                        TextInput::make('prefix')
                                            ->label(__('filament::resources.inputs.prefix'))
                                            ->maxLength(5),

                                        ColorPicker::make('prefix_color')
                                            ->label(__('filament::resources.inputs.prefix_color')),

                                        TextInput::make('description')
                                            ->columnSpanFull()
                                            ->maxLength(255)
                                            ->label(__('filament::resources.inputs.description'))
                                            ->nullable(),

                                        Toggle::make('is_hidden')
                                            ->label(__('filament::resources.inputs.is_hidden'))
                                            ->columnSpanFull(),

                                        Section::make()
                                            ->schema([
                                                Grid::make()
                                                    ->columns([
                                                        'md' => 2
                                                    ])
                                                    ->schema([
                                                        TextInput::make('auto_credits_amount')
                                                            ->columnSpan(1)
                                                            ->label(__('filament::resources.inputs.auto_credits_amount'))
                                                            ->required(),

                                                        TextInput::make('auto_pixels_amount')
                                                            ->label(__('filament::resources.inputs.auto_pixels_amount'))
                                                            ->required(),

                                                        TextInput::make('auto_gotw_amount')
                                                            ->label(__('filament::resources.inputs.auto_gotw_amount'))
                                                            ->required(),

                                                        TextInput::make('auto_points_amount')
                                                            ->label(__('filament::resources.inputs.auto_points_amount'))
                                                            ->required(),
                                                    ])
                                            ])
                                    ])
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString()
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
                    ->alignCenter()
                    ->label(__('filament::resources.columns.image')),

                TextColumn::make('rank_name')
                    ->label(__('filament::resources.columns.name'))
                    ->description(fn (Model $record) => \Str::limit($record->description, 40))
                    ->tooltip(function (Model $record): ?string {
                        $description = $record->description;

                        if (strlen($description) <= 40) return null;

                        return $description;
                    })
                    ->searchable(),

                TextColumn::make('prefix')
                    ->label(__('filament::resources.columns.prefix'))
                    ->description(fn (Model $record) => $record->prefix_color)
                    ->searchable(),

                ToggleColumn::make('is_hidden')
                    ->label(__('filament::resources.columns.is_hidden')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'view' => Pages\ViewPermission::route('/{record}'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
            'roles' => Pages\EditPermissionRoles::route('/{record}/roles'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        $action = \Str::after($page->getName(), 'permission-resource.pages.');

        if(str_starts_with($action, 'view')) return [];

        return $page->generateNavigationItems([
            Pages\EditPermission::class,
            Pages\EditPermissionRoles::class
        ]);
    }
}
