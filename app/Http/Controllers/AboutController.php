<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function discordInvite(): RedirectResponse
    {
        return redirect()->away(getSetting('discord_invite'));
    }

    public function safety(): View
    {
        return view('pages.about.safety');
    }
}
