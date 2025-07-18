<?php

namespace Src\Grievance\Enums;

enum GrievanceMediumEnum: string
{
    case EMAIL = 'email';
    case FAX = 'fax';
    case LETTER = 'letter';
    case CALL = 'call';
    case SYSTEM = 'system';
    case MOBILE = 'mobile'; 
    case WEB = 'Web';
    case GUEST = 'guest'; 

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::EMAIL => __('Email'),
            self::FAX => __('Fax'),
            self::LETTER => __('Letter'),
            self::CALL => __('Call'),
            self::SYSTEM => __('system'),
            self::MOBILE => __('mobile'),
            self::WEB => __('web'),
            self::GUEST => __('guest'),
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

}
