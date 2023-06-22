<?php

namespace App\Services\Parsers\Badge;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\{
    Str,
    Collection,
    Facades\Log,
    Facades\Storage
};

class NitroBadgeParser extends BadgeParser
{
    protected ?Collection $nitroTexts = null;
    protected ?Filesystem $disk = null;

    public function __construct()
    {
        $this->buildTemporaryDisk();
        $this->parseTexts();
    }

    private function buildTemporaryDisk()
    {
        $this->disk = Storage::build([
            'root' => public_path(config('hotel.client.nitro.gamedata_relative_path')),
            'driver' => 'local',
            'visibility' => 'public',
        ]);
    }

    private function parseTexts(): void
    {
        if ($this->nitroTexts instanceof Collection) return;

        if (!($this->disk instanceof Filesystem)) {
            Log::warning('[ORION NITRO PARSER] - Error while creating temporary disk.');
            return;
        }

        if(!$this->disk->exists($this->getFileName())) {
            Log::warning("[ORION NITRO PARSER] - Error while parsing nitro texts: {$this->getFileName()} does not exist.");
            return;
        }

        $allNitroTexts = $this->disk->get($this->getFileName());

        if (empty($allNitroTexts)) {
            $this->nitroTexts = null;
        }

        $allNitroTexts = json_decode($allNitroTexts, true);

        $this->nitroTexts = collect($allNitroTexts)
            ->filter(fn (?string $value, ?string $key) =>
                Str::contains($key, ['badge_name_', 'badge_desc_', 'ACH_'])
            );
    }

    public function getFileName(): string
    {
        return 'ExternalTexts.json';
    }

    public function getTexts(): ?Collection
    {
        return $this->nitroTexts;
    }
}
