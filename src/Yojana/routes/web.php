<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\PlanDashboardController;

Route::group(['prefix' =>'admin/plan_management_system', 'as'=>'admin.plan.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[PlanDashboardController::class,'index'])->name('index');

});

