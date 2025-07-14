<?php

namespace Src\TokenTracking\Enums;

enum TokenPurposeEnum: string
{
    case AUTHENTICATED_SERVICE_TOKEN = 'authenticated_service_token';
    case OTHER_SERVICE_TOKEN = 'other_service_token';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::AUTHENTICATED_SERVICE_TOKEN => 'एकीकृत सेवा टोकन',
            self::OTHER_SERVICE_TOKEN => 'अन्य सेवा टोकन',
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
