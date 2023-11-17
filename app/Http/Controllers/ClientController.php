<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\ClientService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        app('debugbar')->disable();
    }

    public function nitro(): View
    {
        if(!config('hotel.client.nitro.enabled')) {
            throw new AuthorizationException(__('Nitro client is disabled.'));
        }

        return view('pages.client.nitro', [
            'nitroClientUrl' => sprintf('%s/index.html', config('hotel.client.nitro.path')),
            'authTicket' => ClientService::updateAndGetAuthTicket()
        ]);
    }

    public function flash(): View
    {
        if(!config('hotel.client.flash.enabled')) {
            throw new AuthorizationException(__('Flash client is disabled.'));
        }

        return view('pages.client.flash', [
            'authTicket' => ClientService::updateAndGetAuthTicket()
        ]);
    }

    public function clientErrors(Request $request)
    {
        if(!Auth::check()) {
            return redirect()->route('index');
        }

        if(Auth::user()->rank < getSetting('min_rank_to_view_client_errors', 7)) {
            return redirect()->route('index');
        }

        return response()->json([
            'flash_version' => $request->input('flash_version'),
            'system' => $request->input('system'),
            'description' => $request->input('error_desc'),
        ]);
    }
}
