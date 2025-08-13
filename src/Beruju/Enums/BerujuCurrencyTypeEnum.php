<?php

namespace Src\Beruju\Enums;

enum BerujuCurrencyTypeEnum: string
{
    case NPR = 'npr';
    case INR = 'inr';
    case POUND = 'pound';
    case DOLLAR = 'dollar';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NPR => __('NPR'),
            self::INR => __('INR'),
            self::POUND => __('Pound'),
            self::DOLLAR => __('Dollar'),
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
            self::NPR => 'नेपाली रुपैयाँ',
            self::INR => 'भारतीय रुपैयाँ',
            self::POUND => 'पाउन्ड',
            self::DOLLAR => 'डलर',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NPR => 'primary',
            self::INR => 'info',
            self::POUND => 'warning',
            self::DOLLAR => 'success',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($currency) {
            return [$currency->value => $currency->label()];
        })->toArray();
    }
}
