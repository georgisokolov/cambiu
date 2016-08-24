<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::get('/', 'AdminController@index');
    Route::get('/users', 'UserController@index');

    // Authentication Routes...
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('confirm/code', ['as' => 'confirm', 'uses' => 'Auth\AuthController@confirm']);
    Route::get('confirm/code', ['as' => 'getConfirm', 'uses' => function(){return view('admin.auth.confirm');}]);
    Route::post('login/confirm', 'Auth\AuthController@authenticate');
    Route::get('logout', 'Auth\AuthController@logout');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    //Every different admin rout need to be authenticate
    Route::group(['middleware' => 'auth'], function()
    {
        // Registration Routes...
        Route::get('users/register', 'Auth\AuthController@showRegistrationForm');
        Route::post('users/register', 'Auth\AuthController@register');
        Route::get('users/edit/{id}', 'UserController@edit');
        Route::post('users/update', 'Auth\AuthController@update');
        Route::get('users/destroy/{id}', 'UserController@destroy');

        //Exchange Rates
//        Route::get('exchangerates', 'ExchangeRateController@index');
//        Route::get('exchangerate/create', 'ExchangeRateController@create');
//        Route::post('exchangerate/store', 'ExchangeRateController@store');
//        Route::get('exchangerate/edit/{iId}', 'ExchangeRateController@edit');
//        Route::post('exchangerate/update', 'ExchangeRateController@update');
//        Route::get('exchangerate/destroy/{iId}', 'ExchangeRateController@destroy');

    });
});