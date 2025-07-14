<?php

namespace Src\Ejalas\Enum;

enum PlaceOfRegistration: string
{
    case JUDICIAL_COMMITTEE = 'न्यायिक समिति';
    case MEDIATION_CENTER = 'मेलमिलाप केन्द्र';
    case MAP_APPROVAL = 'नक्सा पास';
    // public function label(): string
    // {
    //     return self::getLabel($this);
    // }

    // public static function getLabel(self $value): string
    // {
    //     return match ($value) {
    //         self::JUDICIAL_COMMITTEE => 'न्यायिक समिति',
    //         self::MEDIATION_CENTER => 'मेलमिलाप केन्द्र',
    //         self::MAP_APPROVAL => 'नक्सा पास',
    //     };
    // }
    // public static function getValuesWithLabels(): array
    // {
    //     $valuesWithLabels = [];
    //     foreach (self::cases() as $value) {
    //         $valuesWithLabels[$value->value] = $value->label();
    //     }

    //     return $valuesWithLabels;
    // }
}
