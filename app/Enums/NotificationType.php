<?php

namespace App\Enums;

enum NotificationType: int
{
    case ArticlePosted = 1;
    case ArticleCommented = 2;

    case ProfileMessage = 3;
    case ProfileRating = 4;

    case ProductDelivered = 5;
    case ReferrerUser = 6;

    case HousekeepingCustomMessage = 7;

    public function getMessage(): string
    {
        return match ($this) {
            self::ArticlePosted => __('just posted an article.'),
            self::ArticleCommented => __('just commented on your article.'),
            self::ProfileMessage => __('left a message on your profile.'),
            self::ProfileRating => __('rated your profile.'),
            self::ProductDelivered => __('Your purchase has been delivered! Thank you for supporting us.'),
            self::ReferrerUser => __('registered using your referral link.'),
        };
    }
}
