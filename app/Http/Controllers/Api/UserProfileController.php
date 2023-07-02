<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\HomeItemType;
use Illuminate\Http\Request;
use App\Models\Home\UserHomeItem;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function getInventory(string $username): JsonResponse
    {
        if (!$user = User::whereUsername($username)->first()) {
            return $this->jsonResponse([
                'message' => __('User not found')
            ], 404);
        }

        $allInventoryItems = $user->inventoryHomeItems()
            ->latest()
            ->get();

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
