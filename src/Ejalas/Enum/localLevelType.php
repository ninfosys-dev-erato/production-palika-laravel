<?php

namespace Src\Ejalas\Enum;

enum LocalLevelType: string
{
    case METROPOLITAN_CITY = 'metropolitan_city';
    case SUB_METROPOLITAN_CITY = 'sub_metropolitan_city';
    case MUNICIPALITY = 'municipality';
    case RURAL_MUNICIPALITY = 'rural_municipality';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::METROPOLITAN_CITY => __('Metropolitan City'),
            self::SUB_METROPOLITAN_CITY => __('Sub Metropolitan City'),
            self::MUNICIPALITY => __('Municipality'),
            self::RURAL_MUNICIPALITY => __('Rural Municipality'),
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
            self::METROPOLITAN_CITY => 'महानगरपालिका',
            self::SUB_METROPOLITAN_CITY => 'उपमहानगरपालिका',
            self::MUNICIPALITY => 'नगरपालिका',
            self::RURAL_MUNICIPALITY => 'गाउँपालिका',
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
