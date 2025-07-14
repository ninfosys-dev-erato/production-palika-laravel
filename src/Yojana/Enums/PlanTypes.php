<?php

namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum PlanTypes: string implements EnumInterface
{
    case Periodic = 'periodic';
    case Sequential = 'sequential';

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
            self::Periodic => __('yojana::yojana.periodic'),
            self::Sequential => __('yojana::yojana.sequential'),
        };

    }
}
