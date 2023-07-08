<?php

namespace App\Services;

use App\Models\User;
use App\Models\Home\HomeItem;
use App\Services\RconService;
use App\Models\Home\UserHomeItem;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    public function checkPurchasePossibility(User $user, HomeItem $item, array $data, int $totalPrice): void
    {
        if ($item->limit && $item->exceededPurchaseLimit()) {
            throw new \Exception(__('This item exceeded the purchase limit.'));
        }

        if ($item->limit && (($item->total_bought + $data['quantity']) > $item->limit)) {
            throw new \Exception(__("You can't buy more than :max of this item.", ['max' => $item->limit - $item->total_bought]));
        }

        if ($totalPrice > $user->currency($item->currency_type)) {
            throw new \Exception(__("You don't have enough :c to buy this item.", ['c' => strtolower(__($item->currency_type->name))]));
        }
    }

    public function buyItemForUser(User $user, HomeItem $item, array $data, int $totalPrice): bool
    {
        if (!$user->online) {
            DB::transaction(function () use ($user, $item, $data, $totalPrice) {
                $user->discountCurrency($item->currency_type, $totalPrice);
                $user->giveHomeItem($item, $data['quantity']);
            });

            return true;
        }

        if (!config('hotel.rcon.enabled')) {
            throw new \Exception(__('RCON is not enabled!'));
        }

        $rcon = app(RconService::class);

        $rcon->sendSafely('giveCurrency',
            [$user, $item->currency_type?->value, $user->fresh()->currency($item->currency_type) - $totalPrice],
            fn () => throw new \Exception(__('An error occurred while connecting with RCON'))
        );

        $user->giveHomeItem($item, $data['quantity']);
    }

    public function saveItems(User $user, array $data)
    {
        if (isset($data['backgroundId']) && $background = $user->inventoryHomeItems()->find($data['backgroundId'])) {
            $user->changeProfileBackground($background);
        }

        $itemsCollection = collect($data['items']);
        $allItemsInstance = $user->homeItems()
            ->whereIn('id', $itemsCollection->pluck('id'))
            ->get();

        DB::transaction(function () use ($itemsCollection, $allItemsInstance) {
            $allItemsInstance->each(function (UserHomeItem $item) use ($itemsCollection) {
                $itemData = $itemsCollection->where('id', $item->id)->first();

                $item->update([
                    'placed' => 1,
                    'x' => (int) $itemData['x'] ?? $item->x,
                    'y' => (int) $itemData['y'] ?? $item->y,
                    'z' => (int) $itemData['z'] ?? $item->z,
                    'is_reversed' => (bool) $itemData['is_reversed'] ?? $item->is_reversed,
                    'theme' => (bool) $itemData['theme'] ?? $item->theme,
                ]);
            });
        });
    }
}
