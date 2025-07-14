<?php

namespace Src\FileTracking\Enums;

enum SenderMediumEnum: string
{
    case EMAIL = 'email';
    case POST_OFFICE = 'post_office';
    case HARDCOPY = 'hardcopy';
    case THROUGH_PERSONAL = 'through_personal';
    case RESERVE = 'reserve';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::EMAIL => __('Email'),
            self::POST_OFFICE => __('Post Office'),
            self::HARDCOPY => __('Hardcopy'),
            self::THROUGH_PERSONAL => __('Through Personal'),
            self::RESERVE => __('Reserve'),
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
    public function nepaliLabel(): string
    {
        return match ($this) {
            self::EMAIL => 'इमेल',
            self::POST_OFFICE => 'हुलाक',
            self::HARDCOPY => 'हार्डकपी',
            self::THROUGH_PERSONAL => 'स्वयं व्यक्ति मार्फत',
            self::RESERVE => 'सरिजर्ब',

        };
    }
}
