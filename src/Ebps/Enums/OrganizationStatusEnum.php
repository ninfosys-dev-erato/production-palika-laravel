<?php

namespace Src\Ebps\Enums;

enum OrganizationStatusEnum: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::PENDING => __('Pending'),
            self::REJECTED => __('Rejected'),
            self::ACCEPTED => __('Accepted')
        };
    }
}
