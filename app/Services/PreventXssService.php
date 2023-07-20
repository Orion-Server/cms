<?php

namespace App\Services;

use HtmlSanitizer\Sanitizer;

class PreventXssService
{
    public static function sanitize(string $dataToSanitize, array $config = []): string
    {
        return Sanitizer::create($config)->sanitize($dataToSanitize);
    }
}
