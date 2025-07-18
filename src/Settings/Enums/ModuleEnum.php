<?php

namespace Src\Settings\Enums;

enum ModuleEnum: string
{
    case RECOMMENDATION = 'Recommendation';
        //    case BUSINESSREGISTRATION = 'BusinessRegistration';
    case BUSINESSREGISTRATION = 'business-registration';
    case EBPS = 'Ebps';
    case PATRACHAR = 'Patrachar';
    case EJALAS = 'Ejalas';

    case PLANMANAGEMENTSYSTEM = 'plan_management_system';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::RECOMMENDATION => __('Recommendation'),
            self::BUSINESSREGISTRATION => __('Business Registration'),
            self::PLANMANAGEMENTSYSTEM => __('Plan Management System'),
            self::EBPS => __('Ebps'),
            self::PATRACHAR => __('Patrachar'),
            self::EJALAS => __('Ejalas'),
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

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }
}
