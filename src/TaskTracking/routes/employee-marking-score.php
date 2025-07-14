<?php
use \Src\TaskTracking\Controllers\EmployeeMarkingScoreAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/task-reports/employee-marking-scores', 'as'=>'admin.employee_marking_scores.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[EmployeeMarkingScoreAdminController::class,'index'])->name('index');
    Route::get('/create',[EmployeeMarkingScoreAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EmployeeMarkingScoreAdminController::class,'edit'])->name('edit');
});
