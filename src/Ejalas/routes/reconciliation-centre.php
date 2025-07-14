<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\ReconciliationCenterAdminController;

Route::group(['prefix' => 'admin/ejalas/reconciliation_centers', 'as' => 'admin.ejalas.reconciliation_centers.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [ReconciliationCenterAdminController::class, 'index'])->name('index');
    Route::get('/create', [ReconciliationCenterAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ReconciliationCenterAdminController::class, 'edit'])->name('edit');
});
