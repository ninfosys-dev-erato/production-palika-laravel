<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\SubRegionAdminController;

Route::group(['prefix' => 'admin/plan_management_system/sub_regions', 'as' => 'admin.sub_regions.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [SubRegionAdminController::class, 'index'])->name('index');
    Route::get('/create', [SubRegionAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [SubRegionAdminController::class, 'edit'])->name('edit');
});
