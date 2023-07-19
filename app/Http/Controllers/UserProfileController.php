<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\HomeItemType;
use Illuminate\Http\Request;
use App\Models\Home\HomeItem;
use App\Services\ProfileService;
use App\Models\Home\UserHomeItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct()
    {
        $this->profileService = app(ProfileService::class);
    }

    public function show(string $username): RedirectResponse|View
    {
        return view('pages.users.profile.show', [
            'user' => User::whereUsername($username)->first(),
            'isMe' => $username === \Auth::user()?->username
        ]);
    }

    public function getUserHomeItems(string $username): JsonResponse
    {
        if (!$user = User::whereUsername($username)->first()) {
            return $this->jsonResponse([
                'message' => __('User not found')
            ], 404);
        }

        $allPlacedItems = $user->placedHomeItems()
            ->defaultRelationships(true)
            ->get();

        $filterByType = fn ($type) => $allPlacedItems->filter(
            fn (UserHomeItem $item) => $item->homeItem?->type === $type->value
        )->values();

        $notes = $filterByType(HomeItemType::Note)
            ->each(fn (UserHomeItem $item) => $item->setParsedData());

        $widgets = $filterByType(HomeItemType::Widget)
            ->each(fn (UserHomeItem $item) => $item->setWidgetContent($user));

        return $this->jsonResponse([
            'activeBackground' => $filterByType(HomeItemType::Background)->first(),
            'items' => $widgets->concat($notes)->concat($filterByType(HomeItemType::Sticker))
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

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'items.*.id' => 'required|integer',
            'items.*.x' => 'required|integer',
            'items.*.y' => 'required|integer',
            'items.*.z' => 'required|integer',
            'items.*.is_reversed' => 'nullable|boolean',
            'items.*.theme' => 'nullable|string',
            'items.*.placed' => 'nullable|boolean',
            'items.*.extra_data' => 'nullable|string',
            'backgroundId' => 'required|integer',
        ]);

        $user = \Auth::user();

        try {
            $this->profileService->saveItems($user, $data);
        } catch (\Throwable $ignored) {
            return $this->jsonResponse([
                'message' => __('An error occurred while saving your profile.')
            ], 500);
        }

        return $this->jsonResponse([
            'message' => __('Profile saved successfully.'),
            'href' => route('users.profile.show', $user->username)
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
