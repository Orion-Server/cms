<?php

use App\Services\CacheTimeService;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Pipeline;

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

if(!function_exists('getPredominantImageColor')) {
    /**
     * Gets the most predominant color in an image.
     */
    function getPredominantImageColor(string $imageUrl, string $default = '#000'): string {
        return Cache::remember("image-color-$imageUrl", CacheTimeService::getForImagePredominantColor(), function () use ($imageUrl, $default) {
            try {
                $gdImage = imagecreatefromstring(
                    Http::get($imageUrl)->body()
                );

                if(!$gdImage) return $default;

                $shortendImage = imagecreatetruecolor(1, 1);

                imagecopyresampled($shortendImage, $gdImage, 0, 0, 0, 0, 1, 1, imagesx($gdImage), imagesy($gdImage));

                $color = dechex(imagecolorat($shortendImage, 0, 0));

                return "#$color";
            } catch (\Throwable $ignored) {
                return $default;
            }
        });
    }
}

if(!function_exists('isDarkColor')) {
    /**
     * Determines whether a color is dark or not.
     */
    function isDarkColor(string $hexColor): bool
    {
        $hexColor = str_replace('#', '', $hexColor);

        $c_r = hexdec(substr($hexColor, 0, 2));
        $c_g = hexdec(substr($hexColor, 2, 2));
        $c_b = hexdec(substr($hexColor, 4, 2));

        $brightness = (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;

        return $brightness <= 155;
    }
}

if(!function_exists('getSetting')) {
    /**
     * Gets a setting from the database (**cms_settings** table).
     */
    function getSetting(string $key, ?string $defaultValue = null): mixed
    {
        return app(SettingsService::class)->get($key, $defaultValue);
    }
}

if(!function_exists('convertTagsToHtml')) {
    /**
     * Converts tags to HTML.
     */
    function convertTagsToHtml(string $tagStart, string $tagEnd, string $htmlTagStart, string $htmlTagEnd, string $content): string
    {
        $tagStart = preg_quote($tagStart, '/');
        $tagEnd = preg_quote($tagEnd, '/');

        return preg_replace("/{$tagStart}(.*){$tagEnd}/s", "{$htmlTagStart}$1{$htmlTagEnd}", $content);
    };
}

if(!function_exists('renderBBCodeText')) {
    /**
     * Render BBCode text to HTML.
     *
     * @param bool $reflectLineBreaks Whether to reflect line breaks or not. (usually when displaying rendered text)
     */
    function renderBBCodeText(string $content, bool $reflectLineBreaks = false): string
    {
        return Pipeline::send($content)
            ->through([
                fn (string $content, \Closure $next) => $next(convertTagsToHtml('[b]', '[/b]', '<b>', '</b>', $content)),
                fn (string $content, \Closure $next) => $next(convertTagsToHtml('[i]', '[/i]', '<i>', '</i>', $content)),
                fn (string $content, \Closure $next) => $next(convertTagsToHtml('[u]', '[/u]', '<u>', '</u>', $content)),
                fn (string $content, \Closure $next) => $next(convertTagsToHtml('[s]', '[/s]', '<s>', '</s>', $content)),
                fn (string $content, \Closure $next) => $next(convertTagsToHtml('[h]', '[/h]', '<span class="bbcode-highlighter">', '</span>', $content)),
            ])->then(fn (string $content) => $reflectLineBreaks ? nl2br($content) : $content);
    }
}

if(!function_exists('getFigureUrl')) {
    /**
     * Gets the Habbo Imager URL.
     */
    function getFigureUrl(string $figure, string $strings): string
    {
        return sprintf('%s%s&%s', getSetting('figure_imager'), $figure, $strings);
    }
}
