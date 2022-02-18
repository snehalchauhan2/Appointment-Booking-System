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

Route::get('/', 'Site\SiteController@index')->name('site');
Route::get('/appointment/success', 'Site\SiteController@appointmentSuccess')->name('site.appointment.success');

Auth::routes();

// AJAX Routes
Route::group(['middleware' => 'auth', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {

    // Routes not blocked to Client Users
    Route::get('services', 'ServiceController@indexJson')->name('services.index');
    Route::get('services/{id}/times', 'ServiceController@availableTimes')->name('services.times');

    Route::post('appointments/client', 'AppointmentController@storeClientAppointment')->name('appointments.storeClientAppointment');

});

Route::group(['middleware' => 'auth', 'prefix' => 'home', 'as' => 'home.'], function() {

    // Routes Blocked to Client Users
    Route::group(['middleware' => 'block_client'], function() {
        Route::get('/', 'HomeController@index')->name('index');

        // Clients
        Route::resource('clients', 'ClientController');

        // Providers
        Route::resource('providers', 'ProviderController');

        // Services
        Route::resource('services', 'ServiceController');

        // Appointments
        Route::resource('appointments', 'AppointmentController');

        // Users
        Route::resource('users', 'UserController');

        // Settings
        Route::get('settings', 'SettingsController@index')->name('settings.index');
        Route::post('settings', 'SettingsController@store')->name('settings.store');
    });

});