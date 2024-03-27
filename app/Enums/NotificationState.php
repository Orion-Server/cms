<?php

namespace App\Enums;

enum NotificationState: string
{
    case Unread = 'unread';
    case Seen = 'seen';
    case Read = 'read';
}
