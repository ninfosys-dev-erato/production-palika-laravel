<?php

namespace Src\Downloads\Tests\TestData;

class DownloadForm_TestData
{
    public static function validData(): array
    {
        return [
            // order (int)
            'order' => 1,
            // status (boolean)
            'status' => true,
            // title (string)
            'title' => 'test',
            // title_en (string)
            'title_en' => 'test',
        ];
    }

    public static function invalidData(): array
    {
        return [
            // order (int)
            'order' => 'invalid-number',
            // status (boolean)
            'status' => 'not-a-boolean',
            // title (string)
            'title' => '', // Empty
            // title_en (string)
            'title_en' => '', // Empty
        ];
    }
}
