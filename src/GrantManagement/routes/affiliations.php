<?php
use \Src\GrantManagement\Controllers\AffiliationAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/affiliations', 'as'=>'admin.affiliations.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[AffiliationAdminController::class,'index'])->name('index');
    Route::get('/create',[AffiliationAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AffiliationAdminController::class,'edit'])->name('edit');
});
