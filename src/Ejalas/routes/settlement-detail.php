<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\SettlementDetailAdminController;

Route::group(['prefix' => 'admin/ejalas/settlement_details', 'as' => 'admin.ejalas.settlement_details.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [SettlementDetailAdminController::class, 'index'])->name('index');
    Route::get('/create', [SettlementDetailAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [SettlementDetailAdminController::class, 'edit'])->name('edit');
});
