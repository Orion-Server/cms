<?php

namespace App\Services\Parsers\Badge;

use Illuminate\Support\{
    Str,
    Collection,
    Facades\Log,
    Facades\Http
};

class NitroBadgeParser extends BadgeParser
{
    protected ?Collection $nitroTexts = null;

    public function __construct()
    {
        $this->parseTexts();
    }

    private function parseTexts(): void
    {
        if ($this->nitroTexts instanceof Collection) return;

        if (!$nitroTextsPath = config('hotel.client.nitro.externalTextsUrl')) {
            Log::warning('[ORION PARSER] - Nitro external texts url is not set, badges will not be parsed.');
            return;
        }

        $allNitroTexts = Http::get($nitroTextsPath)->json();

        if (empty($allNitroTexts)) {
            $this->nitroTexts = null;
        }

        $this->nitroTexts = collect($allNitroTexts)
            ->filter(fn (?string $value, ?string $key) =>
                Str::contains($key, ['badge_name_', 'badge_desc_', 'ACH_'])
            );
    }

    public function getTexts(): ?Collection
    {
        return $this->nitroTexts;
    }
}
