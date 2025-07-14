<?php

namespace Src\GrantManagement\Enums;

enum GrantEnum: string
{
    case CASH = 'cash';
    case GENSI = 'gensi';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::CASH => __('Cash'),
            self::GENSI => __('Gensi'),
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
}
