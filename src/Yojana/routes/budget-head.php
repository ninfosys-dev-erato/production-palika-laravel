<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BudgetHeadAdminController;

Route::group(['prefix' =>'admin/budget_heads', 'as'=>'admin.budget_heads.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [BudgetHeadAdminController::class, 'index'])->name('index');
    Route::get('/create', [BudgetHeadAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BudgetHeadAdminController::class, 'edit'])->name('edit');
});
