<?php

use Frontend\CustomerPortal\PublicGrievance\Controllers\PublicGrievanceController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/public-grievance', [PublicGrievanceController::class, 'index'])->name('public-grievance');
    Route::get('/apply-grievance', [PublicGrievanceController::class, 'apply'])->name('apply-grievance');

   
});