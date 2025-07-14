<?php

namespace Src\Ebps\Enums;

enum OwnershipTypeEnum: string
{
    case HOUSE_OWNER = 'house_owner';
    case LAND_OWNER = 'land_owner';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::HOUSE_OWNER => __('घरधनी'),
            self::LAND_OWNER => __('जग्गाधनी'),
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
