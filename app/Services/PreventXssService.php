<?php

namespace App\Services;

use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;

class PreventXssService
{
    public static function sanitize(string $dataToSanitize, array $config = []): string
    {
        $config = (new HtmlSanitizerConfig)->allowSafeElements();
        $sanitizer = new HtmlSanitizer($config);

        return strip_tags($sanitizer->sanitize($dataToSanitize));
    }
}
