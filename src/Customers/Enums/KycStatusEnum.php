<?php

namespace Src\Customers\Enums;

enum KycStatusEnum: string
{
    case PENDING = 'pending';
    case REVIEWING = 'reviewing';
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
            self::REVIEWING => __('Reviewing'),
            self::REJECTED => __('Rejected'),
            self::ACCEPTED => __('Accepted'),
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
