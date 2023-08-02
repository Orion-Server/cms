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
            'user' => User::select('id', 'username')->whereUsername($username)->first(),
            'isMe' => $username === \Auth::user()?->username
        ]);
    }

    public function getPlacedItems(string $username): JsonResponse
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
}
