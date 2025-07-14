<?php

namespace Src\TokenTracking\Enums;

enum TokenStatusEnum: string
{
    case COMPLETE = 'complete';
    case PROCESSING = 'processing';
    case SKIPPING = 'skipping';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::COMPLETE => 'सम्पन्न',
            self::PROCESSING => 'प्रक्रियामा',
            self::SKIPPING => 'छोडिएको',
            self::REJECTED => 'अस्वीकृत',
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
