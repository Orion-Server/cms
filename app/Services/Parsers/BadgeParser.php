<?php

namespace App\Services\Parsers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BadgeParser
{
    protected ?Collection $nitroTexts = null;
    protected ?Collection $flashTexts = null;

    public function __construct()
    {
        $this->parseNitroTexts();
        $this->parseFlashTexts();
    }

    private function parseNitroTexts(): void
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

    public function getBadgeData(string $badgeCode): ?array
    {
        return [
            'code' => $badgeCode,
            'image' => sprintf('%s%s.gif', getSetting('badges_path'), $badgeCode),
            'nitro' => $this->getBadgeFor('nitro', $badgeCode),
            'flash' => $this->getBadgeFor('flash', $badgeCode)
        ];
    }

    public function getBadgeFor(string $clientVersion, string $badgeCode): ?array
    {
        $property = match ($clientVersion) {
            'nitro' => $this->nitroTexts,
            'flash' => $this->flashTexts,
            default => null
        };

        if (!($property instanceof Collection)) return null;

        $filterResult = $property->filter(function (string $value, string $key) use ($badgeCode) {
            return in_array($key, [
                "badge_name_{$badgeCode}",
                "badge_desc_{$badgeCode}"
            ]);
        });

        if ($filterResult->isEmpty()) return null;

        return [
            'title' => $filterResult?->get("badge_name_{$badgeCode}", null),
            'description' => $filterResult?->get("badge_desc_{$badgeCode}", null)
        ];
    }

    private function parseFlashTexts(): void
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
}
