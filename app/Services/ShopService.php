<?php

namespace App\Services;

use App\Models\Room;
use App\Models\User;
use App\Enums\CurrencyType;
use App\Enums\NotificationType;
use App\Models\ItemDefinition;
use App\Models\User\UserOrder;
use App\Models\ShopProductItem;
use App\Enums\ShopProductItemType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ShopController;
use App\Models\Permission;

class ShopService
{
    public static function deliver(
        User $user,
        UserOrder $order
    ): void {
        $product = $order->product;
        $hasError = false;

        if($order->is_delivered) {
            if(ShopController::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[DELIVER] Order already delivered.', [
                    'user' => $user->username,
                    'order' => $product->name,
                ]);
            }

            return;
        }

        if(!$product) {
            if(ShopController::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[DELIVER] Order product not found.', [
                    'user' => $user->username,
                    'order' => $product->name,
                ]);
            }

            return;
        }

        if($user->online) {
            if(ShopController::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[DELIVER] User is online.', [
                    'user' => $user->username,
                    'order' => $product->name,
                ]);
            }

            return;
        }

        if($product->items->isEmpty()) {
            if(ShopController::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[DELIVER] Order product items not found.', [
                    'user' => $user->username,
                    'order' => $product->name,
                ]);
            }

            return;
        }

        $product->items->each(function(ShopProductItem $item) use ($user, &$hasError) {
            self::treatProductDeliverWithoutRcon($user, $item, $hasError);
        });

        if($hasError) {
            if(ShopController::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[DELIVER] An error occurred while delivering the order. The order was not marked as delivered!', [
                    'user' => $user->username,
                    'order' => $product->name,
                ]);

                return;
            }
        }

        $user->notify(null, NotificationType::ProductDelivered, null);

        $order->update([
            'is_delivered' => true
        ]);
    }

    public static function treatProductDeliverWithoutRcon(User $user, ShopProductItem $item, bool &$hasError): void
    {
        if($item->type === ShopProductItemType::Currency) {
            $currency = CurrencyType::fromCurrencyName($item->data);

            if(!$currency) {
                if(ShopController::ENABLE_ERRORS_LOG) {
                    Log::driver('shop')->error('[DELIVER] Order product item currency not found.', [
                        'user' => $user->username,
                        'item' => $item,
                    ]);

                    $hasError = true;
                }

                return;
            }

            $user->incrementCurrency($currency, $item->quantity);
            return;
        }

        if($item->type === ShopProductItemType::Badge) {
            $user->badges()->updateOrCreate([
                'badge_code' => $item->data
            ]);

            return;
        }

        if($item->type === ShopProductItemType::Furniture) {
            $itemDefinition = ItemDefinition::whereItemName($item->data)->first();

            if(!$itemDefinition) {
                if(ShopController::ENABLE_ERRORS_LOG) {
                    Log::driver('shop')->error('[DELIVER] Order product item furniture not found.', [
                        'user' => $user->username,
                        'item' => $item,
                    ]);

                    $hasError = true;
                }

                return;
            }

            $user->addItem($itemDefinition, $item->quantity);
        }

        if($item->type === ShopProductItemType::Room) {
            $room = Room::find($item->data);

            if(!$room) {
                if(ShopController::ENABLE_ERRORS_LOG) {
                    Log::driver('shop')->error('[DELIVER] Order product item room not found.', [
                        'user' => $user->username,
                        'item' => $item,
                    ]);

                    $hasError = true;
                }

                return;
            }

            $room->replicateForUser($user);
        }

        if($item->type === ShopProductItemType::Rank) {
            $rank = Permission::find($item->data);

            if(!$rank) {
                if(ShopController::ENABLE_ERRORS_LOG) {
                    Log::driver('shop')->error('[DELIVER] Order product item rank not found.', [
                        'user' => $user->username,
                        'item' => $item,
                    ]);

                    $hasError = true;
                }

                return;
            }

            $user->rank = $rank->id;
            $user->save();
        }
    }
}
