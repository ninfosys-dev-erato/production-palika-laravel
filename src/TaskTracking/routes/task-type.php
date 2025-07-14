<?php
use \Src\TaskTracking\Controllers\TaskTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/task-types', 'as'=>'admin.task-types.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[TaskTypeAdminController::class,'index'])->name('index')->middleware('permission:task_access');
    Route::get('/create',[TaskTypeAdminController::class,'create'])->name('create')->middleware('permission:task_type_create');
    Route::get('/edit/{id}',[TaskTypeAdminController::class,'edit'])->name('edit')->middleware('permission:task_type_update');
});
