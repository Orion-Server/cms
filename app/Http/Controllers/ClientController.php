<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\ClientService;

class ClientController extends Controller
{
    public function __construct()
    {
        app('debugbar')->disable();
    }

    public function nitro(): View
    {
        return view('pages.client.nitro', [
            'nitroClientUrl' => sprintf('%s/index.html', config('hotel.client.nitro.path')),
            'authTicket' => ClientService::updateAndGetAuthTicket()
        ]);
    }
}
