<?php

namespace App\Services\Parsers\Badge;

use Illuminate\Support\Collection;

class BadgeParser
{
    public function getBadgeData(string $badgeCode): ?array
    {
        if (!($this->getTexts() instanceof Collection)) return null;

        $filterResult = $this->getTexts()->filter(function (string $value, string $key) use ($badgeCode) {
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

    public function getTexts(): ?Collection
    {
        return null;
    }
}
