<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ExpenseHeadAdminController;

Route::group(['prefix' => 'admin/plan_management_system/expense_heads', 'as' => 'admin.expense_heads.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [ExpenseHeadAdminController::class, 'index'])->name('index');
    Route::get('/create', [ExpenseHeadAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ExpenseHeadAdminController::class, 'edit'])->name('edit');
});
