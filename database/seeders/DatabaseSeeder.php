<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            NavigationSeeder::class,
            CmsSettingsSeeder::class,
            HomeCategorySeeder::class,
            HomeItemSeeder::class,
            TeamSeeder::class,
            ShopCategorySeeder::class,
            WriteableBoxSeeder::class,
            PermissionRoleSeeder::class,
        ]);
    }
}
