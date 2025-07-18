<?php

use Illuminate\Support\Facades\Route;
use Src\TaskTracking\Controllers\CriterionAdminController;

Route::group(['prefix' =>'admin/task-reports/criteria', 'as'=>'admin.criteria.','middleware'=>['web','auth','check_module:task_tracking'] ], function () {
    Route::get('/',[CriterionAdminController::class,'index'])->name('index');
    Route::get('/create',[CriterionAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CriterionAdminController::class,'edit'])->name('edit');
});
