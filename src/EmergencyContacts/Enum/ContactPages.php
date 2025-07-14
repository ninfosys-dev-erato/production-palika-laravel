<?php

namespace Src\EmergencyContacts\Enum;

enum ContactPages: string
{
    case HOME = 'home';
    case EMERGENCY_CONTACT = 'emergency_contact';
    case TEMPLES = 'temples';
    case SCHOOL = 'school';
    case COOPERATIVE = 'cooperative';
    case INDUSTRIES = 'industries';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::HOME => __('Home'),
            self::EMERGENCY_CONTACT => __('Emergency Contact'),
            self::TEMPLES => __('Temples'),
            self::SCHOOL => __('School'),
            self::COOPERATIVE => __('Cooperative'),
            self::INDUSTRIES => __('Industries'),
        };
    }
}
