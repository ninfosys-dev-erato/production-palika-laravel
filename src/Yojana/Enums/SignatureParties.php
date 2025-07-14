<?php


namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum SignatureParties: string implements EnumInterface
{
    case ImplementationAgency = 'implementation_agency';
    case Ward = 'ward';
    case PlanningDepartment = 'planning_department';
    case Office = 'office';
    case Other = 'other';


    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
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

    public static function getLabel(EnumInterface $value): string
    {
        return match ($value) {
            self::ImplementationAgency => __('yojana::yojana.implementation_agency'),
            self::Ward => __('yojana::yojana.ward'),
            self::PlanningDepartment => __('yojana::yojana.planning_department'),
            self::Office => __('yojana::yojana.office'),
            self::Other => __('yojana::yojana.other'),
        };

    }
}

