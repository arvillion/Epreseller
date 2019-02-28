<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin']], function () {
    Route::resource('servers', 'ServerController');
    Route::resource('products', 'ProductController');
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    Route::resource('services', 'ServiceController');
    Route::get('/', 'HomeController@index')->name('home');

    Route::post('services/{id}/status', 'ServiceController@changeStatus')->name('services.status');
    Route::post('services/{id}/password', 'ServiceController@changePassword')->name('services.password');

    Route::get('users/{id}/suspend', 'UserController@suspend')->name('users.suspend');
    Route::get('users/{id}/unsuspend', 'UserController@unSuspend')->name('users.unsuspend');
    Route::post('users/{id}/months', 'UserController@updateExpiresAt')->name('users.months');
    Route::post('users/{id}/password', 'UserController@changePassword')->name('users.password');

    Route::get('products/{id}/suspend', 'ProductController@suspend')->name('products.suspend');
    Route::get('products/{id}/unsuspend', 'ProductController@unSuspend')->name('products.unsuspend');

    Route::get('servers/{id}/suspend', 'ServerController@suspend')->name('servers.suspend');
    Route::get('servers/{id}/unsuspend', 'ServerController@unSuspend')->name('servers.unsuspend');
});

Route::group(['middleware' => 'auth'], function (){
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('services', 'ServiceController');
    Route::post('services/{id}/status', 'ServiceController@changeStatus')->name('services.status');
    Route::post('services/{id}/password', 'ServiceController@changePassword')->name('services.password');
    Route::get('/products', 'ProductController@index')->name('products.index');
    Route::get('/products/{id}', 'ProductController@show')->name('products.show');
});