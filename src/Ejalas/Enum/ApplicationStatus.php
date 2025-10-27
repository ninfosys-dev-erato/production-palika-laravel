<?php

namespace Src\Ejalas\Enum;

enum ApplicationStatus: string
{
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Pending = 'pending';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::Accepted => __('Accepted'),
            self::Rejected => __('Rejected'),
            self::Pending => __('Pending'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];
        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }
    public function color(): string
    {
        return match ($this) {
            self::Accepted => 'success',
            self::Rejected => 'danger',
            self::Pending => 'warning',
        };
    }
}
