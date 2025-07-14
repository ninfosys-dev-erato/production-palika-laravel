<?php

namespace Src\Ebps\Enums;

enum ApplicationTypeEnum: string
{
    case MAP_APPLIES = 'map_applies';
    case OLD_APPLICATIONS = 'old_applications';
    case BUILDING_DOCUMENTATION = 'building_documentation';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::MAP_APPLIES => __('नक्शा सम्बन्धि आवेदन'),
            self::OLD_APPLICATIONS => __('पुराना आवेदनहरु'),
            self::BUILDING_DOCUMENTATION => __('घर अभिलेखीकरण सम्बन्धि'),
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
