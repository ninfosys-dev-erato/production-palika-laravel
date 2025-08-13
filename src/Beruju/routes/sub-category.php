<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\SubCategoryAdminController;

Route::group(['prefix' => 'admin/beruju/sub-categories', 'as' => 'admin.beruju.sub-categories.', 'middleware' => ['web', 'auth', 'check_module:beruju']], function () {
    Route::get('/', [SubCategoryAdminController::class, 'index'])->name('index');
    Route::get('/create', [SubCategoryAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [SubCategoryAdminController::class, 'edit'])->name('edit');
});
