<?php

namespace Database\Seeders;

use App\Models\CmsSetting;
use Illuminate\Database\Seeder;

class CmsSettingsSeeder extends Seeder
{
    /**
     * The default settings.
     * **Order: [key, value, comment]**
     *
     * @var array
     */
    public function getDefaultSettings(): array
    {
        return [
            [
                'hotel_name',
                'Habbo',
                'The name of the hotel'
            ],
            [
                'default_cms_mode',
                'light',
                'Determines the default CMS mode (dark/light)'
            ],
            [
                'start_credits',
                '50000',
                'The amount of credits a user starts with'
            ],
            [
                'start_duckets',
                '10000',
                'The amount of duckets a user starts with'
            ],
            [
                'start_diamonds',
                '0',
                'The amount of diamonds a user starts with'
            ],
            [
                'start_points',
                '0',
                'The amount of points a user starts with'
            ],
            [
                'start_motto',
                'I love to play Habbo hotel.',
                'The default motto a user starts with'
            ],
            [
                'figure_imager',
                'https://www.habbo.com.br/habbo-imaging/avatarimage?figure=',
                'The imager base URL to render the user look on the CMS (by figure)'
            ],
            [
                'username_imager',
                '/api/avatar/',
                'The imager base URL to render the user look on the CMS (by username)'
            ],
            [
                'start_female_look',
                'hr-540-45-61.hd-600-1-.ch-665-1408-61.lg-720-72-61.sh-730-1408-61',
                'The default look a female user starts with'
            ],
            [
                'start_male_look',
                'hr-3090-42-61.hd-180-10-61.ch-804-82-61.lg-281-1408-61.sh-295-80-61',
                'The default look a male user starts with'
            ],
            [
                'discord_invite',
                'https://discord.com/invite/Kb7USXupCT',
                'The Discord invite link to show on the CMS'
            ],
            [
                'facebook_link',
                'https://www.facebook.com/',
                'The Facebook link to show on the CMS'
            ],
            [
                'twitter_link',
                'https://twitter.com/',
                'The Twitter link to show on the CMS'
            ],
            [
                'instagram_link',
                'https://www.instagram.com/',
                'The Instagram link to show on the CMS'
            ],
            [
                'disable_registrations',
                '0',
                'Disable CMS user registrations'
            ],
            [
                'beta_period',
                '0',
                'Determines if the hotel is in the beta testing period'
            ],
            [
                'discord_widget_id',
                '1099836667780665364',
                'Hotel Discord Server ID Widget'
            ],
            [
                'register_username_regex',
                '/^[a-zA-Z0-9_.-]+$/u',
                'Determines which characters can be used in the username field when registering'
            ],
            [
                'maintenance',
                '0',
                'Determines the hotel maintenance (0 disabled, 1 enabled)'
            ],
            [
                'min_rank_to_maintenance_login',
                '5',
                'Minimum rank to login during maintenance'
            ],
            [
                'maintenance_reason',
                'Habbo is under maintenance and will undergo some improvements.',
                'Maintenance Reason (showed on the maintenance page)'
            ],
            [
                'max_accounts_per_ip',
                '4',
                'The maximum number of accounts allowed per IP.'
            ],
            [
                'vpn_protection',
                '1',
                'Enables protection against BOTs and VPN hosting services'
            ],
            [
                'start_room_id',
                '0',
                'The default room a user starts with'
            ],
            [
                'rcon_ip',
                '127.0.0.1',
                'RCON Server IP to send RCON commands'
            ],
            [
                'rcon_port',
                '3001',
                'RCON Server PORT to send RCON commands'
            ],
            [
                'min_rank_to_housekeeping_login',
                '7',
                'Minimum rank to login into housekeeping'
            ],
            [
                'badges_path',
                'https://images.habbo.com/c_images/album1584/',
                'The base URL to render the badges on the CMS'
            ],
            [
                'min_list_rank',
                '4',
                'The minimum rank to show on CMS lists (Eg. rankings, staff pages)'
            ]
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->getDefaultSettings() as $setting) {
            [$key, $value, $comment] = $setting;

            CmsSetting::firstOrCreate(['key' => $key], [
                'value' => $value,
                'comment' => $comment
            ]);
        }
    }
}
