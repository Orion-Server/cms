<?php

namespace App\Services;

use App\Models\CmsSetting;
use Illuminate\Support\Collection;

class SettingsService
{
    public ?Collection $allSettings;

    public function __construct()
    {
        $this->loadSettingsFromDatabase();
    }

    private function loadSettingsFromDatabase(): void
    {
        try {
            $this->allSettings = CmsSetting::all()->pluck('value', 'key');
        } catch (\Throwable $ignored) {
            $this->allSettings = collect();
        }
    }

    public function get(string $key, ?string $defaultValue = null): mixed
    {
        return $this->allSettings->get($key, $defaultValue);
    }

    public function set(string $key, string $value, ?string $comment = null): void
    {
        $this->allSettings->put($key, $value);

        CmsSetting::updateOrCreate(['key' => $key], [
            'value' => $value,
            'comment' => $comment
        ]);
    }
}
