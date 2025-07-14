<?php
use \Src\TaskTracking\Controllers\ProjectAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/task/projects', 'as'=>'admin.task.projects.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[ProjectAdminController::class,'index'])->name('index')->middleware('permission:project_access');
    Route::get('/create',[ProjectAdminController::class,'create'])->name('create')->middleware('permission:project_create');
    Route::get('/edit/{id}',[ProjectAdminController::class,'edit'])->name('edit')->middleware('permission:project_update');
});
