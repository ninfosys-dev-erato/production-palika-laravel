<?php

use \Src\Pages\Controllers\PageAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/pages', 'as' => 'admin.pages.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [PageAdminController::class, 'index'])->name('index')->middleware('permission:page access');
    Route::get('/create', [PageAdminController::class, 'create'])->name('create')->middleware('permission:page create');
    Route::get('/edit/{id}', [PageAdminController::class, 'edit'])->name('edit')->middleware('permission:page edit');
});
