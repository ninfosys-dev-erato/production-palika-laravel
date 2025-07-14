<?php

namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum Natures: string implements EnumInterface
{
    case Program = 'program';
    case Purchase = 'purchase';
    case Construction = 'construction';
    case ConsultingServices = 'consulting_services';

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
            self::Program => __('yojana::yojana.program'),
            self::Purchase => __('yojana::yojana.purchase'),
            self::Construction => __('yojana::yojana.construction'),
            self::ConsultingServices => __('yojana::yojana.consulting_services'),
        };
    }
}
