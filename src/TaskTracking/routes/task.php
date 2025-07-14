<?php
use Src\TaskTracking\Controllers\TaskTrackingDashboardController;
use \Src\TaskTracking\Controllers\TaskAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/tasks', 'as'=>'admin.tasks.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[TaskAdminController::class,'index'])->name('index')->middleware('permission:task_access');
    Route::get('/create',[TaskAdminController::class,'create'])->name('create')->middleware('permission:task_create');
    Route::get('/edit/{id}',[TaskAdminController::class,'edit'])->name('edit')->middleware('permission:task_update');
    Route::get('/view/{id}',[TaskAdminController::class,'view'])->name('view')->middleware('permission:task_view');
});
Route::group(['prefix' =>'admin/task-tracking', 'as'=>'admin.task-tracking.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[TaskTrackingDashboardController::class,'index'])->name('index');
});
