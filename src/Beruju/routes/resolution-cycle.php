<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\ResolutionCycleAdminController;

Route::group(['prefix' => 'admin/beruju/resolution-cycles', 'as' => 'admin.beruju.resolution-cycles.', 'middleware' => ['web', 'auth', 'check_module:beruju']], function () {
    Route::get('/', [ResolutionCycleAdminController::class, 'index'])->name('index');
    Route::get('/create', [ResolutionCycleAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ResolutionCycleAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [ResolutionCycleAdminController::class, 'show'])->name('show');
});
