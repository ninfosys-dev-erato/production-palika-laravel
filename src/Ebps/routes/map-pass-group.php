<?php
use \Src\Ebps\Controllers\MapPassGroupAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/map-pass-groups', 'as'=>'admin.ebps.map_pass_groups.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[MapPassGroupAdminController::class,'index'])->name('index');
    Route::get('/create',[MapPassGroupAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MapPassGroupAdminController::class,'edit'])->name('edit');
});
