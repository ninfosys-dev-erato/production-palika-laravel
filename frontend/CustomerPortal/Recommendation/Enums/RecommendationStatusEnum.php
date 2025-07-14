<?php

namespace Src\Recommendation\Enums;

enum RecommendationStatusEnum: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case SENT_FOR_PAYMENT = 'sent for payment';
    case BILL_UPLOADED = 'bill uploaded';
    case SENT_FOR_APPROVAL = 'sent for approval';
    case ACCEPTED = 'accepted';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::PENDING => __('Pending'),
            self::REJECTED => __('Rejected'),
            self::SENT_FOR_PAYMENT => __('Sent For Payment'),
            self::BILL_UPLOADED => __('Bill Uploaded'),
            self::SENT_FOR_APPROVAL => __('Sent for Approval'),
            self::ACCEPTED => __('Accepted'),
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
}