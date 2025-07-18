<?php

namespace Src\Settings\Traits;

use Src\Settings\Models\MstSetting;

trait AdminSettings
{
    public function getConstant(string $key):string|int|float|bool|null
    {
        $row = MstSetting::where('key', $key)->firstOrFail();
        return $row->value??false;
    }

    public function getConstantWithKey(string $key):array
    {
        $row = MstSetting::where('key', $key)->firstOrFail();
        return [$row->key_id => $row->value];
    }
}