<?php
use \Src\GrantManagement\Controllers\GroupAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/groups', 'as'=>'admin.groups.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[GroupAdminController::class,'index'])->name('index');
    Route::get('/create',[GroupAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[GroupAdminController::class,'edit'])->name('edit');
    Route::get('/show/{id}',[GroupAdminController::class,'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.groups.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/groups', [GroupAdminController::class, 'reports'])->name('reports');
});
