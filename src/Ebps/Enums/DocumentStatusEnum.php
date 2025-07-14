<?php

namespace Src\Ebps\Enums;

enum DocumentStatusEnum : string
{

    case REQUESTED = 'requested';
    case UPLOADED = 'uploaded';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::REQUESTED => __('Requested'),
            self::UPLOADED => __('Uploaded'),
            self::VERIFIED => __('Verified'),
            self::REJECTED => __('Rejected'),

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

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }
}
