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
        $allNavigations = $this->getDefaultNavigations();

        collect($allNavigations)->each(function ($navigation, $navigationName) {
            tap(Navigation::create(
                array_merge(['label' => $navigationName], $navigation['data'])
            ), function($navInstance) use ($navigation) {
                foreach($navigation['subNavigations'] as $key => $subNavigationName) {
                    if(is_string($subNavigationName)) {
                        $navInstance->subNavigations()->create(['label' => $subNavigationName]);
                        continue;
                    }

                    $navInstance->subNavigations()
                        ->create([
                            'label' => $key,
                            'slug' => $subNavigationName['slug'] ?? null,
                        ]);
                }
            });
        });
    }

    public function getDefaultNavigations(): array
    {
        return [
            'Home' => [
                'data' => $this->makeNavigationData('/', 'home.gif', 0),
                'subNavigations' => [],
            ],
            'Community' => [
                'data' => $this->makeNavigationData('/community', 'community.png', 1),
                'subNavigations' => [
                    'Staff' => ['slug' => '/community/staff'],
                    'Rankings',
                    'Photos' => ['slug' => '/community/photos']
                ]
            ],
            'Forum' => [
                'data' => $this->makeNavigationData('/forum', 'forum.gif', 2),
                'subNavigations' => [
                    'Access',
                    'Rules',
                    'Achievements',
                    'Rankings',
                    'Levels'
                ]
            ],
            'Shop' => [
                'data' => $this->makeNavigationData('/shop', 'shop.gif', 3),
                'subNavigations' => [],
            ],
            'Radio' => [
                'data' => $this->makeNavigationData('/radio', 'radio.gif', 4),
                'subNavigations' => [
                    'Schedules',
                    'Join Us'
                ]
            ]
        ];
    }

    private function makeNavigationData(
        string $slug,
        string $icon,
        int $order
    ): array {
        return [
            'slug' => $slug,
            'icon' => "assets/images/icons/small/$icon",
            'order' => $order
        ];
    }
}
