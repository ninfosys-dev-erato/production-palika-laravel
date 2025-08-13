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
            self::DRAFT => __('Draft'),
            self::SUBMITTED => __('Submitted'),
            self::ASSIGNED => __('Assigned'),
            self::ACTION_TAKEN => __('Action Taken'),
            self::UNDER_REVIEW => __('Under Review'),
            self::RESOLVED => __('Resolved'),
            self::PARTIALLY_RESOLVED => __('Partially Resolved'),
            self::REJECTED_NOT_RESOLVED => __('Rejected / Not Resolved'),
            self::ARCHIVED => __('Archived'),
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
            self::DRAFT => 'secondary',
            self::SUBMITTED => 'info',
            self::ASSIGNED => 'primary',
            self::ACTION_TAKEN => 'warning',
            self::UNDER_REVIEW => 'info',
            self::RESOLVED => 'success',
            self::PARTIALLY_RESOLVED => 'warning',
            self::REJECTED_NOT_RESOLVED => 'danger',
            self::ARCHIVED => 'dark',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->label()];
        })->toArray();
    }
}
