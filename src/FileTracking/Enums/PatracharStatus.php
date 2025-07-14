<?php

namespace Src\FileTracking\Enums;

enum PatracharStatus: string
{
    case FORWARDED = 'forwarded';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
    case CLOSED = 'closed';
    case ARCHIVED = 'archived';
    case DELETED = 'deleted';
    case FARSYAUT = 'farsyaut';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::FORWARDED => '<span class="badge rounded-pill bg-primary">' . __('Forwarded') . '</span>',
            self::REJECTED => '<span class="badge rounded-pill bg-danger">' . __('Rejected') . '</span>',
            self::PENDING => '<span class="badge rounded-pill bg-warning">' . __('Pending') . '</span>',
            self::CLOSED => '<span class="badge rounded-pill bg-secondary">' . __('Closed') . '</span>',
            self::ARCHIVED => '<span class="badge rounded-pill bg-dark">' . __('Archived') . '</span>',
            self::DELETED => '<span class="badge rounded-pill bg-danger">' . __('Deleted') . '</span>',
            self::FARSYAUT => '<span class="badge rounded-pill bg-info">' . __('Farsyaut') . '</span>',
        };
    }
}
