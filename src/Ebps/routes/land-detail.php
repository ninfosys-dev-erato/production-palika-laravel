<?php
use \Src\Ebps\Controllers\CustomerLandDetaiAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/customer-land-detais', 'as'=>'admin.customer_land_detais.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[CustomerLandDetaiAdminController::class,'index'])->name('index');
    Route::get('/create',[CustomerLandDetaiAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CustomerLandDetaiAdminController::class,'edit'])->name('edit');
});
