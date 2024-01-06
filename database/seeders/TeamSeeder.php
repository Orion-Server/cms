<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
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
                'Wired Programming',
                'ADM',
                'The Wired Programming team is responsible for creating games and in-game systems.'
            ],
            [
                'Promoters',
                'ADM',
                'Responsible for promoting the hotel.'
            ],
            [
                'Helpers',
                'ADM',
                'Responsible for helping users in the hotel.'
            ],
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getDefaultSettings() as $setting) {
            [$name, $badge, $description] = $setting;

            Team::firstOrCreate(['name' => $name], [
                'badge' => $badge,
                'description' => $description
            ]);
        }
    }
}
