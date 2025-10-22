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
            self::Accepted => 'स्वीकृत',
            self::Rejected => 'अस्वीकृत',
            self::Pending => 'बाँकी',
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
}
