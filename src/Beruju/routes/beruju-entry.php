<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\BerujuEntryAdminController;
use Src\Beruju\Controllers\BerujuDashboardController;

Route::group(['prefix' => 'admin/beruju', 'as' => 'admin.beruju.registration.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [BerujuEntryAdminController::class, 'index'])->name('index');
    Route::get('/create', [BerujuEntryAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BerujuEntryAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [BerujuEntryAdminController::class, 'view'])->name('show');
    Route::get('/preview/{id}', [BerujuEntryAdminController::class, 'preview'])->name('preview');
});

Route::group(['prefix' => 'admin/beruju', 'as' => 'admin.beruju.dashboard.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [BerujuDashboardController::class, 'index'])->name('dashboard');
});
