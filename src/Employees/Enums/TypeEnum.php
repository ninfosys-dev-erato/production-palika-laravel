<?php

namespace Src\Employees\Enums;

enum TypeEnum: string
{
    case TEMPORARY_STAFF = 'temporary staff';
    case PERMANENT_STAFF = 'permanent staff';
    case REPRESENTATIVE = 'representative';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::TEMPORARY_STAFF => 'करार',
            self::PERMANENT_STAFF => 'स्थाही',
            self::REPRESENTATIVE => 'जनप्रतिनिधि',
        };
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[] = [
                'value' => $value->value,
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
