<?php

namespace Src\Ebps\Enums;

enum BuildingStructureEnum: string
{
    case A_LEVEL = 'a_level';
    case B_LEVEL = 'b_level';
    case C_LEVEL = 'c_level';
    case D_LEVEL = 'd_level';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::A_LEVEL => __('क वर्ग'),
            self::B_LEVEL => __('ख वर्ग'),
            self::C_LEVEL => __('ग वर्ग'),
            self::D_LEVEL => __('घ वर्ग'),
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
