<?php
use \Src\Ebps\Controllers\DocumentAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/documents', 'as'=>'admin.ebps.documents.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[DocumentAdminController::class,'index'])->name('index');
    Route::get('/create',[DocumentAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[DocumentAdminController::class,'edit'])->name('edit');
});
