<?php

namespace Database\Seeders;

use App\Models\ShopCategory;
use Illuminate\Database\Seeder;

class ShopCategorySeeder extends Seeder
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
                'Rares',
                'https://i.imgur.com/miq0Aiv.png'
            ],
            [
                'Diamonds',
                'https://i.imgur.com/dmmnI18.png'
            ],
            [
                'Seasonal Points',
                'https://i.imgur.com/uGY9pbm.png'
            ],
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getDefaultSettings() as $setting) {
            [$name, $icon] = $setting;

            ShopCategory::firstOrCreate(['name' => $name], [
                'icon' => $icon
            ]);
        }
    }
}
