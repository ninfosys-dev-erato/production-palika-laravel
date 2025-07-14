<?php

namespace Src\Ebps\Enums;

enum DirectionEnum: string
{
    case East = 'East';
    case West = 'West';
    case North = 'North';
    case South = 'South';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::East => __('पूर्व'),
            self::West => __('पश्चिम'),
            self::North => __('उत्तर'),
            self::South => __('दक्षिण'),
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
