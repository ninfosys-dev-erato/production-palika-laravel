<?php

namespace Src\Settings\Enums;

use App\Contracts\EnumInterface;

enum TemplateEnum: string implements EnumInterface
{


    case Recommendation = 'recommendation';
    case Business = 'business';
    case Footer = 'footer';
    case BusinessRenewal = 'business_renewal';
    case Plan = 'plan';


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
            self::Recommendation => __('settings::settings.recommendation'),
            self::Business => __('settings::settings.business'),
            self::Footer => __('settings::settings.footer'),
            self::BusinessRenewal => __('settings::settings.business_renewal'),
            self::Plan => __('settings::settings.plan'),
        };
    }
}
