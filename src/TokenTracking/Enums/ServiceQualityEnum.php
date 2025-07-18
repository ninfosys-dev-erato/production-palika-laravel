<?php

namespace Src\TokenTracking\Enums;

enum ServiceQualityEnum: string
{
    case EXCELLENT = 'Excellent';
    case AVERAGE = 'Average';
    case POOR = 'Poor';
    case VERY_POOR = 'Very Poor';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::EXCELLENT => 'राम्रो',
            self::AVERAGE => 'ठिकठाक',
            self::POOR => 'नराम्रो',
            self::VERY_POOR => 'अत्यन्त नराम्रो',
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
