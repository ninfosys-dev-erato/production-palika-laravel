<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProgramAdminController;

Route::group(['prefix' => 'admin/plan_management_system/programs', 'as' => 'admin.programs.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [ProgramAdminController::class, 'index'])->name('index');
    Route::get('/create', [ProgramAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProgramAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [ProgramAdminController::class, 'show'])->name('show');

});
