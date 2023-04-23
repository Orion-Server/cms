<?php

if(!function_exists('getPredominantImageColor')) {
    /**
     * Gets the most predominant color in an image.
     */
    function getPredominantImageColor(string $imageUrl, string $default = '#000'): string {
        try {
            $gdImage = @imagecreatefromstring(@file_get_contents($imageUrl));

            if(!$gdImage) return $default;

            $shortendImage = imagecreatetruecolor(1, 1);

            imagecopyresampled($shortendImage, $gdImage, 0, 0, 0, 0, 1, 1, imagesx($gdImage), imagesy($gdImage));

            $color = dechex(imagecolorat($shortendImage, 0, 0));

            return "#$color";
        } catch (\Throwable $ignored) {
            return $default;
        }
    }
}

if(!function_exists('isDarkColor')) {
    /**
     * Determines whether a color is dark or not.
     */
    function isDarkColor(string $hexColor): bool {
        $hexColor = str_replace('#', '', $hexColor);

        $c_r = hexdec(substr($hexColor, 0, 2));
        $c_g = hexdec(substr($hexColor, 2, 2));
        $c_b = hexdec(substr($hexColor, 4, 2));

        $brightness = (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;

        return $brightness <= 155;
    }
}

if(!function_exists('getTitleColor')) {
    /**
     * Determines the color of a string based on the predominant color of an image (possibly a string background).
     */
    function getStringColorByPredominantImageColor(string $imageUrl, $defaultColor): string {
        $color = getPredominantImageColor($imageUrl, $defaultColor);

        return isDarkColor($color) ? '#fff' : '#000';
    }
}
