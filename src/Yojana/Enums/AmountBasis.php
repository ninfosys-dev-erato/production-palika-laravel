<?php


namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum AmountBasis: string implements EnumInterface
{

    //    case allocated_budget = 'Allocated Budget';
    //    case estimated_subtotal_excluding_vat = 'Estimated SubTotal (Excluding Vat)';
    //    case estimated_subtotal_including_vat = 'Estimated SubTotal (Including Vat)';
    //    case running_total = 'Running Total';
    //    case other = 'Other';

    case AllocatedBudget = 'allocated_budget';
    case EstimatedSubTotalExcludingVat = 'estimated_subtotal_excluding_vat';
    case EstimatedSubTotalIncludingVat = 'estimated_subtotal_including_vat';
    case RunningTotal = 'running_total';
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
            self::AllocatedBudget => __('yojana::yojana.allocated_budget'),
            self::EstimatedSubTotalExcludingVat => __('yojana::yojana.estimated_subtotal_excluding_vat'),
            self::EstimatedSubTotalIncludingVat => __('yojana::yojana.estimated_subtotal_including_vat'),
            self::RunningTotal => __('yojana::yojana.running_total'),
            self::Other => __('yojana::yojana.other'),
        };
    }
}
