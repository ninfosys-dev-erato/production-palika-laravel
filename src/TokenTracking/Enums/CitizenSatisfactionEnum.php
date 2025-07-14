<?php

namespace Src\TokenTracking\Enums;

enum CitizenSatisfactionEnum: string
{
    case SATISFIED = 'Satisfied';
    case DISSATISFIED = 'Dissatisfied';
    case NO_FEEDBACK = 'No Feedback';
    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::SATISFIED => 'सन्तुष्ट',
            self::DISSATISFIED => 'असन्तुष्ट',
            self::NO_FEEDBACK => 'प्रतिक्रिया नदिएको',
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
