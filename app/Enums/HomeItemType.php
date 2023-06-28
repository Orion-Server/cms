<?php

namespace App\Enums;

enum HomeItemType: string
{
    case Sticker = 's';
    case Note = 'n';
    case Widget = 'w';
    case Background = 'b';
}
