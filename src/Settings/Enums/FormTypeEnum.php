<?php

namespace Src\Settings\Enums;

enum FormTypeEnum: string
{
    case TEXT = 'text';
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case RADIO = 'radio';

    case FILE = 'file';
    case TABLE = 'table';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::TEXT => 'Text',
            self::SELECT => 'Select',
            self::CHECKBOX => 'Checkbox',
            self::RADIO => 'Radio',
            self::FILE => 'File',
            self::TABLE => 'Table',

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
