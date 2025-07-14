<?php

namespace Src\Grievance\Enums;

enum GrievancePriorityEnum: string
{
    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::HIGH => __('High'),
            self::MEDIUM => __('Medium'),
            self::LOW => __('Low'),
        };
    }
}
