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
            'root' => $this->getRootPath(),
            'driver' => 'local',
            'visibility' => 'public',
        ]);
    }

    public function getRootPath(): string
    {
        return public_path(trim(config('hotel.client.nitro.relative_files_path'), '\//') . '/gamedata');
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

    public function updateBadgeTexts(string $code, string $name, string $description): void {
        $file = $this->disk->get($this->getFileName());

        if(empty($file)) {
            Log::warning("[ORION NITRO PARSER] - Error while updating nitro texts: {$this->getFileName()} does not exist.");
            return;
        }

        $file = json_decode($file, true);

        $file["badge_desc_{$code}"] = $description;
        $file["badge_name_{$code}"] = $name;

        $this->disk->put($this->getFileName(), json_encode($file));
    }

    public function getFileName(): string
    {
        return 'ExternalTexts.json';
    }

    public function getTexts(): ?Collection
    {
        return $this->nitroTexts;
    }

    public function getUniqueCount(): int
    {
        if (!($this->nitroTexts instanceof Collection)) return 0;

        return $this->getTexts()->filter(fn (?string $value, ?string $key) => Str::contains($key, ['badge_name_']))->count();
    }
}
