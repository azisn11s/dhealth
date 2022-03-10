<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'LoginController@login')->name('login');
    // Route::post('register', 'RegisterController@register');
    Route::post('password/email', 'ForgotPasswordController@forgot');
    Route::post('password/reset', 'ForgotPasswordController@reset');

});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@me');

    Route::group(['prefix'=> 'admin', 'namespace'=> 'Admin'], function(){
        Route::get('users/export-excel', 'UserController@export')->name('user.export');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');
        Route::patch('users/{user}/default-password', 'UserController@defaultPassword');
        Route::resource('features', 'FeatureController');
        Route::post('role-features/{role}', 'RoleController@addFeatureAbility');
    });

    Route::apiResource('employees', 'EmployeeController');
    Route::get('employee-search', 'EmployeeController@search');

    // Request Item
    Route::apiResource('request-items', 'RequestItemController');

});
