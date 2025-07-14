<?php
use \Src\Ebps\Controllers\StructureTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/structure_types', 'as'=>'admin.structure_types.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[StructureTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[StructureTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[StructureTypeAdminController::class,'edit'])->name('edit');
});
