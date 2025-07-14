<?php

use \Src\FuelSettings\Controllers\VehicleCategoryAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/vehicle_categories', 'as' => 'admin.vehicle_categories.', 'middleware' => ['web', 'auth','check_module:fuel']], function () {
    Route::get('/', [VehicleCategoryAdminController::class, 'index'])->name('index');
    Route::get('/create', [VehicleCategoryAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [VehicleCategoryAdminController::class, 'edit'])->name('edit');
});
