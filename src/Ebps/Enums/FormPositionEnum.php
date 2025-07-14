<?php

namespace Src\Ebps\Enums;

enum FormPositionEnum: string
{
    case BEFORE_FILLING_APPLICATION = 'before_filling_application';
    case AFTER_FILLING_APPLICATION = 'after_filling_application';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::BEFORE_FILLING_APPLICATION => __('दरखास्त फारम भर्नु भन्दा अगाडी'),
            self::AFTER_FILLING_APPLICATION => __('दरखास्त फारम भरी सके पछि'),
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
