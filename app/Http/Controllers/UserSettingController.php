<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function index(string $page = 'account')
    {
        if (!in_array($page, ['account', 'password', 'ingame'])) {
            $page = 'account';
        }

        return view('pages.users.settings.index', [
            'user' => \Auth::user(),
            'page' => $page,
            'navigations' => $this->getSettingsNavigationData()
        ]);
    }

    private function getSettingsNavigationData(): array
    {
        return [
            [
                'type' => 'account',
                'title' => 'Account Preferences',
                'icon' => 'fa-regular fa-address-card'
            ],
            [
                'type' => 'password',
                'title' => 'Account Security',
                'icon' => 'fa-solid fa-key'
            ],
            [
                'type' => 'ingame',
                'title' => 'Ingame Settings',
                'icon' => 'fa-solid fa-gamepad'
            ]
        ];
    }
}
