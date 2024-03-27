<?php

namespace App\Http\Controllers;

use App\Enums\NotificationState;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->withSender()
            ->latest()
            ->get();

        $notifications->each->update([
            'state' => NotificationState::Seen
        ]);

        return $this->jsonResponse([
            'notifications' => $notifications
        ]);
    }

    public function count()
    {
        return $this->jsonResponse([
            'unread_count' => Auth::user()->notifications()
                ->unread()
                ->count()
        ]);
    }
}
