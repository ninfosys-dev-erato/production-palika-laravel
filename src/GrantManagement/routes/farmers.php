<?php
use \Src\GrantManagement\Controllers\FarmerAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/farmers', 'as'=>'admin.farmers.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[FarmerAdminController::class,'index'])->name('index');
    Route::get('/create',[FarmerAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[FarmerAdminController::class,'edit'])->name('edit');
    Route::get('/show/{id}',[FarmerAdminController::class,'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.farmers.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/farmer', [FarmerAdminController::class, 'reports'])->name('reports');
});
