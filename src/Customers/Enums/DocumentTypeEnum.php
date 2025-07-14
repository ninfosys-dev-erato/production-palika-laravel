<?php

namespace Src\Customers\Enums;

enum DocumentTypeEnum: string
{
    case NATIONAL_ID = 'national_id';
    case CITIZENSHIP = 'citizenship';
    case PASSPORT = 'passport';
    case DRIVING_LICENSE = 'driving_license';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NATIONAL_ID => __('National ID'),
            self::CITIZENSHIP => __('Citizenship'),
            self::PASSPORT => __('Passport'),
            self::DRIVING_LICENSE => __('Driving License'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[] = [
                'value' => $value,
                'label' => $value->label(),
            ];
        }

        return $valuesWithLabels;
    }
}
