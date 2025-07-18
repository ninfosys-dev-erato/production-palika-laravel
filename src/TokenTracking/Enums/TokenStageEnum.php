<?php

namespace Src\TokenTracking\Enums;

enum TokenStageEnum: string
{
    case ENTRY = 'entry';
    case TOKEN_ORDER = 'token_order';
    case REGISTRATION = 'registration';
    case VERIFICATION = 'verification';
    case COMPLETION = 'completion';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::ENTRY => 'प्रवेश',
            self::TOKEN_ORDER => 'तोक आदेश',
            self::REGISTRATION => 'दर्ता',
            self::VERIFICATION => 'वर्गीकरण',
            self::COMPLETION => 'सम्पादन',
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
