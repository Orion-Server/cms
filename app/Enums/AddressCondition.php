<?php

namespace App\Enums;

enum AddressCondition: string
{
    case Whitelist = 'whitelist';
    case Blacklist = 'blacklist';
}
