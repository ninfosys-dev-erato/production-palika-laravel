<?php

namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum AccountTypes: string implements EnumInterface
{
    case Savings = 'savings';
    case Current = 'current';
    case FixedDeposit = 'fixed_deposit';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
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

    public static function getLabel(EnumInterface $value): string
    {
        return match ($value) {
            self::Savings => __('yojana::messages.savings'),
            self::Current => __('yojana::messages.current'),
            self::FixedDeposit => __('yojana::messages.fixed_deposit'),
        };
    }
}
