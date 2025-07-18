<?php

namespace App\Contracts;


interface EnumInterface
{
    public function label(): string;

    public static function getForWeb(): array;

    public static function getValuesWithLabels(): array;

    public static function getLabel(EnumInterface $value): string;
}
