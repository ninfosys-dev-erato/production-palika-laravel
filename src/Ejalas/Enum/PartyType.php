<?php

namespace Src\Ejalas\Enum;

enum PartyType: string
{
    case Complainer = 'Complainer';
    case Defender = 'Defender';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::Complainer => 'निवेदक',
            self::Defender => 'विपक्षी',
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
