<?php

namespace Src\BusinessRegistration\Enums;

enum BusinessRegistrationType: string
{
    case REGISTRATION = 'registration';
    case DEREGISTRATION = 'de-registration';
    case Application = 'application';
    case RENEWAL = 'renewal';
    case CAPITAL_GROWTH = 'capital-growth';
    case ARCHIVING = 'archiving';
    case CHANGEREQUEST = 'change-request';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::REGISTRATION => __('Registration'),
            self::DEREGISTRATION => __('Deregistration'),
            self::Application => __('Application'),
            self::RENEWAL => __('Renewal'),
            self::CAPITAL_GROWTH => __('Capital Growth'),
            self::ARCHIVING => __('Archiving'),
            self::CHANGEREQUEST => __('Change Request'),
        };
    }

    public static function getNepaliLabel(self $value): string
    {
        return match ($value) {
            self::REGISTRATION => 'दर्ता',
            self::DEREGISTRATION => 'खारेज',
            self::Application => 'निवेदन',
            self::RENEWAL => 'नवीकरण',
            self::CAPITAL_GROWTH => 'पूँजी वृद्धि',
            self::ARCHIVING => 'अभिलेखिकरण',
            self::CHANGEREQUEST => 'परिवर्तन अनुरोध',
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

    public static function getForWebInNepali(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = self::getNepaliLabel($value);
        }

        return $valuesWithLabels;
    }
}
