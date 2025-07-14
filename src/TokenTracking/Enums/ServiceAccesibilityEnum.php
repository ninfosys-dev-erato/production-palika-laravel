<?php

namespace Src\TokenTracking\Enums;

enum ServiceAccesibilityEnum: string
{
    case QUICK = 'Service was quick';
    case DELAYED = 'Service was delayed';
    case NOT_RECEIVED = 'Service was not received';
    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::QUICK => 'सेवा सजिलै प्राप्त भयो',
            self::DELAYED => 'सेवा ढिलो भयो',
            self::NOT_RECEIVED => 'सेवा नै प्राप्त भएन',
        };
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];
        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }
}
