<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\MeasurementUnitAdminController;

Route::group(['prefix' => 'admin/plan_management_system/measurement_units', 'as' => 'admin.measurement_units.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [MeasurementUnitAdminController::class, 'index'])->name('index');
    Route::get('/create', [MeasurementUnitAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [MeasurementUnitAdminController::class, 'edit'])->name('edit');
});
