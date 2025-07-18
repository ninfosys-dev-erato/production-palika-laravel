<?php

namespace Src\Ebps\Enums;

enum ApplicantTypeEnum: string
{
    case HOUSE_OWNER = 'house_owner';
    case LAND_OWNER = 'land_owner';
    case HEIR = 'heir';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::HOUSE_OWNER => __('घरधनी'),
            self::LAND_OWNER => __('जग्गाधनी'),
            self::HEIR => __('वारिस भएमा'),
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
