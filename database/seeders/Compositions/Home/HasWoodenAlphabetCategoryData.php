<?php

namespace Database\Seeders\Compositions\Home;

use App\Models\Home\HomeCategory;

trait HasWoodenAlphabetCategoryData
{
    public function getWoodenAlphabetItemsData(HomeCategory $category): array
    {
        return [
            $this->buildItemStructure($category, 'https://imgur.com/rD9xRtS', 'Wooden A'),
            $this->buildItemStructure($category, 'https://imgur.com/ugX8JU4', 'Wooden A with Circle'),
            $this->buildItemStructure($category, 'https://imgur.com/jXTAUQ1', 'Wooden A with Dots'),
            $this->buildItemStructure($category, 'https://imgur.com/oDTz7SH', 'Wooden B'),
            $this->buildItemStructure($category, 'https://imgur.com/mve4r4L', 'Wooden C'),
            $this->buildItemStructure($category, 'https://imgur.com/7I8oh6q', 'Wooden D'),
            $this->buildItemStructure($category, 'https://imgur.com/AX7Bz81', 'Wooden E'),
            $this->buildItemStructure($category, 'https://imgur.com/39GJPuX', 'Wooden F'),
            $this->buildItemStructure($category, 'https://imgur.com/7eVZTkg', 'Wooden G'),
            $this->buildItemStructure($category, 'https://imgur.com/3sWi7A6', 'Wooden H'),
            $this->buildItemStructure($category, 'https://imgur.com/ci1S3st', 'Wooden I'),
            $this->buildItemStructure($category, 'https://imgur.com/egGtdgX', 'Wooden J'),
            $this->buildItemStructure($category, 'https://imgur.com/B5LRzQO', 'Wooden K'),
            $this->buildItemStructure($category, 'https://imgur.com/Mp5CEjG', 'Wooden L'),
            $this->buildItemStructure($category, 'https://imgur.com/nw48Hw0', 'Wooden M'),
            $this->buildItemStructure($category, 'https://imgur.com/2FBwCKd', 'Wooden N'),
            $this->buildItemStructure($category, 'https://imgur.com/1gNTqGa', 'Wooden O'),
            $this->buildItemStructure($category, 'https://imgur.com/iGAT7gk', 'Wooden O with Dots'),
            $this->buildItemStructure($category, 'https://imgur.com/tjn6zIl', 'Wooden P'),
            $this->buildItemStructure($category, 'https://imgur.com/fDi4M4C', 'Wooden Q'),
            $this->buildItemStructure($category, 'https://imgur.com/dj9hXeu', 'Wooden R'),
            $this->buildItemStructure($category, 'https://imgur.com/R0qgK7b', 'Wooden S'),
            $this->buildItemStructure($category, 'https://imgur.com/ZUbxiV5', 'Wooden T'),
            $this->buildItemStructure($category, 'https://imgur.com/S3aMyFu', 'Wooden U'),
            $this->buildItemStructure($category, 'https://imgur.com/Tu4j5p8', 'Wooden V'),
            $this->buildItemStructure($category, 'https://imgur.com/pffbyYo', 'Wooden W'),
            $this->buildItemStructure($category, 'https://imgur.com/gxs4vZI', 'Wooden X'),
            $this->buildItemStructure($category, 'https://imgur.com/UwFJRtb', 'Wooden Y'),
            $this->buildItemStructure($category, 'https://imgur.com/E0BvzIr', 'Wooden Z'),
            $this->buildItemStructure($category, 'https://imgur.com/lVgO0LQ', 'Wooden Exclamation'),
            $this->buildItemStructure($category, 'https://imgur.com/e6XshAT', 'Wooden Ascent 1'),
            $this->buildItemStructure($category, 'https://imgur.com/0VqdtYy', 'Wooden Ascent 2'),
            $this->buildItemStructure($category, 'https://imgur.com/ei91H19', 'Wooden Dot'),
            $this->buildItemStructure($category, 'https://imgur.com/UodfiS8', 'Wooden Question'),
            $this->buildItemStructure($category, 'https://imgur.com/i4h1loB', 'Wooden Comma'),
            $this->buildItemStructure($category, 'https://imgur.com/IjSVdCR', 'Wooden Underscore'),
        ];
    }
}
