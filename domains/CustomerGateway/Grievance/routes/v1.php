<?php

use Domains\CustomerGateway\Grievance\Api\GrievanceHandler;
use Domains\CustomerGateway\Grievance\Api\ShowAllComplaintsHandler;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1/grievances', 'as' => 'api.grievance.', 'middleware' => ['auth:api-customer', 'setLocale']], function () {
    Route::post('/submit', [GrievanceHandler::class, 'create']);
    Route::get('/my', [GrievanceHandler::class, 'myComplaints']);
    Route::get('/types', [GrievanceHandler::class, 'grievanceType']);
    Route::get('/counts', [GrievanceHandler::class, 'countGrievance']);
    Route::get('/all', [ShowAllComplaintsHandler::class, 'allComplaints']);
    Route::get('/show/{id}', [GrievanceHandler::class, 'showComplaintDetail']);
    
});

Route::group(['prefix' => 'api/v2/grievances', 'as' => 'api.grievance.', 'middleware' => ['auth:api-customer', 'setLocale' , 'checkKycVerification']], function () {
    Route::post('/submit', [GrievanceHandler::class, 'create']);
    Route::get('/my', [GrievanceHandler::class, 'myComplaintsV2']);
    Route::get('/types', [GrievanceHandler::class, 'grievanceType']);
    Route::get('/counts', [GrievanceHandler::class, 'countGrievance']);
    Route::get('/all', [ShowAllComplaintsHandler::class, 'allComplaintsV2']);
    Route::get('/show/{id}', [GrievanceHandler::class, 'showComplaintDetailV2']);
});


