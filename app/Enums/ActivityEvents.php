<?php

namespace App\Enums;

enum ActivityEvents: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
    case CUSTOMER_LOGIN = 'customer-login';
    case CUSTOMER_LOGOUT = 'customer-logout';
    case USER_LOGIN = 'user-login';
    case USER_LOGOUT = 'user-logout';
    case BUSINESS_LOGIN = 'business-login';
    case BUSINESS_LOGOUT = 'business-logout';

    public function label():string
    {
        return self::getLabel($this);
    }

    public function getLabel(self $value):string
    {
        return match ($value) {
            self::CREATED => __('Created'),
            self::UPDATED => __('Updated'),
            self::DELETED => __('Deleted'),
            self::CUSTOMER_LOGIN => __('Customer Logged IN'),
            self::CUSTOMER_LOGOUT => __('Customer Logged Out'),
            self::USER_LOGIN => __('User Logged In'),
            self::BUSINESS_LOGIN => __('Business Logged In'),
            self::BUSINESS_LOGOUT => __('Business Logged Out'),
        };
    }

    public function getValuesWithLabel()
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
