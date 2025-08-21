<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\BerujuReportController;

Route::group(['prefix' => 'admin/beruju/reports', 'as' => 'admin.beruju.reports.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [BerujuReportController::class, 'index'])->name('index');
});
