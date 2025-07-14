<?php

use Frontend\Pwa\PwaTv\Controllers\PwaTvController;

Route::group(['middleware' => ['web'], 'prefix' => 'pwa-tv', 'as' => 'pwa.digital-board.'], function () {
    Route::get('/{ward?}', [PwaTVController::class, 'index'])->name('index');
});
