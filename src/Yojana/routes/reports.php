<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ReportAdminController;

Route::group(['prefix' => 'admin/plan_management_system/reports', 'as' => 'admin.plan_reports.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/agreedPlans', [ReportAdminController::class, 'agreedPlans'])->name('agreedPlans');
    Route::get('/extendedPlans', [ReportAdminController::class, 'extendedPlans'])->name('extendedPlans');
    Route::get('/closedPlans', [ReportAdminController::class, 'closedPlans'])->name('closedPlans');
    Route::get('/planReport', [ReportAdminController::class, 'planReport'])->name('planReport');
    Route::get('/programReport', [ReportAdminController::class, 'programReport'])->name('programReport');
    Route::get('/paymentsReports', [ReportAdminController::class, 'paymentReport'])->name('paymentReport');
    Route::get('/plansByAllocatedBudget', [ReportAdminController::class, 'plansByAllocatedBudget'])->name('plansByAllocatedBudget');
    Route::get('/planGoalsReport', [ReportAdminController::class, 'planGoalsReport'])->name('planGoalsReport');
    Route::get('/costEstimationByArea', [ReportAdminController::class, 'costEstimationByArea'])->name('costEstimationByArea');
    Route::get('/planByCompletion', [ReportAdminController::class, 'planByCompletion'])->name('planByCompletion');
    Route::get('/costEstimationByBudgetSource', [ReportAdminController::class, 'costEstimationByBudgetSource'])->name('costEstimationByBudgetSource');
    Route::get('/costEstimationByDepartment', [ReportAdminController::class, 'costEstimationByDepartment'])->name('costEstimationByDepartment');
    Route::get('/costEstimationByExpenseHead', [ReportAdminController::class, 'costEstimationByExpenseHead'])->name('costEstimationByExpenseHead');
    Route::get('/activePlan', [ReportAdminController::class, 'activePlan'])->name('activePlan');
    Route::get('/taxDeductionReport', [ReportAdminController::class, 'taxDeductionReport'])->name('taxDeductionReport');
    Route::get('/wardPlansByArea', [ReportAdminController::class, 'wardPlansByArea'])->name('wardPlansByArea');
    Route::get('/wardPlansByBudget', [ReportAdminController::class, 'wardPlansByBudget'])->name('wardPlansByBudget');
    Route::get('/wardPlansByDepartment', [ReportAdminController::class, 'wardPlansByDepartment'])->name('wardPlansByDepartment');
    Route::get('/MunicipalityPlansByBudget', [ReportAdminController::class, 'MunicipalityPlansByBudget'])->name('MunicipalityPlansByBudget');
    Route::get('/plansByConsumerCommittee', [ReportAdminController::class, 'plansByConsumerCommittee'])->name('plansByConsumerCommittee');
    Route::get('/plansByOrganization', [ReportAdminController::class, 'plansByOrganization'])->name('plansByOrganization');
    Route::get('/overDuePlanReport', [ReportAdminController::class, 'overDuePlanReport'])->name('overDuePlanReport');
    Route::get('/planNearDeadline', [ReportAdminController::class, 'planNearDeadline'])->name('planNearDeadline');
    Route::get('/paidPlans', [ReportAdminController::class, 'paidPlans'])->name('paidPlans');
});
