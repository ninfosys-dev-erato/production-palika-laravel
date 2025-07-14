<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BudgetSourceAdminController;

Route::group(['prefix' =>'admin/budget_sources', 'as'=>'admin.budget_sources.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [BudgetSourceAdminController::class, 'index'])->name('index');
    Route::get('/create', [BudgetSourceAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BudgetSourceAdminController::class, 'edit'])->name('edit');
});
