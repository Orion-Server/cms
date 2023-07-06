<?php

namespace App\Http\Controllers;

use App\Models\Home\HomeItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function show(string $username): RedirectResponse|View
    {
        return view('pages.users.profile.show', [
            'user' => User::whereUsername($username)->first()
        ]);
    }

    public function buyItem(Request $request): JsonResponse
    {
        $data = $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|between:1,100'
        ]);

        if(! $item = HomeItem::with('homeCategory')->find($data['item_id'])) {
            return $this->jsonResponse([
                'success' => false,
                'message' => __('Home item not found.')
            ]);
        }

        $user = \Auth::user();
        $totalPrice = $item->price * $data['quantity'];

        if($item->limit && $item->exceededPurchaseLimit()) {
            return $this->jsonResponse([
                'success' => false,
                'message' => __('This item exceeded the purchase limit.')
            ]);
        }

        if($item->limit && (($item->total_bought + $data['quantity']) > $item->limit)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => __("You can't buy more than :max of this item.", ['max' => $item->limit - $item->total_bought])
            ]);
        }

        if($totalPrice > $user->currency($item->currency_type)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => __("You don't have enough :c to buy this item.", ['c' => strtolower(__($item->currency_type->name))])
            ]);
        }

        DB::transaction(function () use ($user, $item, $data, $totalPrice) {
            $user->takeCurrency($item->currency_type, $totalPrice);
            $user->giveHomeItem($item, $data['quantity']);
        });

        return $this->jsonResponse([
            'success' => true,
            'message' => __('You have successfully bought :quantity items.', ['quantity' => $data['quantity']])
        ]);
    }
}
