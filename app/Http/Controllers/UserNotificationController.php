<?php

namespace App\Http\Controllers;

use App\Enums\NotificationState;
use App\Models\User\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    private const NOTIFICATION_LIMIT = 10;

    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->withSender()
            ->latest()
            ->limit(self::NOTIFICATION_LIMIT)
            ->get();

        $notifications->each(function (UserNotification $notification) {
            if($notification->state != NotificationState::Unread) return;

            $notification->update([
                'state' => NotificationState::Seen
            ]);
        });

        return $this->jsonResponse([
            'notifications' => $notifications
        ]);
    }

    public function count()
    {
        return $this->jsonResponse([
            'unread_count' => Auth::user()->notifications()->unread()->count()
        ]);
    }

    public function visit(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer'
        ]);

        $notification = Auth::user()->notifications()->find($data['id']);

        if($notification && $notification->state != NotificationState::Read) {
            $notification->update([
                'state' => NotificationState::Read,
                'read_at' => now()
            ]);
        }

        return $this->jsonResponse([]);
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->whereNot('state', 'read')
            ->update([
                'state' => NotificationState::Read,
                'read_at' => now()
            ]);

        return $this->jsonResponse([]);
    }

    public function deleteAllNotifications()
    {
        Auth::user()->notifications()->delete();

        return $this->jsonResponse([]);
    }
}
