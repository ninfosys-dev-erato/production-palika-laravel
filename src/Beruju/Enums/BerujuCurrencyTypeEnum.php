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
            self::NPR => __('beruju::beruju.npr'),
            self::INR => __('beruju::beruju.inr'),
            self::POUND => __('beruju::beruju.pound'),
            self::DOLLAR => __('beruju::beruju.dollar'),
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

    public static function symbol(self $value): string
    {
        return match ($value) {
            self::NPR => __('beruju::beruju.npr_symbol'),
            self::INR => __('beruju::beruju.inr_symbol'),
            self::POUND => __('beruju::beruju.pound_symbol'),
            self::DOLLAR => __('beruju::beruju.dollar_symbol'),
        };
    }
}
