<?php

namespace Src\BusinessRegistration\Enums;

enum RegistrationCategoryEnum: string
{
    case BUSINESS = 'business';
    case ORGANIZATION = 'organization';
    case FIRM = 'firm';
    case INDUSTRY = 'industry';

    public function label(): string
    {
        return match ($this) {
            self::BUSINESS => __('Business'),
            self::ORGANIZATION => __('Organization'),
            self::FIRM => __('Firm'),
            self::INDUSTRY => __('Industry'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        return array_map(fn($value) => [
            'value' => $value->value,
            'label' => $value->label(),
        ], self::cases());
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
            self::BUSINESS => 'व्यवसाय',
            self::ORGANIZATION => 'संघ/संस्था',
            self::FIRM => 'फर्म',
            self::INDUSTRY => 'उद्योग',
        };
    }

    public static function getForWebInNepali(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = self::getNepaliLabel($value);
        }

        return $valuesWithLabels;
    }
}
