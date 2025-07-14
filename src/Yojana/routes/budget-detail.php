<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BudgetDetailAdminController;

Route::group(['prefix' =>'admin/budget_details', 'as'=>'admin.budget_details.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [BudgetDetailAdminController::class, 'index'])->name('index');
    Route::get('/create', [BudgetDetailAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BudgetDetailAdminController::class, 'edit'])->name('edit');
});
