<?php

namespace App\Services;

use App\Models\User;
use App\Models\Home\HomeItem;
use App\Services\RconService;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    public static function buyItemForUser(User $user, HomeItem $item, array $data, int $totalPrice = null): bool
    {
        if(!$user->online) {
            DB::transaction(function () use ($user, $item, $data, $totalPrice) {
                $user->discountCurrency($item->currency_type, $totalPrice);
                $user->giveHomeItem($item, $data['quantity']);
            });

            return true;
        }

        if(!config('hotel.rcon.enabled')) {
            throw new \Exception(__('RCON is not enabled!'));
        }

        $rcon = app(RconService::class);

        $rcon->sendSafely('giveCurrency',
            [$user, $item->currency_type?->value, $user->fresh()->currency($item->currency_type) - $totalPrice],
            fn () => throw new \Exception(__('An error occurred while connecting with RCON'))
        );

        $user->giveHomeItem($item, $data['quantity']);
    }
}
