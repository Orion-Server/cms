<?php

namespace App\Enums;

enum ShopProductItemType: string
{
    case Room = 'room';
    case Badge = 'badge';
    case Currency = 'currency';
    case Furniture = 'furniture';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function valuesExcept(HomeItemType $exceptValue = null): array
    {
        return array_filter(self::values(), fn ($value) => $value !== $exceptValue->value);
    }

    public function getImage(string $itemData): string
    {
        return match ($this->value) {
            self::Badge->value => $this->getBadgeImage($itemData),
            self::Furniture->value => $this->getFurnitureImage($itemData),
            self::Room->value => $this->getRoomImage($itemData),
            self::Currency->value => $this->getCurrencyImage($itemData)
        };
    }

    private function getBadgeImage(string $itemData): string
    {
        return sprintf('%s%s.gif', getSetting('badges_path'), $itemData);
    }

    private function getFurnitureImage(string $itemData): string
    {
        if(!str_ends_with($itemData, '_icon')) {
            $itemData = sprintf('%s_icon', $itemData);
        }

        $itemData = str_replace('*', '_', $itemData);

        return sprintf('%s%s.png', getSetting('furniture_icon_path'), $itemData);
    }

    private function getRoomImage(string $itemData): string
    {
        return $itemData;
    }

    private function getCurrencyImage(string $itemData): string
    {
        return match ($itemData) {
            'credits' => 'https://i.imgur.com/6Z1Noci.gif',
            'duckets' => 'https://i.imgur.com/ZRBOYoE.png',
            'diamonds' => 'https://i.imgur.com/7MyGvjK.png',
            'points' => 'https://i.imgur.com/8p2Dqlw.png'
        };
    }
}
