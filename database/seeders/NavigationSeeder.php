<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Navigation::count() && !$this->command->confirm(
            'It was detected that your database already has navigations, are you sure you want to generate them again?'
        )) return;

        $allNavigations = $this->getDefaultNavigations();

        collect($allNavigations)->each(function ($navigation, $navigationName) {
            tap(Navigation::updateOrCreate(
                array_merge(['label' => $navigationName], $navigation['data'])
            ), function($navInstance) use ($navigation) {
                foreach($navigation['subNavigations'] as $label => $subNavigationName) {
                    if(is_string($subNavigationName)) {
                        $navInstance->subNavigations()->updateOrCreate(['label' => $subNavigationName]);
                        continue;
                    }

                    $navInstance->subNavigations()
                        ->updateOrCreate([
                            'label' => $label,
                            'slug' => $subNavigationName['slug'] ?? null,
                            'new_tab' => $subNavigationName['newTab'] ?? false,
                        ]);
                }
            });
        });
    }

    public function getDefaultNavigations(): array
    {
        return [
            'Home' => [
                'data' => $this->makeNavigationData('/', 'https://i.imgur.com/FFql1oZ.gif', 0),
                'subNavigations' => [],
            ],
            'Community' => [
                'data' => $this->makeNavigationData('/community', 'https://i.imgur.com/dTeCegt.png', 1),
                'subNavigations' => [
                    'Articles' => ['slug' => '/articles'],
                    'Staff' => ['slug' => '/community/staff'],
                    'Photos' => ['slug' => '/community/photos'],
                    'Teams' => ['slug' => '/community/teams'],
                ]
            ],
            'Leaderboards' => [
                'data' => $this->makeNavigationData('/community/rankings', 'https://imgur.com/NiNsGW4.png', 2),
                'subNavigations' => [],
            ],
            'About' => [
                'data' => $this->makeNavigationData('/about', 'https://imgur.com/AdmVS6p.png', 3),
                'subNavigations' => [
                    'Discord' => ['slug' => '/about/discord', 'newTab' => true],
                    'Safety' => ['slug' => '/about/safety'],
                ],
            ],
            'Shop' => [
                'data' => $this->makeNavigationData('/shop', 'https://i.imgur.com/6Z1Noci.gif', 4),
                'subNavigations' => [],
            ],
        ];
    }

    private function makeNavigationData(
        string $slug,
        string $icon,
        int $order
    ): array {
        return [
            'slug' => $slug,
            'icon' => $icon,
            'order' => $order
        ];
    }
}
