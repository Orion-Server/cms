<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Home\HomeCategory;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Compositions\HasUserProfileData;

class HomeItemSeeder extends Seeder
{
    use HasUserProfileData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addItemForCategory('Cine');
        $this->addItemForCategory('Bling Alphabet');
        $this->addItemForCategory('Plastic Alphabet');
        $this->addItemForCategory('Wooden Alphabet');
        $this->addItemForCategory('Keep It Real');
        $this->addItemForCategory('Summer Vacation');
        $this->addItemForCategory('Pirates');
        $this->addItemForCategory('Valentine');
        $this->addItemForCategory('Buttons');
        $this->addItemForCategory('Alhambra');
        $this->addItemForCategory('Sports');
        $this->addItemForCategory('WWE');
        $this->addItemForCategory('Paintings');
        $this->addItemForCategory('Dividers');
    }

    protected function addItemForCategory(string $categoryName): void
    {
        if(!$category = HomeCategory::whereName($categoryName)->first()) return;

        $method = sprintf('get%sItemsData', str_replace(' ', '', $categoryName));

        if(!method_exists($this, $method)) return;

        DB::table('home_items')->insert($this->{$method}($category));
    }
}
