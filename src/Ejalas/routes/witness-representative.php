<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\WitnessesRepresentativeAdminController;

Route::group(['prefix' => 'admin/ejalas/witnesses_representatives', 'as' => 'admin.ejalas.witnesses_representatives.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [WitnessesRepresentativeAdminController::class, 'index'])->name('index');
    Route::get('/create', [WitnessesRepresentativeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [WitnessesRepresentativeAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [WitnessesRepresentativeAdminController::class, 'preview'])->name('preview');
});
