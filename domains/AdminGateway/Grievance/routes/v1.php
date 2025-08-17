<?php
use Illuminate\Support\Facades\Route;
use \Domains\AdminGateway\Grievance\Api\AdminGrievanceHandler;
Route::group(['middleware' => ['auth:api-user','setLocale'],'prefix'=>'api/v1/admin/grievance'], function () {
    Route::get('/',[AdminGrievanceHandler::class,'listGrievance'])->middleware('permission:grievance access');
});