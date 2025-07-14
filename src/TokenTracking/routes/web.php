<?php

use \Src\TokenTracking\Controllers\RegisterTokenAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/register-tokens', 'as' => 'admin.register_tokens.', 'middleware' => ['web', 'auth','check_module:token']], function () {
    Route::get('/', [RegisterTokenAdminController::class, 'index'])->name('index');
    Route::get('/create', [RegisterTokenAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [RegisterTokenAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [RegisterTokenAdminController::class, 'view'])->name('view');
    Route::get('/update/{id}', [RegisterTokenAdminController::class, 'update'])->name('status');
});

Route::group(['prefix' => 'admin/search_token', 'as' => 'admin.searchToken.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/search', [RegisterTokenAdminController::class, 'searchToken'])->name('searchToken');
});
Route::group(['prefix' => 'admin/register-tokens', 'as' => 'admin.tokenReport.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/report', [RegisterTokenAdminController::class, 'report'])->name('report');
});

Route::group(['prefix' => 'admin/token-tracking', 'as' => 'admin.token_dashboard.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [RegisterTokenAdminController::class, 'dashboard'])->name('dashboard');
});
