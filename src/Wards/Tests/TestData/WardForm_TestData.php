<?php

namespace Src\Wards\Tests\TestData;

class WardForm_TestData
{
    public static function validData(): array
    {
        return [
            // address_en (string)
            'address_en' => 'test',
            // address_ne (string)
            'address_ne' => 'test',
            // email (string)
            'email' => 'test@example.com',
            // id (int)
            'id' => 1,
            // phone (string)
            'phone' => '1234567890',
            // ward_name_en (string)
            'ward_name_en' => 'Test Name',
            // ward_name_ne (string)
            'ward_name_ne' => 'Test Name',
        ];
    }

    public static function invalidData(): array
    {
        return [
            // address_en (string)
            'address_en' => '', // Empty
            // address_ne (string)
            'address_ne' => '', // Empty
            // email (string)
            'email' => '', // Empty
            // id (int)
            'id' => '',
            // phone (string)
            'phone' => '', // Empty
            // ward_name_en (string)
            'ward_name_en' => '', // Empty
            // ward_name_ne (string)
            'ward_name_ne' => '', // Empty
        ];
    }
}
