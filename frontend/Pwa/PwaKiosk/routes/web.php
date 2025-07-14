<?php

use Frontend\Pwa\PwaKiosk\Controllers\PwaKioskController;

Route::group(['middleware' => ['web'], 'prefix' => 'pwa/kiosk', 'as' => 'pwa.kiosk.'], function () {
    Route::get('/{ward?}', [PwaKioskController::class, 'index'])->name('index');
    Route::get('/notices/{ward?}',[PwaKioskController::class,'notice'])->name('notice');
    Route::get('/program/{ward?}',[PwaKioskController::class,'program'])->name('program');
    Route::get('/citizen-charter/{ward?}',[PwaKioskController::class,'citizenCharter'])->name('citizen-charter');
    Route::get('/video/{ward?}',[PwaKioskController::class,'video'])->name('video');

});
