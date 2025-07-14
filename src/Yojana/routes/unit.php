<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\UnitAdminController;

Route::group(['prefix' => 'admin/plan_management_system/units', 'as' => 'admin.units.', 'middleware' => ['web', 'auth','check_module:plan']], function () {
    Route::get('/', [UnitAdminController::class, 'index'])->name('index');
    Route::get('/create', [UnitAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [UnitAdminController::class, 'edit'])->name('edit');
});
