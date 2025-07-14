<?php

use Frontend\Pwa\PwaSmartboard\Controllers\PwaTvController;

Route::group(['middleware' => ['web'], 'prefix' => 'smartboard', 'as' => 'smartboard.'], function () {
    // Specific routes should come before the wildcard route
    Route::get('/notices/{ward?}', [PwaTvController::class, 'notices'])->name('notices');
    Route::get('/programs/{ward?}', [PwaTvController::class, 'programs'])->name('programs');
    Route::get('/videos/{ward?}', [PwaTvController::class, 'videos'])->name('videos');
    Route::get('/representatives/{ward?}', [PwaTvController::class, 'representatives'])->name('representatives');
    Route::get('/employees/{ward?}', [PwaTvController::class, 'employees'])->name('employees');

    // Wildcard route should be last
    Route::get('/{ward?}', [PwaTvController::class, 'index'])->name('index');
});