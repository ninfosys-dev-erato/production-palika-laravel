<?php
use Domains\CustomerGateway\FileTracking\Api\FileRecordHandler;

Route::group(['prefix'=> 'api/v1/file-records', 'as' => 'api.file_records','middleware' => ['auth:api-customer', 'setLocale']], function(){
    Route::get('/', [FileRecordHandler::class, 'searchRecords']);
});