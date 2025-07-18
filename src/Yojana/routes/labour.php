<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\LabourAdminController;

Route::group(['prefix' =>'admin/labours', 'as'=>'admin.labours.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[LabourAdminController::class,'index'])->name('index');
    Route::get('/create',[LabourAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LabourAdminController::class,'edit'])->name('edit');
});
