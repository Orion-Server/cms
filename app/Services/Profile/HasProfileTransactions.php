<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Models\Home\HomeItem;
use App\Models\Home\UserHomeItem;
use Illuminate\Support\Facades\DB;
use App\Services\PreventXssService;

trait HasProfileTransactions
{
    public function buyItem(HomeItem $item, User $user, array $data, int $totalPrice): void
    {
        DB::transaction(function () use ($user, $item, $data, $totalPrice) {
            $user->discountCurrency($item->currency_type, $totalPrice);
            $user->giveHomeItem($item, $data['quantity']);
        });
    }

    public function saveItems(User $user, array $data): void
    {
        if (isset($data['backgroundId']) && $background = $user->inventoryHomeItems()->find($data['backgroundId'])) {
            $user->changeProfileBackground($background);
        }

        if (!isset($data['items']) || count($data['items']) < 1) return;

        $itemsCollection = collect($data['items']);

        $allItemsInstance = $user->homeItems()
            ->defaultRelationships()
            ->whereIn('id', $itemsCollection->pluck('id'))
            ->get();

        DB::transaction(function () use ($itemsCollection, $allItemsInstance) {
            $allItemsInstance->each(function (UserHomeItem $item) use ($itemsCollection) {
                $itemData = $itemsCollection->where('id', $item->id)->first();

                $item->placed = (bool) $itemData['placed'] ?? $item->placed;
                $item->x = (int) $itemData['x'] ?? $item->x;
                $item->y = (int) $itemData['y'] ?? $item->y;
                $item->z = (int) $itemData['z'] ?? $item->z;
                $item->is_reversed = (bool) $itemData['is_reversed'] ?? $item->is_reversed;
                $item->theme = $itemData['theme'] ?? $item->homeItem->getDefaultTheme();

                $item->extra_data = isset($itemData['extra_data']) && $itemData['extra_data']
                    ? PreventXssService::sanitize($itemData['extra_data'])
                    : $item->extra_data;

                if(!$item->placed && $item->homeItem->type == 'n') {
                    $item->extra_data = '';
                }

                if (!$item->isDirty()) return;

                $item->save();
            });
        });
    }
}
