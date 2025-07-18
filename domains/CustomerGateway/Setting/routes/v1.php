<?php

use Domains\CustomerGateway\Setting\Api\SettingsHandler;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1/settings', 'as' => 'api.settings.', 'middleware' => ['setLocale']], function () {
    Route::get('/', [SettingsHandler::class, 'settingGroup'] );
});

