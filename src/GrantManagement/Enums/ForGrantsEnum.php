<?php

namespace Src\GrantManagement\Enums;

enum ForGrantsEnum: string
{
    case FARMER = 'farmer';
    case COOPERATIVE = 'cooperative';
    case GROUP = 'group';
    case HUSTLE = 'hustle';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::FARMER => __('Farmer'),
            self::COOPERATIVE => __('Cooperative'),
            self::GROUP => __('Group'),
            self::HUSTLE => __('Hustle'),
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