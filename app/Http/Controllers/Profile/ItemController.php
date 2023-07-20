<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Home\HomeItem;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    protected ProfileService $profileService;

    public function __construct()
    {
        $this->profileService = app(ProfileService::class);
    }

    public function store(Request $request): JsonResponse
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

        try {
            $this->profileService->verifyPurchasePossibility($user, $item, $data, $totalPrice);
            $this->profileService->buyItem($item, $user, $data, $totalPrice);
        } catch (\Throwable $exception) {
            return $this->jsonResponse([
                'message' => $exception->getMessage()
            ], 500);
        }

        return $this->jsonResponse([
            'message' => __('You have successfully bought :quantity items.', ['quantity' => $data['quantity']]),
            'items' => $this->profileService->getLatestPurchaseItemIds($user, $item, $data['quantity'])
        ]);
    }

    public function getWidgetContent(string $username, int $itemId): JsonResponse
    {
        if(!$user = User::whereUsername($username)->first()) {
            return $this->jsonResponse([
                'message' => __('User not found.')
            ], 404);
        }

        if(!$item = $user->homeItems()->defaultRelationships()->find($itemId)) {
            return $this->jsonResponse([
                'message' => __('Home item not found.')
            ], 404);
        }

        $item->setWidgetContent($user);

        return $this->jsonResponse([
            'name' => $item->homeItem->name,
            'widget_type' => $item->widget_type,
            'content' => $item->content
        ]);
    }
}
