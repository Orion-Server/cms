<?php

namespace Database\Seeders;

use App\Models\WriteableBox;
use Illuminate\Database\Seeder;

class WriteableBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(WriteableBox::count() && !$this->command->confirm(
            'It was detected that your database already has writeable boxes, are you sure you want to generate them again?', false
        )) return;

        $boxes = [
            [
                'icon' => 'https://i.imgur.com/yTNQDwp.png',
                'name' => 'Staff Team',
                'description' => 'Responsible for monitoring!',
                'page_target' => 'staff',
                'is_active' => true,
                'content' => 'Our staff team is always active to help you.',
            ],
            [
                'icon' => 'https://i.imgur.com/zLEFQEq.png',
                'name' => 'Shop',
                'description' => 'Buy your items here',
                'page_target' => 'shop',
                'is_active' => true,
                'content' => 'We have a wide variety of items for you to buy.',
            ],
            [
                'icon' => 'https://i.imgur.com/Yi1ty7r.png',
                'name' => 'Teams',
                'description' => 'They are always active to help.',
                'page_target' => 'teams',
                'is_active' => true,
                'content' => 'Our teams are always active to help you.',
            ],
        ];

        foreach ($boxes as $box) {
            WriteableBox::create($box);
        }
    }
}
