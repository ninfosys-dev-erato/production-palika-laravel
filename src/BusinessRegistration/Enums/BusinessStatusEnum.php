<?php

namespace Src\BusinessRegistration\Enums;

enum BusinessStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';


    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::ACTIVE => __('Active'),
            self::INACTIVE => __('Inactive'),
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
    public static function getNepaliLabel(self $value): string
    {
        return match ($value) {
            self::ACTIVE => 'सक्रिय',
            self::INACTIVE => 'निष्क्रिय',
        };
    }
    public static function getForWebInNepali(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = self::getNepaliLabel($value);
        }

        return $valuesWithLabels;
    }
}
