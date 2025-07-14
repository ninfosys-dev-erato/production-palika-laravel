<?php

namespace Src\Ebps\Enums;

enum MapProcessTypeEnum: string
{
    case MAP_REGISTRATION = 'map_registration'; // नक्शा दर्ता
    case MAP_APPROVAL = 'map_approval';         // नक्शा प्रमाणित

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::MAP_REGISTRATION => __('नक्शा दर्ता'),
            self::MAP_APPROVAL => __('नक्शा प्रमाणित'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        return array_map(fn($value) => [
            'value' => $value->value,
            'label' => $value->label(),
        ], self::cases());
    }
}
