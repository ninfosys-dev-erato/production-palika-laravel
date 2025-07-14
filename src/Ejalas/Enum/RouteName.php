<?php

namespace Src\Ejalas\Enum;

use App\Contracts\EnumInterface;

enum RouteName: string implements EnumInterface
{
    case General = 'general';
    case ReconciliationCenter = 'reconciliation_center';

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
            self::General => __('ejalas::ejalas.general'),
            self::ReconciliationCenter => __('ejalas::ejalas.reconciliation_center'),
        };
    }
}
