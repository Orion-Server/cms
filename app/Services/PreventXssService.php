<?php

namespace App\Services;

use HtmlSanitizer\Sanitizer;

class PreventXssService
{
    public static function sanitize(string $dataToSanitize, array $config = []): string
    {
        return strip_tags(Sanitizer::create($config)->sanitize($dataToSanitize));
    }
}
