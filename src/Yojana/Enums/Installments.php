<?php

namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum Installments: string implements EnumInterface
{
    case FirstInstallment = 'first_installment';
    case SecondInstallment = 'second_installment';
    case LastInstallment = 'last_installment';

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
            self::FirstInstallment => __('yojana::yojana.first_installment'),
            self::SecondInstallment => __('yojana::yojana.second_installment'),
            self::LastInstallment => __('yojana::yojana.last_installment'),
        };
    }

}
