<?php

namespace App\Services;

use App\Models\User;
use App\Models\Home\HomeItem;
use Illuminate\Support\Facades\DB;
use App\Services\Profile\InteractWithWidgets;
use App\Services\Profile\HasProfileTransactions;

class ProfileService
{
    use HasProfileTransactions,
        InteractWithWidgets;

    public function verifyPurchasePossibility(User $user, HomeItem $item, array $data, int $totalPrice): void
    {
        if($user->online) {
            throw new \Exception(__('You must be offline to buy this item.'));
        }

        if ($item->limit && $item->exceededPurchaseLimit()) {
            throw new \Exception(__('This item exceeded the purchase limit.'));
        }

        if ($item->limit && (($item->total_bought + $data['quantity']) > $item->limit)) {
            throw new \Exception(__("You can't buy more than :max of this item.", ['max' => $item->limit - $item->total_bought]));
        }

        if ($totalPrice > $user->currency($item->currency_type)) {
            throw new \Exception(__("You don't have enough :c to buy this item.", ['c' => strtolower(__($item->currency_type->name))]));
        }

        if(in_array($item->type, ['b', 'w']) && $user->homeItems()->where('home_item_id', $item->id)->exists()) {
            throw new \Exception(__('You already have this item in your inventory.'));
        }

        if(in_array($item->type, ['b', 'w']) && $data['quantity'] > 1) {
            throw new \Exception(__('You can buy this item only once.'));
        }
    }

    public function getLatestPurchaseItemIds(User $user, HomeItem $item, int $quantity): array
    {
        $query = "SELECT hi.id, hi.type, hi.name, hi.image, uhi.home_item_id, JSON_ARRAYAGG(uhi.id) AS item_ids
            FROM (
                SELECT home_item_id, id
                FROM user_home_items
                WHERE user_id = ?
                AND user_id IS NOT NULL
                AND placed = ?
                AND home_item_id = ?
                ORDER BY id DESC
                LIMIT ?
            ) AS uhi
        JOIN home_items hi ON hi.id = uhi.home_item_id
        GROUP BY hi.id, hi.type, hi.name, hi.image, uhi.home_item_id";

        $queryResult = DB::select($query, [$user->id, 0, $item->id, $quantity]);

        if(empty($queryResult)) return [];

        return array_map(function ($item) {
            return [
                'home_item_id' => $item->home_item_id,
                'item_ids' => json_decode($item->item_ids),
                'home_item' => [
                    'id' => $item->id,
                    'type' => $item->type,
                    'name' => $item->name,
                    'image' => $item->image,
                ],
            ];
        }, $queryResult);
    }
}
