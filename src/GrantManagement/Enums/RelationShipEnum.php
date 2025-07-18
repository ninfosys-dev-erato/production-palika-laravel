<?php

namespace Src\GrantManagement\Enums;

enum RelationShipEnum: string
{
    case FATHER = 'father';
    case MOTHER = 'mother';
    case FATHER_OR_MOTHER = 'father_mother';
    case BROTHER_OR_SISTER = 'brother_sister';
    case UNCLE_OR_AUNTY = 'uncle_aunty';
    case GRANDPA_OR_GRANDMA = 'grandpa_grandma';
    case OTHER = 'other';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getLabels(): array
    {
        return [
            self::FATHER->value => __('Father'),
            self::MOTHER->value => __('Mother'),
            self::FATHER_OR_MOTHER->value => __('Father / Mother'),
            self::BROTHER_OR_SISTER->value => __('Brother / Sister'),
            self::UNCLE_OR_AUNTY->value => __('Uncle / Aunty'),
            self::GRANDPA_OR_GRANDMA->value => __('Grand Pa / Grand Ma'),
            self::OTHER->value => __('Other'),
        ];
    }

    public static function getValuesWithLabels(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => self::getLabels()[$case->value]];
        })->toArray();
    }
}
