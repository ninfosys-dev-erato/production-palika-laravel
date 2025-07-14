<?php

namespace Src\Ebps\Enums;

enum FormSubmitterEnum: string
{
    case HOUSEOWNER= 'house_owner';
    case CONSULTANT_SUPERVISOR = 'consultant_supervisor';
    case MUNICIPALITY = 'municipality';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::HOUSEOWNER => __('घरघनी'),
            self::CONSULTANT_SUPERVISOR => __('परामर्शदाता/सुपरिवेक्षक'),
            self::MUNICIPALITY => __('पालिका'),
        };
    }

    public static function getValuesWithLabels(): array
    {
        return array_map(fn($value) => [
            'value' => $value->value,
            'label' => $value->label(),
        ], self::cases());
    }
}
