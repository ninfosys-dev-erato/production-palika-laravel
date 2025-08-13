<?php

namespace Src\Beruju\Enums;

enum BerujuCategoryEnum: string
{
    case THEORETICAL_BERUJU = 'theoretical_beruju';
    case MONETARY_BERUJU = 'monetary_beruju';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::THEORETICAL_BERUJU => __('Theoretical Beruju'),
            self::MONETARY_BERUJU => __('Monetary Beruju'),
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
            self::THEORETICAL_BERUJU => 'सैद्धािन्तक बेरुज',
            self::MONETARY_BERUJU => 'लगती बेरुजु',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::THEORETICAL_BERUJU => 'primary',
            self::MONETARY_BERUJU => 'success',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->label()];
        })->toArray();
    }
}
