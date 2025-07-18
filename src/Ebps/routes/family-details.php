<?php
use \Src\Ebps\Controllers\CustomerFamilyDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/customer-family-details', 'as'=>'admin.customer_family_details.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[CustomerFamilyDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[CustomerFamilyDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CustomerFamilyDetailAdminController::class,'edit'])->name('edit');
});
