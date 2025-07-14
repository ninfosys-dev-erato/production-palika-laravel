<?php

use Illuminate\Support\Facades\Route;
use Src\TaskTracking\Controllers\EmployeeMarkingAdminController;

Route::group(['prefix' =>'admin/task-reports/employee-markings', 'as'=>'admin.employee_markings.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[EmployeeMarkingAdminController::class,'index'])->name('index');
    Route::get('/create',[EmployeeMarkingAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EmployeeMarkingAdminController::class,'edit'])->name('edit');
});
