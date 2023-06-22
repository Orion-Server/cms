<?php

namespace App\Services\Parsers\Badge;

use Illuminate\Support\{
    Str,
    Collection,
    Facades\Log,
    Facades\Http
};

class FlashBadgeParser extends BadgeParser
{
    protected ?Collection $flashTexts = null;

    public function __construct()
    {
        $this->parseTexts();
    }

    private function parseTexts(): void
    {
        if ($this->flashTexts instanceof Collection) return;

        if (!$flashTextsPath = config('hotel.client.flash.externalTextsUrl')) {
            Log::warning('[ORION PARSER] - Flash external texts url is not set, badges will not be parsed.');
            return;
        }

        $allFlashTexts = Http::get($flashTextsPath)->body();

        if (empty($allFlashTexts)) {
            $this->flashTexts = null;
        }

        $splittedFlashTexts = collect(preg_split('/\r\n|\r|\n/', $allFlashTexts, -1, PREG_SPLIT_NO_EMPTY));

        try {
            $this->flashTexts = collect($splittedFlashTexts)
                ->filter(fn (?string $value) => Str::contains($value, ['badge_name_', 'badge_desc_', 'ACH_']))
                ->mapWithKeys(function (string $value): array {
                    $splitted = explode('=', $value);

                    if(count($splitted) !== 2) return [];

                    return [
                        $splitted[0] => $splitted[1] // badge_text => badge_text_value
                    ];
                });
        } catch (\Throwable $error) {
            Log::error('[ORION PARSER] - Error while parsing flash texts: ' . $error->getMessage());
            $this->flashTexts = null;
        }
    }

    public function getTexts(): ?Collection
    {
        return $this->flashTexts;
    }
}
