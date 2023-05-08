<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\ClientService;

class ClientController extends Controller
{
    public function nitroClient(): View
    {
        return view('pages.client.nitro', [
            'nitroClientUrl' => sprintf('%s/index.html', config('hotel.client.nitro.path')),
            'authTicket' => ClientService::updateAndGetAuthTicket()
        ]);
    }
}
