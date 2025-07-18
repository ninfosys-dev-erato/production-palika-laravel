<?php


namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum ImplementationMethods: string implements EnumInterface
{

    case OperatedByConsumerCommittee = 'operated_by_consumer_committee';
    case OperatedByNGO = 'operated_by_ngo';
    case OperatedByTrust = 'operated_by_trust';
    case OperatedByQuotation = 'operated_by_quotation';
    case OperatedByContract = 'operated_by_contract';


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
            self::OperatedByConsumerCommittee => __('yojana::yojana.operated_by_consumer_committee'),
            self::OperatedByNGO => __('yojana::yojana.operated_by_ngo'),
            self::OperatedByTrust => __('yojana::yojana.operated_by_trust'),
            self::OperatedByQuotation => __('yojana::yojana.operated_by_quotation'),
            self::OperatedByContract => __('yojana::yojana.operated_by_contract'),
        };
    }
}
