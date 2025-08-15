<?php

namespace Src\Beruju\Enums;

enum BerujuStatusEnum: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case ASSIGNED = 'assigned';
    case ACTION_TAKEN = 'action_taken';
    case UNDER_REVIEW = 'under_review';
    case RESOLVED = 'resolved';
    case PARTIALLY_RESOLVED = 'partially_resolved';
    case REJECTED_NOT_RESOLVED = 'rejected_not_resolved';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::DRAFT => __('beruju::beruju.draft'),
            self::SUBMITTED => __('beruju::beruju.submitted'),
            self::ASSIGNED => __('beruju::beruju.assigned'),
            self::ACTION_TAKEN => __('beruju::beruju.action_taken'),
            self::UNDER_REVIEW => __('beruju::beruju.under_review'),
            self::RESOLVED => __('beruju::beruju.resolved'),
            self::PARTIALLY_RESOLVED => __('beruju::beruju.partially_resolved'),
            self::REJECTED_NOT_RESOLVED => __('beruju::beruju.rejected_not_resolved'),
            self::ARCHIVED => __('beruju::beruju.archived'),
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
            self::DRAFT => 'मस्यौदा',
            self::SUBMITTED => 'पेश गरएको',
            self::ASSIGNED => 'जिम्मेवारी तोकेको',
            self::ACTION_TAKEN => 'कार्य गर्यो',
            self::UNDER_REVIEW => 'समिक्षामा',
            self::RESOLVED => 'फस्यट भयो',
            self::PARTIALLY_RESOLVED => 'आंशिक फस्यट',
            self::REJECTED_NOT_RESOLVED => 'अस्वीकृत / नभएको',
            self::ARCHIVED => 'अभिलेख राख्यो',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => '#6c757d',
            self::SUBMITTED => '#17a2b8',
            self::ASSIGNED => '#007bff',
            self::ACTION_TAKEN => '#ffc107',
            self::UNDER_REVIEW => '#17a2b8',
            self::RESOLVED => '#28a745',
            self::PARTIALLY_RESOLVED => '#ffc107',
            self::REJECTED_NOT_RESOLVED => '#dc3545',
            self::ARCHIVED => '#343a40',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->label()];
        })->toArray();
    }
}
