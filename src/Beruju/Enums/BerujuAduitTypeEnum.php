<?php

namespace Src\Beruju\Enums;

enum BerujuAduitTypeEnum: string
{
    case INTERNAL_AUDIT = 'internal_audit';
    case EXTERNAL_AUDIT = 'external_audit';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::INTERNAL_AUDIT => __('beruju::beruju.internal_audit'),
            self::EXTERNAL_AUDIT => __('beruju::beruju.external_audit'),
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

    public static function getNepaliLabel(self $value): string
    {
        return match ($value) {
            self::INTERNAL_AUDIT => 'आन्तरिक लेखा परीक्षण',
            self::EXTERNAL_AUDIT => 'बाह्य लेखा परीक्षण',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::INTERNAL_AUDIT => 'primary',
            self::EXTERNAL_AUDIT => 'info',
        };
    }
}
