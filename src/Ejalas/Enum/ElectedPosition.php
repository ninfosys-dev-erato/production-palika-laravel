<?php

namespace Src\Ejalas\Enum;

enum ElectedPosition: string
{
    case DEPUTY_MAYOR = 'deputy_mayor';
    case WARD_PRESIDENT = 'ward_president';
    case EXECUTIVE_MEMBER = 'executive_member';
    case WARD_MEMBER = 'ward_member';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::DEPUTY_MAYOR => __('Deputy Mayor'),
            self::WARD_PRESIDENT => __('Ward President'),
            self::EXECUTIVE_MEMBER => __('Executive Member'),
            self::WARD_MEMBER => __('Ward Member'),
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
            self::DEPUTY_MAYOR => 'उपमहापौर',
            self::WARD_PRESIDENT => 'वडा अध्यक्ष',
            self::EXECUTIVE_MEMBER => 'कार्यकारी सदस्य',
            self::WARD_MEMBER => 'वडा सदस्य',
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
