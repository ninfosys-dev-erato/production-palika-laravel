<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\PlanAdminController;

Route::group(['prefix' => 'admin/plan_management_system/plans', 'as' => 'admin.plans.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [PlanAdminController::class, 'index'])->name('index');
    Route::get('/create', [PlanAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [PlanAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [PlanAdminController::class, 'show'])->name('show');
    Route::get('/print/{id}', [PlanAdminController::class, 'print'])->name('print');
    Route::get('/cost_estimation/print/{id}', [PlanAdminController::class, 'downloadPdf'])->name('cost-estimation.print');

});
