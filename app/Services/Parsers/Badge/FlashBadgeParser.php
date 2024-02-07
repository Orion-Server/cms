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
            'root' => $this->getRootPath(),
            'driver' => 'local',
            'visibility' => 'public',
        ]);
    }

    public function getRootPath(): string
    {
        return public_path(trim(config('hotel.client.flash.relative_files_path'), '\//') . '/gamedata');
    }

    private function parseTexts(): void
    {
        if ($this->flashTexts instanceof Collection) return;

        if (!($this->disk instanceof Filesystem)) {
            Log::warning('[ORION FLASH PARSER] - Error while creating temporary disk.');
            return;
        }

        if (!$this->disk->exists($this->getFileName())) {
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

                    if (count($splitted) !== 2) return [];

                    return [
                        $splitted[0] => $splitted[1] // badge_text => badge_text_value
                    ];
                });
        } catch (\Throwable $error) {
            Log::error('[ORION FLASH PARSER] - Error while parsing flash texts: ' . $error->getMessage());
            $this->flashTexts = null;
        }
    }

    public function updateBadgeTexts(string $code, string $name, string $description): void
    {
        if(!($this->flashTexts instanceof Collection)) return;

        $updatedFlashTexts = $this->clearOldBadgedata(
            $this->disk->get($this->getFileName()),
            $code
        );

        $this->disk->put($this->getFileName(), $updatedFlashTexts);

        $this->disk->append($this->getFileName(), "badge_desc_{$code}={$description}");
        $this->disk->append($this->getFileName(), "badge_name_{$code}={$name}");
    }

    protected function clearOldBadgedata(string $texts, string $code): string
    {
        $possibleBadgeData = [
            "badge_desc_{$code}=",
            "badge_name_{$code}="
        ];

        if(! Str::contains($texts, $possibleBadgeData)) {
            return $texts;
        }

        $texts = collect(preg_split('/\r\n|\r|\n/', $texts, -1, PREG_SPLIT_NO_EMPTY));

        return $texts->filter(function(?string $value, ?string $key) use ($possibleBadgeData): bool {
            return ! Str::contains($value, $possibleBadgeData);
        })->join("\r\n");
    }

    public function getFileName(): string
    {
        return 'external_flash_texts.txt';
    }

    public function getDisk(): ?Filesystem
    {
        return $this->disk;
    }

    public function getTexts(): ?Collection
    {
        return $this->flashTexts;
    }

    public function getUniqueCount(): int
    {
        if (!($this->flashTexts instanceof Collection)) return 0;

        return $this->getTexts()->filter(fn (?string $value, ?string $key) => Str::contains($key, ['badge_name_']))->count();
    }
}
