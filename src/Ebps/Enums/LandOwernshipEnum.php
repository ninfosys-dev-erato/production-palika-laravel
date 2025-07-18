<?php

namespace Src\Ebps\Enums;

enum LandOwernshipEnum: string
{
    case Private = 'Private';
    case Community = 'Community';
    case Shared = 'Shared';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::Private => __('निजी'),
            self::Community => __('गुठी'),
            self::Shared => __('साझा'),
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
