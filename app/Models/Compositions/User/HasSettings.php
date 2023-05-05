<?php

namespace App\Models\Compositions\User;

use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSettings
{
    private function generateInitialSettings(): void
    {
        $this->settings()->create();
    }

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }
}
