<?php

namespace App\Services;

use App\Enums\CurrencyType;
use App\Enums\ShopProductItemType;
use App\Models\User;
use App\Models\User\UserOrder;
use App\Models\ShopProductItem;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Log;

class ShopService
{
    public static function deliver(
        User $user,
        UserOrder $order
    ): void {
        $product = $order->product;
        $hasError = false;

        if(!$product) {
            if(ShopController::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[DELIVER] Order product not found.', [
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

        $product->items->each(function(ShopProductItem $item) use ($user, $product, &$hasError) {
            $rconEnabled = config('hotel.rcon.enabled');
            $rcon = app(RconService::class);

            if(!$user->online) {
                self::treatProductDeliverWithoutRcon($user, $item, $hasError);
                return;
            }

            if(!$rconEnabled) {
                if(ShopController::ENABLE_ERRORS_LOG) {
                    Log::driver('shop')->error('[DELIVER] You cannot deliver products because RCON is not enabled and the user is online.', [
                        'user' => $user->username,
                        'order' => $product->name,
                    ]);
                }

                return;
            }

            self::treatProductDeliverWithRcon($rcon, $user, $item, $hasError);
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
    }

    public static function treatProductDeliverWithRcon(RconService $rcon, User $user, ShopProductItem $item, bool &$hasError): void
    {

    }
}
