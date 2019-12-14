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

// Get all the properties
Route::get('/properties', 'PropertyController@indexData')->name('properties');

// Search route
Route::get('search', 'SearchController@search');

// Contact send message route
Route::post('contactUs', 'MessageController@contactUs');

// AUTHENTICATED ROUTES

Route::group(['middleware' => 'auth'], function () {

    // Self-service routes
    Route::prefix('self_service/')->group(function () {

        Route::get('index', 'SelfServiceController@index')->name('self_service.index');

        // List of properties for sale by the authenticated user (if exists)
        Route::get('myProperties', 'SelfServiceController@indexMyProperties')->name('myProperties.index');
        // Edit auth user info
        Route::post('storeEditUser', 'SelfServiceController@storeEditUser')->name('storeEditUser');
        // Soft delete auth user (User does not get deleted permanently, can be recovered anytime)
        Route::delete('storeSoftDeleteUser', 'SelfServiceController@storeSoftDeleteUser');
    });

    // Authenticated property handling routes (e.g. "create property")

    Route::prefix('property/')->group(function () {

        // Return the create view
        Route::get('create', 'PropertyController@create')->name('create.property');
        // Store property
        Route::post('store', 'PropertyController@store');
        // Show single property page
        Route::get('show/{id}', 'PropertyController@show')->name('show');
        // Return data for single paroperty
        Route::get('show/showProperty/{id}', 'PropertyController@singlePropertyData');
        // Upload images after creation
        Route::post('storeUpload', 'PropertyController@storeImage');

    });



});
