<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function index()
    {
        return $this->jsonResponse([
            'notifications' => Auth::user()->notifications()->latest()->get()
        ]);
    }

    public function count()
    {
        return $this->jsonResponse([
            'unread_count' => Auth::user()->notifications()->unread()->count()
        ]);
    }
}
