<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BudgetTransferController;


Route::group(['prefix' => 'admin/plan_management_system/budget_transfer', 'as' => 'admin.budget_transfer.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [BudgetTransferController::class, 'index'])->name('index');
    Route::get('/create', [BudgetTransferController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BudgetTransferController::class, 'edit'])->name('edit');
});
