<?php

use Frontend\CustomerPortal\DartaChalani\Controllers\DartaChalaniController;

Route::group(['middleware' => ['web', 'customer'], 'prefix' => 'customer/darta_chalani', 'as' => 'customer.darta_chalani.'], function () {
    Route::get('/', [DartaChalaniController::class, 'index'])->name('index');
   
});