<?php

use Domains\CustomerGateway\CustomerSignup\Api\CustomerForgotPasswordHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerLanguagePreferenceHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerNotificationPreferenceHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerPasswordSetHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerResentOtpHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerSignoutHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerSignupHandler;
use Domains\CustomerGateway\CustomerSignup\Api\CustomerVerifyOtpHandler;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::group(['prefix'=> 'api/v1/customers', 'as' => 'api.customer.'], function(){
    Route::post('register', [CustomerSignupHandler::class, 'register']);
    Route::post('verify-otp', [CustomerVerifyOtpHandler::class, 'verifyOtp']); 
    Route::post('set-password', [CustomerPasswordSetHandler::class, 'setPassword']); 
    Route::post('forgot-password', [CustomerForgotPasswordHandler::class, 'forgotPassword']); 
    Route::post('logout', [CustomerSignoutHandler::class, 'logout'])->middleware('auth:api-customer');
    Route::post('set-language', [CustomerLanguagePreferenceHandler::class, 'setLanguage']);
    Route::post('set-notification', [CustomerNotificationPreferenceHandler::class, 'setNotification']);
    Route::post('resent', [CustomerResentOtpHandler::class, 'resentOtp']); 
});

Route::group(['as' => 'passport.','prefix' => 'oauth'], function () {
    Route::post('token', [
        'uses' => AccessTokenController::class . '@issueToken',
        'as' => 'client.token',
    ]);
});