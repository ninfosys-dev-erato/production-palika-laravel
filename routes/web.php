<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LocalFileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UploadController;
use Frontend\CustomerPortal\DigitalBoard\Controllers\DigitalBoardController;
use Illuminate\Support\Facades\Route;


Route::get('/user/register', [AuthController::class, 'showRegisterForm'])->name('showForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [FrontController::class, 'login'])->name('digital-service');
Route::post('/login', [AuthController::class, 'customerLogin'])->name('customer.authenticate');
Route::get('/services', [FrontController::class, 'services'])->name('services');


Route::get('auth/login', [AuthController::class, 'login'])->name('login');
Route::post('auth/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

Route::prefix('customer')->name('customer.')->middleware('customer')->group(function () {
    Route::get('/dashboard', function () {
        return view("customerDashboard");
    })->name('dashboard');

    Route::get('/change-password',[AuthController::class,'changePassword'])->name('change-password');
    Route::any('/logout', [AuthController::class, 'customerLogout'])->name('logout');
});
Route::post('/upload', [UploadController::class, 'store'])->name('ckeditor.upload');

// Local file serving route (for temporary files before cloud transfer)
Route::get('/local-file', [LocalFileController::class, 'serve'])->name('local-file.serve');

require __DIR__ . '/admin.php';

Route::post('/change-language', [DigitalBoardController::class, 'changeLanguage'])->name('change-language');

Route::get('/organization/login', [OrganizationController::class, 'login'])->name('organization-login');
Route::post('/organization/login', [OrganizationController::class, 'organizationLogin'])->name('organization.authenticate');
Route::get('/organization/register', [OrganizationController::class, 'organizationRegister'])->name('organization.register');


Route::prefix('organization')->name('organization.')->middleware('auth:organization')->group(function () {
    Route::get('/dashboard', function () {

        return view("businessDashboard");
    })->name('dashboard');

    Route::get('/change-password',[OrganizationController::class,'changeOrganizationPassword'])->name('change-password');
    Route::any('/logout', [OrganizationController::class, 'organizationLogout'])->name('logout');
});

// Health check endpoint for Docker container
Route::get('/health', function () {
    return response('healthy', 200)->header('Content-Type', 'text/plain');
});
