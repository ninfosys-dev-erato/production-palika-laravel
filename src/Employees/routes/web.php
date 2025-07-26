<?php

use Src\Employees\Controllers\BranchController;
use Illuminate\Support\Facades\Route;
use Src\Employees\Controllers\DesignationController;
use Src\Employees\Controllers\EmployeeController;

Route::group(['prefix' => 'admin/employees', 'as' => 'admin.employee.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/branch', [BranchController::class, 'index'])->name('branch.index')->middleware('permission:branch_access');
    Route::get('/branch/create', [BranchController::class, 'create'])->name('branch.create')->middleware('permission:branch_create');
    Route::get('/branch/edit/{id}', [BranchController::class, 'edit'])->name('branch.edit')->middleware('permission:branch_update');
    Route::get('/branch/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete')->middleware('permission:branch_delete');
    Route::get('/branch/employee/{branchname}', [BranchController::class, 'showEmployee'])->name('branch.showemployee');

    Route::get('/designation', [DesignationController::class, 'index'])->name('designation.index')->middleware('permission:designation_access');
    Route::get('/designation/create', [DesignationController::class, 'create'])->name('designation.create')->middleware('permission:designation_create');
    Route::get('/designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation.edit')->middleware('permission:designation_update');

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index')->middleware('permission:employee access');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create')->middleware('permission:employee create');
    Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware('permission:employee update');
});
