<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::group(['middleware' => ['auth:api', 'status']], function (){
        Route::post('services', 'ServiceController@store');
        Route::delete('services/{id}', 'ServiceController@destroy');
        Route::get('services/{id}/status', 'ServiceController@changeStatus');
        Route::post('services/{id}/password', 'ServiceController@changePassword');
        Route::post('services/id', 'ServiceController@getServiceIdByName');
    });

    Route::post('panel', 'PanelController@userLogin');
});



Route::get('test2', function (){
    return 'OK';
});

