<?php

namespace Src\Recommendation\Enums;

enum RecommendationMediumEnum: string
{
    case MOBILE= 'mobile'; 
    case WEB= 'web'; 
    case SYSTEM = 'system'; 


    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
           
            self::MOBILE => __('mobile'),
            self::WEB => __('web'),
            self::SYSTEM => __('system'),
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

}
