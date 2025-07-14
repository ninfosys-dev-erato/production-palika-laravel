<?php

use Illuminate\Support\Facades\Route;
use Src\Customers\Controllers\CustomerController;

Route::group(['middleware' => ['auth', 'web'], 'prefix' => 'admin/customers', 'as' => 'admin.customer.'], function () {
    Route::resource('/', CustomerController::class)->middleware('permission:customer_access');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('detail');
});
