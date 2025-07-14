<?php

namespace Src\BusinessRegistration\Enums;

enum ApplicationStatusEnum: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case SENT_FOR_PAYMENT = 'sent for payment';
    case BILL_UPLOADED = 'bill uploaded';
    case SENT_FOR_APPROVAL = 'sent for approval';
    case ACCEPTED = 'accepted';
    case SENT_FOR_RENEWAL = 'sent for renewal';

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
            self::SENT_FOR_RENEWAL => __('Sent for renewal')
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
            self::PENDING => 'विचाराधीन',
            self::REJECTED => 'अस्वीकृत',
            self::SENT_FOR_PAYMENT => 'भुक्तानीको लागि पठाइएको',
            self::BILL_UPLOADED => 'बिल अपलोड गरिएको',
            self::SENT_FOR_APPROVAL => 'स्वीकृतिका लागि पठाइएको',
            self::ACCEPTED => 'स्वीकृत',
            self::SENT_FOR_RENEWAL => 'नवीकरणको लागि पठाइएको',
        };
    }
    public static function getForWebInNepali(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = self::getNepaliLabel($value);
        }

        return $valuesWithLabels;
    }
}
