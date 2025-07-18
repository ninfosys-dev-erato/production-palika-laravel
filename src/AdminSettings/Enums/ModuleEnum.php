<?php

namespace Src\AdminSettings\Enums;

enum ModuleEnum: string
{
    case User = \App\Models\User::class;
    case Customer = \Src\Customers\Models\Customer::class;
    case CustomerKyc = \Src\Customers\Models\CustomerKyc::class;
    case GrievanceDetail = \Src\Grievance\Models\GrievanceDetail::class;
    case Recommendation = \Src\Recommendation\Models\Recommendation::class;

    /**
     * Get the label for each module
     */
    public function label(): string
    {
        return self::getLabel($this);
    }

    /**
     * Match each enum case to a human-readable label
     */
    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::User => __('User'),
            self::Customer => __('Customer'),
            self::CustomerKyc => __('Customer Kyc'),
            self::GrievanceDetail => __('Grievance Detail'),
            self::Recommendation => __('Recommendation'),
        };
    }

    /**
     * Get the values with their labels as an array for forms, dropdowns, etc.
     */
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

    /**
     * Get values in an associative array for web display (keyed by value)
     */
    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }
}
