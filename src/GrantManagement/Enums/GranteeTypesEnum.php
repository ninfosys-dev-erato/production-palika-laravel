<?php

namespace Src\GrantManagement\Enums;

use Src\GrantManagement\Models\Farmer;

enum GranteeTypesEnum: string
{
    case FARMER = "Src\GrantManagement\Models\Farmer";
    case GROUP =  "Src\GrantManagement\Models\Group";
    case ENTERPRISE =  "Src\GrantManagement\Models\Enterprise";
    case COOPERATIVE = "Src\GrantManagement\Models\Cooperative";

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::FARMER => __('Farmer'),
            self::GROUP => __('Group'),
            self::ENTERPRISE => __('Enterprise'),
            self::COOPERATIVE => __('Cooperative'),
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
