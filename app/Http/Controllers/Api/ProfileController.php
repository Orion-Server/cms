<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\HomeItemType;
use App\Models\Home\HomeItem;
use App\Models\Home\HomeCategory;
use App\Models\Home\UserHomeItem;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function getShopCategories(): JsonResponse
    {
        return $this->jsonResponse([
            'categories' => HomeCategory::orderBy('order')->get()->values()
        ]);
    }

    public function getShopItemsByCategory(string $categoryId): JsonResponse
    {
        $category = HomeCategory::with([
            'homeItems' => fn ($query) => $query->orderBy('order')->whereType(HomeItemType::Sticker)
        ])->whereId($categoryId)->first();

        if (!$category) {
            return $this->jsonResponse([
                'message' => __('Category not found')
            ], 404);
        }

        return $this->jsonResponse([
            'items' => $category->homeItems->values()
        ]);
    }

    public function getShopItemsByType(string $categoryType): JsonResponse
    {
        $firstCategoryLetter = substr($categoryType, 0, 1);

        if(!$firstCategoryLetter || ! in_array($firstCategoryLetter, HomeItemType::values(HomeItemType::Sticker))) {
            return $this->jsonResponse([
                'message' => __('Category not found')
            ], 404);
        }

        return $this->jsonResponse([
            'items' => HomeItem::whereType($firstCategoryLetter)->orderBy('order')->get()->values()
        ]);
    }

    public function getUserInventory(string $username): JsonResponse
    {
        if (!$user = User::whereUsername($username)->first()) {
            return $this->jsonResponse([
                'message' => __('User not found')
            ], 404);
        }

        $allInventoryItems = $user->groupedInventoryItems()->get();

        $filterByType = fn ($type) => $allInventoryItems->filter(
            fn (UserHomeItem $item) => $item->homeItem?->type === $type->value
        )->values();

        return $this->jsonResponse([
            'inventory' => [
                'stickers' => $filterByType(HomeItemType::Sticker),
                'notes' => $filterByType(HomeItemType::Note),
                'widgets' => $filterByType(HomeItemType::Widget),
                'backgrounds' => $filterByType(HomeItemType::Background)
            ]
        ]);
    }
}
