<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\MediatorSelectionAdminController;

Route::group(['prefix' => 'admin/ejalas/mediator_selections', 'as' => 'admin.ejalas.mediator_selections.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/{from?}', [MediatorSelectionAdminController::class, 'index'])->name('index');
    Route::get('/create/{from?}', [MediatorSelectionAdminController::class, 'create'])->name('create');
    Route::get('/edit/{from?}/{id}', [MediatorSelectionAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [MediatorSelectionAdminController::class, 'preview'])->name('preview');
    Route::get('/reconciliation/index', [MediatorSelectionAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});

Route::group(['prefix' => 'admin/mediator_selections', 'as' => 'admin.ejalas.reconciliation.mediator_selections.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/reconciliation/index', [MediatorSelectionAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
