<?php

namespace Src\Pages\Tests\TestData;

class PageForm_TestData
{
    public static function validData(): array
    {
        return [
            // slug (string)
            'slug' => 'test',
            // title (string)
            'title' => 'test',
        ];
    }

    public static function invalidData(): array
    {
        return [
            // slug (string)
            'slug' => '', // Empty
            // title (string)
            'title' => '', // Empty
        ];
    }
}
