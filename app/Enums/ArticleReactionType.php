<?php

namespace App\Enums;

enum ArticleReactionType: string
{
    case SAD = 'sad';
    case WOW = 'wow';
    case HAHA = 'haha';
    case LOVE = 'love';
    case LIKE = 'like';
    case DISLIKE = 'dislike';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function forValidation(): string
    {
        return implode(',', self::values());
    }

    public function getColor(): string
    {
        return match ($this->value) {
            self::SAD->value => '#f87171',
            self::WOW->value => '#0ea5e9',
            self::HAHA->value => '#84cc16',
            self::LOVE->value => '#be123c',
            self::LIKE->value => '#16a34a',
            self::DISLIKE->value => '#dc2626',
        };
    }

    public function getIcon(): string
    {
        return asset("assets/images/icons/reactions/{$this->value}.png");
    }
}
