<?php

namespace Src\Ejalas\Enum;

enum PlaceOfRegistration: string
{
    case PALIKA = 'palika';
    case WARD = 'ward';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::PALIKA => __('Palika'),
            self::WARD => __('Ward'),
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
            self::PALIKA => 'पालिका',
            self::WARD => 'वडा',
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
