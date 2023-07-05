<?php

namespace Database\Seeders\Compositions;

use App\Models\Home\HomeCategory;
use Database\Seeders\Compositions\Home\{
    HasAlhambraCategoryData,
    HasBlingAlphabetCategoryData,
    HasButtonsCategoryData,
    HasCineCategoryData,
    HasDividersCategoryData,
    HasKeepItRealCategoryData,
    HasPaintingsCategoryData,
    HasPlasticAlphabetCategoryData,
    HasPiratesCategoryData,
    HasSportsCategoryData,
    HasSummerVacationCategoryData,
    HasValentineCategoryData,
    HasWoodenAlphabetCategoryData,
    HasWWECategoryData
};

trait HasUserProfileData
{
    use HasCineCategoryData,
        HasBlingAlphabetCategoryData,
        HasPlasticAlphabetCategoryData,
        HasWoodenAlphabetCategoryData,
        HasKeepItRealCategoryData,
        HasSummerVacationCategoryData,
        HasPiratesCategoryData,
        HasValentineCategoryData,
        HasButtonsCategoryData,
        HasAlhambraCategoryData,
        HasSportsCategoryData,
        HasWWECategoryData,
        HasPaintingsCategoryData,
        HasDividersCategoryData;

    protected function buildItemStructure(
        HomeCategory $category,
        string $image,
        ?string $name = null,
        int $price = 5,
        string $type = 's'
    ): array {
        return [
            'type' => $type,
            'home_category_id' => $category->id,
            'name' => $name ?? sprintf('%s %s', config('app.name'), 'Item'),
            'image' => $image,
            'price' => $price,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
