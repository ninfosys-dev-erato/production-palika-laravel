<?php

namespace Src\Beruju\Enums;

enum BerujuSubmissionStatusEnum: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case UNDER_REVIEW = 'under_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::DRAFT => __('beruju::beruju.draft'),
            self::SUBMITTED => __('beruju::beruju.submitted'),
            self::UNDER_REVIEW => __('beruju::beruju.under_review'),
            self::APPROVED => __('beruju::beruju.approved'),
            self::REJECTED => __('beruju::beruju.rejected'),
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
            self::UNDER_REVIEW => 'समिक्षामा',
            self::APPROVED => 'स्वीकृत',
            self::REJECTED => 'अस्वीकृत',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => '#6c757d',
            self::SUBMITTED => '#17a2b8',
            self::UNDER_REVIEW => '#ffc107',
            self::APPROVED => '#28a745',
            self::REJECTED => '#dc3545',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->label()];
        })->toArray();
    }
}
