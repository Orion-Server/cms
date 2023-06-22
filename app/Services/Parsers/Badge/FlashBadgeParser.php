<?php

namespace App\Services\Parsers\Badge;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\{
    Str,
    Collection,
    Facades\Log,
    Facades\Storage
};

class FlashBadgeParser extends BadgeParser
{
    protected ?Collection $flashTexts = null;
    protected ?Filesystem $disk = null;

    public function __construct()
    {
        $this->buildTemporaryDisk();
        $this->parseTexts();
    }

    private function buildTemporaryDisk()
    {
        $this->disk = Storage::build([
            'root' => public_path(config('hotel.client.flash.gamedata_relative_path')),
            'driver' => 'local',
            'visibility' => 'public',
        ]);
    }

    private function parseTexts(): void
    {
        if ($this->flashTexts instanceof Collection) return;

        if (!($this->disk instanceof Filesystem)) {
            Log::warning('[ORION FLASH PARSER] - Error while creating temporary disk.');
            return;
        }

        if(!$this->disk->exists($this->getFileName())) {
            Log::warning("[ORION FLASH PARSER] - Error while parsing flash texts: {$this->getFileName()} does not exist.");
            return;
        }

        $allFlashTexts = $this->disk->get($this->getFileName());

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
            Log::error('[ORION FLASH PARSER] - Error while parsing flash texts: ' . $error->getMessage());
            $this->flashTexts = null;
        }
    }

    public function getFileName(): string
    {
        return 'external_flash_texts.txt';
    }

    public function getTexts(): ?Collection
    {
        return $this->flashTexts;
    }
}
