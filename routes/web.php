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

// PUBLIC ROUTES

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/properties', 'PropertyController@indexData')->name('properties');

// AUTHENTICATED ROUTES

Route::group(['middleware' => 'auth'], function () {

    // Self-service routes
    Route::prefix('self_service/')->group(function () {

        Route::get('index', 'SelfServiceController@index')->name('self_service.index');

        // List of sold properties by the authenticated user (if exists)
        Route::get('myProperties', 'SelfServiceController@indexMyProperties')->name('myProperties.index');
    });
});
