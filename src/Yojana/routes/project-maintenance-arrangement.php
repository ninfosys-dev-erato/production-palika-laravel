<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectMaintenanceArrangementAdminController;

Route::group(['prefix' =>'admin/project_maintenance_arrangements', 'as'=>'admin.project_maintenance_arrangements.','middleware'=>['web','auth', 'check_module:plan'] ], function () {
    Route::get('/',[ProjectMaintenanceArrangementAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectMaintenanceArrangementAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectMaintenanceArrangementAdminController::class,'edit'])->name('edit');
});
