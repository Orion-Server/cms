<?php

namespace Database\Seeders\Compositions;

use App\Models\Home\HomeCategory;
use Database\Seeders\Compositions\Home\{
    HasAlhambraCategoryData,
    HasArtistsCategoryData,
    HasBackgroundsCategoryData,
    HasBlingAlphabetCategoryData,
    HasButtonsCategoryData,
    HasCineCategoryData,
    HasClampsAndRelatedCategoryData,
    HasCoinsAndRelatedCategoryData,
    HasDividersCategoryData,
    HasForestAndRelatedCategoryData,
    HasHabboweenCategoryData,
    HasKeepItRealCategoryData,
    HasPaintingsCategoryData,
    HasPlasticAlphabetCategoryData,
    HasPiratesCategoryData,
    HasSnowStormCategoryData,
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
        HasDividersCategoryData,
        HasSnowStormCategoryData,
        HasArtistsCategoryData,
        HasHabboweenCategoryData,
        HasCoinsAndRelatedCategoryData,
        HasForestAndRelatedCategoryData,
        HasClampsAndRelatedCategoryData,
        HasBackgroundsCategoryData;

    protected function buildItemStructure(
        ?HomeCategory $category,
        string $image,
        ?string $name = null,
        int $price = 5,
        string $type = 's'
    ): array {
        return [
            'type' => $type,
            'home_category_id' => $category?->id,
            'name' => $name ?? sprintf('%s %s', config('app.name'), 'Item'),
            'image' => $image,
            'price' => $price,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
