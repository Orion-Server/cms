<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class JailController extends Controller
{
    public function show(Request $request): View
    {
        return view('pages.jail', [
            'ban' => $request->get('ban')
        ]);
    }
}
