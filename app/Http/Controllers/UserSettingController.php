<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\RconService;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserSettingController extends Controller
{
    public function index(Request $request, string $page = 'ingame'): View|JsonResponse
    {
        if (!in_array($page, ['account', 'password', 'ingame', '2fa'])) {
            $page = 'ingame';
        }

        if ($request->isMethod('POST')) {
            return $this->treatUpdateSettings($request, $page);
        }

        /** @var User $user */
        $user = Auth::user();

        $settingsVariables = [
            'user' => $user,
            'page' => $page,
            'navigations' => $this->getSettingsNavigationData()
        ];

        if($page === '2fa') $settingsVariables['twoFactorRoute'] = match (true) {
            $user->needsEnableTwoFactorAuthentication() => route('two-factor.enable'),
            $user->hasEnabledTwoFactorAuthentication() => route('two-factor.disable'),
            $user->hasIncompleteTwoFactorAuthentication() => route('two-factor.confirm'),
        };

        return view('pages.users.settings.index', $settingsVariables);
    }

    public function purchases(): View
    {
        return view('pages.users.purchases', [
            'purchases' => \Auth::user()->orders()->defaultRelationships()->latest()->paginate(10)
        ]);
    }

    public function treatUpdateSettings(Request $request, string $page): JsonResponse
    {
        $user = \Auth::user();

        $response = match ($page) {
            'account' => $this->treatUpdateAccountSettings($request, $user),
            'password' => $this->treatUpdatePasswordSettings($request, $user),
            'ingame' => $this->treatUpdateIngameSettings($request, $user),
        };

        return $this->externalJsonResponse(...$response);
    }

    private function treatUpdateAccountSettings(Request $request, User $user): array
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'mail')->ignore($user->id)],
            'referral_code' => ['nullable', 'string', 'between:3,15', Rule::unique('users', 'referral_code')->ignore($user->id)],
            'avatar_background' => ['nullable', 'string', 'url', 'max:255']
        ]);

        $user->update([
            'mail' => $data['email'],
            'referral_code' => $data['referral_code'],
            'avatar_background' => $data['avatar_background']
        ]);

        return ['type' => 'success', 'message' => __('Your account settings has been updated!')];
    }

    private function treatUpdatePasswordSettings(Request $request, User $user): array
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => \Hash::make($data['password'])
        ]);

        \Auth::logout();

        return ['type' => 'success', 'message' => __('Your password has been updated! Please, login again.')];
    }

    private function treatUpdateIngameSettings(Request $request, User $user): array
    {
        $data = $request->validate([
            'motto' => ['required', 'string', 'between:0,127'],
            'receiveFriendRequests' => ['required', 'boolean'],
            'allowFriendsFollow' => ['required', 'boolean'],
            'allowRoomInvites' => ['required', 'boolean'],
            'oldChat' => ['required', 'boolean'],
            'blockCameraFollow' => ['required', 'boolean'],
        ]);

        $hasRconEnabled = config('hotel.rcon.enabled');

        if (!$user->online) {
            $user->update([
                'motto' => $data['motto'],
            ]);

            $user->settings()->update([
                'block_friendrequests' => (bool) $data['receiveFriendRequests'] ? '0' : '1',
                'block_following' => (bool) $data['allowFriendsFollow'] ? '0' : '1',
                'block_roominvites' => (bool) $data['allowRoomInvites'] ? '0' : '1',
                'old_chat' => (bool) $data['oldChat'] ? '1' : '0',
                'block_camera_follow' => (bool) $data['blockCameraFollow'] ? '1' : '0'
            ]);

            return ['type' => 'success', 'message' => __('Your in-game settings has been updated!')];
        }

        if (!$hasRconEnabled) {
            return ['type' => 'error', 'message' => __("You can't change your in-game settings while you are online!")];
        }

        $hasRconError = false;
        $rcon = app(RconService::class);

        $rcon->sendSafely('setMotto', [$user, $data['motto']], function () use (&$hasRconError) {
            $hasRconError = true;
        });

        $rcon->sendSafely('updateUser', [$user, [
            'block_friendrequests' => (bool) $data['receiveFriendRequests'] ? 0 : 1,
            'block_following' => (bool) $data['allowFriendsFollow'] ? 0 : 1,
            'block_roominvites' => (bool) $data['allowRoomInvites'] ? 0 : 1,
            'old_chat' => (bool) $data['oldChat'] ? 1 : 0,
            'block_camera_follow' => (bool) $data['blockCameraFollow'] ? 1 : 0
        ]], function () use (&$hasRconError) {
            $hasRconError = true;
        });

        return $hasRconError
            ? ['type' => 'error', 'message' => __('An error occurred while trying to update your in-game settings!')]
            : ['type' => 'success', 'message' => __('Your in-game settings has been updated!')];
    }

    public function changeUsername(Request $request)
    {
        $data = $request->validate([
            'newUsername' => ['required', 'string', 'max:25', sprintf('regex:%s', getSetting('register_username_regex')), Rule::unique('users', 'username')->ignore(Auth::id())],
            'gender' => ['required', 'string', 'max:1', Rule::in(['M', 'F'])],
        ]);

        $user = Auth::user();

        if($user->username === $data['newUsername']) {
            $user->settings->can_change_name = false;
            $user->settings->save();

            return $this->externalJsonResponse('success', __('Your username has been updated!'));
        }

        if($user->online) {
            return $this->externalJsonResponse('error', __("You can't change your username while you are online!"));
        }

        if(!$user->settings->can_change_name) {
            return $this->externalJsonResponse('error', __("You can't change your username right now!"));
        }

        $user->rooms()->update(['owner_name' => $data['newUsername']]);

        $user->update([
            'username' => $data['newUsername'],
            'gender' => $data['gender']
        ]);

        $user->settings->can_change_name = '0';
        $user->settings->save();

        return $this->externalJsonResponse('success', __('Your username has been updated!'));
    }

    private function getSettingsNavigationData(): array
    {
        return [
            [
                'type' => 'ingame',
                'title' => __('In-game Settings'),
                'icon' => 'fa-solid fa-gamepad'
            ],
            [
                'type' => 'account',
                'title' => __('Account Preferences'),
                'icon' => 'fa-regular fa-address-card'
            ],
            [
                'type' => 'password',
                'title' => __('Account Security'),
                'icon' => 'fa-solid fa-key'
            ],
            [
                'type' => '2fa',
                'title' => __('Two-Factor Authentication'),
                'icon' => 'fa-solid fa-user-shield'
            ]
        ];
    }
}
