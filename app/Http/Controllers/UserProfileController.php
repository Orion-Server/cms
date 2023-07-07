<?php

namespace App\Http\Controllers;

use App\Models\Home\HomeItem;
use App\Models\User;
use App\Services\ProfileService;
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
            'user' => User::whereUsername($username)->first(),
            'isMe' => $username === \Auth::user()?->username
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
                'message' => __('Home item not found.')
            ], 404);
        }

        $user = \Auth::user();
        $totalPrice = $item->price * $data['quantity'];

        if($item->limit && $item->exceededPurchaseLimit()) {
            return $this->jsonResponse([
                'message' => __('This item exceeded the purchase limit.')
            ], 400);
        }

        if($item->limit && (($item->total_bought + $data['quantity']) > $item->limit)) {
            return $this->jsonResponse([
                'message' => __("You can't buy more than :max of this item.", ['max' => $item->limit - $item->total_bought])
            ], 400);
        }

        if($totalPrice > $user->currency($item->currency_type)) {
            return $this->jsonResponse([
                'message' => __("You don't have enough :c to buy this item.", ['c' => strtolower(__($item->currency_type->name))])
            ], 400);
        }

        try {
            ProfileService::buyItemForUser($user, $item, $data, $totalPrice);
        } catch (\Throwable $exception) {
            return $this->jsonResponse([
                'message' => $exception->getMessage()
            ], 500);
        }

        return $this->jsonResponse([
            'message' => __('You have successfully bought :quantity items.', ['quantity' => $data['quantity']])
        ]);
    }
}
