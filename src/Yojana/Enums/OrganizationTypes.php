<?php

namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum OrganizationTypes: string implements EnumInterface
{
    case Other = 'other';
    case GSN = 'gsn';
    case ContractLease = 'contract_lease';

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
            self::Other => __('yojana::yojana.other'),
            self::GSN => __('yojana::yojana.gsn'),
            self::ContractLease => __('yojana::yojana.contract_lease'),
        };
    }
}
