<?php

namespace Src\Grievance\Enums;

enum GrievanceMediumEnum: string
{
    case EMAIL = 'email';
    case FAX = 'fax';
    case LETTER = 'letter';
    case CALL = 'call';
    case SYSTEM = 'System';
    case MOBILE = 'mobile'; 
    case WEB = 'Web';
    case GUEST = 'Guest'; 

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
            self::SYSTEM => __('System'),
            self::MOBILE => __('mobile'),
            self::WEB => __('Web'),
            self::GUEST => __('Guest'),
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
