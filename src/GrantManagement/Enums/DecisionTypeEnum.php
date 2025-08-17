<?php

namespace Src\GrantManagement\Enums;

enum DecisionTypeEnum: string
{
    case CHAIRMAN_ORDER = 'chairman_order';
    case EXECUTIVE_DECISION = 'executive_decision';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::CHAIRMAN_ORDER => __('grantmanagement::grantmanagement.chairman_order'),
            self::EXECUTIVE_DECISION => __('grantmanagement::grantmanagement.executive_decision'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[] = [
                'value' => $value->value,
                'label' => $value->label(),
            ];
        }

        return $valuesWithLabels;
    }
}
