<?php

namespace Src\Ebps\Enums;

enum MapApplyStatusEnum: string
{
    case NOT_APPLIED = 'not applied';
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under review';
    case MODIFY = 'modify';
    case ACCEPTED = 'accepted';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NOT_APPLIED => __('Not Applied'),
            self::PENDING => __('Pending'),
            self::UNDER_REVIEW => __('under review'),
            self::MODIFY => __('modify'),
            self::ACCEPTED => __('Accepted'),
        };
    }
}
