<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Home\HomeItem;
use App\Services\ProfileService;
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
            $this->profileService->checkPurchasePossibility($user, $item, $data, $totalPrice);
            $this->profileService->buyItemForUser($user, $item, $data, $totalPrice);
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
}
