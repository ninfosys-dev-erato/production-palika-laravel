<?php

namespace Src\Ebps\Enums;

enum DocumentTypeEnum: string
{
    case MAP_APPLY = 'map_apply';
    case BUILDING_DOCUMENT = 'building_document';
    case OLD_APPLICATION = 'old_application';
    case HOUSE_OWNER_CHANGE = 'house_owner_change';
    case ORGANIZATION_CHANGE = 'organization_change';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::MAP_APPLY => __('नक्सा पास'),
            self::BUILDING_DOCUMENT => __('भवन सम्बन्धी कागजात'),
            self::OLD_APPLICATION => __('पुरानो दरखास्त'),
            self::HOUSE_OWNER_CHANGE => __('घरधनी परिवर्तन'),
            self::ORGANIZATION_CHANGE => __('संस्था/परामर्शदाता परिवर्तन'),
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
