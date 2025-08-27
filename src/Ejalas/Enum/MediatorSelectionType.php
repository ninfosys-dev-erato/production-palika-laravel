<?php

namespace Src\Ejalas\Enum;

enum MediatorSelectionType: string
{
    case MUTUALLY_SELECTED = 'mutually_selected';
    case SELECTED_BY_FIRST_PARTY = 'selected_by_first_party';
    case SELECTED_BY_SECOND_PARTY = 'selected_by_second_party';
    case SELECTED_BY_BOTH_PARTY = 'selected_by_both_party';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::MUTUALLY_SELECTED => __('Mutually Selected'),
            self::SELECTED_BY_FIRST_PARTY => __('Selected by First Party'),
            self::SELECTED_BY_SECOND_PARTY => __('Selected by Second Party'),
            self::SELECTED_BY_BOTH_PARTY => __('Selected by Both Party'),
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

    public static function getNepaliLabel(self $value): string
    {
        return match ($value) {
            self::MUTUALLY_SELECTED => 'परस्पर छानिएको',
            self::SELECTED_BY_FIRST_PARTY => 'पहिलो पक्षद्वारा छानिएको',
            self::SELECTED_BY_SECOND_PARTY => 'दोस्रो पक्षद्वारा छानिएको',
            self::SELECTED_BY_BOTH_PARTY => 'दुवै पक्षद्वारा छानिएको',
        };
    }

    public static function getForWebInNepali(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = self::getNepaliLabel($value);
        }

        return $valuesWithLabels;
    }
}
