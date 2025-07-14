<?php

namespace Src\Grievance\Enums;

enum GrievanceStatusEnum: string
{
    case UNSEEN = 'unseen';
    case INVESTIGATING = 'investigating';
    case REPLIED = 'replied';
    case CLOSED = 'closed';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::UNSEEN => __('Unseen'),
            self::INVESTIGATING => __('Investigating'),
            self::REPLIED => __('Replied'),
            self::CLOSED => __('Closed'),
        };
    }
}
