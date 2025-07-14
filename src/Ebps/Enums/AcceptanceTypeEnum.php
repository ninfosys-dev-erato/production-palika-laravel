<?php

namespace Src\Ebps\Enums;

enum AcceptanceTypeEnum: string
{
    case APPROVABLE = 'approvable';
    case NOT_APPROVABLE = 'not_approvable';
    case CONDITIONALLY_APPROVABLE = 'conditionally_approvable';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::APPROVABLE => __('स्वीकृति दिन सकिने'),
            self::NOT_APPROVABLE => __('स्वीकृति दिन नसकिने'),
            self::CONDITIONALLY_APPROVABLE => __('विशेष स्वीकृति दिन सकिने'),
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
